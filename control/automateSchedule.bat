@echo off
echo Schedule update started
echo Downloading schedule...
powershell.exe curl -o timetableCSV.zip http://lms.apiit.edu.my/intake-timetable/download_timetable/timetableCSV.zip
if exist "timetableCSV.zip" (
  echo timetableCSV.zip downloaded
) else (
  echo Schedule download fail
  goto end
)

echo Unzipping...
"7za/7za.exe" e -y timetableCSV.zip > NUL
if exist "*.csv" (
  ren *.csv a.csv
) else (
  echo Failed to unzip. CSV not found
  goto end
)

D:\home\python364x64\python.exe sortcsv.py
if exist "data.csv" (
  echo Deploying schedule...
  copy /Y data.csv "../data/data.csv"
) else (
  echo Failed to deploy schedule. Sorting failed
  goto end
)

:end
echo Cleaning up
del *.csv
del *.zip
echo Done
