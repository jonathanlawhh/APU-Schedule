<?php
// This will process all query and logic
// Goal is to clean main index.php\
if(isset($_POST['date']) && isset($_POST['duty'])){
  $date = $_POST['date'];
  $duty = $_POST['duty'];
  $a = "D:\home\python364x64\python.exe onduty.py -d $duty -s $date";
  exec($a, $returnval);
  foreach($returnval AS $array){
    $result = explode( ',', $array);
    echo "<tr><td>$result[1]</td><td>$result[0]</td></tr>";
  }
} else {
  header('Location: index.php');
}
?>
