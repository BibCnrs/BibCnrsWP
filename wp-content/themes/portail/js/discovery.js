(function ($) {
    // DOM ready
    $(function() {
		function change_domain(){
			$('#domain-'+encours+'').hide();
			$('#detail-'+encours+'').hide();
			$('#postDetail-'+focus+'').hide();
			$('#box-'+focus+'').css({"border":"none"});
			$('#domain-'+prochaine+'').show();
			$('#detail-'+prochaine+'').css({"display":"flex"});
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		function show_detail(){
			$('.postDetail').hide();
			$('.discBox').css({"border":"none"});
			$('.commonBox').css({"border":"none"});
			$('#postDetail-'+focus+'').show();
			$('html, body').animate({
        		scrollTop: $('#postDetail-'+focus+'').offset().top
    		}, 200);
			$('#box-'+focus+'').css({"border":"2px solid #FF9982"});
		}
		function close_detail(){
			$('#postDetail-'+focusnext+'').hide();
			$('#box-'+focus+'').css({"border":"none"});
		}
		var encours = $('.menuItem').first().attr('id').split("-")[1];
		var prochaine;
		var focus;
		var focusnext;
		var elems = $('.discBox[data-type="type-'+encours+'"]');
		$('#domain-'+encours+'').show();
		$('#detail-'+encours+'').css({"display":"flex"});
		$('#menuNews-'+encours).prop( "checked", true );
		$('.menuItem').click(function(e) {
			prochaine = $(e.target).attr('id').split("-")[1];
			change_domain();
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
