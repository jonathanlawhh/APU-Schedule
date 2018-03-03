import xlrd

from xlrd import open_workbook
workbook = xlrd.open_workbook("roster.xlsx")
sheet = workbook.sheet_by_index(0)

print(sheet.cell(3, 0).value)
