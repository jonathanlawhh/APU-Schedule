function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	fetch("fragment/classlist.html?ver=1").then(function(a) { return a.text(); })
	.then(function(a) { document.querySelector("#classlist").innerHTML = a;}); }

function doSearch() {
  var b = ""; b = document.querySelector(".emptyClass").checked ? "on" : "";
  var c = document.getElementById("searchInfo"), f = document.getElementById("resultArea"), g = document.getElementById("tutorial"), d = document.querySelector(".dateDay:checked").value, h = document.getElementById("hidemsg"), e = document.getElementById("searchVal").value, a = new XMLHttpRequest;
  a.open("POST", "control/logic.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("classroom=" + e + "&date=" + d + "&emptyClass=" + b);
  a.onload = function() { 200 == this.status && (g.style.display = "none", f.removeAttribute("style"), h.removeAttribute("style"), c.style.display = "block", c.innerHTML = "Results for " + e + " on " + d, document.getElementById("resultArea").innerHTML = a.responseText); }; }

function changemytimetable() {
	if (!document.getElementById("timetableContent")) {
  var a = new XMLHttpRequest, intakeC = ""; c = document.cookie.split(";");
	for(i=0;i<c.length;i++){ if( c[i].indexOf('myIntakeCode') != -1){ c=c[i].split("="); intakeC = c[1]; break; } }
  a.open("POST", "control/mytimetable.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("intake=" + unescape(intakeC));
  a.onreadystatechange = function() { document.getElementById("mytimetable").innerHTML = a.responseText; M.Collapsible.init(document.querySelector(".collapsible"), {}); }; }
	document.getElementById("headercolor").className = "nav-extended brown darken-4";
	document.querySelector("meta[name=theme-color]").setAttribute("content", "#3e2723"); }

function warning() {
document.getElementById("headercolor").className = "nav-extended red darken-3";
document.getElementById("btn_all").className = "waves-effect waves-light btn col s4 m2 l2 red darken-1";
document.querySelector("meta[name=theme-color]").setAttribute("content", "#b71c1c"); }

function hidethead() {
var a = document.getElementById("removethead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;", document.getElementById("hidemsg").innerHTML = "Hide table header;") : (a.style.display = "none", document.getElementById("hidemsg").innerHTML = "Show table header", document.cookie = "apuschedule-tablehead=hidden;expires=Mon, 31 Dec 2018 20:00:00 UTC; path=/;");
}

function getCurTimetable(b) {
  if (!document.getElementById(b + "Data")) { document.getElementById(b).innerHTML = "<div class='progress brown lighten-5'><div class='indeterminate brown darken-2'></div></div>";
  var a = new XMLHttpRequest; a.open("POST", "control/getTimetable.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("getMe=" + b);
  a.onload = function() { 200 == this.status && (document.getElementById(b).innerHTML = a.responseText); }; } }

window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
document.getElementById("searchVal").addEventListener("keyup", function(a) { a.preventDefault(); 13 === a.keyCode && doSearch(); });
