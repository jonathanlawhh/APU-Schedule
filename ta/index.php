<?php
$searchUser = $_COOKIE['myName-APU'];
$timeNow = date('Hi'); $today = date('l');
if ($today === 'Saturday'){ $currShift = 'Saturday'; }
elseif ($today === 'Sunday'){ $currShift = 'It is Sunday...'; }
elseif ('0800'<=$timeNow && $timeNow<='1029'){ $currShift = 'S1'; }
elseif ('1030'<=$timeNow && $timeNow<='1229'){ $currShift='S2'; }
elseif ('1230'<=$timeNow && $timeNow<='1429'){ $currShift = 'S3'; }
elseif ('1430'<=$timeNow && $timeNow<='1629'){ $currShift = 'S4'; }
elseif ('1630'<=$timeNow && $timeNow<='1829'){ $currShift = 'S5'; }
elseif ('1830'<=$timeNow && $timeNow<='2130'){ $currShift = 'S6'; }
else { $currShift = 'none / overtime'; } ?>
<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
  <title>TA Final Roster</title>
  <meta name="theme-color" content="#0d47a1">
  <?php include('../fragment/frameworkImportsTA.html'); ?>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; }
    ::selection { background: #43a047; color:#ffffff;} ::-moz-selection { background: #43a047; color:#ffffff; }
    .tabs .indicator { background-color: #0288d1; } .iconfix { vertical-align: bottom; } .marginbottom20 { margin-bottom:20px; }
  </style>
</head>

<body>
<main>
<nav>
  <div class="nav-wrapper blue darken-3">
    <form action="fragment/setTA.php" method="POST">
      <div class="input-field">
        <input id="search" type="search" name="user" placeholder="Enter your name here" required>
        <label class="label-icon" for="search"><i class="material-icons">search</i></label><i class="material-icons">close</i>
      </div>
    </form>
  </div>
</nav>
<div class="row">
  <div class="col s12">
    <ul class="tabs">
      <li class="tab col s6 m5"><a class="active blue-text text-darken-1" href="#main">my Duty</a></li>
      <li class="tab col s6 m6" onclick="loadOnDuty();"><a class="blue-text text-darken-1" href="#onduty">onDuty</a></li>
    </ul>
  </div>
</div>

<div id="main" class="container">
  <?php if(isset($searchUser)){ ?>
    <script>
    function dutyNow(a, b) { document.getElementById("dutyNowLbl").innerHTML = "Duty now as " + a + " for " + b; }
    function totalHours(a) { document.getElementById("totalDutyHours").innerHTML = "Total duty hours this week : " + a; }
    function showSec(a) { document.getElementById(a + "Sec").removeAttribute("style"); }
    function addSec(a, b) { a += "c"; var c = document.createElement("p"); b = document.createTextNode(b); c.appendChild(b); document.getElementById(a).appendChild(c); }
    </script>
    <h4>TA Duty Roster for <?php echo $searchUser; ?></h4>
    <p>Roster for the week of <?php exec("D:\home\python364x64\python.exe currRoster.py", $rosterWeek); foreach($rosterWeek AS $weekOf){ echo $weekOf; } ?><br>
    Current ongoing shift : <?php echo $currShift; ?></p>
    <div class="row">
    <div class="col s12">
      <div class="card hoverable">
        <div class="card-content">
          <span class="card-title">Duty summary</span>
          <p id="dutyNowLbl"></p><p id="totalDutyHours"></p><a href="claim.php" target="_blank">Claim form generator</a>
          <p id="dutyNowLbl"></p><p id="totalDutyHours"></p><a href="claimform.php" target="_blank">New claim form generator [Broken]</a>
        </div>
      </div>
    </div>
    </div>

    <div id="MondaySec" style="display:none;"><h5>Monday</h5><div class="divider"></div><div id="Mondayc"></div></div><br>
    <div id="TuesdaySec" style="display:none;"><h5>Tuesday</h5><div class="divider"></div><div id="Tuesdayc"></div></div><br>
    <div id="WednesdaySec" style="display:none;"><h5>Wednesday</h5><div class="divider"></div><div id="Wednesdayc"></div></div><br>
    <div id="ThursdaySec" style="display:none;"><h5>Thursday</h5><div class="divider"></div><div id="Thursdayc"></div></div><br>
    <div id="FridaySec" style="display:none;"><h5>Friday</h5><div class="divider"></div><div id="Fridayc"></div></div><br>
    <div id="SaturdaySec" style="display:none;"><h5>Saturday</h5><div class="divider"></div><div id="Saturdayc"></div></div><br>

      <?php $totalHours = 0;
      if(($handle = fopen('../data/gen-roster.csv', 'r')) !== false) {
          while(($data = fgetcsv($handle, 4096, ',')) !== false) {
            $dDate = array_search($data[0], $data); $dShift = array_search($data[1], $data);
            $dJob = array_search($data[2], $data); $dPerson = array_search($data[3], $data);

            if(stripos($data[$dPerson], $searchUser) !== false) {
              $e2 = trim($data[$dJob]); $e1 = trim($data[$dShift]); $e0 = trim($data[$dDate]);
              echo "<script>showSec('$e0');</script>";
              if($e1==='S6'){ $totalHours += 3; } elseif ($e1==='S1'){ $totalHours += 2.25; } elseif ($e1==='Saturday'){ $totalHours += 9; } else { $totalHours += 2; } //Calculate total hours
              echo "<script>addSec('$e0','$e1 - $e2');</script>";
              if(($e0===$today && $e1===$currShift) || ($e0===$today && $today==='Saturday')){ echo "<script>dutyNow('$e2','$e1')</script>"; }
            }  //Cleanup and close table
        } fclose($handle);
      } else { echo "<p>Roster not found/generated...</p>"; } echo "<script>totalHours($totalHours);</script>"; ?><div class="marginbottom20"></div>
    <p class="deep-orange-text text-darken-1" onclick="clearCookie();"><i class="material-icons iconfix">clear_all</i>Click me to clear this website cookie</p>
    <div class="marginbottom20"></div>
<?php } else { include('userless.html'); } //Close isset($searchUser) ?>
</div>

<div id="onduty" class="container"></div>

</main>
<footer class="page-footer grey darken-3" id="meme">
  <div class="footer-copyright grey darken-4"><div class="container">APU Schedule <a href="../index.php">here</a></div></div>
</footer>
<script>
function initialize(){ M.Tabs.init(document.querySelectorAll('.tabs'), {});}
window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
function loadOnDuty() { if(!document.getElementById("ondutyContent")){
  var a = new XMLHttpRequest; a.open("POST", "fragment/duty.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send();
  a.onreadystatechange = function() {
    var script = document.createElement("script"); script.type = "text/javascript"; script.src = "fragment/doSearch.js?ver=1"; document.getElementsByTagName("head")[0].appendChild(script);
    document.getElementById("onduty").innerHTML = a.responseText; }
}}
function clearCookie() { document.cookie = "myName-APU=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;"; M.toast({html:"Cookies cleared!!"}); }
</script>
</body>
</html>
