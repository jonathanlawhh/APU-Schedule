<?php
// This will process mytimetable
$classroom = null; $results = $columns = array(); $intakedat = $_POST['intake'];
if ($intakedat==""){ ?>
  <div class='row' id="timetableContent">
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
  </div>
<?php goto end; }

$daysOfWeek = array("Monday","Tuesday","Wednesday","Thursday","Friday"); ?>

<p id="timetableContent">Timetable for intake <?php echo "$intakedat<br>"; ?><a href='settings.php'><i class='material-icons left'>settings</i>Settings</a></p>
<ul class="collapsible popout">
<?php for($i=0; $i<5; $i++){ $idate = substr($daysOfWeek[$i],0,3); ?>
  <li <?php if(date('D')===$idate){ echo "class='active'"; } ?>><div class="collapsible-header"><i class="material-icons">filter_drama</i><?php echo $daysOfWeek[$i]; ?></div>
    <div class="collapsible-body"><table class='responsive-table highlight bordered'><tbody>
      <?php
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
              echo "<tr><td class='hide-on-small-only'>$data[$date]</td><td>$data[$time]</td><td class='hide-on-small-only'>$data[$location]</td>
              <td>$data[$classroom]</td><td>$data[$module]</td><td $ect>$data[$module]</td><td>$data[$lecterur]</td></tr>"; }
        } //Cleanup and close table
        fclose($handle); }
      ?></tbody></table></div></li>
<?php } ?></ul>
<?php end: ?>
<script>M.Collapsible.init(document.querySelectorAll('.collapsible'),{});</script>
