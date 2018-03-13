function addSec(a, b) { a += "c"; var c = document.createElement("p"); b = document.createTextNode(b); c.appendChild(b); document.getElementById(a).appendChild(c); }

function doSearch() {
  var a = document.getElementById("searchInfo"), b = document.querySelector(".duty:checked").value, c = document.querySelector(".dateDay:checked").value;
  document.getElementById("S1c").innerHTML = '';document.getElementById("S2c").innerHTML = '';document.getElementById("S3c").innerHTML = '';
  document.getElementById("S4c").innerHTML = '';document.getElementById("S5c").innerHTML = '';document.getElementById("S6c").innerHTML = ''; a.innerHTML = "Please wait...";
  b ? $.ajax({type:"post", url:"searchLogic.php", dataType:"text", data:{duty:b, date:c}, success:function(e) { a.innerHTML = "Results for " + b + " on " + c; eval(e);
  }}) : a.innerHTML = "No results found";
}
