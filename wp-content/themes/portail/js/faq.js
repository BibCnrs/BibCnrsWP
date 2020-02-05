(function ($) {
    // DOM ready
    $(function() {
		function flipflop(id,cat,move) {
			if (cat=='faq'){
				if (move == 'yes') {
					$('html, body').animate({
		        		scrollTop: $('#faq-'+id+'').offset().top
		    		}, 200);									
				}
			if (!document.getElementById('rep-'+id+'').style.display || document.getElementById('rep-'+id+'').style.display == "none")
					document.getElementById('rep-'+id+'').style.display = "block";
			else	document.getElementById('rep-'+id+'').style.display = "none";
			}
			if (cat=='sub' && move=='yes'){
				$('html, body').animate({
	        		scrollTop: $('#subfaq-'+id+'').offset().top
	    		}, 200);									
			}
		}
		var search;
		url = window.location.search;
		searchfaq = url.split("faq=")[1];
		searchsubfaq = url.split("sub=")[1];
		if (searchfaq) {
			flipflop(searchfaq,'faq','yes');
		}
		if (searchsubfaq) {
			flipflop(searchsubfaq,'sub','yes');
		}
		$('.faqTitle').click(function(e) {
			var focus = $(e.target).attr('id').split("-")[1];
			flipflop(focus,'faq','no');
		});
    });
})(jQuery);
