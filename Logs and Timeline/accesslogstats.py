import collections
import matplotlib.pyplot as plt
import matplotlib.dates as mdates
from datetime import datetime
import numpy as np
import pandas as pd

file = open("access_info.dat", "r")

ip = []
time = []
page = []
browser = []
months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
for line in file:
    data = line.split(";")
    if (data[3]!= '/' and data[3]!='-'):
        ip.append(data[0])
        datepara = data[1].split("/")
        #converting date to proper format
        for month in months:
            if (datepara[1] == month):
                datepara[1] = months.index(month) + 1
        string_date = [str(int) for int in datepara]
        converted = "-".join(string_date)
        time.append(converted+' ' +data[2])
        page.append(data[3])
        browser.append(data[4])


#Plotting bar chart for frequency of each page
def plot(freq, filename):
    plt.figure(figsize=(8,6))
    counter=collections.Counter(freq)
    x = counter.keys()
    y = counter.values()
    plt.bar(x, y)
    plt.xticks(rotation = 90)
    for index, value in enumerate(y):
        plt.text(index, value + 2, str(value))
    plt.ylim(0, max(y)*1.10)    
    plt.title(filename+'\n') 
    plt.tight_layout()
    plt.savefig(filename)
    
plot(page,'Logs of Page')
plot(browser, 'Logs of browser')
plot(ip, 'Logs of IP')

df = pd.DataFrame(list(zip(ip, time, page, browser)), 
               columns =['IP', 'Time', 'Page', 'Browser'])

#groupData
gpage = df.groupby('Page')

#Plot timeline
def timeline(group, filename):
    time = group['Time'].tolist()
    ip = group['IP'].tolist()
    browser = group['Browser'].tolist()
    
    l = []
    for i in range(1, 6):
        l.append(i*(-2))
        l.append(i*2)
       
    levels = np.tile(l,int(np.ceil(len(time)/10)))[:len(time)]
    
    fig, ax = plt.subplots(figsize=(15, 10), constrained_layout=True)
    ax.set(title='Log of' + str(filename)+'\n\n')
    
    markerline, stemline, baseline = ax.stem(time, levels,
                                             linefmt="C3-", basefmt="k-",
                                             use_line_collection=True)
    
    plt.setp(markerline, mec="k", mfc="w", zorder=3)
    plt.setp(ax.get_xticklabels(), rotation = 90)
    
    markerline.set_ydata(np.zeros(len(time)))
    
    vert = np.array(['top', 'bottom'])[(levels > 0).astype(int)]
    for d, l, r, p, va in zip(time, levels, ip, browser, vert):
        ax.annotate(r + '\n' +p, xy=(d, l), xytext=(-3, np.sign(l)*3),
                    textcoords="offset points", va=va, ha="right")
        
    # remove y axis and spines
    ax.get_yaxis().set_visible(False)
    for spine in ["left", "top", "right"]:
        ax.spines[spine].set_visible(False)
    plt.show()
    fig.savefig(filename[1:-4].replace('/' , '.')+'.png')

#for all the pages
for page in list(collections.Counter(page).keys()):
    Page = gpage.get_group(page)
    timeline(Page, page)
