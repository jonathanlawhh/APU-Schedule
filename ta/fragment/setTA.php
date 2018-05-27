<?php
if (isset($_POST['user'])){
  if(preg_match('/[\'"^$%*}{?><>,|;]/', $_POST['user'])){ header('Location: ../index.php'); }
  setcookie('myName-APU', $_POST['user'], time() + 31536000, '/');
  header('Location: ../index.php'); } ?>
