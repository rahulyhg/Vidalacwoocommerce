// Video popup
(
	function( $ ) {

		amely.videoPopup = function() {

			$( '.button-video, #button-video a' ).magnificPopup( {
				type           : 'iframe',
				mainClass      : 'mfp-fade',
				removalDelay   : 160,
				preloader      : false,
				fixedContentPos: false
			} );

			$( '.video-lightbox-btn' ).magnificPopup( {
				type           : 'iframe',
				mainClass      : 'mfp-fade',
				removalDelay   : 160,
				preloader      : false,
				fixedContentPos: false
			} );

		};
	}
)( jQuery );
