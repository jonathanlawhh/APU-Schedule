<!-- APU Schedule by jonathan law -->
<?php
$date = $_POST['date'] ?? 'TODAY';
function checkLastDate($dateInput){ if($_POST['date'] === $dateInput){ echo 'checked'; }}
include('control/theme.php'); ?>
<head>
	<meta http-equiv="cache-control" content="max-age=518400" />
	<title>APU/APIIT Schedule</title>
	<link rel="preload" href="css/materialize.min.css" as="style" onload="this.rel='stylesheet'"/>
	<link rel="preload" href="https://fonts.googleapis.com/icon?family=Material+Icons" as="style" onload="this.rel='stylesheet'"/>
	<link rel="icon" href="images/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="theme-color" content="<?php echo $theme_meta ?>">
	<script type="text/javascript" src="js/materialize.min.js" async></script>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; }
	  main {  flex: 1 0 auto; }
		.marginleft4 { margin-left: 4%; }
  </style>
</head>
<script async>
function changedefault() {
document.getElementById("headercolor").className = "nav-extended <?php echo $theme_color ?>";
document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_meta ?>");
}
function changemytimetable() {
document.getElementById("headercolor").className = "nav-extended brown darken-4";
document.querySelector("meta[name=theme-color]").setAttribute("content", "#3e2723");
}
function changesyntax() {
document.getElementById("headercolor").className = "nav-extended <?php echo $theme_syntax ?>";
document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_metasyntax ?>");
}
function warning() {
document.getElementById("headercolor").className = "nav-extended red darken-3";
document.getElementById("btn_all").className = "waves-effect waves-light btn col s4 m2 l2 red darken-1";
document.querySelector("meta[name=theme-color]").setAttribute("content", "#b71c1c");
}
function hidethead() {
var a = document.getElementById("removethead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;", document.getElementById("hidemsg").innerHTML = "Hide table header;") : (a.style.display = "none", document.getElementById("hidemsg").innerHTML = "Show table header", document.cookie = "apuschedule-tablehead=hidden;");
}
</script>

<body>
  <main>
  <nav id="headercolor" class="nav-extended <?php echo $theme_color; ?>" style="margin-bottom:10px;">
    <div class="container">
      <span class="nav-title hide-on-small-only">APU/APIIT Schedule</span>
      <b><span class="show-on-small hide-on-med-and-up" style="margin-bottom:0; font-size:22px;">APU/APIIT Schedule</span></b>
      <div class="nav-content">
        <ul class="tabs tabs-transparent">
          <li class="tab" onclick="changedefault()"><a href="#schedule">Schedule</a></li>
          <li class="tab" onclick="changemytimetable()"><a href="#mytimetable">My Timetable</a></li>
          <li class="tab" onclick="changesyntax()"><a href="#syntax">Syntax</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="schedule" class="container">
    <form class="col s12" action="index.php" method="post">
		<p>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-0" value="<?php echo date('D'); ?>" <?php if($date === 'TODAY' || $date === 'Sat' || $date === 'Sun'){?>checked<?php } ?>/>
	      <span class="tooltipped" data-position="top" data-delay="50" data-tooltip="<?php echo date('D'); ?>">TODAY</span>
	    </label>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-1" value="Mon" <?php checkLastDate("Mon"); ?>/>
	      <span>MONDAY</span>
	    </label>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-2" value="Tue" <?php checkLastDate("Tue"); ?>/>
	      <span>TUESDAY</span>
	    </label>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-3" value="Wed" <?php checkLastDate("Wed"); ?>/>
	      <span>WEDNESDAY</span>
	    </label>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-4" value="Thu" <?php checkLastDate("Thu"); ?>/>
	      <span>THURSDAY</span>
	    </label>
	    <label>
	      <input class="with-gap" name="date" type="radio" id="option-5" value="Fri" <?php checkLastDate("Fri"); ?>/>
	      <span>FRIDAY</span>
	    </label>
	  </p>
	<br>
		<div class="row">
      <div class="input-field col s12 m6 l3" style="margin-top:0; padding:0;">
          <input list="classlist" placeholder="eg. LAB 4-01 or UCDF1604ICT(SE)" name="classroom" type="text">
      </div>
			<datalist id="classlist">
	   		  <?php $list = fopen("data/classlist.txt", "r");
	   			while(!feof($list)) { echo "<option value='" . trim(fgets($list)) . "'/>"; } fclose($list); ?>
		  </datalist>
		  <button type="submit" id="btn_all" name="search" class="waves-effect waves-light btn col s5 m3 l2 <?php echo $theme_secondary ?>" style="margin-left:20px;">
				<i class="material-icons left">lightbulb_outline</i>Search
			</button>
		 </div>
		</form>

    <?php include("control/logic.php"); ?>
  </div>

	<div id="mytimetable" class="container">
    <?php include('control/mytimetable.php');
		function tutorial(){
			echo "<div class='marginleft4'><h4>ಠ_ಠ</h4><p>The keyword [ Lab / B- / Studio ] is used to search for classes <br>
			You can also search for your intake timetable here<br>
			Check the syntax tab for more</p>
			<p>Web page not loading correctly?<br>Select refresh <a href='settings.php'>here</a><br></p>
			</div>"; } ?>
  </div>

  <div id="syntax" class="container">
    <div class="row">
      <div class="col s12 m12 l5">
        <div class="card-panel hoverable">
          <span>
            <div class="section">
              <b>To search for labs</b><br>LAB 4-01, or just typing LAB 4 will search all labs on level 4. LAB 4-01 will search for that lab only.
            </div>
            <div class="divider"></div>
            <div class="section">
              <b>To search for classes</b><br>B-04-02, or just typing B-04 will search all classes on block B level 4. Offices are not included in the search
            </div>
            <div class="divider"></div>
            <div class="section">
              <b>Auditoriums</b><br>Auditorium 3 will search for Auditorium 3. Auditoriums used for events are not shown here.
            </div>
            <div class="divider"></div>
            <div class="section">
              <b>APIIT classrooms</b><br>L2 classrooms will not show here.
            </div>
          </span>
        </div>
				<div class="card-panel hoverable">
          <span>
            <div class="section">
              <b>Experimental</b><br>
              - New search method <br>
							- Browser caching ( Max 6 days cache ) <br>
							- Brotli compression <br>
            </div>
          </span>
        </div>
      </div>
    </div>

  </div>
</main>

<footer class="page-footer grey darken-3">
  <div class="footer-copyright grey darken-4">
    <div class="container">
    Deprecated website <a href="http://apu-schedule.azurewebsites.net/redirect.html">here</a>
    </div>
  </div>
</footer>
<script type="text/javascript">
function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	M.Tooltip.init(document.querySelectorAll('.tooltipped'), {});
	}
	window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
</script>
</body>
