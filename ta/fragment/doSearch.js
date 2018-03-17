function addSec(a, b) { a += "c"; var c = document.createElement("p"); b = document.createTextNode(b); c.appendChild(b); document.getElementById(a).appendChild(c); }

function doSearch() {
  var a = document.getElementById("searchInfo"), b = document.querySelector(".duty:checked").value, c = document.querySelector(".dateDay:checked").value;
  document.getElementById("S1c").innerHTML = '';document.getElementById("S2c").innerHTML = '';document.getElementById("S3c").innerHTML = '';
  document.getElementById("S4c").innerHTML = '';document.getElementById("S5c").innerHTML = '';document.getElementById("S6c").innerHTML = ''; a.innerHTML = "Please wait...";
  var j = new XMLHttpRequest;
  j.open("POST", "searchLogic.php", !0); j.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); j.send("duty=" + b + "&date=" + c);
  j.onreadystatechange = function() {
  j.readyState == XMLHttpRequest.DONE && 200 == j.status && (a.innerHTML = "Results for " + b + " on " + c, eval(j.responseText)); };
}
