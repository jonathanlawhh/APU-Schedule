<?php
if(isset($_POST['postData'])){ searchData($_POST['postData'],$_POST['intake']); }
function searchData($paraDate, $paraIntake, $paraClass=''){
  echo "<tbody>";
  $idate = $paraDate; $intakedat = $paraIntake;
  if(($handle = fopen('../data/data.csv', 'r')) !== false) {
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $columns = $data;
        $intake = array_search($columns[1], $data);
        $date = array_search($columns[2], $data);
        $time = array_search($columns[3], $data);
        $location = array_search($columns[4], $data);
        $classroom = array_search($columns[5], $data);
        $module = array_search($columns[6], $data);
        $lecterur = array_search($columns[7], $data);

        if((stripos($data[$date], $idate) !== false) && stripos($data[$intake], $intakedat) !== false) {
          $results[] = $data;
          return "<tr><td class='hide-on-small-only'>$data[$date]</td><td>$data[$time]</td><td>$dt</td><td class='hide-on-small-only'>$data[$location]</td><td>$data[$classroom]</td><td>$data[$module]</td><td>$data[$lecterur]</td></tr>";
        }
    } //Cleanup and close table
    fclose($handle); } echo "</tbody>";
}
?>
