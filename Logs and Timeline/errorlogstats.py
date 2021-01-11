import collections
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
from datetime import datetime
import numpy as np
import pandas as pd
from textwrap import wrap

file = open("error_info.dat", "r")
date = []
time = []
ip = []
error = []
months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
for line in file:
    data = line.split(";")
    datepara = data[0].split(" ")
    #converting date to proper format
    for month in months:
        if (datepara[1] == month):
            datepara[1] = months.index(month) + 1
    string_date = [str(int) for int in datepara]
    converted = string_date[2] + "-" + string_date[1] + "-" + string_date[4]
    date.append(converted)
    #removing fractional part of time
    onlytime = datepara[3].split(".")
    time.append(converted+ ' ' +onlytime[0])
    ip.append(data[1])
    error.append(data[2])




df = pd.DataFrame(list(zip(ip, time, error)), 
               columns =['IP', 'Time', 'Error'])
counter=collections.Counter(df['Error'].tolist())
x = counter.keys()

#Create Unique Error codes
error_code = []
i = 100
for error in x:
    error_code.append(str(i))
    i = i+1
y = counter.values()

#Plot Frequency of Errors
plt.figure(1, figsize=(10,6))
plt.bar(error_code, y)
plt.xticks(rotation = 90)
plt.xlabel('Error codes', fontsize =14)
for index, value in enumerate(y):
    plt.text(index, value + 0.25, str(value))
plt.savefig('error')
    
#Write the generated Codes
code = open("error_codes.txt", "w")
for i in range(len(error_code)):
    code.write("------------------------------------ \n")
    code.write(error_code[i])
    code.write("\t")
    code.write(list(counter)[i])
    code.write("------------------------------------ \n")

code.close()


#groupData by errors
gerror = df.groupby('Error')


#Plot timeline
def timeline(group, k):
    time = group['Time'].tolist()
    ip = group['IP'].tolist()
    
    l = []
    for i in range(1, 6):
        l.append(i*(-2))
        l.append(i*2)
       
    levels = np.tile(l,int(np.ceil(len(time)/10)))[:len(time)]
    
    fig, ax = plt.subplots(figsize=(10, 8), constrained_layout=True)
    ax.set(title="\n".join(wrap('Log of Error: ' + list(x)[k],100)))
    
    markerline, stemline, baseline = ax.stem(time, levels,
                                             linefmt="C3-", basefmt="k-",
                                             use_line_collection=True)
    
    plt.setp(markerline, mec="k", mfc="w", zorder=3)
    plt.setp(ax.get_xticklabels(), rotation = 90)
    
    markerline.set_ydata(np.zeros(len(time)))
    
    vert = np.array(['top', 'bottom'])[(levels > 0).astype(int)]
    for d, l, r, va in zip(time, levels, ip, vert):
        ax.annotate(r, xy=(d, l), xytext=(-3, np.sign(l)*3),
                    textcoords="offset points", va=va, ha="right")
        
    # remove y axis and spines
    ax.get_yaxis().set_visible(False)
    for spine in ["left", "top", "right"]:
        ax.spines[spine].set_visible(False)
    plt.show()
    fig.savefig(error_code[k]+'.png')
 
#Create timeline for each error; use k index to call respective error codes    
k = -1
for error in list(x):
    k = k+1
    Error = gerror.get_group(error)
    timeline(Error, k)

