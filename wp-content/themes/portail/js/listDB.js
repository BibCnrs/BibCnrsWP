(function ($) {
    // DOM ready
    $(function() {
  // Transform to alphabetiical list
    $( '#bases li' ).each( function(){

        // Get first letter
        var letter = $(this).text().match( /^\s*([a-z])/im )[1].toUpperCase();

        /*
         * If letter is not in list
         * Creation of sublist
         */
        if ( $( "#_" + letter ).length === 0 ){
            $( '#bases' ).append(
                $( '<div/>' ).attr('class', 'blockletter letter' +letter)
            );
            $( '.letter' +letter).append(
                $( '<h2/>' ).text( letter ),
                $( '<ul/>' ).attr('id', '_' + letter)
            );
        }

        // Add li elements to sublist
        $( '#_' + letter ).append( $(this) );
    });
  });
})(jQuery);
