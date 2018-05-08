<?php
// This will process all query and logic
// Goal is to clean main index.php\
$idate = $_POST['date']; $now = date('H:i');
$ect = '';
$returnMe = array();

//XSS Detection
if (preg_match('/[\'"^$%*}{?><>,|;]/', $_POST['classroom'])){ array_push($returnMe,array('method' => 'invalid')); echo json_encode($returnMe); goto end; }
//Start Query
$queryFor = 'intake'; $queryValue = $_POST['classroom'];
if($queryValue=='takeIntakeCode'){ $queryValue = $_COOKIE['myIntakeCode-APU']; }
if(preg_match("/\b(LAB|Auditorium|B-|D-|E-|STUDIO)\b/i", $queryValue)) { $queryFor = 'classroom'; }
elseif (empty($queryValue)){ array_push($returnMe,array('method' => 'noinput')); echo json_encode($returnMe); goto end; }
if(isset($_POST['emptyClass']) && $_POST['emptyClass']!=NULL && $queryFor == 'classroom'){ $queryFor='emptyclassroom'; }

//Hello analytica
if((!isset($_COOKIE['analytick-APU']) || $_COOKIE['analytick-APU']!==$queryValue) && !isset($_POST['method'])){
  $ana = fopen("../data/analytica.txt", "a");
  setcookie('analytick-APU', $queryValue); fwrite($ana, ','.$queryValue);
  fclose($ana);
}

$v1=''; $oDT1=''; $ocr=''; $stat='emptyNow';
if(($handle = fopen('../data/data.csv', 'r')) !== false) {
    while(($data = fgetcsv($handle, 4096, ',')) !== false) {
      $intake = array_search($data[0], $data);
      $date = array_search($data[1], $data);
      $time = array_search($data[2], $data);
      $location = array_search($data[3], $data);
      $classroom = array_search($data[4], $data);
      $module = array_search($data[5], $data);
      $lecterur = array_search($data[6], $data);

      if($queryFor === 'intake'){ $searchThis = $intake; } else { $searchThis = $classroom; }
      if((stripos($data[$date], $idate) !== false) && (stripos($data[$searchThis], $queryValue) !== false)) {
        $dt = $data[$time]; $newcr = $data[$classroom];
        $checkDT = explode( '-', $dt);
        if($v1 == $dt && $queryFor == 'emptyclassroom' && $newcr==$ocr){ continue 1; }
        if($queryFor == 'emptyclassroom' && trim($checkDT[0])<$now && trim($checkDT[1])>$now){ $stat = 'ongoingclass'; }
        if($queryFor == 'emptyclassroom'){
          array_push($returnMe,array('method'=>$queryFor, 'status'=>$stat,'intake'=>$data[$intake], 'date'=>$data[$date], 'time'=>$data[$time], 'classroom'=>$data[$classroom], 'module'=>$data[$module], 'lecturer'=>$data[$lecterur]));
        } else {
          array_push($returnMe,array('method'=>$queryFor, 'intake'=>$data[$intake], 'date'=>$data[$date], 'time'=>$data[$time], 'classroom'=>$data[$classroom], 'module'=>$data[$module], 'lecturer'=>$data[$lecterur]));
        }
        $v1 = $dt; $oDT1 = $checkDT[1]; $ocr = $newcr;
      }  //Cleanup and close table
  } fclose($handle);
  //if(trim($oDT1)<$now && $emptyClass=='checkMe'){ echo "<script>document.getElementById('emptyInfo').style.display = 'block';</script>"; }
  if($v1==''){ array_push($returnMe,array('method' => 'empty')); }
  echo json_encode($returnMe);
}
end:
?>
