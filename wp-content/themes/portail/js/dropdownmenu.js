(function ($) {
    // DOM ready
    $(function() {
        // Translation of menu title
        var oRegex = new RegExp("(?:; )?pll_language=([^;]*);?");
        var lang, title;
            if (oRegex.test(document.cookie)) {
                    lang = decodeURIComponent(RegExp.$1);
            } else {
                    lang = "fr";
            }
            if (lang == "fr") {
                title = "Actus en ...";
            } else {
                title = "News in ...";
            }

        // Create the dropdown base
        $("<select />").appendTo("nav");

        // Create default option "Go to..."
        $("<option />", {
            "selected": "selected",
            "value"   : "http://bib.cnrs.fr/",
            "text"    : title,
        }).appendTo("nav select");

        // Populate dropdown with menu items
        $("nav > div > div.menu > div.nav-main-item").each(function() {

          var el = $(this);

          var hasChildren = el.find("div.menu"),
              children    = el.find("div.nav-main-item > a");

          if (hasChildren.length) {

              $("<optgroup />", {
                  "label": el.find("> a").text()
              }).appendTo("nav select");

              children.each(function() {
                  var chil =$(this);

                  $("<option />", {
                       "value"   : chil.attr("href"),
                       "text"    : " - " + chil.text()
                  }).appendTo("optgroup:last");

              });

          } else {
            $("<option />", {
                "value": el.find(">a").attr("href"),
                "text": el.text()
           }).appendTo("nav select");

          }

        });

        // To make dropdown actually work
        // To make more unobtrusive: http://css-tricks.com/4064-unobtrusive-page-changer/
        $("nav select").change(function() {
            window.location = $(this).find("option:selected").val();
        });

    });
})(jQuery);
