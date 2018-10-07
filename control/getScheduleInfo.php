<?php
function getScheduleInfo(){
    $list = fopen("data/update.log", "r"); while(!feof($list)) { $updateDate = fgets($list); } fclose($list);
    $updateDate = explode(',',$updateDate);
    return $updateDate;
}

function getScheduleInfoAPI(){
    $list = fopen("../data/update.log", "r"); while(!feof($list)) { $updateDate = fgets($list); } fclose($list);
    $updateDate = explode(',',$updateDate);
    return trim($updateDate[0]);
}

if(isset($_POST['getschedule'])){ echo json_encode(array('lastupdate'=>getScheduleInfoAPI())); exit; }
?>
