import nsepy
import csv
import os
import mysql.connector
import datetime

directory = "utils/data/"

db = mysql.connector.connect(
    host="localhost",    # your host, usually localhost
    user="root",         # your username
    passwd="root",  # your password
    db="nse_india"
)

def putData(row,iid):
    cursor = db.cursor()
    try:
        day = datetime.datetime.strptime(row['TIMESTAMP'], '%d-%b-%Y').date()
        day = day.isoformat()+""
        ins_q = "INSERT INTO sh_symbol_data \
        (sid,open,high,low,close,last,pclose,tqty,tval,dt,tt) \
        VALUES ('%d','%f','%f','%f','%f','%f','%f','%d','%f','%s','%d')" %(iid,float(row['OPEN']),float(row['HIGH']),float(row['LOW']),float(row['CLOSE']),float(row['LAST']),float(row['PREVCLOSE']),int(row['TOTTRDQTY']),float(row['TOTTRDVAL']),day,int(row['TOTALTRADES']))

        # print ins_q

        cursor.execute(ins_q)
        db.commit()
        # print "Added for "+row['SYMBOL']
    except Exception as e:
        print(e)
        print "Rollback for "+row['SYMBOL']
        db.rollback()

def putSymbol(row):
    cursor = db.cursor()
    cursor.execute("SELECT id from sh_symbols where symbol like '%s'" %(row['SYMBOL']))
    data = cursor.fetchone()
    if (data):
        putData(row,data[0])
    else:
        try:
            cursor.execute("INSERT INTO sh_symbols (symbol,series,isin) VALUES ('%s','%s','%s')" %(row['SYMBOL'],row['SERIES'],row['ISIN']))
            db.commit()
            iid = cursor.lastrowid
            putData(row,iid)
        except:
            print "Rollback for "+row['SYMBOL']
            db.rollback()

def readCsv(path):
    with open(path) as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            if (row['SERIES'] == 'EQ'):
                putSymbol(row)

def publishAll():
    for filename in os.listdir(directory):
        if filename.endswith(".csv"):
            print(filename)
            readCsv(os.path.join(directory, filename))

def publishPending(lastUpdatedDate):
    deltaDays = datetime.datetime.now().date() - lastUpdatedDate
    for i in range(1, deltaDays.days+1):
        dt = lastUpdatedDate + datetime.timedelta(days = i)
        if (os.path.exists(directory+str(dt)+'.csv')):
            print('putting for '+str(dt))
            readCsv(directory+str(dt)+'.csv')
        else:
            print('no data for '+str(dt))

def getBhavCopy(lastUpdatedDate):
    deltaDays = datetime.datetime.now().date() - lastUpdatedDate
    for i in range(0, deltaDays):
        try:
            day = datetime.datetime.now() - datetime.timedelta(days=i)
            day = day.date()
            print(day)
            stringDay = day.isoformat()+""
            # print(stringDay)
            # prices = nsepy.history.get_price_list(dt=day)
            # prices.to_csv('utils/data/'+stringDay+'.csv', sep=',')
        except:
            print("Failed for : "+stringDay)



cursor = db.cursor()
cursor.execute("select max(dt) dt from sh_symbol_data")
data = cursor.fetchone()
if data[0] == None:
    print("publish all")
    # publishAll()
else:
    getBhavCopy(data[0])