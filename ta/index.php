<?php
$searchUser = $_POST['user'];
if(isset($searchUser)){
  setcookie('myName-APU', $searchUser, time() + 31536000, '/');
  echo "<script>window.location.replace('index.php');</script>";
}
$timeNow = date('Hi');
$today = date('l');
if ($today === 'Saturday'){ $currShift = 'Saturday'; }
elseif ('0800'<=$timeNow && $timeNow<='1029'){ $currShift = "S1"; }
elseif ('1030'<=$timeNow && $timeNow<='1229'){ $currShift="S2"; }
elseif ('1230'<=$timeNow && $timeNow<='1429'){ $currShift = "S3"; }
elseif ('1430'<=$timeNow && $timeNow<='1629'){ $currShift = "S4"; }
elseif ('1630'<=$timeNow && $timeNow<='1829'){ $currShift = "S5"; }
elseif ('1830'<=$timeNow && $timeNow<='2130'){ $currShift = "S6"; }
else { $currShift = "none"; } ?>
<head>
  <title>TA Final Roster</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/materialize.min.css" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="../css/materialize.min.css"></noscript>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"></noscript>
	<link rel="icon" href="../images/favicon.png">
  <meta name="theme-color" content="#0d47a1">
  <script type="text/javascript" src="../js/materialize.min.js" async></script>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; }
	  main {  flex: 1 0 auto; }
  </style>
</head>

<body>
<main>
<nav>
  <div class="nav-wrapper blue darken-3">
    <form action="index.php" method="POST">
      <div class="input-field">
        <input id="search" type="search" name="user" placeholder="Enter your name here" required>
        <label class="label-icon" for="search"><i class="material-icons">search</i></label>
        <i class="material-icons">close</i>
      </div>
    </form>
  </div>
</nav>

<div class="container">
  <?php
  $searchUser = $_COOKIE['myName-APU'];
  if(isset($searchUser)){
    $a = 'D:\home\python364x64\python.exe reader.py -u ' . '"' . $searchUser . '"';
    exec($a, $returnval); ?>

    <h4>TA Duty Roster for <?php echo $searchUser; ?></h4>
    <p>Roster for the week of <?php exec("D:\home\python364x64\python.exe currRoster.py", $rosterWeek); foreach($rosterWeek AS $weekOf){echo $weekOf;} ?></p>
    <p>Current ongoing shift : <?php echo $currShift; ?></p>
    <div class="row">
    <div class="col s12">
      <div class="card hoverable">
        <div class="card-content">
          <span class="card-title">Duty summary</span>
    <?php
    $totalHours = 0;
    foreach($returnval AS $array){
      $explodedArray = explode( ',', $array);
      if($t1 === $explodedArray[0] && $t2 === $explodedArray[1]){ continue; } else {
        $e0 = trim($explodedArray[0]); $e1 = trim($explodedArray[1]);
        if($e1==='S6'){ $totalHours += 3; }
        elseif($e1==='Saturday'){ $totalHours += 9; }
        else { $totalHours += 2; }

        if(($e0===$today && $e1===$currShift) || ($e0===$today && $today==='Saturday')){ ?>
        <p>Duty now as <?php echo $explodedArray[2] . ' for ' . $e1;?></p>
      <?php }} $t1 = $explodedArray[0]; $t2 = $explodedArray[1]; }
        if(empty($t2)){ ?>
        <p>Please ensure the name you used is exactly same as shown in final roster.<br>For eg, Jonathan instead of jonathan</p> <?php } else { ?>
        <p>Total duty hours this week : <?php echo $totalHours; ?></p><?php } ?>
        </div>
      </div>
    </div>
    </div>

    <a id='hidemsg' onclick='hidethead()' class='hide-on-med-and-up'>Toggle table header</a>
    <table class="highlight responsive-table">
      <thead id='removethead'><tr><th>Day</th><th>Shift</th><th>Duty</th><th>Notes</th>
      </tr></thead>
      <tbody>
    <?php $t1 = $t2 = '';
    foreach($returnval AS $array){
      $explodedArray = explode( ',', $array);
      if($t1 === $explodedArray[0] && $t2 === $explodedArray[1]){ continue; } else {
        $e0 = trim($explodedArray[0]); $e1 = trim($explodedArray[1]);
        echo "<tr><td>$e0</td><td>$e1</td><td>$explodedArray[2]</td>";
        if($e0===$today && $e1===$currShift){
          echo "<td><span class='new badge' data-badge-caption='You have duty now'></span></td>";
        } elseif($e0===$today && $today==='Saturday'){
          echo "<td><span class='new badge' data-badge-caption='You have duty now'></span></td>";
        } else { echo "<td></td>"; }
        echo '</tr>'; }
        $t1 = $explodedArray[0]; $t2 = $explodedArray[1];
    } ?> </tbody></table><div style="margin-bottom:30px"></div><?php } ?>

</div>
</main>
<footer class="page-footer grey darken-3">
  <div class="footer-copyright grey darken-4">
    <div class="container">APU Schedule <a href="https://apu-schedule.azurewebsites.net">here</a></div>
  </div>
</footer>
<script>
function hidethead() {
var a = document.getElementById("removethead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;", document.getElementById("hidemsg").innerHTML = "Hide table header;") : (a.style.display = "none", document.getElementById("hidemsg").innerHTML = "Show table header", document.cookie = "apuschedule-tablehead=hidden;");
}
</script>
</body>
