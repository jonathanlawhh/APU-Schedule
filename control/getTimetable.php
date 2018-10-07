<?php
function getTimetable($when){
  $intakedat = $_COOKIE['myIntakeCode-APU']; $idate=$when;
  if(($handle = fopen('data/data.csv', 'r')) !== false) {
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $intake = array_search($data[0], $data);
        $date = array_search($data[1], $data);
        $time = array_search($data[2], $data);
        $classroom = array_search($data[4], $data);
        $module = array_search($data[5], $data);
        $lecturer = array_search($data[6], $data);

        if((stripos($data[$date], $idate) !== false) && stripos($data[$intake], $intakedat) !== false) {
          echo "<tr><td>$data[$time]</td>
          <td>$data[$classroom]</td><td>$data[$module]</td><td>$data[$lecturer]</td></tr>"; }
    } fclose($handle); } }

  function getTimetableAPI($intakedat){
    if(($handle = fopen('../data/data.csv', 'r')) !== false) {
        $temp = array();
        while(($data = fgetcsv($handle, 4096, ',')) !== false) {
          $intake = array_search($data[0], $data);
          $date = array_search($data[1], $data);
          $time = array_search($data[2], $data);
          $classroom = array_search($data[4], $data);
          $module = array_search($data[5], $data);
          $lecturer = array_search($data[6], $data);

          if(stripos($data[$intake], $intakedat) !== false) {
            array_push($temp,array('date'=>$data[$date],'time'=>$data[$time],'classroom'=>$data[$classroom],'module'=>$data[$module],'lecturer'=>$data[$lecturer]));
      }} fclose($handle);
    }
    return json_encode($temp);
  } ?>
