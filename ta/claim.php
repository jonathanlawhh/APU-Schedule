<!-- TA Final Roster displayer by jonathan law -->
<html lang="en">
<?php $searchUser = $_POST['user'] ?? $_COOKIE['myName-APU']; ?>
<head>
  <title>TA Claim Form Gen</title>

  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="../css/materialize.min.css" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="../css/materialize.min.css"></noscript>
	<link rel="icon" href="../images/favicon.png">
  <meta name="theme-color" content="#0d47a1">
  <script type="text/javascript" src="../js/materialize.min.js" async></script>
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
    Adjust 30min break yourself</p>
    <p>Copy the table below and paste with match source option in Excel</p>

    <table>
      <thead <?php if(isset($_COOKIE['apuschedule-tablehead'])){ echo "style='display:none;'"; }?>><tr><th>Date</th><th>Code</th><th>Activity (Leave blank)</th><th>Time in</th><th>Time out</th>
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
        $c = substr_replace($c, ":", 2, 0);
        if($c>'12:00'){
          $c = substr_replace($c, ":00 PM", 5, 0);
        } else {
          $c = substr_replace($c, ":00 AM", 5, 0);
        }
        $d = substr_replace($d, ":", 2, 0);
        if($d>'12:00'){
          $d = strtotime("-12 hours", strtotime($d));
          $d = date('H:i', $d);
          $d = substr_replace($d, ":00 PM", 5, 0);
        } else {
          $d = substr_replace($d, ":00 AM", 5, 0);
        }

        echo "<tr><td>$a</td><td>$b</td><td>$e</td><td>$c</td><td>$d</td></tr>";
      }
      foreach($returnval AS $array){
        $result = explode( ',', $array);
        if($t0 === $result[0] && $t1 === $result[1]){ continue; } else {
          redo:
          $round += 1;
          $e0 = trim($result[0]); $e1 = trim($result[1]); $e2 = trim($result[2]); $link = substr($t1,2) + 1; $link2 = substr($e1,1);

          if($e2==='APIIT Helpdesk' || $e2==='APIIT Rounding/QC'){ $duty = '1'; $msg = 'APIIT NORMAL LAB DUTY'; } else { $duty = '2'; $msg = 'APU  NORMAL LAB DUTY'; }

          if(($link==$link2 && trim($t0)==$e0)|| $round == 1){
            $i += 1;
            setShiftTime($e1);
            if($i==1){ $iniStart = $start; }
          } else {
            //Display previous first
            if($i){
            setShiftTime($t1);
            $start = $iniStart ?? $start;
            $timeOut = $start + $shiftDur;
            addTable($t0, $duty, $start, $timeOut, "$msg");
            $shiftDur = '0000';
            unset($iniStart); unset($start); unset($timeOut); $i = 0; $round = 0; goto redo;}

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
            $timeOut = $start + $shiftDur;
            addTable($e0, $duty, $start, $timeOut, "$msg");
            $shiftDur = '0000';
            unset($iniStart); unset($start); unset($timeOut); $i = 0;
          }
          $t0 = $result[0]; $t1 = $result[1];
          }
        }
        if($start){
          $start = $iniStart ?? $start;
          $timeOut = $start + $shiftDur;
          addTable($e0, $duty, $start, $timeOut, "$msg");

          unset($iniStart); unset($start); unset($timeOut); unset($shiftDur); $i = 0;
        } //End foreach ?>
      </tbody>
    </table><div class="marginbottom30"></div>
<?php } else { include('userless.html'); } //Close isset($searchUser) ?>
</div>
</main>
</body>
</html>
