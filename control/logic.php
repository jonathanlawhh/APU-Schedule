<?php
// This will process all query and logic
// Goal is to clean main index.php

$i = 0;
$classroom = null;

$results = array();
$columns = array();

if ($_POST['intakebtn']=="Intake") {
  $intake=$_POST["classroom"];
  if($intake == ""){
    tutorial();
    goto end;
  }
  // XSS detection
  if (preg_match('/[\'"^$%*}{@#~?><>,|]/', $intake))
  {
     xss_warning();
     goto end;
  }
  $needles = array($date);
  $needles02 = array($intake);

echo "<p>Timetable for intake $intake on $date</p>";
hidemsg();
echo "<thead id='removethead'><tr><th class='hide-on-small-only'>Intake</th><th class='hide-on-small-only'>Date</th><th width='15%'>Time</th><th class='hide-on-small-only'>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
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
            echo "<td class='hide-on-small-only'>".$data[$intake]."</td>";
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
} elseif ($_POST['intakebtn']=="Class") {
  $classroom=$_POST["classroom"];
  if($classroom == ""){
    tutorial();
    goto end;
  }
  // XSS detection
  if (preg_match('/[\'"^$%*}{@#~?><>,|]/', $classroom))
  {
     xss_warning();
     goto end;
  }

  $needles = array($date);
  $needles02 = array($classroom);
echo "<p>Classroom schedule for $classroom on $date</p>";
hidemsg();
echo "<thead id='removethead'><tr><th width='15%'>Time</th><th>Date</th><th>Intake</th><th class='hide-on-small-only'>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
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

  $test=array_search($columns[0], $data);
        foreach($needles as $needle) {
        if(stripos($data[$date], $needle) !== false) {
          foreach($needles02 as $needle02) {
            if(stripos($data[$classroom], $needle02) !== false) {
              $results[] = $data;
              echo "<tr>";
              echo "<td>".$data[$time]."</td>";
              echo "<td>".$data[$intake]."</td>";
              echo "<td>".$data[$date]."</td>";
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
} else {
  tutorial();
}

end:
?>
