<!-- APU Schedule by jonathan law -->

<?php
	$row = 1;
	$array = array();
	$date=$_POST["date"];

	//Load theme
	include("control/theme.php");
?>

<head>
	<title>APU/APIIT Schedule</title>
	<link rel="icon" href="images/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="theme-color" content="<?php echo $theme_meta ?>">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script>
    function changedefault(){
    document.getElementById("headercolor").className = "nav-extended <?php echo $theme_color ?>";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "<?php echo $theme_meta ?>");
    }
    function changemytimetable(){
    document.getElementById("headercolor").className = "nav-extended brown darken-4";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "#3e2723");
    }
		function changesyntax(){
    document.getElementById("headercolor").className = "nav-extended <?php echo $theme_syntax ?>";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "<?php echo $theme_metasyntax ?>");
    }
    function warning(){
    document.getElementById("headercolor").className = "nav-extended red darken-3";
    document.getElementById("btn_all").className = "waves-effect waves-light btn col s4 m2 l2 red darken-1";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "#b71c1c");
    }
		function hidethead() {
	    var x = document.getElementById("removethead");
	    if (x.style.display === "none") {
	        x.style.display = "block";
					document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;";
					document.getElementById("hidemsg").innerHTML = "Hide table header;";
	    } else {
	        x.style.display = "none";
					document.getElementById("hidemsg").innerHTML = "Show table header";
					document.cookie = "apuschedule-tablehead=hidden;";
	    }
		}
  </script>
  <style>
  body {
    display: flex;
    min-height: 100vh;
    flex-direction: column;
  }

  main {
    flex: 1 0 auto;
  }
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
          <li class="tab" onclick="changesyntax()"><a href="#syntax">Syntax</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="schedule" class="container">
    <form class="col s12" action="index.php" method="post">
		<p>
	    <input class="with-gap" name="date" type="radio" id="option-0" name="date" value="<?php echo date('D'); ?>" <?php if(!isset($date) || $date === "" ){?>checked<?php } ?>/>
	    <label for="option-0">TODAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-1" name="date" value="Mon" <?php if($date === "Mon"){?>checked<?php } ?>/>
	    <label for="option-1">MONDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-2" name="date" value="Tue" <?php if($date === "Tue"){?>checked<?php } ?>/>
	    <label for="option-2">TUESDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-3" name="date" value="Wed" <?php if($date === "Wed"){?>checked<?php } ?>/>
	    <label for="option-3">WEDNESDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-4" name="date" value="Thu" <?php if($date ==="Thu"){?>checked<?php } ?>/>
	    <label for="option-4">THURSDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-5" name="date" value="Fri" <?php if($date === "Fri"){?>checked<?php } ?>/>
	    <label for="option-5">FRIDAY</label>
  	</p>
	<br>
		<div class="row">
      <div class="input-field col s12 m6 l2 " style="margin-top:0; padding:0;">
          <input list="classlist" placeholder="eg. LAB 4-01" name="classroom" id="classroom" type="text" class="validate">
      </div>
		  <datalist id="classlist">
  		  <?php
  			$myfile = fopen("data/classlist.txt", "r") or die("Classes list not found");
  			while(!feof($myfile)) {
  			  echo "<option value='" . trim(fgets($myfile)) . "'/>";
  			}
  			fclose($myfile);
  		  ?>
		  </datalist>
		  <button type="submit" id="btn_all" name="search" class="waves-effect waves-light btn col s4 m2 l2 <?php echo $theme_secondary ?>" style="margin-left:20px;">
				<i class="material-icons left">lightbulb_outline</i>Search
			</button>
		 </div>
		</form>

    <?php
		//Process in control/logic.php
    include("control/logic.php");
		//Cleanup and close table
    echo "</tbody></table><div class='row'></div>";
    array_unshift($results, $columns );

		?>
  </div>

	<div id="mytimetable" class="container">
    <?php
		//Process in control/logic.php
    include("control/mytimetable.php");

		//Functions
		function tutorial(){
			echo "<div style='margin-left: 4%;'><h4>o_o</h4><p>Choose Class to search for class schedule <br>Choose T.table to search for timetable</p></div>";
		}
		?>
  </div>

  <div id="syntax" class="container">
    <div class="row">
      <div class="col s12 m12 l5">
        <div class="card-panel">
          <span>
            <div class="section">
              <b>To search for labs</b><br>
              LAB 4-01, or just typing LAB 4 will search all labs on level 4. LAB 4-01 will search for that lab only.
            </div>
            <div class="divider"></div>
            <div class="section">
              <b>To search for classes</b><br>
              B-04-02, or just typing B-04 will search all classes on block B level 4. Offices are not included in the search
            </div>
            <div class="divider"></div>
            <div class="section">
              <b>Auditoriums</b><br>
              Auditorium 3 will search for Auditorium 3. Auditoriums used for events are not shown here.
            </div>
          </span>
        </div>
				<div class="card-panel">
          <span>
            <div class="section">
              <b>Notes</b><br>
              APIIT classroom L2-1 to L2-13 may not show in the schedule
            </div>
          </span>
        </div>
				<div class="card-panel">
          <span>
            <div class="section">
              <b>Experimental</b><br>
              - myTimetable <br>
              - Settings conf <br>
              - Dark theme after 6PM <br>
							- Selected days will remain checked <br>
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
</body>
