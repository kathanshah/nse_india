import nsetools
import pprint
#import nsetools.nse

nse = nsetools.Nse()
q = nse.get_quote('infy', as_json=True)
print q
# all_stock_codes = nse.get_stock_codes()
# print all_stock_codes