<?php if(isset($_GET['redirect'])){ ?>
  <!-- APU Schedule by jonathan law -->
  <html lang="en">
  <head>
  	<title>APU/APIIT Updater</title>
  	<meta name="theme-color" content="#ffffff">
  	<?php include('../fragment/frameworkImportsTA.html'); ?>
    <style>
  	  body { display: flex; min-height: 100vh; flex-direction: column; } main {  flex: 1 0 auto; }
  		.loadingText{ animation: move 4s infinite forwards; margin-top: 60%;}
  		@keyframes move{ 0% { transform: translateY(0px);} 75% { transform: translateY(-50px);} 100% { transform: translateY(0px);}}
      @media only screen and (min-width: 720px) { .loadingText{ margin-top: 25%; } }
    </style>
  </head>

  <body>
    <main>
      <div id="loadingPage" style="position: fixed; background: #ffffff; z-index: 10; height: 100%; width :100%;">
        <div class="container"><h5 class="teal-text center loadingText">Please wait...<br />The schedule is being updated now</h5></div>
      </div>
    </main>
  	<footer class="page-footer grey darken-3" id="meme"><div class="footer-copyright grey darken-4"></div></footer>
  <script>
  	a = new XMLHttpRequest;
  	a.open("POST", "updater.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("action=updateS");
  	a.onload = function() { 200 == this.status && ( window.location.replace('../index.php') );
  	};
  </script>
  </body>
  </html>

<?php } else { echo 'You are not authorized'; } ?>
