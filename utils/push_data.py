import pymysql
import paramiko
import pandas as pd
from paramiko import SSHClient
from sshtunnel import SSHTunnelForwarder
from os.path import expanduser
import nsepy
import csv
import os
import datetime

directory = "utils/data/"
sql_hostname = '127.0.0.1'
sql_username = 'nse_india'
sql_password = 'nse_india'
sql_main_database = 'nse_india'
sql_port = 3306
ssh_host = 'cat-apps.com'
ssh_user = 'qukocsfx0e4u'
ssh_port = 22

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
        if (dt.strftime("%A") != "Sunday" and dt.strftime("%A") != "Saturday"):
            if (os.path.exists(directory+str(dt)+'.csv')):
                print('putting for '+str(dt))
                readCsv(directory+str(dt)+'.csv')
            else:
                print('no data for '+str(dt))

def getBhavCopy(lastUpdatedDate):
    deltaDays = datetime.datetime.now().date() - lastUpdatedDate
    for i in range(0, deltaDays.days):
        day = datetime.datetime.now() - datetime.timedelta(days=i)
        day = day.date()
        if (day.strftime("%A") != "Sunday" and day.strftime("%A") != "Saturday"):
            try:
                stringDay = day.isoformat()+""
                prices = nsepy.history.get_price_list(dt=day)
                prices.to_csv('utils/data/'+stringDay+'.csv', sep=',')
            except:
                print("Failed for : "+stringDay)
    publishPending(lastUpdatedDate)
    
    
with SSHTunnelForwarder(
        (ssh_host, ssh_port),
        ssh_username=ssh_user,
        ssh_password='}4IL}UrZ#G',
        remote_bind_address=(sql_hostname, sql_port)) as tunnel:
    db = pymysql.connect(host='127.0.0.1', user=sql_username,
        passwd=sql_password, db=sql_main_database,
        port=tunnel.local_bind_port)
    queryMaxDate = 'select max(dt) dt from sh_symbol_data'
    # data = pd.read_sql_query(query, conn)
    cursor = db.cursor()
    cursor.execute("select max(dt) dt from sh_symbol_data")
    data = cursor.fetchone()
    print("LAST UPDATED DATE WAS : "+str(data[0]))
    # if data[0] == None:
    #     print("publish all")
    #     # publishAll()
    # else:
    #     getBhavCopy(data[0])