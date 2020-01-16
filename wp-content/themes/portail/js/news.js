(function ($) {
    // DOM ready
    $(function() {
		Math.trunc = Math.trunc | function(x) {
			if (isNaN(x)) {
				return Math.floor(x);
			}
				return Math.ceil(x);
		}
		function change_domain(){
			$('.newsBox').hide();
			$('#domain-'+encours+'').hide();
			$('#domain-'+prochaine+'').show();
			var elems = $('.newsBox[data-type="type-'+prochaine+'"]');
			var nbpage = Math.ceil(elems.length/postperpage);
			$('#newsPages').children('span').remove();
			for (var j = 1; j <= nbpage; j++) {
				$('#newsPages').append('<span class="newsPage" id="page-'+j+'">'+j+'</span>');
			}
			encourspage = 1;
			$('#page-'+encourspage+'').toggleClass('activePage');
			for (var i = 0; i < elems.length; i+=postperpage) {
				elems.slice(i,i+postperpage).wrapAll('<div class="flexrow" id="grpNews-'+prochaine+'-'+grpnews+'"> ')
				grpnews = grpnews + 1;
			}
			$('#grpNews-'+prochaine+'-1 .newsBox').show();
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		function change_page(){
			$('.newsBox').hide();
			$('#grpNews-'+encours+'-'+nextpage+' .newsBox').show();
		}
		var encours = $('.menuItem').first().attr('id').split("-")[1];
		var grpnews = 1;
		var prochaine;
		var encourspage = 1;
		var nextpage;
		var postperpage =12;
		var elems = $('.newsBox[data-type="type-'+encours+'"]');
		var nbpage = Math.ceil(elems.length/postperpage);
		for (var j = 1; j <= nbpage; j++) {
			$('#newsPages').append('<span class="newsPage" id="page-'+j+'">'+j+'</span>');
		}
		$('#page-'+encourspage+'').toggleClass('activePage');
		$('.newsBox').hide();
		for (var i = 0; i < elems.length; i+=postperpage) {
			elems.slice(i,i+postperpage).wrapAll('<div class="flexrow" id="grpNews-'+encours+'-'+grpnews+'"> ')
			grpnews = grpnews + 1;
		}
		$('#grpNews-'+encours+'-1 .newsBox').show();
		$('#domain-'+encours+'').show();
		$('#menuNews-'+encours).prop( "checked", true );

		$('.menuItem').click(function(e) {
			prochaine = $(e.target).attr('id').split("-")[1];
			grpnews = 1;
			change_domain();
		});
		$('#newsPages').on('click', '.newsPage', function(e) {
			nextpage = $(e.target).attr('id').split("-")[1];
			$('#page-'+encourspage+'').toggleClass('activePage');
			$('#page-'+nextpage+'').toggleClass('activePage');
			encourspage = nextpage;
			change_page();
		});
    });
})(jQuery);
