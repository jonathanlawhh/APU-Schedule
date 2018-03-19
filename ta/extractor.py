import xlrd

wb = xlrd.open_workbook('../data/roster.xlsx')
sh = wb.sheet_by_index(0)
your_csv_file = open('../data/gen-roster.csv','w')

duty = [3,4,5,6,7,8,9,10]
day = [7,8,9,10,11,12,18,19,20,21,22,23,29,30,31,32,33,34,40,41,42,43,44,45,51,52,53,54,55,56,61]
for rownum in day:
    for col in duty:
        if(sh.cell(rownum-1, col-1).value==''): continue
        if rownum in (7,8,9,10,11,12): today = "Monday"
        elif rownum in (18,19,20,21,22,23): today = "Tuesday"
        elif rownum in (29,30,31,32,33,34): today = "Wednesday"
        elif rownum in (40,41,42,43,44,45): today = "Thursday"
        elif rownum in (51,52,53,54,55,56): today = "Friday"
        elif (rownum==61 ): today = "Saturday"
        else : shift = "Unidentified"

        if rownum in (7,18,29,40,51): shift = "S1"
        elif rownum in (8,19,30,41,52): shift = "S2"
        elif rownum in (9,20,31,42,53): shift = "S3"
        elif rownum in (10,21,32,43,54): shift = "S4"
        elif rownum in (11,22,33,44,55): shift = "S5"
        elif rownum in (12,23,34,45,56): shift = "S6"
        elif (rownum == 61): shift = "Saturday"
        else : shift = "Unidentified"

        if(col == 3): job = "APU-Helpdesk"
        elif col in (4,5,6): job = "APU-Rounding"
        elif col in (7,8): job = "APU-QC"
        elif (col == 9): job = "APIIT-Helpdesk"
        elif (col == 10): job = "APIIT-Rounding/QC"
        else: job = "Undefined"

        if(rownum==61 and col==8):
            job = "Chairperson"
            today = "Tuesday"
            shift = "Tuesday"
        elif(rownum==61 and col==9):
            job = "Minutes Writer"
            today = "Tuesday"
            shift = "Tuesday"
        elif(rownum==61 and col==10):
            job = "Next MW"
            today = "Tuesday"
            shift = "Tuesday"

        a = today + ',' +  shift + ',' + job + ',' + str(sh.cell(rownum-1, col-1).value) + '\n'
        your_csv_file.write(str(a))

your_csv_file.close()
