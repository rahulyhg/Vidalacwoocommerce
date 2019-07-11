// header
(function( $ ) {

	var $window = $( window );

	amely.stickyHeader = function() {

		if ( ! amelyConfigs.sticky_header ) {
			return;
		}

		var $header = $( '.site-header' ),
			$topBar = $( '.topbar' );

		if ( ! $header.length ) {
			return;
		}

		if ( $header.hasClass( 'header-vertical' ) && $window.width() >= 1200 ) {
			return;
		}

		var $leftCol     = $header.find( '.left-col' ),
			$logo        = $header.find( '.site-logo' ),
			$menu        = $header.find( '.site-menu' ),
			$tools       = $header.find( '.header-tools' ),
			$search      = $header.find( '.header-search' ),
			$offCanvaBtn = $header.find( '.offcanvas-btn' );

		var stickyHeaderHTML = '<div class="' + $header.attr( 'class' ) + ' sticky-header">' + '<div class="' + $header.find( '>.container' )
																													   .attr( 'class' ) + '"><div class="row">';
		if ( $leftCol.length ) {
			stickyHeaderHTML += '<div class="' + $leftCol.attr( 'class' ) + '"></div>';
		}

		if ( $offCanvaBtn.length && $offCanvaBtn.hasClass( 'on-left' ) && $header.hasClass( 'header-base' ) ) {
			stickyHeaderHTML += '<div class="' + $offCanvaBtn.attr( 'class' ) + '"></div>';
		}

		if ( $logo.length ) {
			stickyHeaderHTML += '<div class="' + $logo.attr( 'class' ) + '">' + $logo.html() + '</div>';
		}

		if ( $menu.length && ! $header.hasClass( 'header-menu-left' ) ) {
			stickyHeaderHTML += '<div class="' + $menu.attr( 'class' ) + '"></div>';
		}

		if ( $tools.length ) {
			stickyHeaderHTML += '<div class="' + $tools.attr( 'class' ) + '"></div>';
		}

		stickyHeaderHTML += '</div></div></div>';

		// create HTML for stickyHeader
		$header.before( stickyHeaderHTML );
		var $stickyHeader = $( '.sticky-header' );

		if ( $logo.length ) {

			var $img = $stickyHeader.find( '.site-logo img' );

			if ( $img.length ) {
				var o_logo = $img.attr( 'data-o_logo' );
				if ( typeof o_logo != undefined ) {
					$img.attr( 'src', o_logo );
				}
			}
		}

		$window.scroll( function() {

			var offset         = $header.outerHeight(),
				currentScroll  = $( this ).scrollTop(),
				$realLeftCol   = $( '.site-header:not(.sticky-header)' ).find( '.left-col' ),
				$realMenu      = $( '.site-header:not(.sticky-header)' ).find( '.site-menu' ),
				$realTools     = $( '.site-header:not(.sticky-header)' ).find( '.header-tools' ),
				$stickyLeftCol = $stickyHeader.find( '.left-col' ),
				$stickyMenu    = $stickyHeader.find( '.site-menu' ),
				$stickyTools   = $stickyHeader.find( '.header-tools' );

			if ( $topBar.length ) {
				offset += $topBar.outerHeight();
			}

			if ( $( '#wpadminbar' ).length ) {
				offset += $( '#wpadminbar' ).outerHeight();
			}

			if ( currentScroll > offset - 50 ) {

				// let's sticky
				$stickyHeader.addClass( 'is-sticky' );
				$header.addClass( 'real-header' );
				$( '.site-header.real-header' ).css( 'height', $header.outerHeight() );

				$realTools.find( '>div' ).appendTo( '.site-header.sticky-header .header-tools' );

				if ( $header.hasClass( 'header-menu-bottom' ) ) {

					if ( $stickyTools.hasClass( 'layout-only-mini-cart' ) ) {
						$search.prependTo( $stickyTools );
					}

					if ( $offCanvaBtn.hasClass( 'on-left' ) ) {
						$offCanvaBtn.appendTo( '.site-header.sticky-header .left-col' );
					} else {
						$offCanvaBtn.appendTo( $stickyTools );
					}
				} else {
					$realLeftCol.find( '>div' ).appendTo( '.site-header.sticky-header .left-col' );

					if ( $header.hasClass( 'header-base' ) && $offCanvaBtn.hasClass( 'on-left' ) ) {
						$offCanvaBtn.find( '>a' ).appendTo( '.site-header.sticky-header .offcanvas-btn' );
					}
				}

				if ( ! $header.hasClass( 'header-menu-left' ) ) {
					$realMenu.find( '>div' ).appendTo( '.site-header.sticky-header .site-menu' );
				}
			} else {

				$stickyLeftCol.find( '>div' ).appendTo( '.site-header.real-header .left-col' );
				$stickyMenu.find( '>div' ).appendTo( '.site-header.real-header .site-menu' );
				$stickyTools.find( '>div' ).appendTo( '.site-header.real-header .header-tools' );

				if ( $header.hasClass( 'header-menu-bottom' ) ) {

					if ( $stickyTools.hasClass( 'layout-only-mini-cart' ) ) {
						$search.appendTo( '.site-header.real-header .site-menu' );
					}

					if ( $offCanvaBtn.hasClass( 'on-left' ) ) {
						$offCanvaBtn.prependTo( '.site-header.real-header .site-menu-wrap > .container' );
					} else {
						$offCanvaBtn.appendTo( '.site-header.real-header .site-menu-wrap > .container' );
					}
				} else {

					if ( $header.hasClass( 'header-base' ) && $offCanvaBtn.hasClass( 'on-left' ) ) {
						$stickyHeader.find( '.offcanvas-btn >a' ).appendTo( '.site-header.real-header .offcanvas-btn' );
					}
				}

				$( '.site-header.real-header' ).css( 'height', 'auto' );
				$stickyHeader.removeClass( 'is-sticky' );
				$header.removeClass( 'real-header' );
			}

		} );

		// Trigger scroll
		$window.scroll();
	};

	amely.splitNavHeader = function() {

		var $header = $( '.header-split' );

		if ( ! $header.length ) {
			return;
		}

		var $navigation = $header.find( '.site-menu' ),
			$navItems   = $navigation.find( '.menu > li' ),
			itemsNumber = $navItems.length,
			rtl         = $( 'body' ).hasClass( 'rtl' ),
			midIndex    = parseInt( itemsNumber / 2 + .5 * rtl - .5 ),
			$midItem    = $navItems.eq( midIndex ),
			$logo       = $header.find( '.site-logo > a' ),
			logoWidth,
			leftWidth   = 0,
			rule        = rtl ? 'marginLeft' : 'marginRight',
			rightWidth  = 0;

		var recalc = function() {

			logoWidth = $logo.outerWidth(), leftWidth = 0, rightWidth = 0;

			for ( var i = itemsNumber - 1; i >= 0; i -- ) {
				var itemWidth = $navItems.eq( i ).outerWidth();

				if ( i > midIndex ) {
					rightWidth += itemWidth;
				} else {
					leftWidth += itemWidth;
				}
			}

			var diff = leftWidth - rightWidth;

			if ( rtl ) {
				if ( leftWidth > rightWidth ) {
					$navigation.find( '.menu > li:first-child' ).css( 'marginRight', - diff );
				} else {
					$navigation.find( '.menu > li:last-child' ).css( 'marginLeft', diff );
				}
			} else {
				if ( leftWidth > rightWidth ) {
					$navigation.find( '.menu > li:last-child' ).css( 'marginRight', diff );
				} else {
					$navigation.find( '.menu > li:first-child' ).css( 'marginLeft', - diff );
				}
			}

			$midItem.css( rule, logoWidth + 25 );
		};

		$logo.imagesLoaded( function() {
			recalc();
			$navigation.addClass( 'menu-calculated' );
		} );

		$( window ).on( 'resize', recalc );
	}

	amely.headerOverlap = function() {

		// Swap logo when hover overlap header
		if ( $( 'body' ).hasClass( 'header-overlap' ) ) {

			var $header = $( '.site-header:not(.sticky-header)' ),
				$logo   = $header.find( '.site-logo' ),
				$img    = $logo.find( 'img.logo-desktop' ),
				o_logo  = '',
				o_src   = '';

			if ( $img.length ) {
				o_logo = $img.attr( 'data-o_logo' );
				o_src = $img.attr( 'src' );
			}

			$header.on( 'mouseenter', function() {
				if ( o_logo ) {
					$img.attr( 'src', o_logo );
				}
			} ).on( 'mouseleave', function() {
				if ( o_src ) {
					$img.attr( 'src', o_src );
				}
			} );
		}
	};
})( jQuery );
