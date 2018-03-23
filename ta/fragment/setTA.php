<?php
if (isset($_POST['user'])){
  if(preg_match('/[\'"^$%*}{?><>,|;]/', $_POST['user'])){ header('Location: https://apu-schedule.azurewebsites.net/ta'); }
  setcookie('myName-APU', $_POST['user'], time() + 31536000, '/');
  header('Location: https://apu-schedule.azurewebsites.net/ta'); } ?>
