<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
	<title>APU/APIIT God Mode</title>
	<link rel="icon" href="images/favicon.png">
	<meta name="theme-color" content="#1a237e">
	<?php include('fragment/frameworkImports.html'); ?>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; }
  </style>
</head>

<body>
  <main>
  <nav class="nav-extended indigo darken-3" style="margin-bottom:10px;">
    <div class="container">
      <span class="nav-title hide-on-small-only">APU/APIIT God Mode</span>
      <b><span class="show-on-small hide-on-med-and-up" style="margin-bottom:0; font-size:22px;">God Mode</span></b>
    </div>
  </nav>

  <div class="container">
    <div class="row">
      <div class="col s12 m6">
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Update Schedule</span><br>
						<p><?php $list = fopen("data/update.log", "r");
						while(!feof($list)) { echo 'Schedule updated on ' . trim(fgets($list)); } fclose($list); ?></p><br>
            <button id="uBtn" onclick="updateS();" class="waves-effect waves-light btn indigo darken-3"><i class="material-icons left">cloud_upload</i>Update</button>
            <div id="loggingID" style="display: none"><br><b><p id="status">Please wait...</p></b>
							<div class="progress indigo lighten-5" id="progressbar"><div class="indeterminate indigo darken-2"></div></div>
						</div>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col s12 m6">
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Update TA Final Roster</span><br>
					    <div class="file-field input-field">
					      <div class="btn indigo darken-1"><span>File</span><input id="roster" type="file" accept=".xlsx"></div>
					      <div class="file-path-wrapper"><input class="file-path validate" type="text"></div>
					    </div>
							<button onclick="updateR();" class="waves-effect waves-light btn indigo darken-3"><i class="material-icons left">dashboard</i>Upload</button><br><br>
							<b><p id="rosterStatus" style="display:none;">Uploading and verifying...</p></b>
          </div>
        </div>
      </div>
    </div>

		<div class="row">
      <div class="col s12 m6">
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Quick Links</span><br>
            <a href="index.php"><button class="waves-effect waves-light btn indigo darken-3">APU Schedule</button></a>
            <a href="ta/index.php"><button class="waves-effect waves-light btn indigo darken-3">TA Final Roster</button></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  </main>
	<footer class="page-footer grey darken-3" id="meme">
	  <div class="footer-copyright grey darken-4"><div class="container">APU Schedule <a href="index.php">here</a></div></div>
	</footer>
<script>
function addLog(a) { var b = document.createElement("p"); a = document.createTextNode(a); b.appendChild(a); document.getElementById("loggingID").appendChild(b); }
function updateS() {
  document.getElementById("loggingID").removeAttribute("style");
	a = new XMLHttpRequest;
	a.open("POST", "control/updater.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("action=updateS");
	a.onload = function() { 200 == this.status && (document.getElementById("status").innerHTML = "Update log : ", document.getElementById("progressbar").style.display = "none", eval(a.responseText));
	};
}
function updateR() {
  var b = document.querySelector("#roster"), c = document.getElementById("rosterStatus"), a = b.files[0]; c.removeAttribute("style");
  b = new FormData; b.append("roster", a);
  a = new XMLHttpRequest; a.open("POST", "control/updater.php", !0);
  a.onload = function() { 200 == this.status && (c.innerHTML = this.responseText); }; a.send(b); }
</script>
</body>
</html>
