(function ($) {
    // DOM ready
    $(function() {
		function flipflop(id,move) {
			if (move == 'yes') {
				$('html, body').animate({
	        		scrollTop: $('#faq-'+id+'').offset().top
	    		}, 200);				
			}
			if (!document.getElementById('rep-'+id+'').style.display || document.getElementById('rep-'+id+'').style.display == "none")
					document.getElementById('rep-'+id+'').style.display = "block";
			else	document.getElementById('rep-'+id+'').style.display = "none";
		}
		var search;
		url = window.location.search;
		search = url.split("=")[1];
		if (search) {
			flipflop(search,'yes');
		}
		$('.faqTitle').click(function(e) {
			var focus = $(e.target).attr('id').split("-")[1];
			flipflop(focus,'no');
		});
    });
})(jQuery);
