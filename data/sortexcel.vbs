Const xlAscending = 1

Set objExcel = CreateObject("Excel.Application")
Set objExcel = CreateObject("Excel.Application")
objExcel.Visible = True
Set objWorkbook = _ 
objExcel.Workbooks.Open("D:\APU-Schedule\data\data.csv")

Set objWorksheet = objWorkbook.Worksheets(1)
Set objRange = objWorksheet.UsedRange

Set objRange2 = objExcel.Range("D1")
Set objRange3 = objExcel.Range("F1")

objRange.Sort objRange2,xlAscending,objRange3,,xlAscending
objWorkbook.Save
objWorkbook.Close
objExcel.Quit