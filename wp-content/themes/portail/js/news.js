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
			$('#domain-'+encours+' #postDetail-'+focus+'').hide();
			$('#detail-'+encours+' #box-'+focus+'').css({"border":"none"});
			$('#domain-'+encours+'').hide();
			$('#domain-'+prochaine+'').show();
			$('#title-'+encours+'').hide();
			$('#title-'+prochaine+'').show();
			$('html, body').animate({
        		scrollTop: $('#title-'+prochaine+'').offset().top
    		}, 200);
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
			$('#grpNews-'+prochaine+'-1 .newsBox').css({"display":"flex"});
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		function change_page(){
			$('.newsBox').hide();
			$('#domain-'+encours+' #postDetail-'+focus+'').hide();
			$('#detail-'+encours+' #box-'+focus+'').css({"border":"none"});
			$('#grpNews-'+encours+'-'+nextpage+' .newsBox').css({"display":"flex"});
			$('html, body').animate({
        		scrollTop: $('#title-'+encours+'').offset().top
    		}, 200);
		}
		function show_detail(){
			$('.postDetail').hide();
			$('.newsBox').css({"border":"none"});
			$('#domain-'+encours+' #postDetail-'+focus+'').show();
			$('html, body').animate({
        		scrollTop: $('#postDetail-'+focus+'').offset().top
    		}, 200);
			$('#detail-'+encours+' #box-'+focus+'').css({"border":"2px solid #FF9982"});
		}
		function close_detail(){
			$('#domain-'+encours+' #postDetail-'+focusnext+'').hide();
			$('#detail-'+encours+' #box-'+focus+'').css({"border":"none"});
		}
		var encours = $('.menuItem').first().attr('id').split("-")[1];
		var grpnews = 1;
		var prochaine;
		var encourspage = 1;
		var nextpage;
		var focus;
		var focusnext;
		var postperpage =12;
		var elems = $('.newsBox[data-type="type-'+encours+'"]');
		var nbpage = Math.ceil(elems.length/postperpage);
		for (var j = 1; j <= nbpage; j++) {
			$('#newsPages').append('<span class="newsPage" id="page-'+j+'">'+j+'</span>');
		}
		$('#page-'+encourspage+'').toggleClass('activePage');
		for (var i = 0; i < elems.length; i+=postperpage) {
			elems.slice(i,i+postperpage).wrapAll('<div class="flexrow" id="grpNews-'+encours+'-'+grpnews+'"> ')
			grpnews = grpnews + 1;
		}
		$('#grpNews-'+encours+'-1 .newsBox').css({"display":"flex"});;
		$('#domain-'+encours+'').show();
		$('#title-'+encours+'').show();
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
		$('.discDetail').click(function(e) {
			focus = $(e.target).attr('id').split("-")[1];
			show_detail();
		});
		$('.detailClose').click(function(e) {
			focusnext = $(e.target).attr('id').split("-")[1];
			close_detail();
		});
    });
})(jQuery);
