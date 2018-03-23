<?php $intakedat = $_POST['intake'];
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
<?php goto end; } $daysOfWeek = array("Monday","Tuesday","Wednesday","Thursday","Friday"); ?>
<p id="timetableContent">Timetable for intake <?php echo "$intakedat<br>"; ?><a href='settings.php'><i class='material-icons left'>settings</i>Settings</a></p>
<ul class="collapsible popout">
<?php for($i=0; $i<5; $i++){ $idate = substr($daysOfWeek[$i],0,3); ?>
  <li <?php $today = date('D'); if($today===$idate){ echo "class='active'"; } ?> onclick="getCurTimetable('<?php echo $idate; ?>');"><div class="collapsible-header"><i class="material-icons">arrow_drop_down</i><?php echo $daysOfWeek[$i]; ?></div>
    <div class="collapsible-body"><table class='responsive-table highlight bordered'><tbody id="<?php echo $idate; ?>"><?php if($today===$idate){ include('getTimetable.php'); getTimetable($today); }?></tbody></table></div></li>
<?php } ?></ul>
<?php end: ?>
<script>M.Collapsible.init(document.querySelectorAll('.collapsible'),{});</script>
