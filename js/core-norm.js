function initialize() {
	M.Tabs.init(document.querySelectorAll('.tabs'), {});
  M.Collapsible.init(document.querySelector(".collapsible"), {});
	fetch("fragment/classlist.html?ver=1").then(function(a) { return a.text(); })
	.then(function(a) { document.querySelector("#classlist").innerHTML = a;}); }

function doSearch() {
  document.getElementById('searchTxt').innerHTML = '<i class="material-icons left searchIcon">details</i>Searching';
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
	if(navigator.onLine){
	postMe('control/logic.php',"classroom=" + e + "&date=" + d + "&emptyClass=" + b)
	.then(function(a) {
		if(a[0]['method']=='empty' || a[0]['method']=='invalid' || a[0]['method']=='noinput'){
			g.style.display = f.style.display = h.style.display = "none";
			c.innerHTML = e + ' seems ' + a[0]['method'] + ' on ' + d;
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
    document.getElementById('searchTxt').innerHTML = '<i class="material-icons left">lightbulb_outline</i>Search';
	})
} else {
  M.toast({html: 'You are offline!', displayLength:'5000'});
	g.style.display = "none"; c.innerHTML='<i class="material-icons left">portable_wifi_off</i><h5>No internet connection</h5>';
}
}

function changemytimetable() {
  if(!navigator.onLine){M.toast({html: 'You are offline!', displayLength:'5000'});}
  changeTab('brown darken-4','#3e2723');
}

emptyclasses = [];
function changeavailable() {
  if(!navigator.onLine){M.toast({html: 'You are offline!', displayLength:'5000'});}
  else {
    postMe('control/available.php',"classroom=available")
    .then(function(a) {
        emptyclasses = a;
        queryavailableclass('All');
    });
  }
  changeTab('blue darken-3','#0d47a1');
}


function queryavailableclass(stat){
  var list = document.getElementById('availableClasses'), filter = document.getElementById('filtertype'), emptyclass = '';
  var i = 0;
  list.innerHTML = '';
  emptyclasses.forEach(function(element) {
			switch(stat){
        case 'APIIT Labs' :
            if(element.classroom.toLowerCase().includes("lab l3")){
              emptyclass = createclassblock(element.classroom,element.nextclass,i);
            } else { return; } break;
				case 'APU Labs' :
            if(element.classroom.toLowerCase().includes("lab") && !(element.classroom.toLowerCase().includes("lab l3"))){
              emptyclass = createclassblock(element.classroom,element.nextclass,i);
            } else { return; } break;
        case 'Block-B' :
            if(element.classroom.includes("B-")){
              emptyclass = createclassblock(element.classroom,element.nextclass,i);
            } else { return; } break;
        case 'Block-D' :
            if(element.classroom.includes("D-")){
              emptyclass = createclassblock(element.classroom,element.nextclass,i);
            } else { return; } break;
        case 'Block-E' :
            if(element.classroom.includes("E-")){
              emptyclass = createclassblock(element.classroom,element.nextclass,i);
            } else { return; } break;
        case 'All' :
            emptyclass = createclassblock(element.classroom,element.nextclass); break;
        default :
            emptyclass = "<h5>No data found</h5>"; break;
			}
      filter.innerHTML = stat;
      list.innerHTML += emptyclass;
      i++;
  });
}

function createclassblock(a,b,c=0){
  textcolor = "none" == b.trim() ? "cyan-text text-darken-3" : "";
  return "<div class='col s6 m3'><div class='card-panel fadein' style='animation-delay: " + c/15 + "s;><span class='card-title'>" + a + "</span><p class='" + textcolor + "'>Next class : " + b + "<span></p></div></div>";
}

function hidethead() {
var a = document.getElementById("tableHead");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC;") : (a.style.display = "none", document.cookie = "apuschedule-tablehead=hidden;expires=Mon, 31 Dec 2018 20:00:00 UTC; path=/;");
}

window.addEventListener ? window.addEventListener("load", initialize, !1) : window.attachEvent ? window.attachEvent("onload", initialize) : window.onload = initialize;
document.getElementById("searchVal").addEventListener("keyup", function(a) { a.preventDefault(); 13 === a.keyCode && doSearch(); });

function postMe(c, b) {
  return new Promise(function(d, e) {
    var a = new XMLHttpRequest;
    a.onload = function() { d(JSON.parse(this.responseText)); };
    a.onerror = e; a.open("POST", c); a.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); a.setRequestHeader('Accept', 'application/json'); a.send(b);
  });
}

function changeTab(color,hex){
  document.getElementById("headercolor").className = "nav-extended " + color;
  document.querySelector("meta[name=theme-color]").setAttribute("content", hex);
}

//<script>warning();</script><div class='marginleft4'><h4>(ง'̀-'́)ง</h4><p><b>I smell weird attempts...</b><br>But why though :(</p></div>
