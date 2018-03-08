<?php
if(isset($_POST['action'])){
  exec('automateSchedule.bat', $a);
  foreach($a as $b){ echo 'addLog("' . $b . '");'; }
  $log = fopen("../data/update.log", "w");
  fwrite($log, date('Ymd'));
  fclose($log);
  echo 'addLog("Schedule updated on ' . date('Ymd') . '")';
}

if(isset($_FILES['roster'])){
  $a = strtolower(pathinfo($_FILES['roster']['name'],PATHINFO_EXTENSION));
  $s = 1;

  if($a != "xlsx") { echo 'You tried abusing the system right =.='; $s = 0; }
  if (move_uploaded_file($_FILES['roster']['tmp_name'], '../data/roster.temp.xlsx')) {
    exec("D:\home\python364x64\python.exe ../ta/chkRoster.py", $r); foreach($r AS $cr){ $a = $cr; }
    if(substr($a, 0, 6) != 'Monday'){ echo 'You did not upload TA Final Roster...'; $s = 0; }
    if($s==1){
      exec('del "../data/roster.xlsx"');
      exec('ren "../data/roster.temp.xlsx" roster.xlsx');
      echo 'TA Final Roster for the week of ' . $a .' has been uploaded'; }
  } else { echo 'Sorry, there was an error uploading your file.'; }

  exec('del "../data/roster.temp.xlsx"');
  unset($_FILES['roster']);
}
?>
