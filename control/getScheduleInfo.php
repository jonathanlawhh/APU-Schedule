<?php
function getScheduleInfo(){
    $list = fopen("data/update.log", "r"); while(!feof($list)) { $updateDate = fgets($list); } fclose($list);
    $updateDate = explode(',',$updateDate);
    return trim($updateDate[1]);
}

function getScheduleInfoAPI(){
    $list = fopen("../data/update.log", "r"); while(!feof($list)) { $updateDate = fgets($list); } fclose($list);
    $updateDate = explode(',',$updateDate);
    return trim($updateDate[1]);
}

if(isset($_POST['getschedule'])){ echo json_encode(array('lastupdate'=>getScheduleInfoAPI())); exit; }
?>
