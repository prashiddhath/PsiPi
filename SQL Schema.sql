CREATE TABLE Physicists (
	name VARCHAR(50) NOT NULL,
	nationality VARCHAR(50),
	birthYear INT,
	deathYear INT,
	PRIMARY KEY (name)
);

CREATE TABLE Fields (
	name VARCHAR(50) NOT NULL,
	PRIMARY KEY (name)
);

CREATE TABLE Quantities (
	qid INT NOT NULL,
	name VARCHAR(50) NOT NULL UNIQUE,
	unit VARCHAR(50),
	PRIMARY KEY (qid)
);

CREATE TABLE Variables (
	vid INT NOT NULL REFERENCES Quantities(qid) ON DELETE CASCADE,
	symbol VARCHAR(10) NOT NULL,
	PRIMARY KEY (vid)
);

CREATE TABLE Constants (
	cid INT NOT NULL REFERENCES Variables(vid) ON DELETE CASCADE,
	value REAL NOT NULL,
	exponent INT NOT NULL,
	creator VARCHAR(50),
	FOREIGN KEY (creator) REFERENCES Physicists(name) ON DELETE SET NULL,
	PRIMARY KEY (cid)
);

CREATE TABLE Equations (
	eqid INT NOT NULL,
	name VARCHAR(50) UNIQUE NOT NULL,
	latexCode VARCHAR(256) UNIQUE NOT NULL,
	field VARCHAR(50),
	creator VARCHAR(50),
	PRIMARY KEY (eqid),
	FOREIGN KEY (field) REFERENCES Fields(name) ON DELETE SET NULL,
	FOREIGN KEY (creator) REFERENCES Physicists(name) ON DELETE SET NULL
);

CREATE TABLE Differential_equations (
	deid INT NOT NULL REFERENCES Equations(eqid) ON DELETE CASCADE,
	eqOrder INT NOT NULL,
	PRIMARY KEY (deid)
);

CREATE TABLE Polynomial_equations (
	peid INT NOT NULL REFERENCES Equations(eqid) ON DELETE CASCADE,
	eqDegree INT NOT NULL,
	PRIMARY KEY (peid)
);

CREATE TABLE Part_of (
	vid INT NOT NULL,
	eqid INT NOT NULL,
	FOREIGN KEY (vid) REFERENCES Variables(vid) ON DELETE CASCADE,
	FOREIGN KEY (eqid) REFERENCES Equations(eqid) ON DELETE CASCADE
);

CREATE TABLE Authorization (
	username VARCHAR(50) NOT NULL,
	password VARCHAR(50) NOT NULL
);
