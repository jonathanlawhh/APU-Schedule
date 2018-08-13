<?php
// This will process all query and logic
// Goal is to clean main index.php\
$idate = date('D'); $now = date('H:i');
$returnMe = $allclass = $usedclass = $classdetails = array();

if(($handle = fopen('../data/data.csv', 'r')) !== false) {
    while(($data = fgetcsv($handle, 4096, ',')) !== false) {
      $intake = array_search($data[0], $data);
      $date = array_search($data[1], $data);
      $time = array_search($data[2], $data);
      $location = array_search($data[3], $data);
      $classroom = array_search($data[4], $data);
      $module = array_search($data[5], $data);
      $lecterur = array_search($data[6], $data);

      $dt = $data[$time];
      $checkDT = explode( '-', $dt);

      if (!(in_array($data[$classroom], $allclass))) { array_push($allclass, $data[$classroom]); }

      if(stripos($data[$date], $idate) !== false) {
        $newcr = $data[$classroom];

        if(trim($checkDT[0])<=$now && trim($checkDT[1])>=$now){
            array_push($usedclass,$data[$classroom]);
            continue;
        } else {
            array_push($classdetails,array("classroom"=>$data[$classroom],"nextclass"=>$checkDT[0]));
        }
      }  //Cleanup and close table
  } fclose($handle);
}

sort($allclass);
$oldclassroom = '';
$gotnextclass = true;
$return = array();
foreach(array_diff($allclass, $usedclass) as $emptyclass){
    foreach($classdetails as $classdetail){
      if($oldclassroom == $classdetail["classroom"]) continue;
      if($emptyclass == $classdetail["classroom"] && $now<$classdetail["nextclass"]){
          array_push($return,array("classroom"=>$classdetail["classroom"],"nextclass"=>$classdetail["nextclass"]));
          $gotnextclass = true;
          break;
      } else {
          $gotnextclass = false;
      }
      $oldclassroom = $classdetail["classroom"];
    }
    if(!$gotnextclass) array_push($return,array("classroom"=>$emptyclass,"nextclass"=>"none"));
}

echo json_encode($return);
end:
?>
