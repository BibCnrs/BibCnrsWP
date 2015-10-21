(function () {
    'use strict';
    // JavaScript Document
    // Accessibility links
    var aFocus = function () {
        if(document.getElementById && document.getElementById("skip_nav")) {
            var aEls = document.getElementById("skip_nav").getElementsByTagName("A");
            var onfocus = function () {
                this.className = "";
            };
            for (var i = 0; i < aEls.length; i++) {
                aEls[i].className = "hidden";
                aEls[i].onfocus = onfocus;
            }
        }
    };

    function addLoadEvent(func) {
        if (window.addEventListener){
            window.addEventListener("load", func, false);
        }
        else if (window.attachEvent)
        {
            window.attachEvent("onload", func);
        }
    }
    addLoadEvent(aFocus);
})();
