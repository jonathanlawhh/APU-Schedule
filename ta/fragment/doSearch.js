function doSearch() {
  var a = document.getElementById("searchInfo"), b = document.querySelector(".duty:checked").value, c = document.querySelector(".dateDay:checked").value, d = document.getElementById("resultArea");
  a.innerHTML = "Please wait...";
  b ? $.ajax({type:"post", url:"searchLogic.php", dataType:"text", data:{duty:b, date:c}, success:function(e) {
    d.removeAttribute("style"); a.innerHTML = "Results for " + b + " on " + c; $("#resultArea").html(e);
  }}) : a.innerHTML = "No results found";
}

function hidethead2() {
var a = document.getElementById("removethead2"), b = document.getElementById("hidemsg2");
"none" === a.style.display ? (a.style.display = "block", document.cookie = "apuschedule-tablehead=;expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;", b.innerHTML = "Hide table header") : (a.style.display = "none", b.innerHTML = "Show table header", document.cookie = "apuschedule-tablehead=hidden;expires=Mon, 31 Dec 2018 20:00:00 UTC; path=/;");
}
