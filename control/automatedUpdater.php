<?php if(isset($_GET['redirect'])){ ?>
  <!-- APU Schedule by jonathan law -->
  <html lang="en">
  <head>
  	<title>APU/APIIT Updater</title>
  	<meta name="theme-color" content="#ffffff">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:500" rel="stylesheet">
    <style>
    body{display:flex;min-height:100vh;flex-direction:column}main{flex:1 0 auto}.updateTxt{text-align:center;color:#009688!important;font-family: 'Montserrat', sans-serif; font-weight: 200; font-size: 2.5rem;}.loadingText{animation:move 4s infinite forwards;margin-top:60%}
    .container{margin:0 auto;max-width:1280px;width:90%}@media only screen and (min-width:601px){.container{width:85%}}@media only screen and (min-width:993px){.container{width:70%}}
    @keyframes move{0%,100%{transform:translateY(0)}75%{transform:translateY(-50px)}}@media only screen and (min-width:720px){.loadingText{margin-top:25%}}
    .loadingPage{ position: fixed; background: #ffffff; z-index: 10; height: 100%; width :100%; }
    </style>
  </head>

  <body>
    <main>
      <div id="loadingPage" class="loadingPage">
        <div class="container"><h5 class="updateTxt loadingText">Please wait...<br />The schedule is being updated now</h5></div>
      </div>
    </main>
  <script>
  	var a = new XMLHttpRequest;
  	a.open("POST", "updater.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("action=updateS");
  	a.onload = function() { 200 == this.status && ( window.location.replace('../index.php') );
  	};
  </script>
  </body>
  </html>

<?php } else { echo 'You are not authorized'; } ?>
