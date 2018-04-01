<?php
// This will process all query and logic
// Goal is to clean main index.php\
$idate = $_POST['date'];
$now = date('H:i');
$headMsg = 'Hide table header';

if(isset($_COOKIE['apuschedule-tablehead'])){ $tablehead = "style='display:none'"; $headMsg = 'Show table header'; }

//XSS Detection
if (preg_match('/[\'"^$%*}{?><>,|;]/', $_POST['classroom'])){ echo "<script>warning();</script><div class='marginleft4'><h4>(ง'̀-'́)ง</h4><p><b>I smell weird attempts...</b><br>But why though :(</p></div>"; exit; }

//Start Query
$queryFor = 'intake'; $queryValue = $_POST['classroom']; $hideItems = "class='hide-on-small-only'";

if(preg_match("/\b(LAB|Auditorium|B-|D-|E-|STUDIO)\b/i", $queryValue)) { $queryFor = 'classroom'; $hideItems = ''; }
elseif (empty($queryValue)){
    echo "<div class='marginleft4' id='tutorial'><h4>ಠ_ಠ</h4><p>The keyword [ Lab / B- / Studio ] is used to search for classes<br>You can also search for your intake timetable here<br>
    Restructuring codes to remove jQuery, things will break<br>Check the syntax tab for more<br></p></div>"; goto end; }
if(isset($_POST['emptyClass']) && $_POST['emptyClass']!=NULL && $queryFor == 'classroom'){ $emptyClass='checkMe'; $ect = "style='display:none;'"; }

echo "<thead id='removethead' $tablehead><tr>
          <th $hideItems $ect>Intake</th><th class='hide-on-small-only'>Date</th><th>Time</th><th class='hide-on-small-only'>Location</th><th>Classroom</th><th $ect>Module</th><th $ect>Lecterur</th>
      </tr></thead><tbody>";

if(($handle = fopen('../data/data.csv', 'r')) !== false) {
    while(($data = fgetcsv($handle, 4096, ',')) !== false) {
      $intake = array_search($data[0], $data);
      $date = array_search($data[1], $data);
      $time = array_search($data[2], $data);
      $location = array_search($data[3], $data);
      $classroom = array_search($data[4], $data);
      $module = array_search($data[5], $data);
      $lecterur = array_search($data[6], $data);

      if($queryFor === 'intake'){ $searchThis = $intake; } else { $searchThis = $classroom; }
      if((stripos($data[$date], $idate) !== false) && (stripos($data[$searchThis], $queryValue) !== false)) {
        $dt = $data[$time]; $newcr = $data[$classroom];
        $checkDT = explode( '-', $dt);
        if($emptyClass=='checkMe' && $v1 == $dt && $queryFor == 'classroom' && $newcr==$ocr){ continue 1; }
        if(trim($checkDT[0])>$now && trim($oDT1)<$now && $emptyClass=='checkMe'){ echo "<script>document.getElementById('emptyInfo').style.display = 'block';</script>"; }
        else { echo "<script>document.getElementById('emptyInfo').style.display = 'none';</script>"; }
        echo "<tr><td $hideItems $ect>$data[$intake]</td><td class='hide-on-small-only'>$data[$date]</td><td>$dt</td><td class='hide-on-small-only'>$data[$location]</td><td>$newcr</td><td $ect>$data[$module]</td><td $ect>$data[$lecterur]</td></tr>";
        $v1 = $dt; $oDT1 = $checkDT[1]; $ocr = $newcr;
      }  //Cleanup and close table
  } fclose($handle); echo '</tbody>';
  if(trim($oDT1)<$now && $emptyClass=='checkMe'){ echo "<script>document.getElementById('emptyInfo').style.display = 'block';</script>"; }
}

end:
?>
