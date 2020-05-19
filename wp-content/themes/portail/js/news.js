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
			$('.discBox').hide();
			$('.postDetail').hide();
			$('.newsBox[data-type="news-'+encours+'"]').unwrap();
			$('.discBox[data-type="disc-'+encours+'"]').unwrap();
			$('.newsBox').css({"border":"none"});
			$('.discBox').css({"border":"none"});
			$('#titlenews-'+encours+'').hide();
			$('#titledisc-'+encours+'').hide();
			$('#titlenews-'+prochaine+'').show();
			$('#titledisc-'+prochaine+'').show();
			$('html, body').animate({
        		scrollTop: $('#titlenews-'+prochaine+'').offset().top
    		}, 200);
			var elemsnews = $('.newsBox[data-type="news-'+prochaine+'"]');
			var nbpagenews = Math.ceil(elemsnews.length/postperpage);
			$('#newsPages').children('span').remove();
			for (var j = 1; j <= nbpagenews; j++) {
				if (nbpagenews > 1) {
					$('#newsPages').append('<span class="newsPage" id="pagenews-'+j+'">'+j+'</span>');
				}
			}
			encourspagenews = 1;
			$('#pagenews-'+encourspagenews+'').toggleClass('activePage');
			for (var i = 0; i < elemsnews.length; i+=postperpage) {
				elemsnews.slice(i,i+postperpage).wrapAll('<div id="grpNews-'+prochaine+'-'+grpnews+'"> ')
				grpnews = grpnews + 1;
			}
			var elemsdisc = $('.discBox[data-type="disc-'+prochaine+'"]');
			var nbpagedisc = Math.ceil(elemsdisc.length/postperpage);
			$('#discPages').children('span').remove();
			for (var j = 1; j <= nbpagedisc; j++) {
				if (nbpagedisc > 1) {
					$('#discPages').append('<span class="discPage" id="pagedisc-'+j+'">'+j+'</span>');
				}
			}
			encourspagedisc = 1;
			$('#pagedisc-'+encourspagedisc+'').toggleClass('activePage');
			for (var i = 0; i < elemsdisc.length; i+=postperpage) {
				elemsdisc.slice(i,i+postperpage).wrapAll('<div id="grpDisc-'+prochaine+'-'+grpdisc+'"> ')
				grpdisc = grpdisc + 1;
			}
			$('#grpNews-'+prochaine+'-1 .newsBox').css({"display":"flex"});
			$('#grpDisc-'+prochaine+'-1 .discBox').css({"display":"flex"});
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		function change_newspage(){
			$('.newsBox').hide();
			$('#postDetail-'+focus+'').hide();
			$('#box-'+encours+'-'+focus+'').css({"border":"none"});
			$('#grpNews-'+encours+'-'+nextpagenews+' .newsBox').css({"display":"flex"});
			$('html, body').animate({
        		scrollTop: $('#titlenews-'+encours+'').offset().top
    		}, 200);
		}
		function change_discpage(){
			$('.discBox').hide();
			$('#postDetail-'+focus+'').hide();
			$('#box-'+encours+'-'+focus+'').css({"border":"none"});
			$('#grpDisc-'+encours+'-'+nextpagedisc+' .discBox').css({"display":"flex"});
			$('html, body').animate({
        		scrollTop: $('#titledisc-'+encours+'').offset().top
    		}, 200);
		}
		function show_detail(){
			$('.postDetail').hide();
			$('.newsBox').css({"border":"none"});
			$('.discBox').css({"border":"none"});
			$('#postDetail-'+focus+'').show();
			$('html, body').animate({
        		scrollTop: $('#postDetail-'+focus+'').offset().top
    		}, 200);
			$('#box-'+encours+'-'+focus+'').css({"border":"2px solid #FF9982"});
		}
		function close_detail(){
			$('#postDetail-'+focusnext+'').hide();
			$('#box-'+encours+'-'+focus+'').css({"border":"none"});
		}
		var encours = $('.menuItem').first().attr('id').split("-")[1];
		var prochaine;
		var postperpage =5;
		var grpnews = 1;
		var grpdisc = 1;
		var encourspagenews = 1;
		var encourspagedisc = 1;
		var nextpagenews;
		var nextpagedisc;
		var focus;
		var focusnext;
		var elemsnews = $('.newsBox[data-type="news-'+encours+'"]');
		var elemsdisc = $('.discBox[data-type="disc-'+encours+'"]');
		var nbpagenews = Math.ceil(elemsnews.length/postperpage);
		var nbpagedisc = Math.ceil(elemsdisc.length/postperpage);
		for (var j = 1; j <= nbpagenews; j++) {
			if (nbpagenews > 1) {
				$('#newsPages').append('<span class="newsPage" id="pagenews-'+j+'">'+j+'</span>');
			}
		}
		for (var j = 1; j <= nbpagedisc; j++) {
			if (nbpagedisc > 1) {
				$('#discPages').append('<span class="discPage" id="pagedisc-'+j+'">'+j+'</span>');
			}
		}
		$('#pagenews-'+encourspagenews+'').toggleClass('activePage');
		$('#pagedisc-'+encourspagenews+'').toggleClass('activePage');
		for (var i = 0; i < elemsnews.length; i+=postperpage) {
			elemsnews.slice(i,i+postperpage).wrapAll('<div id="grpNews-'+encours+'-'+grpnews+'"> ')
			grpnews = grpnews + 1;
		}
		for (var i = 0; i < elemsdisc.length; i+=postperpage) {
			elemsdisc.slice(i,i+postperpage).wrapAll('<div id="grpDisc-'+encours+'-'+grpdisc+'"> ')
			grpdisc = grpdisc + 1;
		}
		$('#grpNews-'+encours+'-1 .newsBox').css({"display":"flex"});;
		$('#grpDisc-'+encours+'-1 .discBox').css({"display":"flex"});;
		$('#titlenews-'+encours+'').show();
		$('#titledisc-'+encours+'').show();
		$('#menuNews-'+encours).prop( "checked", true );
		var search;
		url = window.location.search;
		focus = url.split("post=")[1];
		if (focus) {
			show_detail();
		}
		$('.menuItem').click(function(e) {
			prochaine = $(e.target).attr('id').split("-")[1];
			grpnews = 1;
			grpdisc = 1;
			change_domain();
		});
		$('#newsPages').on('click', '.newsPage', function(e) {
			nextpagenews = $(e.target).attr('id').split("-")[1];
			$('#pagenews-'+encourspagenews+'').toggleClass('activePage');
			$('#pagenews-'+nextpagenews+'').toggleClass('activePage');
			encourspagenews = nextpagenews;
			change_newspage();
		});
		$('#discPages').on('click', '.discPage', function(e) {
			nextpagedisc = $(e.target).attr('id').split("-")[1];
			$('#pagedisc-'+encourspagedisc+'').toggleClass('activePage');
			$('#pagedisc-'+nextpagedisc+'').toggleClass('activePage');
			encourspagedisc = nextpagedisc;
			change_discpage();
		});
		$('.detailOpen').click(function(e) {
			focus = $(e.target).attr('id').split("-")[1];
			show_detail();
		});
		$('.detailClose').click(function(e) {
			focusnext = $(e.target).attr('id').split("-")[1];
			close_detail();
		});
    });
})(jQuery);
