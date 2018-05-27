<?php
function generateClaim($user){
  $claims = array();

  function cDate($n){
    $c = Date('N');
    if($n==='Monday'){ $c -= 1; }
    elseif($n==='Tuesday'){ $c -= 2; }
    elseif($n==='Wednesday'){ $c -= 3; }
    elseif($n==='Thursday'){ $c -= 4; }
    elseif($n==='Friday'){ $c -= 5; }
    elseif($n==='Saturday'){ $c -= 6; }
    return Date('d-m-Y', StrToTime("- {$c} Days"));
  }

  if(($handle = fopen('../data/gen-roster.csv', 'r')) !== false) {
      while(($data = fgetcsv($handle, 4096, ',')) !== false) {
        $dDate = array_search($data[0], $data);
        $dShift = array_search($data[1], $data);
        $dJob = array_search($data[2], $data);
        $dPerson = array_search($data[3], $data);


        if(stripos($data[$dPerson], $user) !== false) {
          $a = trim($data[$dDate]); $b = trim($data[$dShift]);
          $c = trim($data[$dJob]); $d = trim($data[$dPerson]);

          //Define next shift and time
          if($b==='S1'){ $start='0815'; $dur='0215'; }
          elseif($b==='S2'){ $start='1030'; $dur='0200'; }
          elseif($b==='S3'){ $start='1230'; $dur='0200'; }
          elseif($b==='S4'){ $start='1430'; $dur='0200'; }
          elseif($b==='S5'){ $start='1630'; $dur='0200'; }
          elseif($b==='S6'){ $start='1830'; $dur='0300'; }
          $shiftDur+=$dur;

          //Assign code for claim form
          if($c==='APIIT Helpdesk' || $c==='APIIT Rounding/QC'){ $dutycode = '1'; $dutymsg = 'APIIT NORMAL LAB DUTY'; } else { $dutycode = '2'; $dutymsg = 'APU  NORMAL LAB DUTY'; }

          //Assign date of duty
          $dutyDate = cDate(trim($a));

          //Output data
          $timeout = $shiftDur + $start;
          array_push($claims, array('date'=>$dutyDate,'shift'=>$b, 'code'=>$dutycode,'activity'=>$dutymsg,'timein'=>$start,'timeout'=>$timeout));
          //unset values
          $show==0; $streakshift=0; $shiftDur=0; unset($shiftInitial); unset($timeout); unset($start);
        }
    } fclose($handle);
  }
  return json_encode($claims);
}

$a = generateClaim($_COOKIE['myName-APU']);
$lol = json_decode($a,true);

function convertTime($z){
  $z = substr_replace($z, ":", 2, 0);
  if($z>='12:00'){
    $z = strtotime("-12 hours", strtotime($z));
    $z = date('H:i', $z);
    $z = substr_replace($z, ":00 PM", 5, 0);
  } else {
    $z = substr_replace($z, ":00 AM", 5, 0);
  }
  return $z;
}

$iteration = 0;
$claims = array();
for($i=0; $i<=count($lol); $i++){
    if($iteration==0){
      $start = $lol[$i]['timein'];
      $iteration++;
    } elseif($iteration==1) {
      if($lol[$i-1]['timeout']==$lol[$i]['timein']){
        $iteration++;
      } else {
        $start = convertTime($start);
        $timein = convertTime($lol[$i]['timein']);
        $timeout = convertTime($lol[$i]['timeout']);
        $timeout1 = convertTime($lol[$i-1]['timeout']);
        array_push($claims, array('date'=>$lol[$i-1]['date'],'shift'=>$lol[$i-1]['shift'],'code'=>$lol[$i-1]['code'],
        'act'=>$lol[$i-1]['activity'],'timein'=>$start,'timeout'=>$timeout1));
        array_push($claims, array('date'=>$lol[$i]['date'],'shift'=>$lol[$i]['shift'],'code'=>$lol[$i]['code'],
        'act'=>$lol[$i]['activity'],'timein'=> $timein,'timeout'=>$timeout));
        $start =''; $iteration=0;
      }
    } elseif($iteration==2) {
      $breakHour = $lol[$i]['timeout'] - '0030';
      $start = convertTime($start);
      $breakHour = convertTime($breakHour);
      array_push($claims, array('date'=>$lol[$i]['date'],'shift'=>$lol[$i]['shift'],'code'=>$lol[$i]['code'],
      'act'=>$lol[$i]['activity'],'timein'=> $start,'timeout'=>$breakHour));
      $start =''; $iteration=0;
    } else {
      $timein = convertTime($lol[$i]['timein']);
      $timeout = convertTime($lol[$i]['timeout']);
      array_push($claims, array('date'=>$lol[$i]['date'],'shift'=>$lol[$i]['shift'],'code'=>$lol[$i]['code'],
      'act'=>$lol[$i]['activity'],'timein'=> $timein,'timeout'=>$timeout));
      $start =''; $iteration=0;
    }
}
?>


<html lang="en">
<?php $searchUser = $_POST['user'] ?? $_COOKIE['myName-APU']; ?>
<head>
  <title>TA Claim Form Gen</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/materialize.min.css" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="../css/materialize.min.css"></noscript>
	<link rel="icon" href="../images/favicon.png">
  <style>
    .marginbottom30 { margin-bottom:30px; }
    ::selection { background: #43a047; color:#ffffff;}
		::-moz-selection { background: #43a047; color:#ffffff; }
  </style>
</head>

<body>
<main>

<div class="container">
  <?php if(isset($searchUser)){ ?>

    <h4>TA Claim Form Generator for <?php echo $searchUser; ?></h4>
    <p>Roster for the week of <?php exec("D:\home\python364x64\python.exe currRoster.py", $rosterWeek); foreach($rosterWeek AS $weekOf){ echo $weekOf; } ?><br>
    If you took S6, please double check the form...</p>
    <p>Copy the table below and paste with match source option in Excel</p>

    <table>
      <thead <?php if(isset($_COOKIE['apuschedule-tablehead'])){ echo "style='display:none;'"; }?>><tr><th>Date</th><th>Code</th><th>Activity</th><th>Time in</th><th>Time out</th>
      </tr></thead>
      <tbody>
        <?php unset($a); foreach($claims as $a){
          echo "<tr><td>$a[date]</td><td>$a[code]</td><td>$a[act]</td><td>$a[timein]</td><td>$a[timeout]</td></tr>";
        } ?>
      </tbody>
    </table><div class="marginbottom30"></div>
<?php } else { include('userless.html'); } //Close isset($searchUser) ?>
</div>
</main>
</body>
</html>
