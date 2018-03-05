import xlrd
import sys, getopt

from xlrd import open_workbook
workbook = xlrd.open_workbook("../data/roster.xlsx")
sheet = workbook.sheet_by_index(0)

def main(argv):
   opts, args = getopt.getopt(argv,"d:s:")
   day = ''
   for opt, arg in opts:
      if(opt == "-d"): duty = arg
      elif(opt == "-s"): day = arg
      else: print("Error")
   if(duty=='rounding'): x = [4,5,6]
   elif(duty=='qc'): x = [7,8]
   elif(duty=='apiithelpdesk'): x = [9]
   elif(duty=='apiitqc'): x = [10]
   else: x = [1]

   if(day=='Monday'): y = [7,8,9,10,11,12]
   elif(day=='Tuesday'): y = [18,19,20,21,22,23]
   elif(day=='Wednesday'): y = [29,30,31,32,33,34]
   elif(day=='Thursday'): y = [40,41,42,43,44,45]
   elif(day=='Friday'): y = [51,52,53,54,55,56]
   else: y = [0]


   for day in y :
       for duty in x :
           if day in (7,18,29,40,51): shift = "S1"
           elif day in (8,19,30,41,52): shift = "S2"
           elif day in (9,20,31,42,53): shift = "S3"
           elif day in (10,21,32,43,54): shift = "S4"
           elif day in (11,22,33,44,55): shift = "S5"
           elif day in (12,23,34,45,56): shift = "S6"
           elif (day == 61): shift = "Saturday"
           else : shift = "Unidentified"

           duty-=1
           day-=1
           if((sheet.cell(day, duty).value)!='') :
               print(sheet.cell(day, duty).value,',',shift)
           duty+=1
           day+=1
if __name__ == "__main__":
   main(sys.argv[1:])
