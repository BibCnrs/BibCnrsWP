(function ($) {
    // DOM ready
    $(function() {
		function change_domain(){
			$('.discBox').hide();
			$('#domain-'+encours+'').hide();
			$('#domain-'+prochaine+'').show();
			var elems = $('.discBox[data-type="type-'+prochaine+'"]');
			$('#detail-'+prochaine+' .discBox').css({"display":"flex"});
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		function show_detail(){
			$('.postDetail').hide();
			$('.discBox').css({"border":"none"});
			$('#postDetail-'+focus+'').show();
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
		$('#detail-'+encours+' .discBox').css({"display":"flex"});
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
