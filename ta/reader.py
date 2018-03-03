import xlrd
import sys, getopt

from xlrd import open_workbook
workbook = xlrd.open_workbook("roster.xlsx")
sheet = workbook.sheet_by_index(0)

def main(argv):
   global user
   try:
      opts, args = getopt.getopt(argv,"u:")
   except getopt.GetoptError:
      print 'reader.py -u jonathan'
      sys.exit(2)
   for opt, arg in opts:
      if opt in ("-u") :
          user = arg
          for row in range(sheet.nrows):
              for col in range(sheet.ncols):
                  if sheet.cell_value(row, col).lower() == user.lower():
                      row = row + 1
                      col = col + 1
                      if row in (7, 18, 29, 40, 51):
                          shift = "S1"
                      elif row in (8,19,30,41,52):
                          shift = "S2"
                      elif row in (9,20,31,42,53):
                          shift = "S3"
                      elif row in (10,21,32,43,54):
                          shift = "S4"
                      elif row in (11,22,33,44,55):
                          shift = "S5"
                      elif row in (12,23,34,45,56):
                          shift = "S6"
                      elif (row == 61):
                          shift = "Saturday"
                      else :
                          shift = "Unidentified"

                      if (7<=row<=12):
                          day = "Monday"
                      elif (18<=row<=23):
                          day = "Tuesday"
                      elif (29<=row<=34):
                          day = "Wednesday"
                      elif (40<=row<=45):
                          day = "Thursday"
                      elif (51<=row<=56):
                          day = "Friday"
                      elif (row == 61):
                          day = "Saturday"
                      else :
                          day = "Unknown"

                      if (col == 3):
                          duty = "Tech Centre"
                      elif col in (4,5,6):
                          duty = "Rounding"
                      elif col in (7,8):
                          duty = "QC"
                      elif (col == 9):
                          duty = "APIIT Helpdesk"
                      elif (col == 10):
                          duty = "APIIT Rounding/QC"
                      else :
                          duty = "Unidentified"

                      print day,",",shift,",",duty
if __name__ == "__main__":
   main(sys.argv[1:])
