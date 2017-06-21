<?php
echo "
<title>APU/APIIT Schedule</title>
<link rel='icon' href='images/favicon.png'>
<meta name='viewport' content='width=device-width, initial-scale=1'>

<link rel='stylesheet' href='css/teal.css'>
<link rel='stylesheet' href='css/styles.css'>
<link rel='stylesheet' href='https://fonts.googleapis.com/icon?family=Material+Icons'>
<meta name='theme-color' content='#009688'>
<script type='text/javascript' src='js/material.min.js'></script>";

$row = 1;
$array = array();
$today = date('D');
date_default_timezone_set('Asia/Kuala_Lumpur');

echo "
<body class='mdl-demo mdl-color--grey-100 mdl-color-text--grey-700 mdl-base'>
	<div class='mdl-layout mdl-js-layout mdl-layout--fixed-header'>
		<header class='mdl-layout__header mdl-layout__header--scroll mdl-color--primary'>
			<div class='mdl-layout--large-screen-only mdl-layout__header-row margintop1'>
			  <h3>APU/APIIT Classroom Schedule</h3>
			</div>
			<div class='margintopmobile2'>
			  <h3>Syntax usage</h3>
			  <div class='info'>
			  <ul>
			  <span style='display:inline-block; width: 80px;'>Classroom</span>: B-xx-xx <br>
			  <span style='display:inline-block; width: 80px;'>Labs</span>: Lab 4-01<br>
			  <span style='display:inline-block; width: 80px;'>All Classes</span>: -</p>
			  </ul>
			  <ul>
			  <span style='display:inline-block; width: 80px;'>APU LABS</span>: COMM, PLC, ROBOTIC, 03-DESIGN, A&I  <br>
			  <span style='display:inline-block; width: 80px;'>APIIT Labs</span>: ID, DRAWING, VFX, CGI, MEC, DESIGN, STUDIO</p>
			  </ul>
			  </div>
			</div>
		  </header>
	<p id='weekof'></p>
	<div class='margintopmobile2 margintop2'>
		<form action='index.php' method='post'>
		 <label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-0'>
		  <input type='radio' id='option-0' class='mdl-radio__button' name='date' value='$today' checked>
		  <span id='today' class='mdl-radio__label'>TODAY</span>
		  <div class='mdl-tooltip mdl-tooltip--top mdl-tooltip--large' data-mdl-for='today'>$today</div>
		</label>
		<label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-1'>
		  <input type='radio' id='option-1' class='mdl-radio__button' name='date' value='MON'>
		  <span class='mdl-radio__label'>MONDAY</span>
		</label>
		<label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-2'>
		  <input type='radio' id='option-2' class='mdl-radio__button' name='date' value='TUE'>
		  <span class='mdl-radio__label'>TUESDAY</span>
		</label>  
		<label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-3'>
		  <input type='radio' id='option-3' class='mdl-radio__button' name='date' value='WED'>
		  <span class='mdl-radio__label'>WEDNESDAY</span>
		</label>
		<label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-4'>
		  <input type='radio' id='option-4' class='mdl-radio__button' name='date' value='THU'>
		  <span class='mdl-radio__label'>THURSDAY</span>
		</label>
		<label class='mdl-radio mdl-js-radio mdl-js-ripple-effect' for='option-5'>
		  <input type='radio' id='option-5' class='mdl-radio__button' name='date' value='FRI'>
		  <span class='mdl-radio__label'>FRIDAY</span>
		</label>
	<br>
		<div class='margintop1'>
		  <div class='mdl-textfield mdl-js-textfield'>
			<input list='classlist' class='mdl-textfield__input' type='text' name='classroom' id='classroom'>
			<label class='mdl-textfield__label' for='classroom'>eg. LAB 4-01</label>
		  </div>
		  <datalist id='classlist'>";
		  $myfile = fopen("data/classlist.txt", "r") or die("Classes list not found");
			while(!feof($myfile)) {
			  echo "<option value='" . trim(fgets($myfile)) . "'/>";
			}
			fclose($myfile);
			echo "
		  </datalist>
		  <button type='submit' class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored'>
		  <i class='material-icons'>lightbulb_outline</i>
		  Search
		  </button>
		 </div>
		</form>
	</div>";

$i = 0;
$date = null;
$classroom = null;

$classroom=$_POST["classroom"];
$date=$_POST["date"];
$needles = array($date);
$needles02 = array($classroom);
$needles03 = array($time);
$results = array();
$columns = array();
echo "<div><table class='mdl-data-table mdl-js-data-table mdl-shadow--2dp margintopmobile2'>";
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
echo "</tbody></table><p><br></p></div>";

array_unshift($results, $columns );

echo "</div></body>";
?>