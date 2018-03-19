<?php
if(isset($_POST['date']) && isset($_POST['duty'])){
  $idate = $_POST['date']; $iduty = $_POST['duty'];
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
          echo "addSec('$b','$a');";
        }  //Cleanup and close table
    } fclose($handle);
  }
} else { header('Location: index.php'); } ?>
