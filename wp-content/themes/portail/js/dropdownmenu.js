(function ($) {
    // DOM ready
    $(function() {

        // Create the dropdown base
        $("<select />").appendTo("nav");

        // Create default option "Go to..."
        $("<option />", {
            "selected": "selected",
            "value"   : "http://bib-preprod.cnrs.fr/",
            "text"    : "Actus en ..."
        }).appendTo("nav select");

        // Populate dropdown with menu items
        $("nav > div > ul > li").each(function() {

          var el = $(this);

          var hasChildren = el.find("ul"),
              children    = el.find("li > a");

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
