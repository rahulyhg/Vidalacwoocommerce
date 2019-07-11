jQuery( '.showcase-product .product' ).removeClass( 'col-xs-12 col-sm-6 col-md-4 col-lg-4 col-lg-3 col-xl-is-5' );

// One page scroll
if ( jQuery( 'body' ).hasClass( 'onepage-scroll' ) ) {
	if ( jQuery( window ).width() > 900 ) {
		onepageScroll();
	}
}

// Set height for onepage-scroll
function onepageScroll() {
	var $opScroll = jQuery( '.entry-content' );
	var $hWindows = jQuery( window ).height();
	$opScroll.onepage_scroll( {
		sectionContainer: '.onepage',
		easing: 'ease',
		animationTime: 1000
	} );
	$opScroll.css( 'height', $hWindows + 'px' );
	jQuery( window ).trigger( 'resize' );
}