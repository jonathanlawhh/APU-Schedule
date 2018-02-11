<?php
// This will process all query and logic
// Goal is to clean main index.php\
$results = $columns = array();
$headMsg = 'Hide table header';
if(isset($_COOKIE['apuschedule-tablehead'])){ $tablehead = "style='display:none'"; $headMsg = 'Show table header'; }

//XSS Detection
if (preg_match('/[\'"^$%*}{?><>,|;]/', $_POST['classroom'])){ echo "<script>warning();</script><div class='marginleft4'><h4>(ง'̀-'́)ง</h4><p><b>I smell weird attempts...</b><br>But why though :(</p></div>"; exit; }

//Start Query
if (isset($_POST['search'])) {
  $queryFor = 'intake'; $queryValue = $_POST['classroom']; $hideItems = "class='hide-on-small-only'";

  if(preg_match("/\b(LAB|Auditorium|B-|D-|E-|STUDIO)\b/i", $queryValue)) { $queryFor = 'classroom'; $hideItems = ''; }
  elseif (empty($queryValue)){ tutorial(); goto end; }

  $needles = array($date); $needles02 = array($queryValue);

  echo "<p>Timetable for $queryFor $queryValue on $date</p>
        <a id='hidemsg' onclick='hidethead()' class='hide-on-med-and-up'>$headMsg</a>";
  echo "<table class='responsive-table highlight bordered'><thead id='removethead' $tablehead><tr>
            <th $hideItems>Intake</th><th class='hide-on-small-only'>Date</th><th>Time</th><th class='hide-on-small-only'>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th>
        </tr></thead>";

  if(($handle = fopen('data/data.csv', 'r')) !== false) {
    echo '<tbody>';
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $columns = $data;
        $intake = array_search($columns[1], $data);
        $date = array_search($columns[2], $data);
        $time = array_search($columns[3], $data);
        $location = array_search($columns[4], $data);
        $classroom = array_search($columns[5], $data);
        $module = array_search($columns[6], $data);
        $lecterur = array_search($columns[7], $data);

        if($queryFor === 'intake'){ $searchThis = $intake; } else { $searchThis = $classroom; }

        foreach($needles as $needle) { if(stripos($data[$date], $needle) !== false) {
          foreach($needles02 as $needle02) { if(stripos($data[$searchThis], $needle02) !== false) {
              $results[] = $data;
              echo '<tr>';
              echo '<td ' . $hideItems . '>' . $data[$intake] . '</td>';
              echo '<td class=' . 'hide-on-small-only' . '>' . $data[$date] . '</td>';
              echo '<td>' . $data[$time] . '</td>';
              echo '<td class=' . 'hide-on-small-only' . '>' . $data[$location] . '</td>';
              echo '<td>' . $data[$classroom] . '</td>';
              echo '<td>' . $data[$module] . '</td>';
              echo '<td>' . $data[$lecterur] . '</td>';
              echo '</tr>';
            } else { echo '<p>Either the classrooms do not exist or are empty</p>'; break 3;}}
        } else { echo '<p>Are you sure there are classes today?</p>'; break 2;}}   //Cleanup and close table
    } fclose($handle); echo "</tbody></table><div class='row'></div>";
  }
} else { tutorial(); }

end:
?>
