// JavaScript Document
// Accessibility links
aFocus = function() {
  if(document.getElementById && document.getElementById("skip_nav")) {
    var aEls = document.getElementById("skip_nav").getElementsByTagName("A");
    for (var i=0; i<aEls.length; i++) {
      aEls[i].className="hidden";
      aEls[i].onfocus=function() {
        this.className="";
      }
    }
  }
}
function addLoadEvent(func) {
  if (window.addEventListener) 
    window.addEventListener("load", func, false);
  else if (window.attachEvent) 
    window.attachEvent("onload", func);
}
addLoadEvent(aFocus);