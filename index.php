<?php include('control/theme.php');
$list = fopen("data/update.log", "r"); while(!feof($list)) { $updateDate = fgets($list); } fclose($list);
$updateDate = explode(',',$updateDate);
if(date('W') != trim($updateDate[1])){ header('Location: control/automatedUpdater.php?redirect=../index.php'); } ?>
<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
	<title>APU/APIIT Schedule</title>
	<meta name="keywords" content="APU,APIIT,schedule">
  <meta name="author" content="jonathan law">
	<meta name="description" content="APU/APIIT Schedule">

	<meta name="theme-color" content="<?php echo $theme_meta; ?>">
	<?php include('fragment/frameworkImports.html'); ?>
	<script type="text/javascript" src="js/core.js?ver=1.02" async></script>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; } a { color: #f4511e; }
		::selection { background: #d81b60; color:#ffffff;} ::-moz-selection { background: #d81b60; color:#ffffff; }
		.marginleft4 { margin-left: 4%;} .marginbottom20 { margin-bottom: 20px;}
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
			<label><input class="with-gap dateDay" name="date" type="radio" value="<?php echo date('D'); ?>" checked /><span>TODAY</span></label>
			<label><input class="with-gap dateDay" name="date" type="radio" value="Mon" /><span>MONDAY</span></label>
			<label><input class="with-gap dateDay" name="date" type="radio" value="Tue" /><span>TUESDAY</span></label>
			<label><input class="with-gap dateDay" name="date" type="radio" value="Wed" /><span>WEDNESDAY</span></label>
			<label><input class="with-gap dateDay" name="date" type="radio" value="Thu" /><span>THURSDAY</span></label>
			<label><input class="with-gap dateDay" name="date" type="radio" value="Fri" /><span>FRIDAY</span></label>
			<p><label><input type="checkbox" class="emptyClass"/><span>I just want to find when the classroom will be empty</span></label></p>
		</p><br>

		<div class="row">
      <div class="input-field col s12 m6 l3" style="margin-top:0; padding:0;"><input list="classlist" placeholder="eg. LAB 4-01 or UCDF1604ICT(SE)" type="text" id="searchVal"></div>
			<datalist id="classlist"></datalist>
			<button onclick="doSearch()" id="btn_all" class="waves-effect waves-light btn col s9 m3 l2 <?php echo $theme_secondary; ?>" style="margin-left:20px;">
				<i class="material-icons left">lightbulb_outline</i>Search
		 	</button>
		 </div>

 			<div class='marginleft4' id="tutorial"><h4>ಠ_ಠ</h4><p>The keyword [ Lab / B- / Studio ] is used to search for classes<br>You can also search for your intake timetable here<br>Check the syntax tab for more<br></p></div>

			<p><span id="searchInfo"></span><span id="emptyInfo" style="display:none;">This class is empty now</span></p>
			<a id='hidemsg' onclick='hidethead()' class='hide-on-med-and-up' style="display:none;">Toggle table header</a>
			<table id="resultArea" class='responsive-table highlight bordered marginbottom20'></table>
			<p class="marginbottom20" ><?php echo 'Schedule updated on ' . $updateDate[0]; ?></p>
  </div>

	<div id="mytimetable" class="container"></div>
  <div id="syntax" class="container"></div>
	</main>

<footer class="page-footer grey darken-3" id="meme">
  <div class="footer-copyright grey darken-4"><div class="container">Deprecated website <a href="http://apu-schedule.azurewebsites.net/redirect.html">here</a><br></div></div>
</footer>

<script>
function loadSyntax() {
	document.getElementById("syntaxRow") || fetch("syntax.html?ver=1.02").then(function(a) { return a.text();})
	.then(function(a) { document.querySelector("#syntax").innerHTML = a; M.Modal.init(document.querySelectorAll('.modal'), {});});
	document.getElementById("headercolor").className = "nav-extended <?php echo $theme_syntax; ?>";
	document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_metasyntax; ?>"); }

function changedefault() {
	document.getElementById("headercolor").className = "nav-extended <?php echo $theme_color; ?>";
	document.querySelector("meta[name=theme-color]").setAttribute("content", "<?php echo $theme_meta; ?>"); }
</script>
</body>
</html>
