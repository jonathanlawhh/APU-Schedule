<?php
if(isset($_POST['date']) && isset($_POST['duty'])){
  $date = $_POST['date']; $duty = $_POST['duty'];
  $a = "D:\home\python364x64\python.exe onduty.py -d $duty -s $date";
  exec($a, $returnval);
  foreach($returnval AS $array){
    $result = explode( ',', $array);
    $a = trim($result[0]); $b = trim($result[1]);
    echo "addSec('$b','$a');";
  }
} else { header('Location: index.php'); } ?>
