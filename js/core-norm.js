function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
	fetch("fragment/classlist.html?ver=1").then(function(a) { return a.text(); })
	.then(function(a) { document.querySelector("#classlist").innerHTML = a;}); }

function doSearch() {
	var tableBody = document.getElementById('tableBody');
	var head1 = document.getElementById('headIntake');
	var head2 = document.getElementById('headModule');
	head1.removeAttribute("style");
	head2.removeAttribute("style");
	tableBody.innerHTML = '';
	var emptyInfo = document.getElementById('emptyInfo'); emptyInfo.style.display = "none";
  var b = document.querySelector(".emptyClass").checked ? "on" : "";
  var c = document.getElementById("searchInfo"),
	f = document.getElementById("resultArea"), g = document.getElementById("tutorial"),
	d = document.querySelector(".dateDay:checked").value, h = document.getElementById("hidemsg"), e = document.getElementById("searchVal").value;
	postMe('control/logic.php',"classroom=" + e + "&date=" + d + "&emptyClass=" + b)
	.then(function(a) {
		if(a[0]['method']=='empty' || a[0]['method']=='invalid' || a[0]['method']=='noinput'){
			g.style.display = "none";
			f.style.display = "none";
			h.style.display = "none";
			c.innerHTML = e + ' seems ' + a[0]['method'];
		} else {
			g.style.display = "none", f.removeAttribute("style"), h.removeAttribute("style"),
			c.style.display = "block", c.innerHTML = "Results for " + e + " on " + d,
			f.removeAttribute("style"),
			a.forEach(function(element) {
				if(element.method=='emptyclassroom'){
					head1.style.display='none'; head2.style.display='none';
					tableBody.innerHTML += '<tr><td class="hide-on-small-only">' + element.date + '</td><td>' + element.time + '</td><td>' +
					element.classroom + '</td><td>' + element.lecturer + '</td></tr>';
					if(element.status=='emptyNow'){ emptyInfo.style.display = 'block';  } else { emptyInfo.style.display = 'none'; }
				} else {
					tableBody.innerHTML += '<tr><td>' + element.intake + '</td><td class="hide-on-small-only">' + element.date + '</td><td>' + element.time + '</td><td>' +
					element.classroom + '</td><td>' + element.module + '</td><td>' + element.lecturer + '</td></tr>';
				}
			});
			f.classList.add('tableInAnim');
		}
	})
}

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
var a = document.getElementById("tableHead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;") : (a.style.display = "none", document.cookie = "apuschedule-tablehead=hidden;expires=Mon, 31 Dec 2018 20:00:00 UTC; path=/;");
}

function getCurTimetable(b) {
	var intakeTable = document.getElementById(b);
  if (!document.getElementById(b + "Data")) { intakeTable.innerHTML = "<div class='progress brown lighten-5'><div class='indeterminate brown darken-2'></div></div>";
	postMe('control/logic.php',"classroom=takeIntakeCode&date=" + b + "&method=intakeTimetable")
	.then(function(a){
		intakeTable.innerHTML = '';
		a.forEach(function(element) {
			intakeTable.innerHTML += '<tr id="' + b + 'Data"><td>' + element.time + '</td><td>' + element.classroom + '</td><td>' + element.module + '</td><td>' + element.lecturer + '</td></tr>';
		});
	});
}}

window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
document.getElementById("searchVal").addEventListener("keyup", function(a) { a.preventDefault(); 13 === a.keyCode && doSearch(); });


function postMe(c, b) {
  return new Promise(function(d, e) {
    var a = new XMLHttpRequest;
    a.onload = function() { d(JSON.parse(this.responseText)); };
    a.onerror = e; a.open("POST", c); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.setRequestHeader('Accept', 'application/json'); a.send(b);
  });
}

//<script>warning();</script><div class='marginleft4'><h4>(ง'̀-'́)ง</h4><p><b>I smell weird attempts...</b><br>But why though :(</p></div>
