(function ($) {
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
		var searchfaq;
		url = window.location.search;
		searchfaq = url.split("faq=")[1];
		if (searchfaq) {
			flipflop(searchfaq,"yes");
		}
		$('.faqTitle').click(function(e) {
			var focus = $(e.target).attr('id').split("-")[1];
			flipflop(focus,"no");
		});
    });
})(jQuery);
