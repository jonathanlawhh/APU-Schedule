<?php
exec('automateSchedule.bat', $a);
foreach($a as $b){ echo 'addLog("' . $b . '");'; }
$log = fopen("../data/update.log", "w");
fwrite($log, date('Ymd'));
fclose($log);
echo 'addLog("Schedule updated on ' . date('Ymd') . '")'; ?>
