<!-- TA Final Roster displayer by jonathan law -->
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
    30 minutes break is adjusted. Double check if you have S6</p>
    <p>Copy the table below and paste with match source option in Excel</p>

    <table>
      <thead <?php if(isset($_COOKIE['apuschedule-tablehead'])){ echo "style='display:none;'"; }?>><tr><th>Date</th><th>Code</th><th>Activity</th><th>Time in</th><th>Time out</th>
      </tr></thead>
      <tbody>
      <?php
      $a = 'D:\home\python364x64\python.exe reader.py -u ' . '"' . $searchUser . '"';
      exec($a, $returnval);
      function setShiftTime($checkMe){
        global $start;
        global $shiftDur;
        if($checkMe==='S1'){ $start='0815'; $shiftDur+='0215'; }
        elseif($checkMe==='S2'){ $start='1030'; $shiftDur+='0200'; }
        elseif($checkMe==='S3'){ $start='1230'; $shiftDur+='0200'; }
        elseif($checkMe==='S4'){ $start='1430'; $shiftDur+='0200'; }
        elseif($checkMe==='S5'){ $start='1630'; $shiftDur+='0200'; }
        elseif($checkMe==='S6'){ $start='1830'; $shiftDur+='0300'; }
      }
      function addTable($a, $b, $c, $d, $e){
        $c = convertTime($c);
        $d = convertTime($d);
        $a = cDate(trim($a));
        echo "<tr><td>$a</td><td>$b</td><td>$e</td><td>$c</td><td>$d</td></tr>";
      }
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

      foreach($returnval AS $array){
        $result = explode( ',', $array);
        redo:
        $round += 1;
        $e0 = trim($result[0]); $e1 = trim($result[1]); $e2 = trim($result[2]); $link = substr($t1,2) + 1; $link2 = substr($e1,1);

        if($e2==='APIIT Helpdesk' || $e2==='APIIT Rounding/QC'){ $duty = '1'; $msg = 'APIIT NORMAL LAB DUTY'; } else { $duty = '2'; $msg = 'APU  NORMAL LAB DUTY'; }
        if(($link==$link2 && trim($t0)==$e0)|| $round == 1){
          $i += 1;
          setShiftTime($e1);
          if($i==1){ $iniStart = $start; }
        } else {
          if($i){
            setShiftTime($t1);
            $start = $iniStart ?? $start;
            $timeOut = $start + $shiftDur;
            addTable($t0, $duty, $start, $timeOut, "$msg");
            $shiftDur = '0000';
            unset($iniStart); unset($start); unset($timeOut); $i = 0; $round = 0; goto redo;
          }

          setShiftTime($e1);
          $start = $iniStart ?? $start;
          $timeOut = $start + $shiftDur;
          addTable($e0, $duty, $start, $timeOut, "$msg");
          $shiftDur = '0000';
          unset($iniStart); unset($start); unset($timeOut); $i = 0;

          $round = 0;
        }

        if($i === 3){
          $start = $iniStart ?? $start;
          $shiftDur -= '0030';
          $timeOut = $start + $shiftDur;
          addTable($e0, $duty, $start, $timeOut, "$msg");
          $shiftDur = '0000';
          unset($iniStart); unset($start); unset($timeOut); $i = 0;
        }
        $t0 = $result[0]; $t1 = $result[1];
      } //End foreach
        if($start){
          $start = $iniStart ?? $start;
          $timeOut = $start + $shiftDur;
          addTable($e0, $duty, $start, $timeOut, "$msg");

          unset($iniStart); unset($start); unset($timeOut); unset($shiftDur); $i = 0;
        } ?>
      </tbody>
    </table><div class="marginbottom30"></div>
<?php } else { include('userless.html'); } //Close isset($searchUser) ?>
</div>
</main>
</body>
</html>
