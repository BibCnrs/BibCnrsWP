(function ($) {
    // DOM ready
    $(function() {
		function change_domain(){
			$('.newsBox').hide();
			$('#domain-'+encours+'').hide();
			$('#domain-'+prochaine+'').show();
			var elems = $('.newsBox[data-type="type-'+prochaine+'"]');
			$('#detail-'+prochaine+' .newsBox').show();
			$('#menuNews-'+encours).prop( "checked", false );
			$('#menuNews-'+prochaine).prop( "checked", true );
			encours = prochaine;
		}
		$('.newsBox').hide();
		var encours = $('.menuItem').first().attr('id').split("-")[1];
		var prochaine;
		var elems = $('.newsBox[data-type="type-'+encours+'"]');
		$('#domain-'+encours+'').show();
		$('#detail-'+encours+' .newsBox').show();
		$('#menuNews-'+encours).prop( "checked", true );

		$('.menuItem').click(function(e) {
			prochaine = $(e.target).attr('id').split("-")[1];
			change_domain();
		});
    });
})(jQuery);
