<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
	<title>APU/APIIT God Mode</title>
	<meta name="theme-color" content="#1a237e">
	<?php include('fragment/frameworkImports.html'); ?>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; } .margintop10{ margin-top: 10px; }
		.loadingText{ animation: move 4s infinite forwards; } .loaded{ -webkit-transition: opacity 1s ease-in-out; opacity: 0; }
		@keyframes move{ 0% { transform: translateY(0px);} 75% { transform: translateY(-50px);} 100% { transform: translateY(0px);}}
  </style>
</head>

<div id="loadingPage" style="position: fixed; background: #ffffff; z-index: 10; height: 100%; width :100%;"><h5 class="teal-text center loadingText" style="margin-top:20%;">Loading apu-schedule...</h5></div>
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
            <span class="card-title">Analytick</span><br>
							<div class="input-field">
								<textarea id="analytickData" class="materialize-textarea" disabled><?php $list = fopen("data/analytica.txt", "r"); while(!feof($list)) { echo trim(fgets($list)); } fclose($list); ?></textarea>
          			<label for="analytickData">Analytick Data</label>
							</div>
							<button onclick="unlockAnalytick();" class="waves-effect waves-light btn red darken-3 margintop10"><i class="material-icons left">details</i>Unlock</button>
							<button onclick="updateAnalytick();" class="waves-effect waves-light btn indigo darken-3 margintop10" id="btnAna" disabled><i class="material-icons left">change_history</i>Update</button><br><br>
          </div>
        </div>
      </div>
    </div>

		<div class="row">
      <div class="col s12 m6">
        <div class="card hoverable">
          <div class="card-content">
            <span class="card-title">Quick Links</span><br>
            <a href="index.php"><button class="waves-effect waves-light btn indigo darken-3 margintop10">APU Schedule</button></a>
            <a href="analytick.php"><button class="waves-effect waves-light btn indigo darken-3 margintop10">Analytick</button></a>
            <a href="ta/index.php"><button class="waves-effect waves-light btn indigo darken-3 margintop10">TA Final Roster</button></a>
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
function unlockAnalytick(){ document.getElementById("btnAna").disabled=false; document.getElementById("analytickData").disabled=false; }
function updateAnalytick() {
	a = new XMLHttpRequest; b = document.getElementById("analytickData").value;
	a.open("POST", "control/updater.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("updateAna="+b);
	a.onload = function() { 200 == this.status && ( M.toast({html: 'Analytick data updated!!'}), document.getElementById("btnAna").disabled=true, document.getElementById("analytickData").disabled=true );
	};
}
function updateR() {
  var b = document.querySelector("#roster"), c = document.getElementById("rosterStatus"), a = b.files[0]; c.removeAttribute("style");
  b = new FormData; b.append("roster", a);
  a = new XMLHttpRequest; a.open("POST", "control/updater.php", !0);
  a.onload = function() { 200 == this.status && (c.innerHTML = this.responseText); }; a.send(b); }

document.getElementById("loadingPage").classList.add('loaded');
</script>
</body>
</html>
