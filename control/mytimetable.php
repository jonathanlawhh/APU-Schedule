<?php
// This will process mytimetable
$classroom = null; $results = $columns = array(); $intake = $_COOKIE['myIntakeCode-APU'];
if (!isset($intake)){ ?>
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

$date = date('D'); $needles = array($date); $needles02 = array($intake); ?>

<p id="timetableContent">Timetable for intake <?php echo "$intake on $date<br>"; ?><a href='settings.php'><i class='material-icons left'>settings</i>Settings</a></p>
<ul class="collapsible popout">
<li class="active"><div class="collapsible-header"><i class="material-icons">filter_drama</i><?php echo $date; ?></div><div class="collapsible-body">
<table class='responsive-table highlight bordered'><tbody>
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

        foreach($needles as $needle) { if(stripos($data[$date], $needle) !== false) {
          foreach($needles02 as $needle02) { if(stripos($data[$intake], $needle02) !== false) {
              $results[] = $data;
            echo "<tr>";
            echo "<td class='hide-on-small-only'>".$data[$date]."</td>";
            echo "<td>".$data[$time]."</td>";
            echo "<td class='hide-on-small-only'>".$data[$location]."</td>";
            echo "<td>".$data[$classroom]."</td>";
            echo "<td>".$data[$module]."</td>";
            echo "<td>".$data[$lecterur]."</td>";
            echo "</tr>";
            }}
        }}
    } //Cleanup and close table
    fclose($handle); }
    echo "</tbody></table></div></li></ul><script>M.Collapsible.init(document.querySelectorAll('.collapsible'),{});</script>";
end: ?>
