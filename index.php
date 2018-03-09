<!-- APU Schedule by jonathan law -->
<html lang="en">
<?php
$date = $_POST['date'] ?? 'TODAY';
function checkLastDate($dateInput){ if($_POST['date'] === $dateInput){ echo 'checked'; }}
include('control/theme.php'); ?>
<head>
	<meta http-equiv="cache-control" content="max-age=518400" />
	<title>APU/APIIT Schedule</title>
	<link rel="stylesheet" href="css/materialize.min.css" media="none" onload="if(media!='all')media='all'">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" media="none" onload="if(media!='all')media='all'">
	<link rel="icon" href="images/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="keywords" content="APU,APIIT,schedule">
  <meta name="author" content="jonathan law">
	<meta name="description" content="APU/APIIT Schedule">

	<meta name="theme-color" content="<?php echo $theme_meta ?>">
	<script type="text/javascript" src="js/materialize.min.js" async></script>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js" async></script>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; }
	  main {  flex: 1 0 auto; }
		a { color: #f4511e; }
		::selection { background: #d81b60; color:#ffffff;}
		::-moz-selection { background: #d81b60; color:#ffffff; }
		.marginleft4 { margin-left: 4%;}
		.marginbottom20 { margin-bottom: 20px;}
  </style>
</head>

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
          <li class="tab" onclick="loadSyntax()"><a href="#syntax">Syntax</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="schedule" class="container">
		<p>
			<label>
			  <input class="with-gap dateDay" name="date" type="radio" id="option-0" value="<?php echo date('D'); ?>" <?php if($date === 'TODAY' || $date === 'Sat' || $date === 'Sun'){?>checked<?php } ?>/>
			  <span>TODAY</span>
			</label>
			<label id="day"></label>
			<p><label><input type="checkbox" class="emptyClass"/><span>I just want to find when the classroom will be empty</span></label></p>
		</p>
	<br>
		<div class="row">
      <div class="input-field col s12 m6 l3" style="margin-top:0; padding:0;">
          <input list="classlist" placeholder="eg. LAB 4-01 or UCDF1604ICT(SE)" name="classroom" type="text" id="searchVal">
      </div>
			<datalist id="classlist">
	   		  <?php $list = fopen("data/classlist.txt", "r");
	   			while(!feof($list)) { echo "<option value='" . trim(fgets($list)) . "'/>"; } fclose($list); ?>
		  </datalist>
			<button onclick="doSearch()" id="btn_all" class="waves-effect waves-light btn col s9 m3 l2 <?php echo $theme_secondary ?>" style="margin-left:20px;">
			 <i class="material-icons left">lightbulb_outline</i>Search
		 </button>
		 </div>


 			<div class='marginleft4' id="tutorial"><h4>ಠ_ಠ</h4><p>The keyword [ Lab / B- / Studio ] is used to search for classes<br>
 				You can also search for your intake timetable here<br>
 				Check the syntax tab for more<br></p>
 			</div>
			<p>
				<span id="searchInfo"></span>
				<span id="emptyInfo" style="display:none;">This class is empty now</span>
			</p>
			<a id='hidemsg' onclick='hidethead()' class='hide-on-med-and-up' style="display:none;">Toggle table header</a>
			<table id="resultArea" class='responsive-table highlight bordered marginbottom20'></table>
			<p class="marginbottom20" ><?php $list = fopen("data/update.log", "r");
			while(!feof($list)) { echo 'Schedule updated on ' . trim(fgets($list)); } fclose($list); ?></p>
  </div>

	<div id="mytimetable" class="container"></div>
  <div id="syntax" class="container"></div>
</main>

<footer class="page-footer grey darken-3">
  <div class="footer-copyright grey darken-4">
    <div class="container">Deprecated website <a href="http://apu-schedule.azurewebsites.net/redirect.html">here</a><br></div>
  </div>
</footer>

<script type="text/javascript">
function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	$("#day").load("fragment/dayselection.html");
}
window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
document.getElementById("searchVal").addEventListener("keyup", function(a) { a.preventDefault(); 13 === a.keyCode && doSearch(); });

function doSearch() {
var checkedValue = document.querySelector(".emptyClass"), lol = "";
lol = checkedValue.checked ? "on" : null;
var a = document.getElementById("searchInfo"), c = document.getElementById("resultArea"), d = document.getElementById("tutorial"), e = document.querySelector(".dateDay:checked").value, f = document.getElementById("hidemsg"), b = document.getElementById("searchVal").value;
b ? $.ajax({type:"post", url:"control/logic.php", dataType:"text", data:{classroom:b, date:e, emptyClass:lol}, success:function(g) {
	d.style.display = "none"; c.removeAttribute("style"); f.removeAttribute("style"); a.style.display = "block"; a.innerHTML = "Results for " + b + " on " + e;
	$("#resultArea").html(g);
}}) : d.style.display = "block"; f.style.display = "none"; c.style.display = "none"; a.style.display = "none"; f.style.display = "none"; }

function changemytimetable() {
  document.getElementById("timetableContent") || $("#mytimetable").load("control/mytimetable.php");
	document.getElementById("headercolor").className = "nav-extended brown darken-4";
	document.querySelector("meta[name=theme-color]").setAttribute("content", "#3e2723"); }

function loadSyntax() {
  document.getElementById("syntaxRow") || $("#syntax").load("syntax.html");
	document.getElementById("headercolor").className = "nav-extended <?php echo $theme_syntax ?>";
	document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_metasyntax ?>"); }

function changedefault() {
document.getElementById("headercolor").className = "nav-extended <?php echo $theme_color ?>";
document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_meta ?>"); }

function warning() {
document.getElementById("headercolor").className = "nav-extended red darken-3";
document.getElementById("btn_all").className = "waves-effect waves-light btn col s4 m2 l2 red darken-1";
document.querySelector("meta[name=theme-color]").setAttribute("content", "#b71c1c"); }

function hidethead() {
var a = document.getElementById("removethead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;", document.getElementById("hidemsg").innerHTML = "Hide table header;") : (a.style.display = "none", document.getElementById("hidemsg").innerHTML = "Show table header", document.cookie = "apuschedule-tablehead=hidden;expires=Mon, 31 Dec 2018 20:00:00 UTC; path=/;");
}
</script>
</body>
</html>
