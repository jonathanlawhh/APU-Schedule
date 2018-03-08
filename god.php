<!-- APU Schedule by jonathan law -->
<html lang="en">
<head>
	<meta http-equiv="cache-control" content="max-age=518400" />
	<title>APU/APIIT God Mode</title>
	<link rel="stylesheet" href="css/materialize.min.css" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="css/materialize.min.css"></noscript>
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons" media="none" onload="if(media!='all')media='all'">
	<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"></noscript>
	<link rel="icon" href="images/favicon.png">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<meta name="theme-color" content="#1a237e">
	<script type="text/javascript" src="js/materialize.min.js" async></script>
	<script type="text/javascript" src="js/jquery-3.3.1.min.js" async></script>
  <style>
	  body { display: flex; min-height: 100vh; flex-direction: column; }
	  main {  flex: 1 0 auto; }
  </style>
</head>

<body>
  <main>
  <nav class="nav-extended indigo darken-3" style="margin-bottom:10px;">
    <div class="container">
      <span class="nav-title hide-on-small-only">APU/APIIT God Mode</span>
      <b><span class="show-on-small hide-on-med-and-up" style="margin-bottom:0; font-size:22px;">God Mode</span></b>
      <div class="nav-content">
        <ul class="tabs tabs-transparent">
          <li class="tab"><a>Panel</a></li>
        </ul>
      </div>
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

  </div>

  </main>
	<footer class="page-footer grey darken-3">
	  <div class="footer-copyright grey darken-4">
	    <div class="container">APU Schedule <a href="index.php">here</a></div>
	  </div>
	</footer>
<script>
function initialize() { M.Tabs.init(document.querySelectorAll('.tabs'), {}); }
window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;

function addLog(a) {
  var b = document.createElement("p"); a = document.createTextNode(a); b.appendChild(a); document.getElementById("loggingID").appendChild(b);
}

function updateS() {
  document.getElementById("loggingID").removeAttribute("style");
  $.ajax({type:"post", url:"control/updater.php", dataType:"text", data:{action:"updateS"}, success:function(a) {
    document.getElementById("status").innerHTML = "Update log : "; document.getElementById("progressbar").style.display = "none"; eval(a);
  }})
}

function updateR() {
  var b = $("#roster").prop("files")[0], a = new FormData; a.append("roster", b), z=document.getElementById("rosterStatus");
	z.removeAttribute("style");
  $.ajax({url:"control/updater.php", dataType:"text", contentType:!1, processData:!1, data:a, type:"post", success:function(a) { z.innerHTML = a; }});
}
</script>
</body>
</html>
