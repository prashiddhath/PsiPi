/*
Log entry format:
ip - - [Date] "GET /~user/pathToHtml HTTP/1.1" 403 982 "web address" "mozilaCompatability (device info) Gecko/20100101 Browser/version"
*/

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <errno.h>

//#define ACCESS_LOG_PATH "/var/log/apache2/access_log"
//#define ERROR_LOG_PATH "/var/log/apache2/error_log"
#define ACCESS_LOG_PATH "access_log"
#define ERROR_LOG_PATH "error_log"

#define TARG_USER "jwhiteley"

#define COLUMB_WIDTH 35

void printColumb (char* buf, int len, int width, FILE* outFile);
void cpAccInfo (char* buf, FILE* outFile);
void cpErrInfo (char* buf, FILE* outFile);

int main (int argc, char* argv[]) {
	FILE* accLog;
	FILE* accInfo;
	FILE* errLog;
	FILE* errInfo;
	char* buf = NULL;
	size_t n = 0;
	int len;
	char* user;
	
	//open access log file for reading
	accLog = fopen(ACCESS_LOG_PATH, "r");
	if (!accLog) {
		printf("Error: failed to open access log\n");
		exit(EXIT_FAILURE);
	}
	
	//open access info file for writing
	accInfo = fopen("access_info.dat", "w");
	if (!accLog) {
		printf("Error: failed to open access info\n");
		exit(EXIT_FAILURE);
	}
	
	//read each entry in access log and if for TARG_USER put its info in access info
	while ((len = getline(&buf, &n, accLog)) != -1) {
		
		//set user to start of user value in log entry, leave null if pattern not found
		user = strstr(buf, "GET /~");
		if (user) {
			user += sizeof("GET /~") - 1;
		} else {
			user = strstr(buf, "POST /~");
			if (user) {
				user += sizeof("POST /~") - 1;
			}
		}
		
		//if user is TARG_USER extract info
		if (user && (strncmp(user, TARG_USER, strlen(TARG_USER)) == 0)) {
			cpAccInfo(buf, accInfo);
		}
		
		//clean for next itteration
		n = 0;
		free(buf);
		buf = NULL;
	}
	
	//open error log file for reading
	errLog = fopen(ERROR_LOG_PATH, "r");
	if (!errLog) {
		printf("Error: failed to open error log\n");
		exit(EXIT_FAILURE);
	}
	
	//open error info file for writing
	errInfo = fopen("error_info.dat", "w");
	if (!errLog) {
		printf("Error: failed to open error info\n");
		exit(EXIT_FAILURE);
	}
	
	//read each entry in error log and if for TARG_USER put its info in error info
	while ((len = getline(&buf, &n, errLog)) != -1) {
		
		//set user to start of user value in log entry, leave null if pattern not found
		user = strstr(buf, "http://clabsql.clamv.jacobs-university.de/~");
		if (user) {
			user += sizeof("http://clabsql.clamv.jacobs-university.de/~") - 1;
			
			//if user is TARG_USER extract info
			if ((strncmp(user, TARG_USER, strlen(TARG_USER)) == 0)) {
				cpErrInfo(buf, errInfo);
			}
		}
		
		//clean for next itteration
		n = 0;
		free(buf);
		buf = NULL;
	}
	
	//clean up
	fclose(accLog);
	fclose(errLog);
	fclose(accInfo);
	fclose(errInfo);
	
	return 0;
}

void printColumb (char* buf, int len, int width, FILE* outFile) {
	
	//allocate memory to hold the data to be printed
	char* buf2 = malloc(len+1 * sizeof(char));
	if (!buf2) {
		printf("Error: failed to allocate memory in cpACCInfo()\n");
		exit(EXIT_FAILURE);
	}

	//if acceptable len print with a padding of width (can use padding but each column has been separated with ; for python script to read data)
	if (len <= width) {
		strncpy(buf2, buf, len);
		buf2[len] = '\0';
		fprintf(outFile, "%s;", buf2);
	} else {
		printf("Error: columb width is too small, needed size: %d\n", len);
		exit(EXIT_FAILURE);
	}

	free(buf2);
}

void cpAccInfo (char* buf, FILE* outFile) {
	int ipLen;
	int dateTimeLen;
	int pageLen;
	int browserLen;
	int TimeLen;
	char* ipStart;
	char* dateTimeStart;
	char* pageStart;
	char* browserStart;
	char* TimeStart;
	
	//cp ip
	ipStart = buf;
	ipLen = strchr(buf, ' ') - ipStart;
	printColumb(ipStart, ipLen, COLUMB_WIDTH, outFile);
	
	//cp date
	dateTimeStart = strchr(ipStart+ipLen, '[') + 1;
	dateTimeLen = strchr(dateTimeStart, ':') - dateTimeStart;
	printColumb(dateTimeStart, dateTimeLen, COLUMB_WIDTH, outFile);

	//cp time
	TimeStart = strchr(dateTimeStart + dateTimeLen, ':') + 1;
	TimeLen = strchr(TimeStart, ']') - TimeStart - 6;
    printColumb(TimeStart, TimeLen, COLUMB_WIDTH, outFile);
	
	//cp page
	pageStart = strstr(dateTimeStart+dateTimeLen, "http://clabsql.clamv.jacobs-university.de/~jwhiteley");
	if (!pageStart) {
		pageStart = strstr(dateTimeStart+dateTimeLen, "\"-\"") + 1;
		pageLen = 1;
	} else {
		pageStart += sizeof("http://clabsql.clamv.jacobs-university.de/~jwhiteley") - 1;
		if (strchr(pageStart, '?') == 0 || strchr(pageStart, '"') < strchr(pageStart, '?')) {
			pageLen =  strchr(pageStart, '"') - pageStart;
		} else {
			pageLen =  strchr(pageStart, '?') - pageStart;
		}
	}
	printColumb(pageStart, pageLen, COLUMB_WIDTH, outFile);
	
	//cp browser
	browserStart = strrchr(buf, ' ') + 1;
	browserLen = strchr(browserStart, '/') - browserStart;
	printColumb(browserStart, browserLen, COLUMB_WIDTH, outFile);
	
	
	fprintf(outFile, "\n");
}

void cpErrInfo (char* buf, FILE* outFile) {
	int dateTimeLen;
	int ipLen;
	char* dateTimeStart;
	char* ipStart;
	char* infoStart;
	
	//cp date/time
	dateTimeStart = buf+1;
	dateTimeLen = strchr(dateTimeStart, ']') - dateTimeStart;
	printColumb(dateTimeStart, dateTimeLen, COLUMB_WIDTH, outFile);
	
	//cp ip
	ipStart = strstr(dateTimeStart+dateTimeLen, "[client ") + sizeof("[client ") - 1;
	ipLen = strchr(ipStart, ':') - ipStart;
	printColumb(ipStart, ipLen, COLUMB_WIDTH, outFile);
	
	//cp info
	infoStart = strchr(ipStart+ipLen, ']') + 2;
	fprintf(outFile, "%s", infoStart);
}