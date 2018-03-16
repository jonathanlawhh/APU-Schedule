function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	fetch("fragment/classlist.html").then(function(a) { return a.text(); })
	.then(function(a) { document.querySelector("#classlist").innerHTML = a;}); }

function doSearch() {
  var b = ""; b = document.querySelector(".emptyClass").checked ? "on" : "";
  var c = document.getElementById("searchInfo"), f = document.getElementById("resultArea"), g = document.getElementById("tutorial"), d = document.querySelector(".dateDay:checked").value, h = document.getElementById("hidemsg"), e = document.getElementById("searchVal").value, a = new XMLHttpRequest;
  a.open("POST", "control/logic.php", !0); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.send("classroom=" + e + "&date=" + d + "&emptyClass=" + b);
  a.onreadystatechange = function() {
    a.readyState == XMLHttpRequest.DONE && 200 == a.status && (g.style.display = "none", f.removeAttribute("style"), h.removeAttribute("style"), c.style.display = "block", c.innerHTML = "Results for " + e + " on " + d, document.getElementById("resultArea").innerHTML = a.responseText);
}; }

function changemytimetable() {
	document.getElementById("timetableContent") || fetch("control/mytimetable.php").then(function(a) { return a.text(); })
	.then(function(a) { document.querySelector("#mytimetable").innerHTML = a; });
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

window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
document.getElementById("searchVal").addEventListener("keyup", function(a) { a.preventDefault(); 13 === a.keyCode && doSearch(); });
