// Topbar JS
(
	function( $ ) {

		amely.closeTopBar = function() {

			var $closeBtn = $( '.topbar-close-btn' ),
				$openBtn  = $( '.topbar-open-btn' ),
				$topBar   = $( '.topbar' ),
				height    = $topBar.outerHeight();

			$closeBtn.on( 'click', function( e ) {
				e.preventDefault();

				if ( ! $topBar.hasClass( 'closed' ) ) {
					$topBar.addClass( 'closed' );
					$( '#page-container' ).css( 'margin-top', 0 - height );
				}

			} );

			$openBtn.on( 'click', function( e ) {
				e.preventDefault();

				if ( $topBar.hasClass( 'closed' ) ) {
					$topBar.removeClass( 'closed' );
					$( '#page-container' ).css( 'margin-top', 0 );
				}
			} );
		}
	}
)( jQuery );
