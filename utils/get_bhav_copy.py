import nsepy
import datetime

# for i in range(0, 5*365):
#     day = datetime.datetime.now() - datetime.timedelta(days=i)
#     print day.date()

# print datetime.datetime.now() - datetime.timedelta(days=5*365)

for i in range(0, 10):
    try:
        day = datetime.datetime.now() - datetime.timedelta(days=i)
        day = day.date()
        stringDay = day.isoformat()+""
        # print(stringDay)
        prices = nsepy.history.get_price_list(dt=day)
        prices.to_csv('utils/data/'+stringDay+'.csv', sep=',')
    except:
        print("Failed for : "+stringDay)

#data = nsepy.get_history(symbol="SBIN", start=datetime.date(2015,1,1), end=datetime.date(2015,1,31))

# print data
# data[['Close']].plot()

# prices = nsepy.history.get_price_list(dt=datetime.date(2013,5,10))
# print prices
# prices.to_csv("data/2013-05-10.csv", sep=',')
