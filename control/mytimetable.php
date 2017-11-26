<?php
// This will process all query and logic
// Goal is to clean main index.php

$i = 0;
$classroom = null;

$results = array();
$columns = array();
$intake = $_COOKIE['myIntakeCode-APU'];
  if (!isset($intake)){
    echo "
    <div class='row'>
      <div class='col s12 m12 l5'>
        <div class='card-panel hoverable'>
          <span>
            <div class='section'>
              <b>No intake code found</b><br><br>
              <a href='settings.php'><i class='material-icons left'>settings</i> Go to settings</a> <br><br>
              Please add an intake at the settings <a href='settings.php'>here</a> <br>
              Please note that cookies will be used to store your intake code.
            </div>
          </span>
        </div>
      </div>
    </div>";
    goto end;
  }

$date = date('D');
$needles = array($date);
$needles02 = array($intake);

echo "<p>Timetable for intake $intake on $date<br><a href='settings.php'>Settings</a></p>";
hidemsg();
echo "<thead id='removethead'><tr><th class='hide-on-small-only'>Date</th><th width='15%'>Time</th><th class='hide-on-small-only'>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
  if(($handle = fopen('data/data.csv', 'r')) !== false) {
    echo "<tbody>";
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
      if($i == 0)  {
        $columns = $data;
        $i++;
        $weekof = array_search($columns[0], $data);
        $intake = array_search($columns[1], $data);
        $date = array_search($columns[2], $data);
        $time = array_search($columns[3], $data);
        $location = array_search($columns[4], $data);
        $classroom = array_search($columns[5], $data);
        $module = array_search($columns[6], $data);
        $lecterur = array_search($columns[7], $data);

      } else {

        foreach($needles as $needle) {
        if(stripos($data[$date], $needle) !== false) {
          foreach($needles02 as $needle02) {
            if(stripos($data[$intake], $needle02) !== false) {
              $results[] = $data;
            echo "<tr>";
            echo "<td class='hide-on-small-only'>".$data[$date]."</td>";
            echo "<td>".$data[$time]."</td>";
            echo "<td class='hide-on-small-only'>".$data[$location]."</td>";
            echo "<td>".$data[$classroom]."</td>";
            echo "<td>".$data[$module]."</td>";
            echo "<td>".$data[$lecterur]."</td>";
            echo "</tr>";
            }
          }
        }
        }
      }
    }
    fclose($handle);
  }

end:
?>
