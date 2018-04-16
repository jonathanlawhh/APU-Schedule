<?php
if(isset($_GET['redirect'])){
  echo 'Updating Schedule...';
  exec('automateSchedule.bat');
  $log = fopen("../data/update.log", "w");
  fwrite($log, date('Ymd'). ',' . date('W'));
  fclose($log);
  echo 'Done';
  header('Location: ../index.php');
} else {
  echo 'You are not authorized';
} ?>
