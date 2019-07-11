// Menu
(function( $ ) {

	var $window = $( window ),
		$body   = $( 'body' );

	amely.siteMenu = function() {

		var $siteHeader   = $( '.site-header:not(.sticky-header)' ),
			$stickyHeader = $( '.site-header.sticky-header' ),
			$siteMenu     = $siteHeader.find( '.site-menu' );

		if ( $stickyHeader.hasClass( 'is-sticky' ) ) {
			$siteMenu = $stickyHeader.find( '.site-menu' );
		}

		if ( ! $siteMenu.length || ! $siteMenu.find( 'ul.menu' ).length || $siteHeader.hasClass( 'header-vertical' ) ) {
			return;
		}

		$siteMenu.find( 'ul.menu' ).superfish( {
			delay       : 300,
			speed       : 300,
			speedOut    : 300,
			autoArrows  : false,
			dropShadows : false,
			onBeforeShow: function() {
				$( this ).removeClass( 'animated fast fadeOutDownSmall' );
				$( this ).addClass( 'animated fast fadeInUpSmall' );

				defaultMegaMenu( $( this ) );
			},
			onShow      : function() {
				megaMenuOffsets( $( this ) );
				normalMenuHoverBack( $( this ) );
			},
			onBeforeHide: function() {
				$( this ).removeClass( 'animated fast fadeInUpSmall' );
				$( this ).addClass( 'animated fast fadeOutDownSmall' );
			}
		} );

		$window.scroll( function() {
			if ( $stickyHeader.hasClass( 'is-sticky' ) ) {
				var $el = $stickyHeader.find( '.sfHover' );
				if ( $el.length && $el.is( ':hover' ) && $el.hasClass( 'mega-menu-default' ) ) {
					defaultMegaMenu( $el.find( '.sub-menu' ) );
				}
			}
		} );

		// find in cookie
		var findOffsetInCookies = function() {

			$siteMenu.find( '.menu-item' ).each( function() {

				var menu_item = $( this ).attr( 'class' ).match( /menu-item-\d+/g );

				if ( menu_item && menu_item.length == 1 ) {

					menu_item = menu_item[0];
					var css = Cookies.get( 'amely_' + menu_item );

					if ( css ) {
						if ( $( this ).hasClass( 'mega-menu' ) ) {
							$( this ).find( '.sub-menu' ).css( $.parseJSON( css ) );
						} else {
							if ( css == 'hover-back' ) {
								$( this ).addClass( 'has-hover-back' );
								$( this ).find( '.sub-menu' ).each( function() {
									$( this ).addClass( 'hover-back' );
								} );
							}
						}
					}
				}
			} );
		};

		// Calculate position for the mega menu
		var megaMenuOffsets = function( $el ) {

			if ( md.mobile() || md.phone() || md.tablet() || ! $el.length ) {
				return;
			}

			fullWidthMegaMenu( $el );
			customMegaMenu( $el );
		};

		var defaultMegaMenu = function( $el ) {

			if ( $body.hasClass( 'error404' ) ) {
				return;
			}

			if ( ! $el.length || ! $el.parent().hasClass( 'mega-menu-default' ) ) {
				return;
			}

			$siteMenu = $el.closest( '.site-menu' );

			var mainContainerRect = $body.hasClass( 'single-product' ) ? $( '.site-content > .product > .container' )[0].getBoundingClientRect() : $( '.main-container > .container' )[0]
					.getBoundingClientRect(),
				menuContainerRect = $siteMenu[0].getBoundingClientRect(),
				w                 = mainContainerRect.width - 30,
				left              = mainContainerRect.left - menuContainerRect.left + 15;

			if ( mainContainerRect.width > 1200 ) {
				w = 1170;
				left = (menuContainerRect.width - w) / 2;
			}

			if ( $siteHeader.hasClass( 'header-menu-left' ) ) {
				left = 0;
			}

			if ( $siteHeader.hasClass( 'header-menu-bottom' ) ) {
				left = menuContainerRect.width / 2 - w / 2;
			}

			var css = {
				'width': w + 'px',
				'left' : left + 'px'
			}

			$el.css( css );
		};

		// fullwidth mega menu
		var fullWidthMegaMenu = function( $el ) {

			if ( $body.hasClass( 'error404' ) ) {
				return;
			}

			if ( ! $el.length || ! $el.parent().hasClass( 'mega-menu-full-width' ) ) {
				return;
			}

			$siteMenu = $el.closest( '.site-menu' );

			var pageContainerRect = $( '#page-container' )[0].getBoundingClientRect(),
				left              = $siteMenu[0].getBoundingClientRect().left,
				w                 = window.innerWidth;

			if ( $body.hasClass( 'body-boxed' ) ) {
				left = pageContainerRect.left - left;
				w = pageContainerRect.width;
			} else {
				left = 0 - left;
			}

			var css = {
				'width': w + 'px',
				'left' : left + 'px',
			};

			$el.css( css );
		};

		var customMegaMenu = function( $el ) {

			var subMenuRect = $el[0].getBoundingClientRect();

			if ( ! $el.length || ! $el.parent().hasClass( 'mega-menu-custom' ) ) {
				return;
			}

			if ( isOutSide( $el ) ) {

				var pageContainerRect = $( '#page-container' )[0].getBoundingClientRect(),
					sub               = subMenuRect.right - pageContainerRect.right,
					left              = 0 - sub - 15,
					css               = { 'left': left + 'px' };

				$el.css( css );
				saveCSSToCookie( $el, css );
			}
		};

		var isOutSide = function( $el ) {

			if ( ! $el.length ) {
				return;
			}

			var subMenuRect   = $el[0].getBoundingClientRect(),
				screenWidth   = $window.width(),
				viewportWidth = $body.hasClass( 'body-boxed' ) ? $( '#page-container' )
					[0].getBoundingClientRect().right : screenWidth;

			return subMenuRect.right >= viewportWidth;
		};

		var hoverBack = function( $el ) {

			if ( isOutSide( $el ) ) {

				var cookieName = $el.parent().attr( 'class' ).match( /menu-item-\d+/g );

				if ( ! $el.hasClass( 'hover-back' ) ) {
					$el.parent().addClass( 'has-hover-back' );
					$el.addClass( 'hover-back' );

					$el.find( '.sub-menu' ).each( function( $item ) {
						$item.addClass( 'hover-back' );
					} );

					if ( cookieName && cookieName.length == 1 ) {
						cookieName = cookieName[0];

						Cookies.set( 'amely_' + cookieName, 'hover-back', {
							expires: 1,
							path   : '/'
						} )
					}
				} else {
					$el.parent().removeClass( 'has-hover-back' );
					$el.removeClass( 'hover-back' );
					$el.find( '.sub-menu' ).each( function( $item ) {
						$item.removeClass( 'hover-back' );
					} );

					if ( cookieName.length == 1 ) {
						cookieName = cookieName[0];

						Cookies.remove( 'amely_' + cookieName, {
							path: ''
						} );
					}
				}
			}
		};

		var normalMenuHoverBack = function( $el ) {

			if ( md.mobile() || md.phone() || md.tablet() || ! $el.length || $el.parent().hasClass( 'mega-menu' ) ) {
				return;
			}

			hoverBack( $el );
		};

		var saveCSSToCookie = function( $el, css ) {

			var cookieName = $el.parent().attr( 'class' ).match( /menu-item-\d+/g );

			if ( cookieName && cookieName.length == 1 ) {
				cookieName = cookieName[0];

				Cookies.set( 'amely_' + cookieName, css, {
					expires: 1,
					path   : '/'
				} )
			}
		};

		findOffsetInCookies();

		$window.on( 'resize', function() {

			$siteMenu.find( '.menu-item.mega-menu .sub-menu' ).each( function() {
				defaultMegaMenu( $( this ) );
				fullWidthMegaMenu( $( this ) );
			} );
		} );
	};

	amely.setTopValue = function( $el ) {

		var $adminBar = $( '#wpadminbar' ),
			w         = $window.width(),
			h         = $adminBar.height(),
			top       = h;

		if ( $adminBar.length ) {

			if ( $adminBar.css( 'position' ) == 'absolute' && w <= 600 ) {

				var t = $adminBar[0].getBoundingClientRect().top;

				// get the top value for mobile menu
				// t always negative or equal 0
				// E.g: t = -30px, h = 46px => top = 46 + (-30) = 46 - 30 = 13
				top = (
					t >= 0 - h
				) ? h + t : 0;

			}
		}

		if ( w >= 1200 ) {
			return;
		}

		$el.css( 'top', top );
	};

	amely.mobileMenu = function() {

		var $mobileBtn     = $( '.mobile-menu-btn' ),
			$mobileMenu    = $( '#site-mobile-menu' ),
			$mobileMenuClz = $( '.site-mobile-menu' ),
			$pageContainer = $( '#page-container' );

		var caculateRealHeight = function( $ul ) {

			var height = 0;

			$ul.find( '>li' ).each( function() {
				height += $( this ).outerHeight();
			} );

			return height;
		};

		var setUpOverflow = function( h1, h2 ) {

			if ( h1 < h2 ) {
				$mobileMenuClz.css( 'overflow-y', 'hidden' );
			} else {
				$mobileMenuClz.css( 'overflow-y', 'auto' );
			}
		};

		var buildSlideOut = function() {

			if ( typeof $mobileMenu !== 'undefined' && typeof $pageContainer !== 'undefined' ) {

				$body.on( 'click', '.mobile-menu-btn', function() {

					$( this ).toggleClass( 'is-active' );

					$body.toggleClass( 'mobile-menu-opened' );

					amely.setTopValue( $mobileMenuClz );

				} );

				// Close menu if click on the site
				$pageContainer.on( 'click touchstart', function( e ) {

					if ( ! $( e.target ).closest( '.mobile-menu-btn' ).length ) {

						if ( $body.hasClass( 'mobile-menu-opened' ) ) {

							$body.removeClass( 'mobile-menu-opened' );

							$mobileBtn.removeClass( 'is-active' );
							$mobileMenu.find( '#searchform input[type="text"]' ).blur();

							e.preventDefault();
						}

					}
				} );

				setUpOverflow( $mobileMenu.height(), $mobileMenuClz.height() );
			}
		};

		var buildDrillDown = function() {

			var level  = 0,
				opener = '<span class="open-child">open</span>',
				height = $mobileMenuClz.height();

			$mobileMenu.find( 'li:has(ul)' ).each( function() {

				var $this   = $( this ),
					allLink = $this.find( '> a' ).clone();

				if ( allLink.length ) {

					$this.prepend( opener );

					allLink.find( '.menu-item-tag' ).remove();

					$this.find( '> ul' )
						 .prepend( '<li class="menu-back">' + allLink.wrap( '<div>' )
																	 .parent()
																	 .html() + '</a></li>' );
				}
			} );

			$mobileMenu.on( 'click', '.open-child', function() {

				var $parent = $( this ).parent();

				if ( $parent.hasClass( 'over' ) ) {

					$parent.removeClass( 'over' );

					level --;

					if ( level == 0 ) {
						setUpOverflow( $mobileMenu.height(), height );
					}
				} else {

					$parent.parent().find( '>li.over' ).removeClass( 'over' );
					$parent.addClass( 'over' );

					level ++;

					setUpOverflow( caculateRealHeight( $parent.find( '>.sub-menu' ) ), height );
				}

				$mobileMenu.parent().scrollTop( 0 );
			} );

			$mobileMenu.on( 'click', '.menu-back', function() {

				var $grand = $( this ).parent().parent();

				if ( $grand.hasClass( 'over' ) ) {

					$grand.removeClass( 'over' );

					level --;

					if ( level == 0 ) {
						setUpOverflow( $mobileMenu.height(), height );
					}
				}

				$mobileMenu.parent().scrollTop( 0 );

			} );
		};

		buildSlideOut();
		buildDrillDown();

		// re-calculate the top value of mobile menu when resize
		$window.on( 'resize', function() {
			amely.setTopValue( $mobileMenuClz );
		} );
	};

	amely.menuVertical = function() {
		var $menu = $( '#menu-full-screen-menu' );

		$menu.on( 'click', '.menu-item-has-children > a', function( e ) {
			e.preventDefault();
			e.stopPropagation();

			var $_li = $( this ).parent( 'li' );

			if ( $_li.hasClass( 'opened' ) ) {
				$_li.removeClass( 'opened' );
				$_li.find( '.opened' ).removeClass( 'opened' );
				$_li.find( '.sub-menu' ).stop().slideUp();
			} else {
				var $_parent = $_li.parent( 'ul' );

				// If level 1 clicked, slide up other items.
				if ( ! $_parent.hasClass( 'sub-menu' ) ) {
					var $li_opened = $_li.siblings( '.opened' );
					$li_opened.removeClass( 'opened' );
					$li_opened.find( '.opened' ).removeClass( 'opened' );
					$li_opened.find( '.sub-menu' ).stop().slideUp();
				}

				$_li.addClass( 'opened' );
				$_li.children( '.sub-menu' ).stop().slideDown();
			}

		} );
	}

})( jQuery );
