// Compare
(
	function( $ ) {

		var $body = $( 'body' );

		amely.compare = function() {

			$body.on( 'click', '.compare-btn .compare', function() {
				$( this ).parent().addClass( 'loading' );
			} );

			$body.on( 'yith_woocompare_open_popup', function() {
				$( '.compare-btn' ).removeClass( 'loading' );
				$body.addClass( 'compare-opened' );
			} );

			$body.on( 'click', '#cboxClose, #cboxOverlay', function() {
				$body.removeClass( 'compare-opened' );
			} );
		}
	}
)( jQuery );
