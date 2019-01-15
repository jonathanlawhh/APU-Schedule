<?php
if(isset($_GET['date']) && isset($_GET['duty'])){
  $dutylist = array();
  $idate = $_GET['date']; $iduty = $_GET['duty'];
  if(($handle = fopen('../data/gen-roster.csv', 'r')) !== false) {
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $columns = $data;
        $dDate = array_search($columns[0], $data);
        $dShift = array_search($columns[1], $data);
        $dJob = array_search($columns[2], $data);
        $dPerson = array_search($columns[3], $data);

        if((stripos($data[$dDate], $idate) !== false) && (stripos($data[$dJob], $iduty) !== false)) {
          $results[] = $data;
          $b = trim($data[$dShift]);
          $a = trim($data[$dPerson]);
          array_push($dutylist,array('shift'=>$b,'person'=>$a));
        }  //Cleanup and close table
    } fclose($handle);
  }
  echo json_encode($dutylist);
} else {
  echo "Nothing";
}?>
