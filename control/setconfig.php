<?php
$intake_val = $_POST["myIntake"];
// XSS detection
if (preg_match('/[\'"^$%*}{?><>,|;]/', $intake_val)){ goto end; }
// Set cookies
if (isset($intake_val)){ setcookie("myIntakeCode-APU", $intake_val, time() + 31536000, '/'); }
end:
// Redirect back ?>
<script>window.location.replace('../settings.php');</script>
