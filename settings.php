<?php
function intakeInput(){
  if(isset($_COOKIE['myIntakeCode-APU'])){ echo $_COOKIE['myIntakeCode-APU']; }
} ?>
<head>
	<title>APU/APIIT Schedule</title>
	<link rel="icon" href="images/favicon.png">
	<meta name="theme-color" content="#880e4f">
  <?php include('fragment/frameworkImports.html'); ?>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; }
	  main {  flex: 1 0 auto; }
    a { color: #f4511e; } .marginleft4 { margin-left: 4%; }
  </style>
</head>

<body>
<main>
  <nav id="headercolor" class="nav-extended pink darken-4" style="margin-bottom:10px;">
    <div class="container">
      <span class="nav-title hide-on-small-only">APU/APIIT Schedule</span>
      <b><span class="show-on-small hide-on-med-and-up" style="margin-bottom:0; font-size:22px;">APU/APIIT Schedule</span></b>
      <div class="nav-content">
        <ul class="tabs tabs-transparent">
          <li class="tab"><a class="active" href="#settings">Settings</a></li>
        </ul>
      </div>
    </div>
  </nav>

<div id="settings" class="container">
  <div class="row">
    <div class="col s12 m12 l5">
      <div class="card-panel hoverable">
        <span>
          <div class="section">
            <a role="button" onclick="history.go(-1);"><i class="material-icons left">arrow_back</i> Go back to schedule</a>
          </div>
        </span>
      </div>
      <div class="card-panel">
        <span>
          <div class="section">
						<div class="row">
            <b>Intake :</b><br>
	            <form action="control/setconfig.php" method="POST">
	                <div class="input-field col s12 m6 l9" style="margin-top:0; padding:0;">
	                    <input placeholder="eg. UCDF1604ICT(SE)" name="myIntake" id="myIntake" type="text" class="validate" value="<?php intakeInput(); ?>">
	                </div>
	          		  <button type="submit" id="btn_class" name="myIntakebtn" value="myIntakebtn" class="pink darken-4 waves-effect waves-light btn col s6 l4" style="margin-right:10px">
	            		  <i class="material-icons left">cloud_upload</i>Update
	          		  </button>
	             </form>
					 	 </div>
						 <div class="row">
							 <p><b>Refresh browser cache</b><br>Use this option if webpage is not loading correctly</p>
							 <button class="blue-grey darken-4 waves-effect waves-light btn col s6 l4" style="margin-right:10px; margin-top:10px;" onclick="location.reload(true);">
								 <i class="material-icons left">refresh</i>Refresh
							 </button>
						</div>
          </div>
        </span>
      </div>
    </div>
  </div>

</div>
</main>

<footer class="page-footer grey darken-3" id="meme">
<div class="footer-copyright grey darken-4">
  <div class="container">Deprecated website <a href="http://apu-schedule.azurewebsites.net/redirect.html">here</a></div>
</div>
</footer>
<script> //Initialize UI
function initialize() { M.Tabs.init(document.querySelectorAll(".tabs"), {}); }
window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
</script>
</body>
