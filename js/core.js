function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	$("#classlist").load("fragment/classlist.html"); }

function doSearch() {
var checkedValue = document.querySelector(".emptyClass"), lol = "";
lol = checkedValue.checked ? "on" : null;
var a = document.getElementById("searchInfo"), c = document.getElementById("resultArea"), d = document.getElementById("tutorial"), e = document.querySelector(".dateDay:checked").value, f = document.getElementById("hidemsg"), b = document.getElementById("searchVal").value;
b ? $.ajax({type:"post", url:"control/logic.php", dataType:"text", data:{classroom:b, date:e, emptyClass:lol}, success:function(g) {
	d.style.display = "none"; c.removeAttribute("style"); f.removeAttribute("style"); a.style.display = "block"; a.innerHTML = "Results for " + b + " on " + e;
	$("#resultArea").html(g);
}}) : d.style.display = "block"; f.style.display = "none"; c.style.display = "none"; a.style.display = "none"; f.style.display = "none"; }

function changemytimetable() {
  document.getElementById("timetableContent") || $("#mytimetable").load("control/mytimetable.php");
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
