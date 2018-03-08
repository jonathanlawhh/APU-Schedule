import xlrd

from xlrd import open_workbook
workbook = xlrd.open_workbook("../data/roster.temp.xlsx")
sheet = workbook.sheet_by_index(0)

print(sheet.cell(3, 0).value)
