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

	<link rel="stylesheet" href="css/teal.css">
	<link rel="stylesheet" href="css/styles.css">
	<meta name="theme-color" content="#009688">
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
	<script type="text/javascript" src="js/material.min.js"></script>
</head>

<body class="mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base">
	<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
		<header class="mdl-layout__header mdl-layout__header--scroll mdl-color--primary">
			<div class="mdl-layout--large-screen-only mdl-layout__header-row margintop1">
			  <h3>APU/APIIT Classroom Schedule</h3>
			</div>
			<div class="margintopmobile2">
			  <h3>Syntax usage</h3>
			  <div class="info">
			  <ul>
			  <span style="display:inline-block; width: 80px;">APU class</span>: B-xx-xx <br>
			  <span style="display:inline-block; width: 80px;">APIIT class</span>: L2 - 1<br>
			  <span style="display:inline-block; width: 80px;">Labs</span>: Lab 4-01</p>
			  </ul>
			  <ul>
			  <span style="display:inline-block; width: 150px;">All Classes</span>: -<br>
			  <span style="display:inline-block; width: 150px;">Timetable search</span>: UCDFxxxxICT(SE)</p>
			  </ul>
			  </div>
			</div>
		  </header>
	<div class="margintopmobile2 margintop2">
		<form action="old.php" method="post">
		 <label class="mdl-radio mdl-js-radio mdl-js-ripple-effect" for="option-0">
		  <input type="radio" id="option-0" class="mdl-radio__button" name="date" value="<?php echo $today; ?>" checked>
		  <span id="today" class="mdl-radio__label">TODAY</span>
		  <div class="mdl-tooltip mdl-tooltip--top mdl-tooltip--large" data-mdl-for="today"><?php echo $today; ?></div>
		</label>
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect marginleft8" for="option-1">
		  <input type="radio" id="option-1" class="mdl-radio__button" name="date" value="MON">
		  <span class="mdl-radio__label">MONDAY</span>
		</label>
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect marginleft8" for="option-2">
		  <input type="radio" id="option-2" class="mdl-radio__button" name="date" value="TUE">
		  <span class="mdl-radio__label">TUESDAY</span>
		</label>
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect marginleft8" for="option-3">
		  <input type="radio" id="option-3" class="mdl-radio__button" name="date" value="WED">
		  <span class="mdl-radio__label">WEDNESDAY</span>
		</label>
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect marginleft8" for="option-4">
		  <input type="radio" id="option-4" class="mdl-radio__button" name="date" value="THU">
		  <span class="mdl-radio__label">THURSDAY</span>
		</label>
		<label class="mdl-radio mdl-js-radio mdl-js-ripple-effect marginleft8" for="option-5">
		  <input type="radio" id="option-5" class="mdl-radio__button" name="date" value="FRI">
		  <span class="mdl-radio__label">FRIDAY</span>
		</label>
	<br>
		<div class="margintop1">
		  <div class="mdl-textfield mdl-js-textfield">
			<input list="classlist" class="mdl-textfield__input" type="text" name="classroom" id="classroom">
			<label class="mdl-textfield__label" for="classroom">eg. LAB 4-01 // UCDFxxxxICT(SE)</label>
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
		  <button type="submit" id="btn_class" name="intakebtn" value="Class" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect marginleft8">
		  <i class="material-icons">schedule</i>
		  Class
		  </button>
		  <div class="mdl-tooltip mdl-tooltip--top mdl-tooltip--large" data-mdl-for="btn_class">Search for classrooms</div>
		  <button type="submit" id="btn_ttable" name="intakebtn" value="Intake" class="mdl-button mdl-js-button mdl-button--raised mdl-button--colored mdl-js-ripple-effect marginleft8">
		  <i class="material-icons">lightbulb_outline</i>
		  T.table
		  </button>
		  <div class="mdl-tooltip mdl-tooltip--top mdl-tooltip--large" data-mdl-for="btn_ttable">Search for intake timetable</div>
		 </div>
		</form>
	</div>

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
echo "<table class='mdl-data-table mdl-js-data-table mdl-shadow--2dp margintopmobile2'>";
echo "<thead><tr><th>Week</th><th>Intake</th><th>Date</th><th>Time</th><th>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
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
						if(stripos($data[$intake], $needle02) !== false) {
							$results[] = $data;
						echo "<tr>";
						echo "<td>".$data[$weekof]."</td>";
						echo "<td>".$data[$intake]."</td>";
						echo "<td>".$data[$date]."</td>";
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
echo "<table class='mdl-data-table mdl-js-data-table mdl-shadow--2dp margintopmobile2'>";
echo "<thead><tr><th>Week</th><th>Intake</th><th>Date</th><th>Time</th><th>Location</th><th>Classroom</th><th>Module</th><th>Lecterur</th></tr></thead>";
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
							echo "<td>".$data[$weekof]."</td>";
							echo "<td>".$data[$intake]."</td>";
							echo "<td>".$data[$date]."</td>";
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
} else {
	echo "<div class='margintopmobile2'><h4>o_o</h4>
	<p>A new website in trial <a href='http://apu-schedule.azurewebsites.net'>here</a><br>
	Choose Class to search for class schedule <br>
		  Choose T.table to search for timetable</p></div>";
}
echo "</tbody></table><p><br></p></div>";

array_unshift($results, $columns );
?>

</div>
</body>