<!-- APU Schedule by jonathan law -->

<?php
	$row = 1;
	$array = array();
	$today = date('D');
?>

<head>
	<title>APU/APIIT Schedule</title>
	<link rel="icon" href="images/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="theme-color" content="#009688">
	<link type="text/css" rel="stylesheet" href="css/materialize.min.css" media="screen,projection" />
	<script type="text/javascript" src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
	<script type="text/javascript" src="js/materialize.min.js"></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <script>
    function changepurple(){
    document.getElementById("headercolor").className = "nav-extended deep-purple darken-3";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "#4A148C");
    }
    function changeteal(){
    document.getElementById("headercolor").className = "nav-extended teal darken-3";
    var metaThemeColor = document.querySelector("meta[name=theme-color]");
    metaThemeColor.setAttribute("content", "#004d40");
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
  <nav id="headercolor" class="nav-extended teal darken-3" style="margin-bottom:10px;">
    <div class="container">
      <span class="nav-title hide-on-small-only">APU/APIIT Schedule</span>
      <b><p class="show-on-small hide-on-med-and-up" style="margin-bottom:0; font-size:22px;">APU/APIIT Schedule</p></b>
      <div class="nav-content">
        <ul class="tabs tabs-transparent">
          <li class="tab" onclick="changeteal()"><a class="active" href="#schedule">Schedule</a></li>
          <li class="tab" onclick="changepurple()"><a href="#syntax">Syntax</a></li>
        </ul>
      </div>
    </div>
  </nav>

  <div id="schedule" class="container">
    <form class="col s12" action="new.php" method="post">
		<p>
	    <input class="with-gap" name="date" type="radio" id="option-0" name="date" value="<?php echo $today; ?>" checked />
	    <label for="option-0">TODAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-1" name="date" value="MON" />
	    <label for="option-1">MONDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-2" name="date" value="TUE" />
	    <label for="option-2">TUESDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-3" name="date" value="WED" />
	    <label for="option-3">WEDNESDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-4" name="date" value="THU" />
	    <label for="option-4">THURSDAY</label>

	    <input class="with-gap" name="date" type="radio" id="option-5" name="date" value="FRI" />
	    <label for="option-5">FRIDAY</label>
  	</p>
	<br>
		<div class="row">
      <div class="input-field col s12 m6 l2" style="margin-top:0; padding:0;">
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
		  <button type="submit" id="btn_class" name="intakebtn" value="Class" class="waves-effect waves-light btn col s4 m2 l2" style="margin-left:10px; margin-right:10px">
  		  <i class="material-icons left">schedule</i>Class
		  </button>
		  <button type="submit" id="btn_ttable" name="intakebtn" value="Intake" class="waves-effect waves-light btn col s4 m2 l2">
  		  <i class="material-icons left">lightbulb_outline</i> T.table
		  </button>
		 </div>
		</form>

    <?php
    $i = 0;
    $date = null;
    $classroom = null;

    $date=$_POST["date"];

    $results = array();
    $columns = array();
    if ($_POST['intakebtn']=="Intake") {
    	$intake=$_POST["classroom"];
    	$needles = array($date);
    	$needles02 = array($intake);
    echo "<table class='responsive-table highlight container left striped'>";
    echo "<thead><tr><th class='hide-on-small-only'>Time</th><th class='hide-on-small-only'>Date</th><th>Time</th><th>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
    	if(($handle = fopen('data/data.csv', 'r')) !== false) {
    		echo "<tbody>";
    			while(($data = fgetcsv($handle, 4096, ',')) !== false) {
    			if($i == 0)  {
    				$columns = $data;
    				$i++;
    				$weekof = array_search($columns[0], $data);
    				$intake = array_search($columns[1], $data);
    				$date = array_search($columns[2], $data);
    				$time = array_search($columns[3], $data);
    				$location = array_search($columns[4], $data);
    				$classroom = array_search($columns[5], $data);
    				$module = array_search($columns[6], $data);
    				$lecterur = array_search($columns[7], $data);

    			} else {

    				foreach($needles as $needle) {
    				if(stripos($data[$date], $needle) !== false) {
    					foreach($needles02 as $needle02) {
    						if(stripos($data[$intake], $needle02) !== false) {
    							$results[] = $data;
    						echo "<tr>";
    						echo "<td class='hide-on-small-only'>".$data[$intake]."</td>";
    						echo "<td class='hide-on-small-only'>".$data[$date]."</td>";
    						echo "<td>".$data[$time]."</td>";
    						echo "<td>".$data[$location]."</td>";
    						echo "<td>".$data[$classroom]."</td>";
    						echo "<td>".$data[$module]."</td>";
    						echo "<td>".$data[$lecterur]."</td>";
    						echo "</tr>";
    						}
    					}
    				}
    				}
    			}
    		}
    		fclose($handle);
    	}
    } elseif ($_POST['intakebtn']=="Class") {
    	$classroom=$_POST["classroom"];
    	$needles = array($date);
    	$needles02 = array($classroom);
    echo "<table class='container responsive-table highlight left bordered'>";
    echo "<thead><tr><th width='15%' >Time</th><th>Date</th><th>Time</th><th>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
    	if(($handle = fopen('data/data.csv', 'r')) !== false) {
    		echo "<tbody>";
    			while(($data = fgetcsv($handle, 4096, ',')) !== false) {
    			if($i == 0)  {
    				$columns = $data;
    				$i++;
    				$weekof = array_search($columns[0], $data);
    				$intake = array_search($columns[1], $data);
    				$date = array_search($columns[2], $data);
    				$time = array_search($columns[3], $data);
    				$location = array_search($columns[4], $data);
    				$classroom = array_search($columns[5], $data);
    				$module = array_search($columns[6], $data);
    				$lecterur = array_search($columns[7], $data);

    			} else {

    	$test=array_search($columns[0], $data);
    				foreach($needles as $needle) {
    				if(stripos($data[$date], $needle) !== false) {
    					foreach($needles02 as $needle02) {
    						if(stripos($data[$classroom], $needle02) !== false) {
    							$results[] = $data;
    							echo "<tr>";
    							echo "<td>".$data[$time]."</td>";
    							echo "<td>".$data[$intake]."</td>";
    							echo "<td>".$data[$date]."</td>";
    							echo "<td>".$data[$location]."</td>";
    							echo "<td>".$data[$classroom]."</td>";
    							echo "<td>".$data[$module]."</td>";
    							echo "<td>".$data[$lecterur]."</td>";
    							echo "</tr>";
    						}
    					}
    				}
    				}
    			}
    		}
    		fclose($handle);
    	}
    } else {
    	echo "<div style='margin-left: 4%;'><h4>o_o</h4><p>Choose Class to search for class schedule <br>
    		  Choose T.table to search for timetable</p></div>";
    }
    echo "</tbody></table><div class='row'></div>";

    array_unshift($results, $columns );
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
              AUD-03 will search for Auditorium 3. Auditoriums used for events are not shown here.
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
    Deprecated website <a href="https://ta.bitballoon.com">here</a>
    </div>
  </div>
</footer>
</body>
