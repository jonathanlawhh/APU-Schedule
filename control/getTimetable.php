<?php
function getTimetable($when){
  $intakedat = $_COOKIE['myIntakeCode-APU']; $idate=$when; $ID = $idate . 'Data';
  if(($handle = fopen('../data/data.csv', 'r')) !== false) {
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $intake = array_search($data[0], $data);
        $date = array_search($data[1], $data);
        $time = array_search($data[2], $data);
        $location = array_search($data[3], $data);
        $classroom = array_search($data[4], $data);
        $module = array_search($data[5], $data);
        $lecterur = array_search($data[6], $data);

        if((stripos($data[$date], $idate) !== false) && stripos($data[$intake], $intakedat) !== false) {
          echo "<tr id='$ID'><td class='hide-on-small-only'>$data[$date]</td><td>$data[$time]</td><td class='hide-on-small-only'>$data[$location]</td>
          <td>$data[$classroom]</td><td>$data[$module]</td><td>$data[$lecterur]</td></tr>"; }
    } fclose($handle); } }

if(isset($_POST['getMe'])){ getTimetable($_POST['getMe']); } ?>
