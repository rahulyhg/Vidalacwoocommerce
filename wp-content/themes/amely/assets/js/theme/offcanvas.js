// offcanvas sidebar
(function( $ ) {

	amely.offcanvas = function() {

		var $body            = $( 'body' ),
			$sidebar         = $( '.offcanvas-sidebar' ),
			$offCanvasMenu   = $( '.offcanvas-menu' ),
			$offCanvasButton = $( '.offcanvas-btn > a' ),
			$offCanvasClose  = $( '.offcanvas-close' ),
			$pageContainer   = $( '#page-container' );

		if ( $offCanvasButton == null ) {
			return;
		}

		var offcanvasSidebar = function() {

			$offCanvasButton.on( 'click', function( e ) {

				e.preventDefault();

				$sidebar.addClass( 'open' );
				$body.addClass( 'offcanvas-sidebar-opened' );

				amely.setTopValue( $sidebar );
			} );

			var closeSidebar = function() {

				if ( $sidebar.hasClass( 'open' ) && $body.hasClass( 'offcanvas-sidebar-opened' ) ) {

					$sidebar.removeClass( 'open' );
					$body.removeClass( 'offcanvas-sidebar-opened' );
				}
			};

			$offCanvasClose.on( 'click', function( e ) {
				e.preventDefault();
				closeSidebar();
			} );

			$pageContainer.on( 'click', function( e ) {

				if ( ! $( e.target ).closest( '.offcanvas-btn' ).length && ! $( e.target )
						.closest( '.offcanvas-close a' ).length && $sidebar.hasClass( 'open' ) ) {
					e.preventDefault();
					closeSidebar();
				}
			} );

			// perfect scrollbar
			$sidebar.find( '.offcanvas-sidebar-inner' ).perfectScrollbar( { suppressScrollX: true } );
		}

		var fullscreenMenu = function() {

			var interval = .5;
			$offCanvasMenu.find( '.menu > li' ).each( function() {
				$( this ).css( 'transition-delay', interval + 's' );
				interval += .1;
			} );

			$offCanvasButton.on( 'click', function( e ) {

				e.preventDefault();

				$offCanvasMenu.addClass( 'open' );
				$body.addClass( 'offcanvas-menu-opened' );

				amely.setTopValue( $sidebar );
			} );

			var closeMenu = function() {

				var $menu = $offCanvasMenu.find( '.offcanvas-menu-wrapper .menu' );

				if ( $offCanvasMenu.hasClass( 'open' ) && $body.hasClass( 'offcanvas-menu-opened' ) ) {

					$menu.fadeOut( function() {
						$body.removeClass( 'offcanvas-menu-opened' );
						$menu.fadeIn();
					} );
				}
			};

			$offCanvasClose.on( 'click', function( e ) {
				e.preventDefault();
				closeMenu();
			} );

			$pageContainer.on( 'click', function( e ) {

				if ( ! $( e.target ).closest( '.offcanvas-btn' ).length && ! $( e.target )
						.closest( '.offcanvas-close a' ).length && $sidebar.hasClass( 'open' ) ) {
					e.preventDefault();
					closeMenu();
				}
			} );
		}

		if ( $sidebar.length ) {
			offcanvasSidebar();
		}

		if ( $offCanvasMenu.length ) {
			fullscreenMenu();
		}
	}
})( jQuery );
