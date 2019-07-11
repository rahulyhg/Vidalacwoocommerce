/**
 * Script for our theme
 * Written By: ThemeMove
 */
'use strict';

var amely;
var md = new MobileDetect( window.navigator.userAgent ); // Mobile Detect

(
	function() {

		amely = (

			function() {

				return {

					init: function() {

						this.closeTopBar();

						this.offcanvas();

						this.backToTop();

						this.stickyHeader();

						this.splitNavHeader();

						this.headerOverlap();

						this.blog();

						this.switcher();

						this.siteMenu();

						this.mobileMenu();

						this.search();

						this.wishlist();

						this.miniCart();

						this.shop();

						this.quickView();

						this.notification();

						this.compare();

						this.ajaxAddToCart();

						this.ajaxLoadMore();

						this.product();

						this.crossSells();

						this.swatches();

						this.quantityField();

						this.imageCarousel();

						this.testimonialCarousel();

						this.instagramCarousel();

						this.countdown();

						this.productCategoriesShortcode();

						this.productsShortCode();

						this.vcTabs();

						this.vcRow();

						this.vcColumn();

						this.bannerGrid5();

						this.bannerGrid6();

						this.bannerGrid6v2();

						this.cookie();

						this.brand();

						this.videoPopup();

						this.instagram();

						this.mailchimpSubscribe();

						this.menuVertical();

					}
				}
			}()
		);
	}
)( jQuery );

jQuery( document ).ready( function() {
	amely.init();
} );

/**
 * https://tympanus.net/Development/GridLoadingAnimations
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2017, Codrops
 * http://www.codrops.com
 */
;(
	function( window ) {

		/**
		 * GridLoaderFx obj.
		 */
		function GridLoaderFx( el, itemClass, callback ) {
			this.el = el;
			this.items = this.el.querySelectorAll( itemClass );
		}

		/**
		 * Effects.
		 */
		GridLoaderFx.prototype.effects = {
			'Hapi'  : {
				animeOpts: {
					duration: function( t, i ) {
						return 600 + i * 75;
					},
					easing  : 'easeOutExpo',
					delay   : function( t, i ) {
						return i * 50;
					},
					opacity : {
						value : [0, 1],
						easing: 'linear'
					},
					scale   : [0, 1]
				}
			},
			'Amun'  : {
				// Sort target elements function.
				sortTargetsFn: function( a, b ) {
					var aBounds = a.getBoundingClientRect(),
						bBounds = b.getBoundingClientRect();

					return (
							   aBounds.left - bBounds.left
						   ) || (
							   aBounds.top - bBounds.top
						   );
				},
				animeOpts    : {
					duration  : function( t, i ) {
						return 500 + i * 50;
					},
					easing    : 'easeOutExpo',
					delay     : function( t, i ) {
						return i * 20;
					},
					opacity   : {
						value   : [0, 1],
						duration: function( t, i ) {
							return 250 + i * 50;
						},
						easing  : 'linear'
					},
					translateY: [400, 0]
				}
			},
			'Kek'   : {
				sortTargetsFn: function( a, b ) {
					return b.getBoundingClientRect().left - a.getBoundingClientRect().left;
				},
				animeOpts    : {
					duration  : 800,
					easing    : [0.1, 1, 0.3, 1],
					delay     : function( t, i ) {
						return i * 20;
					},
					opacity   : {
						value   : [0, 1],
						duration: 600,
						easing  : 'linear'
					},
					translateX: [- 500, 0],
					rotateZ   : [15, 0]
				}
			},
			'Isis'  : {
				animeOpts: {
					duration  : 900,
					elasticity: 500,
					delay     : function( t, i ) {
						return i * 15;
					},
					opacity   : {
						value   : [0, 1],
						duration: 300,
						easing  : 'linear'
					},
					translateX: function() {
						return [anime.random( 0, 1 ) === 0 ? 100 : - 100, 0];
					},
					translateY: function() {
						return [anime.random( 0, 1 ) === 0 ? 100 : - 100, 0];
					}
				}
			},
			'Montu' : {
				perspective: 800,
				origin     : '50% 0%',
				animeOpts  : {
					duration  : 1500,
					elasticity: 400,
					delay     : function( t, i ) {
						return i * 75;
					},
					opacity   : {
						value   : [0, 1],
						duration: 1000,
						easing  : 'linear'
					},
					rotateX   : [- 90, 0]
				}
			},
			'Osiris': {
				perspective: 3000,
				animeOpts  : {
					duration  : function() {
						return anime.random( 500, 1000 )
					},
					easing    : [0.2, 1, 0.3, 1],
					delay     : function( t, i ) {
						return i * 50;
					},
					opacity   : {
						value   : [0, 1],
						duration: 700,
						easing  : 'linear'
					},
					translateZ: {
						value   : [- 3000, 0],
						duration: 1000
					},
					rotateY   : ['-1turns', 0]
				}
			},
			'Satet' : {
				animeOpts: {
					duration  : 800,
					elasticity: 600,
					delay     : function( t, i ) {
						return i * 100;
					},
					opacity   : {
						value   : [0, 1],
						duration: 600,
						easing  : 'linear'
					},
					scaleX    : {
						value: [0.4, 1]
					},
					scaleY    : {
						value   : [0.6, 1],
						duration: 1000
					}
				}
			},
			'Atum'  : {
				sortTargetsFn: function( a, b ) {
					var docScrolls = { top: document.body.scrollTop + document.documentElement.scrollTop },
						y1         = window.innerHeight + docScrolls.top,
						aBounds    = a.getBoundingClientRect(),
						ay1        = aBounds.top + docScrolls.top + aBounds.height / 2,
						bBounds    = b.getBoundingClientRect(),
						by1        = bBounds.top + docScrolls.top + bBounds.height / 2;

					return Math.abs( y1 - ay1 ) - Math.abs( y1 - by1 );
				},
				perspective  : 1000,
				origin       : '50% 0%',
				animeOpts    : {
					duration  : 800,
					easing    : [0.1, 1, 0.3, 1],
					delay     : function( t, i ) {
						return i * 35;
					},
					opacity   : {
						value   : [0, 1],
						duration: 600,
						easing  : 'linear'
					},
					translateX: [100, 0],
					translateY: [- 100, 0],
					translateZ: [400, 0],
					rotateZ   : [10, 0],
					rotateX   : [75, 0]
				}
			},
			'Ra'    : {
				origin   : '50% 0%',
				animeOpts: {
					duration  : 500,
					easing    : 'easeOutBack',
					delay     : function( t, i ) {
						return i * 100;
					},
					opacity   : {
						value : [0, 1],
						easing: 'linear'
					},
					translateY: [400, 0],
					scaleY    : [{
						value   : [3, 0.6],
						delay   : function( t, i ) {
							return i * 100 + 120;
						},
						duration: 300,
						easing  : 'easeOutExpo'
					}, {
						value   : [0.6, 1],
						duration: 1400,
						easing  : 'easeOutElastic'
					}],
					scaleX    : [{
						value   : [0.9, 1.05],
						delay   : function( t, i ) {
							return i * 100 + 120;
						},
						duration: 300,
						easing  : 'easeOutExpo'
					}, {
						value   : [1.05, 1],
						duration: 1400,
						easing  : 'easeOutElastic'
					}]
				}
			},
			'Sobek' : {
				animeOpts: {
					duration  : 600,
					easing    : 'easeOutExpo',
					delay     : function( t, i ) {
						return i * 100;
					},
					opacity   : {
						value   : [0, 1],
						duration: 100,
						easing  : 'linear'
					},
					translateX: function( t, i ) {
						var docScrolls = { left: document.body.scrollLeft + document.documentElement.scrollLeft },
							x1         = window.innerWidth / 2 + docScrolls.left,
							tBounds    = t.getBoundingClientRect(),
							x2         = tBounds.left + docScrolls.left + tBounds.width / 2;

						return [x1 - x2, 0];
					},
					translateY: function( t, i ) {
						var docScrolls = { top: document.body.scrollTop + document.documentElement.scrollTop },
							y1         = window.innerHeight + docScrolls.top,
							tBounds    = t.getBoundingClientRect(),
							y2         = tBounds.top + docScrolls.top + tBounds.height / 2;

						return [y1 - y2, 0];
					},
					rotate    : function( t, i ) {
						var x1      = window.innerWidth / 2,
							tBounds = t.getBoundingClientRect(),
							x2      = tBounds.left + tBounds.width / 2;

						return [x2 < x1 ? 90 : - 90, 0];
					},
					scale     : [0, 1]
				}
			},
			'Ptah'  : {
				itemOverflowHidden: true,
				sortTargetsFn     : function( a, b ) {
					return b.getBoundingClientRect().left - a.getBoundingClientRect().left;
				},
				origin            : '100% 0%',
				animeOpts         : {
					duration: 500,
					easing  : 'easeOutExpo',
					delay   : function( t, i ) {
						return i * 20;
					},
					opacity : {
						value   : [0, 1],
						duration: 400,
						easing  : 'linear'
					},
					rotateZ : [45, 0]
				}
			},
			'Bes'   : {
				revealer         : true,
				revealerOrigin   : '100% 50%',
				animeRevealerOpts: {
					duration: 800,
					delay   : function( t, i ) {
						return i * 75;
					},
					easing  : 'easeInOutQuart',
					scaleX  : [1, 0]
				},
				animeOpts        : {
					duration: 800,
					easing  : 'easeInOutQuart',
					delay   : function( t, i ) {
						return i * 75;
					},
					opacity : {
						value : [0, 1],
						easing: 'linear'
					},
					scale   : [0.8, 1]
				}
			},
			'Seker' : {
				revealer         : true,
				revealerOrigin   : '50% 100%',
				animeRevealerOpts: {
					duration  : 500,
					delay     : function( t, i ) {
						return i * 50;
					},
					easing    : [0.7, 0, 0.3, 1],
					translateY: [100, 0],
					scaleY    : [1, 0]
				},
				animeOpts        : {
					duration  : 500,
					easing    : [0.7, 0, 0.3, 1],
					delay     : function( t, i ) {
						return i * 50;
					},
					opacity   : {
						value   : [0, 1],
						duration: 400,
						easing  : 'linear'
					},
					translateY: [100, 0],
					scale     : [0.8, 1]
				}
			},
			'Nut'   : {
				revealer          : true,
				revealerColor     : '#ffffff',
				itemOverflowHidden: true,
				animeRevealerOpts : {
					easing    : 'easeOutCubic',
					delay     : function( t, i ) {
						return i * 100;
					},
					translateX: [{
						value   : ['101%', '0%'],
						duration: 400
					}, {
						value   : ['0%', '-101%'],
						duration: 400
					}]
				},
				animeOpts         : {
					duration: 900,
					easing  : 'easeOutCubic',
					delay   : function( t, i ) {
						return 400 + i * 100;
					},
					opacity : {
						value   : 1,
						duration: 1,
						easing  : 'linear'
					},
					scale   : [0.8, 1]
				}
			},
			'Shu'   : {
				lineDrawing         : true,
				animeLineDrawingOpts: {
					duration        : 800,
					delay           : function( t, i ) {
						return i * 150;
					},
					easing          : 'easeInOutSine',
					strokeDashoffset: [anime.setDashoffset, 0],
					opacity         : [{ value: [0, 1] }, {
						value   : [1, 0],
						duration: 200,
						easing  : 'linear',
						delay   : 500
					}]
				},
				animeOpts           : {
					duration: 800,
					easing  : [0.2, 1, 0.3, 1],
					delay   : function( t, i ) {
						return i * 150 + 800;
					},
					opacity : {
						value : [0, 1],
						easing: 'linear'
					},
					scale   : [0.5, 1]
				}
			}
		};

		GridLoaderFx.prototype._render = function( effect, callback ) {
			// Reset styles.
			this._resetStyles();

			var effectSettings = this.effects[effect],
				animeOpts      = effectSettings.animeOpts

			if ( effectSettings.perspective != undefined ) {
				[].slice.call( this.items ).forEach( function( item ) {
					item.style.WebkitPerspective = item.style.perspective = effectSettings.perspective + 'px';
				} );
			}

			if ( effectSettings.origin != undefined ) {
				[].slice.call( this.items ).forEach( function( item ) {
					item.style.WebkitTransformOrigin = item.style.transformOrigin = effectSettings.origin;
				} );
			}

			if ( effectSettings.lineDrawing != undefined ) {
				[].slice.call( this.items ).forEach( function( item ) {
					// Create SVG.
					var svg   = document.createElementNS( 'http://www.w3.org/2000/svg', 'svg' ),
						path  = document.createElementNS( 'http://www.w3.org/2000/svg', 'path' ),
						itemW = item.offsetWidth,
						itemH = item.offsetHeight;

					svg.setAttribute( 'width', itemW + 'px' );
					svg.setAttribute( 'height', itemH + 'px' );
					svg.setAttribute( 'viewBox', '0 0 ' + itemW + ' ' + itemH );
					svg.setAttribute( 'class', 'grid__deco' );
					path.setAttribute( 'd', 'M0,0 l' + itemW + ',0 0,' + itemH + ' -' + itemW + ',0 0,-' + itemH );
					path.setAttribute( 'stroke-dashoffset', anime.setDashoffset( path ) );
					svg.appendChild( path );
					item.appendChild( svg );
				} );

				var animeLineDrawingOpts = effectSettings.animeLineDrawingOpts;
				animeLineDrawingOpts.targets = this.el.querySelectorAll( '.grid__deco > path' );
				anime.remove( animeLineDrawingOpts.targets );
				anime( animeLineDrawingOpts );
			}

			if ( effectSettings.revealer != undefined ) {
				[].slice.call( this.items ).forEach( function( item ) {
					var revealer = document.createElement( 'div' );
					revealer.className = 'grid__reveal';
					if ( effectSettings.revealerOrigin != undefined ) {
						revealer.style.transformOrigin = effectSettings.revealerOrigin;
					}
					if ( effectSettings.revealerColor != undefined ) {
						revealer.style.backgroundColor = effectSettings.revealerColor;
					}
					item.appendChild( revealer );
				} );

				var animeRevealerOpts = effectSettings.animeRevealerOpts;
				animeRevealerOpts.targets = this.el.querySelectorAll( '.grid__reveal' );
				animeRevealerOpts.begin = function( obj ) {
					for ( var i = 0, len = obj.animatables.length; i < len; ++ i ) {
						obj.animatables[i].target.style.opacity = 1;
					}
				};
				anime.remove( animeRevealerOpts.targets );
				anime( animeRevealerOpts );
			}

			if ( effectSettings.itemOverflowHidden ) {
				[].slice.call( this.items ).forEach( function( item ) {
					item.style.overflow = 'hidden';
				} );
			}

			animeOpts.targets =
				effectSettings.sortTargetsFn && typeof effectSettings.sortTargetsFn === 'function' ? [].slice.call( this.items )
																									   .sort( effectSettings.sortTargetsFn ) : this.items;
			if ( typeof callback !== 'undefined' ) {
				animeOpts.complete = callback;
			}

			anime.remove( animeOpts.targets );
			anime( animeOpts );
		};

		GridLoaderFx.prototype._resetStyles = function() {
			this.el.style.WebkitPerspective = this.el.style.perspective = 'none';
			[].slice.call( this.items ).forEach( function( item ) {
				var gItem = item;
				item.style.opacity = 0;
				item.style.WebkitTransformOrigin = item.style.transformOrigin = '50% 50%';
				item.style.transform = 'none';

				var svg = item.querySelector( 'svg.grid__deco' );
				if ( svg ) {
					gItem.removeChild( svg );
				}

				var revealer = item.querySelector( '.grid__reveal' );
				if ( revealer ) {
					gItem.removeChild( revealer );
				}

				gItem.style.overflow = '';
			} );
		};

		window.GridLoaderFx = GridLoaderFx;
	}
)( window );

/**
 * $.parseParams - parse query string paramaters into an object.
 */
!function(n){var r=/([^&=]+)=?([^&]*)/g,e=/\+/g,t=function(n){return decodeURIComponent(n.replace(e," "))};n.parseParams=function(n){for(var e,u={};e=r.exec(n);){var a=t(e[1]),o=t(e[2]);"[]"===a.substring(a.length-2)?(a=a.substring(0,a.length-2),(u[a]||(u[a]=[])).push(o)):u[a]=o}return u}}(jQuery);

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

// language & currency switchers
(
	function( $ ) {

		amely.switcher = function() {

			var $body                  = $( 'body' ),
				$languageSwitcher      = $( '.language-switcher select' ),
				$currencySwitcher      = $( '.currency-switcher select' ),
				$WOOCSCurrencySwitcher = $( '.currency-switcher.woocs-switcher' ),
				$WPMLCurrencySwitcher  = $( '.currency-switcher.wcml-switcher' );

			var loadCurrency = function( currency ) {
				$.ajax( {
					type   : 'post',
					url    : amelyConfigs.ajax_url,
					data   : {
						action  : 'wcml_switch_currency',
						currency: currency,
					},
					success: function() {
						window.location = window.location.href;
					},
					error  : function( error ) {
						console.log( error );
					},
				} );
			};

			var WOOCSSwitcher = function() {

				// WooCommerce Currency Switcher plugin
				$( '.option', $WOOCSCurrencySwitcher ).on( 'click', function() {

					$WPMLCurrencySwitcher.addClass( 'loading' );

					var $this = $( this );

					$( '.currency-switcher' ).addClass( 'loading' );

					setTimeout( function() {
						window.location = $this.attr( 'data-value' );
					}, 500 );
				} );
			};

			var wooWPMLSwitcher = function() {

				// WooCommerce WPML Multilingual plugin
				$( '.option', $WPMLCurrencySwitcher ).on( 'click', function() {

					$WPMLCurrencySwitcher.addClass( 'loading' );

					var currency = $( this ).find( '.option' ).attr( 'data-value' );

					loadCurrency( currency );
				} );
			};

			// Language switcher
			$languageSwitcher.each( function() {

				var $this = $( this );

				if ( $( 'option', $this ).length ) {

					$this.niceSelect();

					var $niceSelect = $this.parent().find( '.nice-select' ),
						imgSrc      = $this.find( ':selected' ).attr( 'data-imagesrc' );

					// Add flag image to .current
					if ( typeof imgSrc != 'undefined' ) {
						$niceSelect.find( 'span.current' ).prepend( '<img src="' + imgSrc + '" alt="" />' );
					}

					// Add flag image to option
					$this.find( 'option' ).each( function() {

						imgSrc = $( this ).attr( 'data-imagesrc' );
						var index = $( this ).index();

						if ( typeof imgSrc != 'undefined' ) {
							$niceSelect.find( '.option' )
									   .eq( index )
									   .prepend( '<img src="' + imgSrc + '" alt="" />' );
						}
					} );

					$body.on( 'click', '.language-switcher .nice-select .option', function() {

						var $this = $( this );

						$( '.language-switcher' ).addClass( 'loading' );

						setTimeout( function() {
							window.location = $this.attr( 'data-value' );
						}, 500 );

					} );
				}
			} );

			// Currency switcher
			if ( $( 'option', $currencySwitcher ).length ) {

				$currencySwitcher.niceSelect();

				WOOCSSwitcher();

				wooWPMLSwitcher();
			}
		};
	}
)( jQuery );

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

// Visual Composer shortcode
(function( $ ) {

	var $window   = $( window ),
		$document = $( document ),
		body      = document.body;

	amely.imageCarousel = function() {

		$( '.amely-image-carousel' ).each( function() {

			var $this = $( this ),
				atts  = JSON.parse( $this.attr( 'data-atts' ) );

			if ( atts == null ) {
				return;
			}

			if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
				atts.auto_play_speed = 5;
			}

			var configs = {
				accessibility : false,
				slidesToShow  : parseInt( atts.number_of_images_to_show ),
				slidesToScroll: parseInt( atts.number_of_images_to_show ),
				infinite      : (
					atts.loop == 'yes'
				),
				autoplay      : (
					atts.auto_play == 'yes'
				),
				autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
				adaptiveHeight: true,
				speed         : 1000,
				responsive    : [{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2,
					},
				}, {
					breakpoint: 544,
					settings  : {
						arrows        : true,
						dots          : false,
						adaptiveHeight: true,
						slidesToShow  : 1,
						slidesToScroll: 1,
					},
				},],
			};

			if ( ! atts.nav_type ) {
				configs.arrows = false;
				configs.dots = false;
			} else {
				if ( atts.nav_type == 'dots' ) {
					configs.arrows = false;
					configs.dots = true;
				}
				if ( atts.nav_type == 'both' ) {
					configs.arrows = true;
					configs.dots = true;
				}
			}

			if ( parseInt( atts.number_of_images_to_show ) == 1 ) {
				configs['responsive'] = [{
					breakpoint: 992,
					settings  : {
						adaptiveHeight: true,
						slidesToShow  : 1,
						slidesToScroll: 1,
					},
				}, {
					breakpoint: 544,
					settings  : {
						arrows        : true,
						dots          : false,
						adaptiveHeight: true,
						slidesToShow  : 1,
						slidesToScroll: 1,
					},
				},];
			}

			$this.slick( configs );
			$this.slick( 'setPosition' );

			if ( ! $this.hasClass( 'custom_link' ) ) {

				$( '.tm-carousel-item:not(.slick-cloned)' ).magnificPopup( {
					type        : 'image',
					delegate    : 'a',
					removalDelay: 300,
					mainClass   : 'mfp-fade',
					gallery     : {
						enabled: true,
					},
				} );
			}
		} );
	};

	amely.testimonialCarousel = function() {

		$( '.amely-testimonial-carousel' ).each( function() {

			var $this = $( this ),
				atts  = JSON.parse( $this.attr( 'data-atts' ) );

			if ( atts == null ) {
				return;
			}

			if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
				atts.auto_play_speed = 5;
			}

			var configs = {
				accessibility : false,
				infinite      : (atts.loop == 'yes'),
				autoplay      : (atts.auto_play == 'yes'),
				autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
				slidesToShow  : parseInt( atts.items_to_show ),
				slidesToScroll: 1,
				speed         : 1000,
				responsive    : [{
					breakpoint: 768,
					settings  : {
						slidesToShow: 1,
					},
				},],
			};

			if ( ! atts.nav_type ) {
				configs.arrows = false;
				configs.dots = false;
			} else {
				if ( atts.nav_type == 'dots' ) {
					configs.arrows = false;
					configs.dots = true;
				}
				if ( atts.nav_type == 'both' ) {
					configs.arrows = true;
					configs.dots = true;
				}
			}

			$this.slick( configs );
		} );
	};

	amely.instagramCarousel = function() {

		var carousels = [].slice.call( document.querySelectorAll( '.amely-instagram--carousel' ) );

		carousels.forEach( function( carousel ) {

			var atts = JSON.parse( carousel.getAttribute( 'data-atts' ) );

			if ( atts == null ) {
				return;
			}

			if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
				atts.auto_play_speed = 5;
			}

			var configs = {
				accessibility : false,
				infinite      : ( atts.loop == 'yes'),
				autoplay      : ( atts.auto_play == 'yes'),
				autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
				slidesToShow  : parseInt( atts.number_of_items_to_show ),
				slidesToScroll: parseInt( atts.number_of_items_to_show ),
				speed         : 1000,
				responsive    : [{
					breakpoint: 768,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2
					},
				}, {
					breakpoint: 425,
					settings  : {
						slidesToShow  : 1,
						slidesToScroll: 1
					},
				},],
			}

			if ( ! atts.nav_type ) {
				configs.arrows = false;
				configs.dots = false;
			} else {
				if ( atts.nav_type == 'dots' ) {
					configs.arrows = false;
					configs.dots = true;
				}
				if ( atts.nav_type == 'both' ) {
					configs.arrows = true;
					configs.dots = true;
				}
			}

			$( carousel.querySelectorAll( '.tm-instagram-pics' ) ).slick( configs );

		} );
	};

	amely.countdown = function() {

		var equalWidthForCountdown = function() {

			if ( ! md.mobile() && ! md.phone() && ! md.tablet() ) {
				$( '.tm-countdown, .product-countdown' ).each( function() {

					var max_width = 0;

					$( this ).find( '.countdown-section' ).each( function() {

						var width = $( this ).outerWidth();

						if ( width > max_width ) {
							max_width = width;
						}
					} );

					$( this ).find( '.countdown-section' ).css( 'width', max_width );
				} );
			}
		};

		$( '.amely-countdown' ).each( function() {
			var $this         = $( this ),
				format        = $this.attr( 'data-countdown-format' ),
				text_singular = $this.attr( 'data-label-singular' ).split( ',' ),
				text_plural   = $this.attr( 'data-label-plural' ).split( ',' ),
				date          = new Date( $this.text().trim() ),
				server_date   = new Date( $this.attr( 'data-server-date' ) );

			if ( $this.is( '.user-timezone' ) ) {
				$this.countdown( {
					labels : text_plural,
					labels1: text_singular,
					format : format,
					until  : date,
					onTick : function() {
						equalWidthForCountdown();
					},
				} );
			} else {
				$this.countdown( {
					labels    : text_plural,
					labels1   : text_singular,
					format    : format,
					until     : date,
					serverSync: server_date,
					onTick    : function() {
						equalWidthForCountdown();
					},
				} );
			}

		} );
	};

	amely.productCategoriesShortcode = function() {

		// Carousel
		$( '.amely-product-categories.categories-layout-carousel' ).each( function() {

			var $this  = $( this ),
				atts   = JSON.parse( $this.attr( 'data-atts' ) ),
				number = parseInt( atts.number_of_items_to_show );

			if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
				atts.auto_play_speed = 5000;
			}

			var configs = {
				accessibility : false,
				slidesToShow  : number,
				infinite      : atts.loop == 'yes',
				autoplay      : atts.auto_play == 'yes',
				autoplaySpeed : parseInt( atts.auto_play_speed ),
				centerMode    : atts.center_mode == 'yes',
				centerPadding : atts.center_padding,
				adaptiveHeight: true,
				speed         : 1000,
				responsive    : [{
					breakpoint: 1199,
					settings  : {
						centerPadding: '100px',
					},
				}, {
					breakpoint: 992,
					settings  : {
						slidesToShow  : number - 1,
						slidesToScroll: number,
						centerPadding : '80px',
					},
				}, {
					breakpoint: 768,
					settings  : {
						slidesToShow  : (
							number > 2
						) ? number - 2 : 2,
						slidesToScroll: 1,
						centerPadding : '50px',
					},
				}, {
					breakpoint: 479,
					settings  : {
						adaptiveHeight: true,
						arrows        : true,
						dots          : false,
						slidesToShow  : 1,
						centerPadding : '0px',
					},
				},],
			};

			if ( ! atts.nav_type ) {
				configs.arrows = false;
				configs.dots = false;
			} else {
				if ( atts.nav_type == 'dots' ) {
					configs.arrows = false;
					configs.dots = true;
				}
				if ( atts.nav_type == 'both' ) {
					configs.arrows = true;
					configs.dots = true;
				}
			}

			$this.slick( configs );
			$this.slick( 'setPosition' );

		} );

		// Masonry
		if ( typeof(
				$.fn.isotope
			) == 'undefined' || typeof (
				$.fn.imagesLoaded
			) == 'undefined' ) {
			return;
		}

		// Categories masonry
		var $catsContainer = $( '.amely-product-categories.categories-layout-masonry' );

		$catsContainer.isotope( {
			masonry     : {
				columnWidth: '.col-xl-3.category-grid-item',
			},
			itemSelector: '.category-grid-item',
		} ).imagesLoaded().progress( function() {
			$catsContainer.isotope( 'layout' );
		} )
	};

	// Product Visual Composer Shortcode (Products Grid & Products Carousel)
	amely.productsShortCode = function() {

		var productGrid = function() {

			if ( typeof($.fn.isotope) == 'undefined' || typeof($.fn.imagesLoaded) == 'undefined' ) {
				return;
			}

			$( '.amely-product-grid' ).each( function() {

				var $this     = $( this ),
					$products = $this.find( '.products' ),
					atts      = JSON.parse( $this.attr( 'data-atts' ) );

				if ( atts == null ) {
					return;
				}

				$products.isotope( {
					layoutMode  : 'fitRows',
					itemSelector: '.product'
				} );

				$products.imagesLoaded().progress( function() {
					$products.isotope('layout');
				});
			} );
		};

		var productTabs = function() {

			if ( typeof($.fn.isotope) == 'undefined' || typeof($.fn.imagesLoaded) == 'undefined' ) {
				return;
			}

			$( '.amely-product-tabs' ).each( function() {

				var $this     = $( this ),
					$products = $this.find( '.products' ),
					atts      = JSON.parse( $this.attr( 'data-atts' ) );

				if ( atts == null ) {
					return;
				}

				$products.isotope( {
					layoutMode        : 'fitRows',
					itemSelector      : '.product',
					hiddenStyle       : {
						opacity: 0
					},
					visibleStyle      : {
						opacity: 1
					},
					transitionDuration: '0.5s'
				} );

				$products.imagesLoaded().progress( function() {
					$products.isotope('layout');
				});
			} );

			$( '.amely-product-tabs' ).on( 'click', '.product-filter a', function( e ) {

				e.preventDefault();

				var t = $(this);
				var r = t.data('category');
				var u = t.parents('.amely-product-tabs');
				u.find('.amely-loadmore-wrap').attr('data-filter',r);
				u.find('.amely-loadmore-wrap').removeClass('hidden');

				var $link           = $( this ),
					$grid           = $link.closest( '.amely-product-tabs' ),
					$products       = $grid.find( '.products' ),
					filterValue     = $link.attr( 'data-filter' ),
					prependProducts = function( $newProducts ) {

						var iso = $products.data( 'isotope' );

						$products.prepend( $newProducts );

						$products.imagesLoaded( function() {

							var $items = $products.find( '.adding-item' ),
								gridFx = new GridLoaderFx( $products[0], '.adding-item' );

							if ( iso != null ) {
								$products.isotope( 'prepended', $items );
							}

							gridFx._render( 'Amun' );
							$items.removeClass( 'adding-item' );
						} );
					};

				if ( $link.hasClass( 'active' ) ) {
					return false;
				}

				var $ul            = $link.closest( '.product-filter' ),
					oldFilterValue = $ul.find( '.active' ).attr( 'data-filter' );

				$ul.find( '.active' ).removeClass( 'active' );
				$link.addClass( 'active' );

				if ( $grid.hasClass( 'filter-type-filter' ) ) {

					$link.closest( '.amely-product-tabs' )
						 .find( '.products' )
						 .isotope( { filter: filterValue } );
				} else {

					filterValue = filterValue.replace( /\./g, '' );
					filterValue = filterValue.replace( /product_cat-/g, '' );

					oldFilterValue = oldFilterValue.replace( /\./g, '' );
					oldFilterValue = oldFilterValue.replace( /product_cat-/g, '' );

					var oldItem = $grid.attr( 'id' ) + '_' + oldFilterValue,
						cache   = sessionStorage.getItem( $grid.attr( 'id' ) + '_' + filterValue );

					// cache old content
					if ( ! sessionStorage.getItem( oldItem ) ) {
						$products.children( '.product' ).addClass( 'adding-item' );
						sessionStorage.setItem( oldItem, $products.html() );
					}

					// page ajax loading
					var atts_btn = JSON.parse( u.find('.amely-loadmore-wrap').attr( 'data-atts' ) );
					var next_page = $link.attr( 'data-page' );
					atts_btn.paged = next_page;
					atts_btn = JSON.stringify(atts_btn);
					u.find('.amely-loadmore-wrap').attr( 'data-atts', atts_btn );

					var atts = JSON.parse( $grid.attr( 'data-atts' ) );

					if ( atts == null ) {
						return;
					}

					var data = {
						action        : 'amely_ajax_load_more',
						post_type     : 'product',
						posts_per_page: atts.number*next_page,
						columns       : atts.columns,
						data_source   : atts.data_source,
					};

					if ( atts.filter == 'category' ) {
						data.category = filterValue;
						data.include_children = atts.include_children == 'yes';
					}

					if ( atts.filter == 'group' ) {
						data.data_source = filterValue;
					}

					$.ajax( {
						method    : 'POST',
						url       : amelyConfigs.ajax_url,
						data      : data,
						cache     : true,
						beforeSend: function() {
							$products.addClass( 'loading' );
						},
						success   : function( response ) {
							if ( response ) {

								$products.children( '.product' ).remove();

								// add to grid
								prependProducts( $( response ) );
							}

							$products.removeClass( 'loading' );
						},
						error     : function( error ) {
							console.log( error );
						}
					} );
				}
			} );
		};

		var productCarousel = function() {

			$( '.amely-product-carousel' ).each( function() {

				var $this = $( this ),
					atts  = JSON.parse( $this.attr( 'data-atts' ) );

				if ( atts == null ) {
					return;
				}

				if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
					atts.auto_play_speed = 5;
				}

				var configs = {
					accessibility : false,
					slidesToShow  : parseInt( atts.columns ),
					slidesToScroll: parseInt( atts.columns ),
					speed         : 1000,
					infinite      : (
						atts.loop === 'yes'
					),
					autoplay      : (
						atts.auto_play === 'yes'
					),
					autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
					responsive    : [{
						breakpoint: 992,
						settings  : {
							slidesToShow  : 3,
							slidesToScroll: 3,
						},
					}, {
						breakpoint: 768,
						settings  : {
							slidesToShow  : 2,
							slidesToScroll: 2,
						},
					}, {
						breakpoint: 425,
						settings  : {
							adaptiveHeight: true,
							arrows        : true,
							dots          : false,
							centerMode    : true,
							centerPadding : '50px',
							slidesToShow  : 1,
							slidesToScroll: 1,
						},
					}, {
						breakpoint: 375,
						settings  : {
							adaptiveHeight: true,
							arrows        : true,
							dots          : false,
							centerMode    : true,
							centerPadding : '30px',
							slidesToShow  : 1,
							slidesToScroll: 1,
						},
					},],
				};

				if ( ! atts.nav_type ) {
					configs.arrows = false;
					configs.dots = false;
				} else {
					if ( atts.nav_type == 'dots' ) {
						configs.arrows = false;
						configs.dots = true;
					}
					if ( atts.nav_type == 'both' ) {
						configs.arrows = true;
						configs.dots = true;
					}
				}

				$this.find( '.products' ).slick( configs );

			} );
		};

		var productWidget = function() {

			$( '.amely-product-widget' )
				.find( '.hint--left' )
				.removeClass( 'hint--left' )
				.addClass( 'hint--top' );

			$( '.amely-product-widget' )
				.find( '.hint--top-left' )
				.removeClass( 'hint--top-left' )
				.addClass( 'hint--top' );

			$( '.amely-product-widget' ).each( function() {

				var $this = $( this ),
					atts  = JSON.parse( $this.attr( 'data-atts' ) );

				if ( atts == null ) {
					return;
				}

				var enable_carousel = atts.enable_carousel === 'yes';

				if ( enable_carousel ) {

					var $products = $this.find( '.product_list_widget' );

					if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
						atts.auto_play_speed = 5;
					}

					var configs = {
						accessibility : false,
						slidesToShow  : 1,
						slidesToScroll: 1,
						speed         : 1000,
						autoplay      : atts.auto_play === 'yes',
						autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
					};
					if ( ! atts.nav_type ) {
						configs.arrows = false;
						configs.dots = false;
					} else {
						if ( atts.nav_type == 'dots' ) {
							configs.arrows = false;
							configs.dots = true;
						}
						if ( atts.nav_type == 'both' ) {
							configs.arrows = atts.arrows_position == 'left-right';
							configs.dots = true;
						}
						if ( atts.nav_type == 'arrows' ) {
							configs.arrows = atts.arrows_position == 'left-right';
						}
					}

					$products.slick( configs );

					// custom navigation
					$this.find( '.slick-prev.small' ).on( 'click', function() {
						$products.slick( 'slickPrev' );
					} );

					$this.find( '.slick-next.small' ).on( 'click', function() {
						$products.slick( 'slickNext' );
					} );
				}
			} );
		};

		productGrid();
		productTabs();
		productCarousel();
		productWidget();
	};

	amely.vcTabs = function() {

		$( '.vc_tta-panel' ).each( function() {

			var $this     = $( this ),
				$carousel = $this.find( '.slick-slider' );

			$document.on( 'beforeShow.vc.accordion', function() {
				$this.find( '.product' ).addClass( 'animated' );
			} );

			$document.on( 'afterShow.vc.accordion', function() {
				$window.trigger( 'resize' );

				setTimeout( function() {
					$this.find( '.product' ).removeClass( 'zoomOut' ).addClass( 'zoomIn' );
				}, 500 );
			} );

			if ( $carousel.length && $carousel.find( '.slick-arrow' ).length ) {

				$document.on( 'beforeShow.vc.accordion', function() {
					$carousel.find( '.slick-track' ).addClass( 'filtering' ).css( 'opacity', 0 );
				} );

				$document.on( 'afterShow.vc.accordion', function() {

					var $panelBody = $carousel.closest( '.vc_tta-panel-body' );

					$panelBody.css( 'overflow', 'initial' );
					$carousel.slick( 'setPosition' );

					$carousel.find( '.slick-track' ).removeClass( 'filtering' ).css( 'opacity', 1 );
				} );
			}
		} );
	};

	amely.vcRow = function() {

		var init = function() {

			var rows        = [].slice.call( document.querySelectorAll( '.vc_row.vc_row-amely-wide' ) ),
				siteContent = document.getElementsByClassName( 'site-content' );

			var wWidth = $(window).width();

			var _left = ((wWidth - 1200) / 2) - 46;

			rows.forEach( function( row ) {

				if ( window.innerWidth < 992 ) {
					row.style = '';
					return;
				}

				if ( body.classList.contains( 'site-header-vertical' ) && window.innerWidth >= 1200 ) {
					var margin = $( body ).css( 'margin-left' );
					margin = parseInt( margin.replace( 'px', '' ) );
				}

				var w = body.classList.contains( 'site-header-vertical' ) ? window.innerWidth - margin : window.innerWidth,
					l = siteContent[0].getBoundingClientRect().left;

				w = w * .95;
				l = - 1 * ( l - w * 0.05 / 2 );

				if ( row.classList.contains( 'vc_row-no-padding' ) ) {
					w -= 30;
					l += 15;
				}

				if ( body.classList.contains( 'site-header-vertical' ) && window.innerWidth >= 1200 ) {
					l += margin;
				}

				row.style.position = 'relative';
				row.style.width = w + 'px';
				row.style.left = - _left + 'px';

				setTimeout( function() {
					row.classList.add( 'row-calculated' );
				}, 300 );

				setTimeout( function() {
					var $products = $( row ).find( '.products' );

					if ($products.data('isotope')) {
						$products.isotope( 'layout' );
					}
				}, 1000 );
			} );
		};

		var stretchRow = function( mode ) {

			if ( ! body.classList.contains( 'site-header-vertical' ) && window.innerWidth < 1200 ) {
				return;
			}

			var rows = [].slice.call( document.querySelectorAll( '.vc_row[data-vc-stretch-content="true"]' ) );

			rows.forEach( function( row ) {

				if ( row.getAttribute( 'style' ) != null && ! row.classList.contains( 'row-calculated' ) ) {

					var margin = $( body ).css( 'margin-left' );
					margin = parseInt( margin.replace( 'px', '' ) );

					var w = window.innerWidth - margin,
						l = parseInt( row.style.left.replace( 'px', '' ) );

					row.style.width = w + 'px';
					row.style.left = (l + margin) + 'px';
					row.classList.add( 'row-calculated' );
				}
				if ( mode != 'resize' ) {
					setTimeout( function() {
						var $products = $( row ).find( '.products' );

						if ($products.data('isotope')) {
							$products.isotope( 'layout' );
						}
					}, 1000 );
				}
			} );

			if ( mode != 'resize' ) {
				$window.trigger( 'resize' );
			}

		};

		init();

		$window.on( 'load', function() {
			stretchRow( 'load' );
		} );

		$window.on( 'resize', function() {
			init();

			var rows = [].slice.call( document.querySelectorAll( '.vc_row.row-calculated[data-vc-stretch-content="true"]' ) );
			rows.forEach( function( row ) {
				row.classList.remove( 'row-calculated' );
			} );

			setTimeout( function() {
				stretchRow( 'resize' );
			} );
		} );
	};

	amely.vcColumn = function() {

		var $stickyCol = $( '.wpb_column.vc_col-amely-sticky .vc_column-inner' );

		if ( md.mobile() || md.phone() || md.tablet() || ! $stickyCol.length || $window.width() < 1200 ) {
			return;
		}

		$stickyCol.stick_in_parent();
	}

	amely.bannerGrid5 = function() {

		var banners = [].slice.call( document.querySelectorAll( '.amely-banner-grid-5' ) );

		banners.forEach( function( _banner ) {

			var _items = [].slice.call( _banner.querySelectorAll( '.tm-shortcode' ) );

			if ( _items ) {

				for ( var i = 0; i < _items.length; i += 5 ) {

					var chuck  = _items.splice( i, i + 5 ),
						$chuck = $( chuck );

					$chuck.filter( ':lt(3)' ).wrapAll( '<div class="banners banners-column-1"/>' );
					$chuck.filter( ':gt(2)' ).wrapAll( '<div class="banners banners-column-2"/>' );
				}

				_banner.classList.add( 'banner-loaded' );
			}
		} );
	};

	amely.bannerGrid6 = function() {

		var banners = [].slice.call( document.querySelectorAll( '.amely-banner-grid-6' ) );

		banners.forEach( function( _banner ) {

			var _items = [].slice.call( _banner.querySelectorAll( '.tm-shortcode' ) );

			if ( _items ) {

				for ( var i = 0; i < _items.length; i += 6 ) {

					var chuck  = _items.splice( i, i + 6 ),
						$chuck = $( chuck );

					$chuck.filter( ':lt(3)' ).wrapAll( '<div class="banners banners-column-1"/>' );
					$chuck.filter( ':eq(3)' ).wrapAll( '<div class="banners banners-column-2"/>' );
					$chuck.filter( ':gt(3)' ).wrapAll( '<div class="banners banners-column-3"/>' );
				}

				_banner.classList.add( 'banner-loaded' );
			}
		} );
	};

	amely.bannerGrid6v2 = function() {

		var banners = [].slice.call( document.querySelectorAll( '.amely-banner-grid-6v2' ) );

		banners.forEach( function( _banner ) {

			var _items = [].slice.call( _banner.querySelectorAll( '.tm-shortcode' ) );

			if ( _items ) {

				for ( var i = 0; i < _items.length; i += 6 ) {

					var chuck  = _items.splice( i, i + 6 ),
						$chuck = $( chuck );

					$chuck.wrapAll( '<div class="banners-wrap"/>' );
					$chuck.filter( ':lt(2)' ).wrapAll( '<div class="banners banners-column-1"/>' );
					$chuck.filter( ':gt(1)' ).wrapAll( '<div class="banners banners-column-2"/>' );
				}

				_banner.classList.add( 'banner-loaded' );
			}
		} );
	};

})( jQuery );

// Back To Top
(
	function( $ ) {

		var $window = $( window );

		amely.backToTop = function() {

			var $backToTop = $( '.back-to-top' );

			$window.scroll( function() {

				if ( $window.scrollTop() > 100 ) {
					$backToTop.addClass( 'show' );
				} else {
					$backToTop.removeClass( 'show' );
				}
			} );

			$backToTop.on( 'click', function( e ) {
				e.preventDefault();
				$( 'html, body' ).animate( { scrollTop: 0 }, 600 );
			} );
		}
	}
)( jQuery );

// Blog
(function( $ ) {

		amely.fitVideo = function() {
			$( '.container' ).fitVids();
		};

		amely.thumbGallery = function() {

			var sliders = [].slice.call( document.querySelectorAll( '.post-gallery > .slider' ) );

			sliders.forEach( function( slider ) {

				if ( [].slice.call( slider.querySelectorAll( '.single-image' ) ).length && ! slider.classList.contains( 'slick-initialized' ) ) {

					$( slider ).slick( {
						accessibility : false,
						slidesToShow  : 1,
						arrows        : true,
						dots          : false,
						infinite      : true,
						adaptiveHeight: true,
					} );

					$( '.single-image:not(.slick-cloned)' ).magnificPopup( {
						delegate: 'a',
						gallery : {
							enabled: true,
						},
						type    : 'image',
					} );
				}
			} );
		};

		amely.blog = function() {

			var blogMasonry = function() {

				if ( typeof(
						$.fn.isotope
					) == 'undefined' || typeof(
						$.fn.imagesLoaded
					) == 'undefined' ) {
					return;
				}

				var masonryContainers = [].slice.call( document.querySelectorAll( '.masonry-container' ) );

				masonryContainers.forEach( function( container ) {

					setTimeout( function() {

						imagesLoaded( container, function() {

							new Isotope( container, {
								gutter      : 0,
								itemSelector: '.masonry-item'
							} ).layout();
						} );

						container.classList.add( 'loaded' );

						new GridLoaderFx( container, '.masonry-item' )._render( 'Amun' );

					}, 500 );
				} );
			};

			var postsSlider = function() {

				var sliders = [].slice.call( document.querySelectorAll( '.amely-blog .js-post-carousel' ) );

				sliders.forEach( function( slider ) {

					var atts = JSON.parse( slider.getAttribute( 'data-atts' ) );

					if ( atts == null ) {
						return;
					}

					if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
						atts.auto_play_speed = 5;
					}

					var configs = {
						slidesToShow  : parseInt( atts.columns ),
						slidesToScroll: parseInt( atts.columns ),
						adaptiveHeight: true,
						infinite      : (
							atts.loop == 'yes'
						),
						autoplay      : (
							atts.auto_play == 'yes'
						),
						autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
						prevArrow     : '<button type="button" class="slick-prev post-carousel-arrow">Previous</button>',
						nextArrow     : '<button type="button" class="slick-next post-carousel-arrow">Next</button>',
						responsive    : [{
							breakpoint: 992,
							settings  : {
								slidesToShow  : 3,
								slidesToScroll: 3,
							},
						}, {
							breakpoint: 769,
							settings  : {
								slidesToShow  : 2,
								slidesToScroll: 2,
							},
						}, {
							breakpoint: 544,
							settings  : {
								adaptiveHeight: true,
								arrows        : true,
								dots          : false,
								centerMode    : true,
								centerPadding : '30px',
								slidesToShow  : 1,
								slidesToScroll: 1,
							},
						},],
					};

					if ( ! atts.nav_type ) {
						configs.arrows = false;
						configs.dots = false;
					} else {
						if ( atts.nav_type == 'dots' ) {
							configs.arrows = false;
							configs.dots = true;
						}
						if ( atts.nav_type == 'both' ) {
							configs.arrows = true;
							configs.dots = true;
						}
					}

					$( slider ).slick( configs );

					setTimeout( function() {

						var thumbGalleries = [].slice.call( slider.querySelectorAll( '.post-gallery > .slider' ) );

						thumbGalleries.forEach( function( gallery ) {

							if ( typeof $( gallery ).get( 0 ).slick != 'undefined' ) {
								$( gallery ).get( 0 ).slick.setPosition();
							}
						} );
					}, 1000 );
				} );
			};

			var blogShortcode = function() {

				var posts = [].slice.call( document.querySelectorAll( '.amely-blog .posts' ) );

				if ( ! posts.length ) {
					return;
				}

				posts.forEach( function( post ) {

					var gridFx        = new GridLoaderFx( post, '.post-item' ),
						masonryConfig = {
							itemSelector: '.post-item'
						};

					if ( post.classList.contains( 'post-carousel-layout' ) ) {

						setTimeout( function() {
							post.parentNode.classList.add( 'loaded' );
						}, 500 );

						return;
					} else if ( post.classList.contains( 'post-grid-layout' ) ) {
						masonryConfig.layoutMode = 'fitRows';
					}

					setTimeout( function() {

						imagesLoaded( post, function() {
							new Isotope( post, masonryConfig ).layout();
						} );

						post.parentNode.classList.add( 'loaded' );

						gridFx._render( 'Seker' );
					}, 500 );
				} );
			};

			amely.fitVideo();
			amely.thumbGallery();

			blogMasonry();
			postsSlider();
			blogShortcode();
		};
	})( jQuery );

// Search
(
	function( $ ) {

		var $body = $( 'body' );

		amely.search = function() {
			var $search      = $( '.header-search' ),
				$formWrapper = $( '.search-form-wrapper' ),
				$closeBtn    = $( '.btn-search-close' ),
				$form        = $( 'form.ajax-search-form' ),
				$select      = $form.find( 'select.search-select' ),
				$input       = $form.find( 'input.search-input' ),
				$ajaxNotice  = $( '.ajax-search-notice' ),
				noticeText   = $ajaxNotice.text(),
				found        = false;

			if ( ! $search.length ) {
				return;
			}

			var categoriesSelectBox = function() {

				if ( $select.find( '>option' ).length ) {
					$select.select2( {
						templateResult: function( str ) {

							if ( ! str.id ) {
								return str.text;
							}

							return $( '<span>' + str.text + '</span>' );
						},
					} ).on( 'change', function() {

						var text = $( this )
							.find( 'option[value="' + $( this ).val() + '"]' )
							.text()
							.trim();

						$( '#select2-product_cat-container' ).text( text );
						$( '#select2-cat-container' ).text( text );

						setTimeout( function() {
							$input.focus();
						}, 500 );

						ajaxSearch();
					} );

					$select.next( '.select2' ).on( 'mousedown', function() {
						$( '#select2-product_cat-results' ).perfectScrollbar();
					} );
				}
			};

			var events = function() {

				$search.on( 'click', '> .toggle', function( e ) {

					e.preventDefault();

					openSearch();
				} );

				$search.on( 'focus', 'input.fake-input', function( e ) {

					e.preventDefault();

					openSearch();
				} );

				$closeBtn.on( 'click', function() {
					closeSearch();
				} );

				$input.on( 'keyup', function( event ) {

					if ( event.altKey || event.ctrlKey || event.shiftKey || event.metaKey ) {
						return;
					}
					var keys = [9, 16, 17, 18, 19, 20, 33, 34, 35, 36, 37, 39, 45, 46];

					if ( keys.indexOf( event.keyCode ) != - 1 ) {
						return;
					}

					switch ( event.which ) {
						case 8: // backspace
							if ( $( this ).val().length < amelyConfigs.search_min_chars ) {
								$( '.autocomplete-suggestion' ).remove();
								$( '.search-view-all' ).remove();
								$ajaxNotice.fadeIn( 200 ).text( noticeText );
							}
							break;
						case 27:// escape

							// close search
							if ( $( this ).val() == '' ) {
								closeSearch();
							}

							// remove result
							$( '.autocomplete-suggestion' ).remove();
							$( '.search-view-all' ).remove();
							$( this ).val( '' );

							$ajaxNotice.fadeIn( 200 ).text( noticeText );

							break;
						default:
							break;
					}
				} );
			};

			var ajaxSearch = function() {

				var productCat = '0',
					cat        = '0',
					symbol     = amelyConfigs.ajax_url.split( '?' )[1] ? '&' : '?',
					postType   = $form.find( 'input[name="post_type"]' ).val(),
					url        = amelyConfigs.ajax_url + symbol + 'action=amely_ajax_search';

				if ( $select.find( 'option' ).length ) {
					productCat = cat = $select.val();
				}

				if ( postType == 'product' ) {
					url += '&product_cat=' + productCat;
				} else {
					url += '&cat=' + cat;
				}

				url += '&limit=' + amelyConfigs.search_limit;

				$input.devbridgeAutocomplete( {
					serviceUrl      : url,
					minChars        : amelyConfigs.search_min_chars,
					appendTo        : $( '.search-results-wrapper' ),
					deferRequestBy  : 300,
					beforeRender    : function( container ) {
						container.perfectScrollbar();
					},
					onSelect        : function( suggestion ) {
						if ( suggestion.url.length ) {
							window.location.href = suggestion.url;
						}

						if ( suggestion.id == - 2 ) {
							return;
						}
					},
					onSearchStart   : function() {
						$formWrapper.addClass( 'search-loading' );
					},
					onSearchComplete: function( query, suggestions ) {

						$formWrapper.removeClass( 'search-loading' );

						if ( found && suggestions[0].id != - 1 ) {
							$ajaxNotice.fadeOut( 200 );
						} else {
							$ajaxNotice.fadeIn( 200 );
						}

						if ( suggestions.length > 1 && suggestions[suggestions.length - 1].id == - 2 ) {

							// append View All link (always is the last element of suggestions array)
							var viewAll = suggestions[suggestions.length - 1];

							$formWrapper.find( '.autocomplete-suggestions' )
										.append( '<a class="search-view-all" href="' + viewAll.url + '"' + 'target="' + viewAll.target + '">' + viewAll.value + '</a>' );
						}

						$( '.autocomplete-suggestion' ).each( function() {
							if ( ! $( this ).html() ) {
								$( this ).remove();
							}
						} );
					},
					formatResult    : function( suggestion, currentValue ) {
						return generateHTML( suggestion, currentValue );
					},
				} );
			};

			var generateHTML = function( suggestion, currentValue ) {

				var postType    = $form.find( 'input[name="post_type"]' ).val(),
					pattern     = '(' + escapeRegExChars( currentValue ) + ')',
					returnValue = '';

				// not found
				if ( suggestion.id == - 1 ) {

					$ajaxNotice.text( suggestion.value ).fadeIn( 200 );

					return returnValue;
				}

				if ( suggestion.id == - 2 ) {
					return returnValue;
				}

				found = true;

				if ( suggestion.thumbnail ) {
					returnValue += ' <div class="suggestion-thumb">' + suggestion.thumbnail + '</div>';
				}

				if ( suggestion.id != - 2 ) {
					returnValue += '<div class="suggestion-details">';
				}

				var title = suggestion.value.replace( new RegExp( pattern, 'gi' ), '<ins>$1<\/ins>' )
									  .replace( /&/g, '&amp;' )
									  .replace( /</g, '&lt;' )
									  .replace( />/g, '&gt;' )
									  .replace( /"/g, '&quot;' )
									  .replace( /&lt;(\/?ins)&gt;/g, '<$1>' ) + '</a>';

				if ( suggestion.url.length ) {
					returnValue += '<a href="' + suggestion.url + '" class="suggestion-title">' + title + '</a>';
				} else {
					returnValue += '<h5 class="suggestion-title">' + title + '</h5>';
				}

				if ( postType === 'product' ) {

					var sku = suggestion.sku;

					if ( amelyConfigs.search_by == 'sku' || amelyConfigs.search_by == 'both' ) {

						sku = suggestion.sku.replace( new RegExp( pattern, 'gi' ), '<ins>$1<\/ins>' )
										.replace( /&/g, '&amp;' )
										.replace( /</g, '&lt;' )
										.replace( />/g, '&gt;' )
										.replace( /"/g, '&quot;' )
										.replace( /&lt;(\/?ins)&gt;/g, '<$1>' ) + '</a>';
					}

					if ( suggestion.sku ) {
						returnValue += '<span class="suggestion-sku">SKU: ' + sku + '</span>';
					}

					if ( suggestion.price ) {
						returnValue += '<span class="suggestion-price">' + suggestion.price + '</span>';
					}
				}

				if ( postType === 'post' ) {
					if ( suggestion.date ) {
						returnValue += '<span class="suggestion-date">' + suggestion.date + '</span>';
					}
				}

				if ( suggestion.excerpt && amelyConfigs.search_excerpt_on ) {
					returnValue += '<p class="suggestion-excerpt">' + suggestion.excerpt + '</p>';
				}

				if ( suggestion.id != - 2 ) {
					returnValue += '</div>';
				}

				return returnValue;
			};

			var escapeRegExChars = function( value ) {
				return value.replace( /[\-\[\]\/\{\}\(\)\*\+\?\.\\\^\$\|]/g, '\\$&' );
			};

			categoriesSelectBox();
			events();
			ajaxSearch();

			var openSearch = function() {

				$body.addClass( 'search-opened' );
				$formWrapper.addClass( 'search--open' );
				$closeBtn.removeClass( 'btn--hidden' );

				setTimeout( function() {
					$input.focus();
				}, 500 );
			};

			var closeSearch = function() {

				$body.removeClass( 'search-opened' );
				$formWrapper.removeClass( 'search--open' );
				$closeBtn.addClass( 'btn--hidden' );

				setTimeout( function() {
					$input.blur();
				}, 500 );
			};
		}
	}
)( jQuery );

// Wishlist
(
	function( $ ) {

		var $window = $( window ),
			$body = $( 'body' );

		amely.wishlist = function() {

			var $wishlist            = $( '.header-wishlist' ),
				$dropDown            = $wishlist.find( '.wishlist-dropdown-wrapper' ),
				updatingWishlist     = false,
				removeAfterAddToCart = false,
				undoTimeout;

			if ( ! $wishlist.length ) {
				return;
			}

			// Wishlist Fragments
			var wlFragments = function() {

				/* Storage Handling */
				var $supports_html5_storage,
					wl_hash_key   = 'amely_wl_hash',
					fragment_name = 'amely_wl_fragments';

				try {
					$supports_html5_storage = (
						'sessionStorage' in window && window.sessionStorage !== null
					);
					window.sessionStorage.setItem( 'amely', 'test' );
					window.sessionStorage.removeItem( 'amely' );
					window.localStorage.setItem( 'amely', 'test' );
					window.localStorage.removeItem( 'amely' );
				} catch ( err ) {
					$supports_html5_storage = false;
				}

				/* Wishlist session creation time to base expiration on */
				function set_wl_creation_timestamp() {
					if ( $supports_html5_storage ) {
						sessionStorage.setItem( 'amely_wl_created', (
							new Date()
						).getTime() );
					}
				}

				/** Set the wishlist hash in both session and local storage */
				function set_wl_hash( wl_hash ) {
					if ( $supports_html5_storage ) {
						localStorage.setItem( wl_hash_key, wl_hash );
						sessionStorage.setItem( wl_hash_key, wl_hash );
					}
				}

				var $fragment_refresh = {
					url    : amelyConfigs.ajax_url,
					type   : 'GET',
					data   : {
						action: 'amely_get_wishlist_fragments',
					},
					success: function( data ) {

						if ( data && data.fragments ) {

							$.each( data.fragments, function( key, value ) {
								$( key ).replaceWith( value );
							} );

							if ( $supports_html5_storage ) {
								sessionStorage.setItem( fragment_name, JSON.stringify( data.fragments ) );
								set_wl_hash( data.wl_hash );

								if ( data.wl_hash ) {
									set_wl_creation_timestamp();
								}
							}

							$( document.body ).trigger( 'wl_fragments_refreshed' );
						}
					},
					error  : function( error ) {
						console.log( error );
					},
				};

				/* Named callback for refreshing wishlist fragment */
				function refresh_wl_fragment() {
					$.ajax( $fragment_refresh );
				}

				/* Wishlist Handling */
				if ( $supports_html5_storage ) {

					var wl_timeout = null,
						day_in_ms = 24 * 60 * 60 * 1000;

					$( document.body ).bind( 'wl_fragment_refresh updated_wc_div', function() {
						refresh_wl_fragment();
					} );

					$( document.body )
						.bind( 'added_to_wishlist removed_from_wishlist', function( event, fragments, cart_hash ) {
							var prev_wl_hash = sessionStorage.getItem( wl_hash_key );

							if ( prev_wl_hash === null || prev_wl_hash === undefined || prev_wl_hash === '' ) {
								set_wl_creation_timestamp();
							}

							sessionStorage.setItem( fragment_name, JSON.stringify( fragments ) );
							refresh_wl_fragment();

						} );

					$( document.body ).bind( 'wl_fragments_refreshed', function() {
						clearTimeout( wl_timeout );
						wl_timeout = setTimeout( refresh_wl_fragment, day_in_ms );
					} );

					// Refresh when storage changes in another tab
					$window.on( 'storage onstorage', function( e ) {
						if ( wl_hash_key === e.originalEvent.key && localStorage.getItem( wl_hash_key ) !== sessionStorage.getItem( wl_hash_key ) ) {
							refresh_wl_fragment();
						}
					} );

					try {

						var wl_fragments = JSON.parse( sessionStorage.getItem( fragment_name ) ),
							wl_hash      = sessionStorage.getItem( wl_hash_key ),
							cookie_hash  = Cookies.set( 'amely_wl_hash' ),
							wl_created   = sessionStorage.getItem( 'amely_wl_created' );

						if ( wl_hash === null || wl_hash === undefined || wl_hash === '' ) {
							wl_hash = '';
						}

						if ( cookie_hash === null || cookie_hash === undefined || cookie_hash === '' ) {
							cookie_hash = '';
						}

						if ( wl_hash && (
								wl_created === null || wl_created === undefined || wl_created === ''
							) ) {
							throw 'No wishlist_created';
						}

						if ( wl_created ) {
							var wl_expiration = 1 * cart_created + day_in_ms,
								timestamp_now = (
									new Date()
								).getTime();

							if ( cart_expiration < timestamp_now ) {
								throw 'Fragment expired';
							}

							wl_timeout = setTimeout( refresh_wl_fragment, (
								wl_expiration - timestamp_now
							) );
						}

						if ( wl_fragments && wl_fragments['div.widget_wishlist_content'] && wl_hash === cookie_hash ) {

							$.each( wl_fragments, function( key, value ) {
								$( key ).replaceWith( value );
							} );

							$( document.body ).trigger( 'wl_fragments_loaded' );

						} else {
							throw 'No fragment';
						}
					} catch ( err ) {
						refresh_wl_fragment();
					}
				} else {
					refresh_wl_fragment();
				}
			};

			var events = function() {

				$wishlist.on( 'click', '>.toggle', function( e ) {

					e.preventDefault();

					if ( ! $wishlist.hasClass( 'wishlist-open' ) ) {
						openWishlist();
					} else {
						closeWishlist();
					}

				} );

				$body.on( 'click', '#page-container', function( e ) {

					var $target = $( e.target ).closest( '.header-wishlist' );

					if ( ! $target.length ) {
						closeWishlist();
					}
				} );

				$body.on( 'added_to_wishlist wl_fragments_refreshed wl_fragments_loaded', function() {
					initUndoAction();
					initRemoveAction();
					initAddToCartAction();

					// perfectScrollbar
					$wishlist.find( '.product_list_widget' ).perfectScrollbar( { suppressScrollX: true } );
				} );

				// re-calculate the top value of mobile menu when resize
				$window.on( 'resize', function() {
					amely.setTopValue( $dropDown );
				} );
			};

			var openWishlist = function() {

				$wishlist.addClass( 'wishlist-open' );

				// on mobile
				if ( $dropDown.css( 'position' ) == 'fixed' ) {

					$body.addClass( 'mobile-wishlist-opened' );

					$wishlist.find( '.close-on-mobile' ).on( 'click', function( e ) {
						e.preventDefault();
						closeWishlist();
					} );

					amely.setTopValue( $dropDown );
				}
			};

			var closeWishlist = function() {

				$wishlist.removeClass( 'wishlist-open' );

				// on mobile
				if ( $dropDown.css( 'position' ) == 'fixed' ) {
					$body.removeClass( 'mobile-wishlist-opened' );
				}
			};

			var initRemoveAction = function() {

				$wishlist.find( '.wishlist_item .remove' ).on( 'click', function( e ) {

					e.preventDefault();

					var $this         = $( this ),
						$item         = $this.closest( '.wishlist_item' ),
						product_id    = $item.data( 'product_id' ),
						wishlistID    = $item.data( 'wishlist_id' ),
						wishlistToken = $item.data( 'wishlist_token' ),
						data          = {
							remove_from_wishlist: product_id,
							wishlist_id         : wishlistID,
							wishlist_token      : wishlistToken,
						};

					requestAjax( 'remove', data, function() {

						resetUndo();

						$item.addClass( 'deleted' );

						if ( ! removeAfterAddToCart ) {
							$wishlist.find( '.undo' ).addClass( 'visible' );
						}

						// Update class for wishlist buttons
						var $wlButtons = $( '.yith-wcwl-add-to-wishlist.add-to-wishlist-' + product_id );

						if ( $wlButtons.length ) {
							$wlButtons.find( '.yith-wcwl-add-button' )
									  .show()
									  .removeClass( 'hide' )
									  .addClass( 'show' );
							$wlButtons.find( '.yith-wcwl-wishlistaddedbrowse' )
									  .hide()
									  .removeClass( 'show' )
									  .addClass( 'hide' );
							$wlButtons.find( '.yith-wcwl-wishlistexistsbrowse' )
									  .hide()
									  .removeClass( 'show' )
									  .addClass( 'hide' );

							$wlButtons.find( '.add_to_wishlist' ).removeClass( 'loading' );
						}

						// wait 8 seconds before completely remove the item
						undoTimeout = setTimeout( function() {
							resetUndo();
						}, 8000 );
					} );
				} );
			};

			var initUndoAction = function() {

				$wishlist.find( '.undo' ).on( 'click', 'a', function( e ) {

					e.preventDefault();

					if ( undoTimeout ) {
						clearInterval( undoTimeout );
					}

					var $item         = $wishlist.find( '.wishlist_item.deleted' ),
						product_id    = $item.data( 'product_id' ),
						wishlistID    = $item.data( 'wishlist_id' ),
						wishlistToken = $item.data( 'wishlist_token' ),
						data          = {
							add_to_wishlist: product_id,
							wishlist_id    : wishlistID,
							wishlist_token : wishlistToken,
						};

					$item.addClass( 'undo-deleted' )
						 .one( 'webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {

							 if ( $wishlist.find( '.wishlist_item' ).length == 1 ) {
								 $wishlist.find( '.wishlist_empty_message' ).addClass( 'hidden' );
							 }

							 $( this )
								 .off( 'webkitAnimationEnd oanimationend msAnimationEnd animationend' )
								 .removeClass( 'deleted undo-deleted' )
								 .removeAttr( 'style' );

							 requestAjax( 'undo', data, function() {

								 resetUndo();

								 // Update class for wishlist buttons
								 var $wlButtons = $( '.yith-wcwl-add-to-wishlist.add-to-wishlist-' + product_id );

								 if ( $wlButtons.length ) {
									 $wlButtons.find( '.yith-wcwl-add-button' )
											   .show()
											   .removeClass( 'show' )
											   .addClass( 'hide' );
									 $wlButtons.find( '.yith-wcwl-wishlistaddedbrowse' )
											   .hide()
											   .removeClass( 'hide' )
											   .addClass( 'show' );
									 $wlButtons.find( '.yith-wcwl-wishlistexistsbrowse' )
											   .hide()
											   .removeClass( 'show' )
											   .addClass( 'hide' );
								 }
							 } );
						 } );
				} );
			};

			var initAddToCartAction = function() {

				$wishlist.find( '.add_to_cart_button.product_type_simple' ).on( 'click', function() {

					if ( $wishlist.find( '.remove_after_add_to_cart' ).length ) {

						removeAfterAddToCart = true;

						$( this ).closest( '.wishlist_item' ).find( '.remove' ).trigger( 'click' );
					}
				} );
			};

			var resetUndo = function() {

				if ( undoTimeout ) {
					clearInterval( undoTimeout );
				}

				$wishlist.find( '.undo' ).removeClass( 'visible' );
				$wishlist.find( '.wishlist_item.deleted' ).remove();
			};

			var requestAjax = function( type, item, callback ) {

				if ( updatingWishlist ) {
					return;
				}

				var action         = '';

				if ( type == 'remove' ) {
					action = 'amely_remove_wishlist_item';
				} else if ( type == 'undo' ) {
					action = 'amely_undo_remove_wishlist_item';
				} else {
					return;
				}

				$dropDown.addClass( 'loading' );

				$.ajax( {
					type    : 'POST',
					dataType: 'json',
					url     : amelyConfigs.ajax_url,
					data    : {
						action: action,
						item  : item
					},
					success : function( response ) {

						if ( typeof response.success != 'undefined' && response.success == false ) {
							return false;
						}

						updateWishListFragments( type, response );

						clearInterval( undoTimeout );

						if ( typeof callback !== 'undefined' ) {
							callback( response );
						}

						$dropDown.removeClass( 'loading' );

						updatingWishlist = false;

						removeAfterAddToCart = false;
					},
					error   : function( error ) {
						console.log( error );
					},
				} );
			};

			var updateWishListFragments = function( action, data ) {

				if ( action === 'remove' || action === 'undo' ) {

					// just update wishlist count

					if ( typeof data.fragments !== 'undefined' ) {

						$.each( data.fragments, function( key, value ) {

							if ( key === 'tm-wishlist' ) {

								var $emptyMessage = $wishlist.find( '.wishlist_empty_message' ),
									$button       = $wishlist.find( '.btn-view-wishlist' );

								if ( action == 'remove' && value.count == 0 ) {
									$emptyMessage.removeClass( 'hidden' );
									$button.addClass( 'hidden' );
								} else if ( action == 'undo' && value.count == 1 ) {
									$button.removeClass( 'hidden' );

								}

								// update wishlist count
								$wishlist.find( '.wishlist-count' ).html( value.count );
							}
						} );
					}
				} else {
					$body.trigger( 'wl_fragment_refresh' );
				}

				$body.trigger( 'wl_fragment_refreshed' );
			};

			wlFragments();
			events();
		};
	}
)( jQuery );

// Minicart
(function( $ ) {

	var $window   = $( window ),
		$document = $( document ),
		$body     = $( document.body );

	amely.miniCart = function() {

		var $minicart        = $( '.header-minicart' ),
			$dropDown        = $minicart.find( '.minicart-dropdown-wrapper' ),
			itemsCount       = 0,
			updatingMiniCart = false,
			favicon,
			undoTimeout,
			minicart_opened  = Cookies.get( 'amely_minicart_favico_opened' );

		if ( amelyConfigs.shop_add_to_cart_favico_on ) {
			favicon = new Favico( {
				animation: 'none',
				bgColor  : amelyConfigs.shop_favico_badge_bg_color,
				textColor: amelyConfigs.shop_favico_badge_text_color,
			} );
		}

		var events = function() {

			var initEvents = function() {
				initRemoveAction();
				initUndoAction();

				itemsCount = parseInt( $minicart.first()
												.find( '.minicart-count' )
												.text() );

				// perfectScrollbar
				$minicart.find( '.product_list_widget' ).perfectScrollbar( { suppressScrollX: true } );

				if ( minicart_opened == 'yes' ) {
					favicon.badge( 0 );
				}
			};

			$minicart.on( 'click', '>.toggle', function( e ) {

				e.preventDefault();

				if ( ! $minicart.hasClass( 'minicart-open' ) ) {
					openMiniCart();
				} else {
					closeMiniCart();
				}

			} );

			$body.on( 'click', '#page-container', function( e ) {

				var $target = $( e.target ).closest( '.header-minicart' );

				if ( ! $target.length ) {
					closeMiniCart();
				}
			} );

			// Trigger  fragments refreshed event
			updateCartFragments( 'refresh' );

			$body.on( 'added_to_cart wc_fragments_refreshed wc_fragments_loaded', function() {
				initEvents();

				// favico notification
				if ( amelyConfigs.shop_add_to_cart_favico_on && minicart_opened != 'yes' ) {
					favicon.badge( itemsCount );
				}
			} );

			$body.on( 'added_to_cart', function() {

				// favico notification
				if ( amelyConfigs.shop_add_to_cart_favico_on ) {
					favicon.badge( itemsCount );
					Cookies.set( 'amely_minicart_favico_opened', 'no', {
						expires: 1,
						path   : '/'
					} );
				}
			} );

			// When Compare iframe closed
			$document.on( 'cbox_closed', function() {
				updateCartFragments( 'refresh' );
			} );

			// re-calculate the top value of mobile menu when resize
			$window.on( 'resize', function() {
				amely.setTopValue( $dropDown );
			} );
		};

		var openMiniCart = function() {

			$minicart.addClass( 'minicart-open' );

			// on mobile
			if ( $dropDown.css( 'position' ) == 'fixed' ) {
				$body.addClass( 'mobile-minicart-opened' );

				$minicart.find( '.close-on-mobile' ).on( 'click', function( e ) {
					e.preventDefault();
					closeMiniCart();
				} );
			}

			// favico notification
			if ( amelyConfigs.shop_add_to_cart_favico_on ) {
				favicon.badge( 0 );
				Cookies.set( 'amely_minicart_favico_opened', 'yes', {
					expires: 1,
					path   : '/'
				} );
			}

			amely.setTopValue( $dropDown );
		};

		var closeMiniCart = function() {
			$minicart.removeClass( 'minicart-open' );

			// on mobile
			if ( $dropDown.css( 'position' ) == 'fixed' ) {
				$body.removeClass( 'mobile-minicart-opened' );
			}
		};

		var initRemoveAction = function() {

			$minicart.find( '.woocommerce-mini-cart-item .remove' ).on( 'click', function( e ) {

				e.preventDefault();

				var $this         = $( this ),
					cart_item_key = $this.attr( 'data-cart_item_key' ),
					$item         = $this.closest( '.woocommerce-mini-cart-item' );

				requestAjax( 'remove', cart_item_key, function() {

					resetUndo();

					$item.addClass( 'deleted' );

					$minicart.find( '.undo' ).addClass( 'visible' );

					// wait 8 seconds before completely remove the items
					undoTimeout = setTimeout( function() {
						resetUndo();
					}, 8000 );
				} );
			} );
		};

		var initUndoAction = function() {

			$minicart.find( '.undo' ).on( 'click', 'a', function( e ) {

				e.preventDefault();

				if ( undoTimeout ) {
					clearInterval( undoTimeout );
				}

				var $item         = $minicart.find( '.woocommerce-mini-cart-item.deleted' ),
					cart_item_key = $item.find( '.remove' ).data( 'cart_item_key' );

				if ( $minicart.find( '.woocommerce-mini-cart-item' ).length == 1 ) {
					$minicart.find( '.woocommerce-mini-cart__empty-message' ).addClass( 'hidden' );
				}

				$item.addClass( 'undo-deleted' )
					 .one( 'webkitAnimationEnd oanimationend msAnimationEnd animationend', function() {
						 $( this )
							 .off( 'webkitAnimationEnd oanimationend msAnimationEnd animationend' )
							 .removeClass( 'deleted undo-deleted' )
							 .removeAttr( 'style' );

						 requestAjax( 'undo', cart_item_key, function() {
							 resetUndo();
						 } );
					 } );
			} );
		};

		var resetUndo = function() {

			if ( undoTimeout ) {
				clearInterval( undoTimeout );
			}

			$minicart.find( '.undo' ).removeClass( 'visible' );
			$minicart.find( '.woocommerce-mini-cart-item.deleted' ).remove();
		};

		var requestAjax = function( type, cart_item_key, callback ) {

			if ( updatingMiniCart ) {
				return;
			}

			var action = '';

			if ( type == 'remove' ) {
				action = 'amely_remove_cart_item';
			} else if ( type == 'undo' ) {
				action = 'amely_undo_remove_cart_item';
			} else {
				return;
			}

			$dropDown.addClass( 'loading' );

			updatingMiniCart = true;

			$.ajax( {
				type    : 'POST',
				dataType: 'json',
				url     : amelyConfigs.ajax_url,
				data    : {
					action: action,
					item  : cart_item_key
				},
				success : function( response ) {

					updateCartFragments( type, response );

					clearInterval( undoTimeout );

					if ( typeof callback !== 'undefined' ) {
						callback( response );
					}

					$dropDown.removeClass( 'loading' );

					updatingMiniCart = false;
				},
				error   : function( error ) {
					console.log( error );
				},
			} );
		};

		var updateCartFragments = function( action, data ) {

			if ( action === 'remove' || action === 'undo' ) {

				// just update cart count & cart total, don't update the product list
				if ( typeof data.fragments !== 'undefined' ) {

					$.each( data.fragments, function( key, value ) {

						if ( key === 'tm-minicart' ) {

							var $emptyMessage    = $minicart.find( '.woocommerce-mini-cart__empty-message' ),
								$total           = $minicart.find( '.woocommerce-mini-cart__total' ),
								$buttons         = $minicart.find( '.woocommerce-mini-cart__buttons' ),
								$minicartMessage = $minicart.find( '.minicart-message' );

							if ( action == 'remove' && value.count == 0 ) {
								$emptyMessage.removeClass( 'hidden' );
								$total.addClass( 'hidden' );
								$buttons.addClass( 'hidden' );
								$minicartMessage.addClass( 'hidden' );
							} else if ( action == 'undo' && value.count == 1 ) {
								$total.removeClass( 'hidden' );
								$buttons.removeClass( 'hidden' );
								$minicartMessage.removeClass( 'hidden' );
							}

							// update cart count
							$minicart.find( '.minicart-count' ).html( value.count );

							// update cart total
							$minicart.find( '.woocommerce-mini-cart__total .woocommerce-Price-amount' )
									 .html( value.total );
						}
					} );
				}

				// if you are in the Cart page, trigger wc_update_cart event
				if ( $body.hasClass( 'woocommerce-cart' ) ) {
					$body.trigger( 'wc_update_cart' );
				}
			} else {
				$body.trigger( 'wc_fragment_refresh' );
			}

			$body.trigger( 'wc_fragments_refreshed' );
		};

		events();
	};
})( jQuery );

// Shop page
(function( $ ) {

	var $window   = $( window ),
		$document = $( document ),
		$body     = $( 'body' ),
		w         = $window.width();

	amely.shop = function() {

		var $products = $( '.products' ),
			$carousel = $( '.categories-carousel' );

		if ( ! $products.length ) {
			return;
		}

		var categoriesCarousel = function() {

			if ( ! amelyConfigs.is_shop ) {
				return;
			}

			var itemCount = parseInt( $carousel.attr( 'data-carousel' ) );

			$carousel.slick( {
				accessibility : false,
				slidesToShow  : itemCount,
				slidesToScroll: itemCount,
				speed         : 1000,
				infinite      : true,
				arrows        : false,
				dots          : true,
				responsive    : [{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2,
					},
				}, {
					breakpoint: 544,
					settings  : {
						centerMode    : true,
						slidesToShow  : 1,
						slidesToScroll: 1,
					},
				}],
			} );
		}

		var categoriesMenu = function() {

			var $menu = $( '.product-categories-menu' );

			if ( ! $menu ) {
				return;
			}

			if ( w > 991 ) {

				var menuWidth = 0;
				$menu.find( 'li' ).each( function() {
					menuWidth += $( this ).outerWidth( true );
				} );

				$menu.width( Math.round( menuWidth ) + 5 );
				$menu.parent().perfectScrollbar( { suppressScrollY: true } );
			} else {
				$menu.perfectScrollbar();
			}

			$body.on( 'click', '.show-categories-menu', function( e ) {

				e.preventDefault();

				var $this = $( this );

				if ( $menu.hasClass( 'open' ) ) {
					$this.removeClass( 'open' );
					$menu.removeClass( 'open' ).slideUp( 200 );
				} else {
					$this.addClass( 'open' );
					$menu.addClass( 'open' ).slideDown( 200 );

					var scrollTo = $this.offset().top;

					if ( amelyConfigs.sticky_header ) {
						scrollTo -= $( '.sticky-header' ).height();
					}

					if ( $( '#wpadminbar' ).length && $( '#wpadminbar' )
														  .css( 'position' ) == 'fixed' ) {
						scrollTo -= $( '#wpadminbar' ).height();
					}

					$body.animate( {
						scrollTop: scrollTo,
					}, 600 );
				}
			} );
		};

		var productCategoriesWidget = function() {

			if ( ! amelyConfigs.categories_toggle ) {
				return;
			}

			var _categoriesWidget = document.querySelector( '.widget_product_categories .product-categories' );

			if ( _categoriesWidget ) {
				_categoriesWidget.classList.add( 'has-toggle' );
			}

			// widget product categories accordion
			var _childrens = [].slice.call( document.querySelectorAll( '.widget_product_categories ul li ul.children' ) );

			if ( _childrens ) {

				_childrens.forEach( function( _children ) {

					var _i = document.createElement( 'i' );
					_i.classList.add( 'fa' );
					_i.classList.add( 'fa-angle-down' );

					_children.parentNode.insertBefore( _i, _children.parentNode.firstChild );
				} );
			}

			var _toggles = [].slice.call( document.querySelectorAll( '.widget_product_categories ul li.cat-parent i' ) );

			_toggles.forEach( function( _toggle ) {

				_toggle.addEventListener( 'click', function() {

					var _parent = _toggle.parentNode;

					if ( _parent.classList.contains( 'expand' ) ) {
						_parent.classList.remove( 'expand' );
						$( _parent ).children( 'ul.children' ).slideUp( 200 );
					} else {
						_parent.classList.add( 'expand' );
						$( _parent ).children( 'ul.children' ).slideDown( 200 );
					}
				} );
			} );

			var _parents = [].slice.call( document.querySelectorAll( '.widget_product_categories ul li.cat-parent' ) );

			_parents.forEach( function( _parent ) {

				if ( _parent.classList.contains( 'current-cat' ) || _parent.classList.contains( 'current-cat-parent' ) ) {
					_parent.classList.add( 'expand' );
					$( _parent ).children( 'ul.children' ).show();
				} else {
					$( _parent ).children( 'ul.children' ).hide();
				}

				$( '.widget_product_categories li.cat-parent.expand' ).find( '> ul.children' ).show();
			} );

		};

		var wooPriceSlider = function() {

			// woocommerce_price_slider_params is required to continue, ensure the object exists
			if ( typeof woocommerce_price_slider_params === 'undefined' ) {
				return false;
			}

			// Get markup ready for slider
			$( 'input#min_price, input#max_price' ).hide();
			$( '.price_slider, .price_label' ).show();

			// Price slider uses jquery ui
			var min_price         = $( '.price_slider_amount #min_price' ).data( 'min' ),
				max_price         = $( '.price_slider_amount #max_price' ).data( 'max' ),
				current_min_price = parseInt( min_price, 10 ),
				current_max_price = parseInt( max_price, 10 );

			if ( typeof $products != 'undefined' && typeof $products.attr( 'data-min_price' ) != 'undefined' && $products.attr( 'data-min_price' ).length ) {
				current_max_price = parseInt( $products.attr( 'data-min_price' ), 10 );
			}

			if ( typeof $products != 'undefined' && typeof $products.attr( 'data-max_price' ) != 'undefined' && $products.attr( 'data-max_price' ).length ) {
				current_max_price = parseInt( $products.attr( 'data-max_price' ), 10 );
			}

			$( '.price_slider' ).slider( {
				range  : true,
				animate: true,
				min    : min_price,
				max    : max_price,
				values : [current_min_price, current_max_price],
				create : function() {

					$( '.price_slider_amount #min_price' ).val( current_min_price );
					$( '.price_slider_amount #max_price' ).val( current_max_price );

					$( document.body ).trigger( 'price_slider_create', [current_min_price, current_max_price] );
				},
				slide  : function( event, ui ) {

					$( 'input#min_price' ).val( ui.values[0] );
					$( 'input#max_price' ).val( ui.values[1] );

					$( document.body )
						.trigger( 'price_slider_slide', [ui.values[0], ui.values[1]] );
				},
				change : function( event, ui ) {

					$( document.body )
						.trigger( 'price_slider_change', [ui.values[0], ui.values[1]] );
				},
			} );

			setTimeout( function() {
				$( document.body )
					.trigger( 'price_slider_create', [current_min_price, current_max_price] );
			}, 300 );
		};

		// add a class if the product container too small
		var productClass = function() {

			[].slice.call( document.querySelectorAll( '.products' ) ).forEach( function( _products ) {

				var _product        = [].slice.call( _products.querySelectorAll( '.product' ) );
					if (_product.length) {
					var _firstProduct   = _product[0],
						productWidth    = Math.round( _firstProduct.clientWidth ),
						windowWidth     = window.innerWidth,
						minWidth        = 155,
						extraSmallWidth = 150,
						maxWidth        = 300,
						extraLargeWidth = 600;

					if ( windowWidth > 768 ) {
						minWidth = 240;
					}

					if ( windowWidth > 992 ) {
						extraSmallWidth = 234;
						minWidth = 235;
					}

					if ( windowWidth > 1200 ) {
						extraSmallWidth = 200;
						minWidth = 270;
					}

					_product.forEach( function( _p ) {

						if ( productWidth < minWidth ) {
							_p.classList.add( 'small-product' );
						} else {
							_p.classList.remove( 'small-product' );
						}

						if ( productWidth < extraSmallWidth ) {
							_p.classList.add( 'extra-small-product' );
						} else {
							_p.classList.remove( 'extra-small-product' );
						}

						if ( windowWidth > 1200 && productWidth > maxWidth && _p.classList.contains( 'col-xl-4' ) ) {
							_p.classList.add( 'large-product' );
						} else {
							_p.classList.remove( 'large-product' );
						}

						if ( windowWidth > 1200 && productWidth > extraLargeWidth && (
								_p.classList.contains( 'col-xl-6' ) || _p.classList.contains( 'col-xl-1' )
							) ) {
							_p.classList.add( 'extra-large-product' );
						} else {
							_p.classList.remove( 'extra-large-product' );
						}

					} );
				}

				$products.trigger( 'arrangeComplete' );
			} );
		};

		var columnSwitcher = function() {

			if ( ! $( '.col-switcher' ).length ) {
				return;
			}

			addActiveClassforColSwitcher();

			var $colSwitcher = $( '.col-switcher' ),
				$product     = $( '.archive.woocommerce .products .product' );

			$body.on( 'click', '#page-container', function( e ) {

				var $target = $( e.target ).closest( '.col-switcher' );

				if ( ! $target.length ) {
					$colSwitcher.removeClass( 'open' );
				}
			} );

			// Change columns when click
			$colSwitcher.find( 'a' ).unbind( 'click' ).on( 'click', function( e ) {

				e.preventDefault();

				var $this         = $( this ),
					windowWidth   = $window.width(),
					col           = $this.attr( 'data-col' ),
					removeClasses = '',
					addClasses    = '';

				// save cookie
				Cookies.set( 'amely_shop_col', col, {
					expires: 1,
					path   : '/'
				} );

				if ( 0 == 12 % col ) {
					col = 12 / col;
				} else {
					if ( 5 == col ) {
						col = 'is-5';
					}
				}

				$colSwitcher.find( 'a' ).removeClass( 'active' );
				$this.addClass( 'active' );

				if ( windowWidth <= 544 ) {
					removeClasses = 'col-xs-2 col-xs-3 col-xs-4 col-xs-is-5 col-xs-6 col-xs-12';
					addClasses = 'col-xs-' + col;
				} else if ( windowWidth >= 545 && windowWidth <= 767 ) {
					removeClasses = 'col-sm-2 col-sm-3 col-sm-4 col-sm-is-5 col-sm-6 col-sm-12';
					addClasses = 'col-sm-' + col;
				} else if ( windowWidth >= 768 && windowWidth <= 991 ) {
					removeClasses = 'col-md-2 col-md-3 col-md-4 col-md-is-5 col-md-6 col-md-12';
					addClasses = 'col-md-' + col;
				} else if ( windowWidth >= 992 && windowWidth <= 1199 ) {
					removeClasses = 'col-lg-2 col-lg-3 col-lg-4 col-lg-is-5 col-lg-6 col-lg-12';
					addClasses = 'col-lg-' + col;
				} else if ( windowWidth >= 1200 ) {
					removeClasses = 'col-xl-2 col-xl-3 col-xl-4 col-xl-is-5 col-xl-6 col-xl-12';
					addClasses = 'col-xl-' + col;
				}

				$product.removeClass( removeClasses ).addClass( addClasses );
				$products.trigger( 'arrangeComplete' );

				shopMasonry();
				productClass();
			} );

			if ( Cookies.get( 'amely_shop_col' ) ) {
				$colSwitcher.find( 'a[data-col="' + Cookies.get( 'amely_shop_col' ) + '"]' ).trigger( 'click' );
			}
		};

		var filterDropdowns = function() {

			if ( ! amelyConfigs.is_shop ) {
				return;
			}

			$( '.widget_tm_layered_nav' ).on( 'change', 'select', function() {

				var slug       = $( this ).val(),
					href       = $( this ).attr( 'data-filter-url' ).replace( 'AMELY_FILTER_VALUE', slug ),
					pseudoLink = $( this ).siblings( '.filter-pseudo-link' );

				pseudoLink.attr( 'href', href );
				pseudoLink.trigger( 'click' );
			} );
		};

		var filtersArea = function() {

			if ( ! amelyConfigs.is_shop ) {
				return;
			}

			var _filters = document.querySelector( '.filters-area' );

			if ( _filters ) {
				$( _filters ).removeClass( 'filters-opened' ).stop().hide();
			}

			$( '.open-filters' ).unbind( 'click' ).on( 'click', function( e ) {
				e.preventDefault();

				var _filters = document.querySelector( '.filters-area' );
				$(_filters).removeClass('always_display_filters');

				if ( _filters.classList.contains( 'filters-opened' ) ) {
					closeFilters();
				} else {
					openFilters();
				}
			} );

			var openFilters = function() {

				var _filters   = document.querySelector( '.filters-area' ),
					_btnFilter = document.querySelector( '.open-filters' );

				_filters.classList.add( 'filters-opened' );
				$( _filters ).stop().slideDown( 300 );
				_btnFilter.classList.add( 'opened' );

				setTimeout( function() {

					$( '.filters-area .widget_tm_layered_nav ul.show-display-list' )
						.perfectScrollbar( { suppressScrollX: true } );

					$( '.filters-area .widget_tm_layered_nav ul.show-display-list.show-labels-off li' )
						.each( function() {
							$( this ).find( '.filter-swatch' ).removeClass( 'hint--top' ).addClass( 'hint--right' );
						} );
				}, 500 );
			};

			var closeFilters = function() {

				var _filters   = document.querySelector( '.filters-area' ),
					_btnFilter = document.querySelector( '.open-filters' );

				_filters.classList.remove( 'filters-opened' );
				$( _filters ).stop().slideUp( 300 );
				_btnFilter.classList.remove( 'opened' );
			};
		};

		var wishlistButton = function() {

			if ( typeof  mojs == 'undefined' ) {
				return;
			}

			var burst = new mojs.Burst( {
				left    : 0,
				top     : 0,
				radius  : { 4: 32 },
				angle   : 45,
				count   : 14,
				children: {
					radius     : 2.5,
					fill       : amelyConfigs.wishlist_burst_color,
					scale      : {
						1     : 0,
						easing: 'quad.in'
					},
					pathScale  : [.8, null],
					degreeShift: [13, null],
					duration   : [500, 700],
					easing     : 'quint.out'
				}
			} );

			$( 'body' ).on( 'click', '.yith-wcwl-add-button.animated-wishlist .add_to_wishlist', function() {

				var $this  = $( this ),
					offset = $this.offset(),
					width  = $this.width(),
					height = $this.height(),
					coords = {
						x: offset.left + width / 2,
						y: offset.top + height / 2
					};

				burst.tune( coords ).replay();
			} );
		};

		var events = function() {

			$( '.shop-filter select.orderby' ).niceSelect();

			$( '.product-categories-select .list' ).perfectScrollbar();

			$( '.widget_tm_layered_nav ul.show-display-list' ).perfectScrollbar();

			$( '.widget_product_categories ul.product-categories' ).perfectScrollbar( { suppressScrollX: true } );

			categoriesCarousel();

			categoriesMenu();

			productCategoriesWidget();

			wooPriceSlider();

			shopMasonry();

			columnSwitcher();

			filterDropdowns();

			filtersArea();

			wishlistButton();

			setTimeout( function() {
				productClass();
			}, 500 );
		};

		var initAfterAjax = function() {

			events();

			// Orderby
			$( '.woocommerce-ordering' ).on( 'change', 'select.orderby', function() {
				$( this ).closest( 'form' ).submit();
			} );

			// re init swatches
			amely.reInitSwatches();

			amely.ajaxLoadMore();
		};

		var ajaxShop = function() {

			if ( ! amelyConfigs.shop_ajax_on ) {
				return;
			}

			if ( ! amelyConfigs.is_shop ) {
				return;
			}

			var ajaxLinks   = '.woocommerce-pagination a, .widget-area a, shop-loop-header a, .filters-area a, .shop-menu a, .active-filters a',
				scrollToTop = function() {

					$( 'html, body' ).stop().animate( {
						scrollTop: $( '.main-container' ).offset().top - 100,
					}, 400 );
				};

			$body.on( 'click', 'nav.woocommerce-pagination a', function() {
				scrollToTop();
			} );

			$document.pjax( ajaxLinks, '.main-container', {
				timeout : 10000,
				scrollTo: false,
				fragment: '.main-container',
			} );

			$document.on( 'click', '.widget_price_filter form .button', function() {

				var form = $( '.widget_price_filter form' );

				$.pjax( {
					container: '.main-container',
					fragment : '.main-container',
					timeout  : 10000,
					url      : form.attr( 'action' ),
					data     : form.serialize(),
					scrollTo : false,
				} );

				return false;
			} );

			$document.on( 'pjax:error', function( xhr, textStatus, error, options ) {
				console.log( 'pjax error ' + error );
			} );

			$document.on( 'pjax:start', function( xhr, options ) {
				scrollToTop();
				$body.addClass( 'ajax-loading' );
			} );

			$document.on( 'pjax:complete', function( xhr, textStatus, options ) {

				initAfterAjax();
				scrollToTop();

				$body.removeClass( 'ajax-loading' );

			} );

			$document.on( 'pjax:success', function( xhr, data, status, options ) {
				var obj = $(data),
					newInlineStyle = '';
				for (var i = 0; i < obj.length; i++) {
					if (obj[i].id == 'amely-main-style-inline-css') {
						newInlineStyle = jQuery(obj[i]).text();
						break;
					}
				}

				if (newInlineStyle.length) {
					$('#amely-main-style-inline-css').text(newInlineStyle);
				}
			} );

			$document.on( 'pjax:end', function( xhr, textStatus, options ) {

				$body.removeClass( 'ajax-loading' );

			} );

			// YITH Ajax navigation compatible
			$document.on( 'yith-wcan-ajax-loading', function() {

				var $yit_wcan = $( '.yit-wcan-container' );

				if ( $yit_wcan.length ) {
					scrollToTop();
				}
			} );
		};

		var shopMasonry = function() {

			if ( ! amelyConfigs.is_shop ) {
				return;
			}

			$products.isotope( {
				layoutMode        : 'fitRows',
				itemSelector      : '.product',
				transitionDuration: '0.5s'
			});

			$products.imagesLoaded().progress( function() {
				$products.isotope('layout');
			});

			$products.on( 'arrangeComplete', function() {
				setTimeout( function() {
					addActiveClassforColSwitcher();
				}, 500 );
			} );

		};

		var addActiveClassforColSwitcher = function() {

			var $colSwitcher = $( '.col-switcher' );

			if ( ! $colSwitcher.length ) {
				return;
			}

			var width  = $( '.products' ).width(),
				pWidth = $( '.product-loop' ).outerWidth(),
				col    = Cookies.get( 'amely_shop_col' ) ? Cookies.get( 'amely_shop_col' ) : Math.round( width / pWidth );

			$colSwitcher.find( 'a' ).removeClass( 'active' );
			$colSwitcher.find( 'a[data-col="' + col + '"]' ).addClass( 'active' );
		};

		events();
		ajaxShop();

		$window.on( 'popstate', function() {

			productCategoriesWidget();

			categoriesMenu();

			columnSwitcher();

			filtersArea();

			wishlistButton();

			// re init swatches
			amely.reInitSwatches();
		} );

		$window.on( 'resize', function() {

			// change to grid if we are in tm-shortcode
			if ( $products.closest( '.tm-shortcode' ).length || $products
					.closest( '.up-sells' ).length || $products
					 .closest( '.cross-sells' ).length || $products
					 .closest( '.related' ).length ) {
				$products.addClass( 'grid' );
			}

			if ( $( this ).width() != w ) {
				productClass();
			}
		} );
	};
})( jQuery );

// Quick view
(function( $ ) {

	var $window   = $( window ),
		$document = $( document ),
		$body     = $( 'body' );

	amely.quickView = function() {

		var $quickView = $( '#woo-quick-view' );

		var events = function() {

			var disable          = false, // prevent user click quick view button too fast
				sliderFinalWidth = amelyConfigs.quickview_image_width, // the quick view image slider width
				maxQuickWidth    = 960;

			$body.on( 'click', '.quick-view-btn', function( e ) {

				e.preventDefault();

				if ( disable ) {
					return false;
				}

				var $this         = $( this ),
					$productThumb = $this.closest( '.product-thumb' );

				if ( ! $productThumb.length ) {
					return;
				}

				var pid           = $this.attr( 'data-pid' ),
					selectedImage = $productThumb.find( 'img.wp-post-image' );

				var cache = sessionStorage.getItem( 'amely_quickview_' + pid );

				// get cache
				if ( cache ) {

					$quickView.html( cache );

					if ( $quickView.hasClass( 'animated-quick-view' ) ) {
						$body.addClass( 'quick-view-opened' );
						animateQuickView( selectedImage, sliderFinalWidth, maxQuickWidth, 'open' );
					} else {
						magnificPopupQuickview();
					}

					reInitEvents();

					return;
				}

				$this.addClass( 'loading' );
				$productThumb.addClass( 'loading' );
				disable = true;

				$.ajax( {
					url    : amelyConfigs.ajax_url,
					data   : {
						action: 'amely_quick_view',
						pid   : pid,
					},
					timeout: 10000,
					success: function( response ) {

						$quickView.empty().html( response ).attr( 'data-product-id', pid );

						if ( $quickView.hasClass( 'animated-quick-view' ) ) {
							$body.addClass( 'quick-view-opened' );
							animateQuickView( selectedImage, sliderFinalWidth, maxQuickWidth, 'open' );
						} else {
							magnificPopupQuickview();
						}

						$this.removeClass( 'loading' );
						$productThumb.removeClass( 'loading' );
						disable = false;

						reInitEvents();
					},
					error  : function( error ) {
						console.log( error );

						$this.removeClass( 'loading' );
						$productThumb.removeClass( 'loading' );
						disable = false;
					},

				} );
			} );

			// close the quick view panel
			$body.on( 'click', function( e ) {
				if ( $( e.target ).is( '.quick-view-close' ) || $( e.target )
						.is( 'body.quick-view-opened #page-container' ) ) {
					e.preventDefault();
					closeQuickView( sliderFinalWidth, maxQuickWidth );
				}
			} );

			// if user has pressed 'Esc'
			$document.keyup( function( event ) {
				if ( event.which == '27' ) {
					closeQuickView( sliderFinalWidth, maxQuickWidth );
				}
			} );

			// center quick-view on window resize
			$window.on( 'resize', function() {
				if ( $quickView.hasClass( 'is-visible' ) ) {
					window.requestAnimationFrame( resizeQuickView );
				}
			} );
		};

		var resizeQuickView = function() {

			var quickViewLeft = (
									$window.width() - $quickView.width()
								) / 2,
				quickViewTop  = (
									$window.height() - $quickView.height()
								) / 2;

			$quickView.css( {
				'top' : quickViewTop,
				'left': quickViewLeft,
			} );

			if ( $( '.quick-view-carousel img' ).length > 1 && $( '.quick-view-carousel' )
					.hasClass( 'slick-slider' ) ) {
				$( '.quick-view-carousel' ).slick( 'setPosition' );
			}
		};

		var closeQuickView = function( finalWidth, maxQuickWidth ) {

			var selectedImage = $( '.empty-box' ).find( '.woocommerce-LoopProduct-link img' );

			if ( $( '.quick-view-carousel img' ).length > 1 ) {
				$( '.quick-view-carousel' ).slick( 'unslick' );
			}

			// remove loading
			$quickView.find( '.quickview-loading' ).removeClass( 'added' ).css( 'display', 'none' );

			// update the image in the gallery
			if ( $quickView.hasClass( 'add-content' ) ) {
				animateQuickView( selectedImage, finalWidth, maxQuickWidth, 'close' );
			} else {
				if ( typeof selectedImage != 'undefined' ) {
					closeNoAnimation( selectedImage );
				}
			}

			// cache quickview
			var oldID = $quickView.attr( 'data-product-id' );
			if ( oldID && ! sessionStorage.getItem( 'amely_quickview_' + oldID ) ) {
				$quickView.find( '.summary' ).perfectScrollbar('destroy');
				sessionStorage.setItem( 'amely_quickview_' + oldID, $quickView.html() );
			}
		};

		var closeNoAnimation = function( image ) {

			var parentListItem = image.parents( 'li' );

			if ( typeof  image.offset() == 'undefined' ) {
				return;
			}

			var topSelected   = image.offset().top - $window.scrollTop(),
				leftSelected  = image.offset().left,
				widthSelected = image.width();

			// close the quick view reverting the animation
			$body.removeClass( 'overlay-layer' );
			parentListItem.removeClass( 'empty-box' );

			$quickView.removeClass( 'add-content animate-width is-visible' )
					  .css( {
						  'top'  : topSelected,
						  'left' : leftSelected,
						  'width': widthSelected,
					  } );
		};

		var animateQuickView = function( image, finalWidth, maxQuickWidth, animationType ) {

			// store some image data (width, top position, ...)
			// store window data to calculate quick view panel position
			var target         = '#woo-quick-view',
				timeline       = anime.timeline(),
				parentListItem = image.parents( '.product-loop' ),
				topSelected    = image.offset().top - $window.scrollTop(), // the selected image top value
				leftSelected   = image.offset().left, // the selected image left value
				widthSelected  = image.width(), // the selected image width
				windowWidth    = $window.width(),
				windowHeight   = $window.height(),
				finalLeft      = (
									 windowWidth - finalWidth
								 ) / 2,
				finalHeight    = amelyConfigs.quickview_image_height,
				finalTop       = (
									 windowHeight - finalHeight
								 ) / 2,
				quickViewWidth = (
					windowWidth * .8 < maxQuickWidth
				) ? windowWidth * .8 : maxQuickWidth,
				quickViewLeft  = (
									 windowWidth - quickViewWidth
								 ) / 2;

			if ( animationType == 'open' ) {

				// hide the image in the gallery
				parentListItem.addClass( 'empty-box' );

				timeline.add( {
					targets   : target,
					top       : [topSelected, finalTop + 'px'],
					left      : [leftSelected, finalLeft + 'px'],
					width     : [widthSelected, finalWidth + 'px'],
					duration  : 1800,
					elasticity: 200,
					begin     : function( anim ) {
						$quickView.addClass( 'is-visible' );
					},
				} ).add( {
					targets : target,
					left    : quickViewLeft + 'px',
					width   : quickViewWidth + 'px',
					duration: 400,
					easing  : 'easeInQuad',
					begin   : function( anim ) {
						$quickView.addClass( 'animate-width' );
					},
					complete: function( anim ) {

						// init quick view carousel
						if ( $( '.quick-view-carousel img' ).length > 1 ) {
							var settings = JSON.parse( $( '.quick-view-carousel' ).attr( 'data-carousel' ) );

							$( '.quick-view-carousel' ).slick( settings );
						}

						// show quick view content
						$quickView.addClass( 'add-content' );
					}
				} );

			} else {

				timeline = anime.timeline();

				timeline.add( {
					targets : target,
					left    : [quickViewLeft + 'px', finalLeft + 'px'],
					width   : [quickViewWidth + 'px', finalWidth + 'px'],
					duration: 400,
					easing  : 'easeInQuad',
					begin   : function( anim ) {
						$quickView.removeClass( 'add-content' );
					},
					complete: function( anim ) {
						$body.removeClass( 'quick-view-opened' );
					}
				} ).add( {
					targets : target,
					top     : [finalTop + 'px', topSelected],
					left    : [finalLeft + 'px', leftSelected],
					width   : [finalWidth + 'px', widthSelected],
					duration: 500,
					easing  : 'easeInQuad',
					begin   : function( anim ) {
						$quickView.removeClass( 'animate-width' );
					},
					complete: function( anim ) {
						$quickView.removeClass( 'is-visible' );
						$body.removeClass( 'quick-view-opened' );
						parentListItem.removeClass( 'empty-box' );
					}
				} );
			}
		};

		var magnificPopupQuickview = function() {

			$.magnificPopup.open( {
				items    : {
					src: $quickView,
				},
				mainClass: 'mfp-fade',
				type     : 'inline',
				callbacks: {
					open      : function() {
						$( '.quick-view-carousel' ).slick( {
							accessibility: false,
							infinite     : false,
							dots         : true,
							arrows       : false
						} );
					},
					afterClose: function() {
						if ( $( '.quick-view-carousel img' ).length > 1 ) {
							var carousel = JSON.parse( $( '.quick-view-carousel' ).attr( 'data-carousel' ) );

							$( '.quick-view-carousel' ).slick( carousel );
						}
					},
				},
			} );
		};

		var initAddToCart = function() {

			$body.on( 'submit', '#woo-quick-view form.cart', function( e ) {

				e.preventDefault();

				var $this    = $( this ),
					$loading = $( '#woo-quick-view .quickview-loading' ),
					$text    = $loading.find( '> span' ),
					data     = $.parseParams( $this.serialize() );

				$text.text( amelyConfigs.adding_to_cart_text );
				$loading.removeClass( 'added' ).removeClass( 'error' ).fadeIn( 200 );

				data.action = 'amely_ajax_add_to_cart';
				data.pid = $this.find( 'button[name="add-to-cart"]' ).val();

				if ( $this.hasClass( 'variations_form' ) || $this.find( '.group_table' ).length ) {
					data.pid = data['add-to-cart'];

					delete data['add-to-cart'];
				}

				// AJAX add to cart
				$this.find( '.single_add_to_cart_button' ).blur();

				$.ajax( {
					type   : 'POST',
					url    : amelyConfigs.ajax_url,
					data   : data,
					success: function( response ) {

						if ( 'undefined' !== typeof response.fragments ) { // Successfull
							$text.text( amelyConfigs.added_to_cart_text );
							$loading.addClass( 'added' );

							$body.trigger( 'wc_fragment_refresh' );
							$body.trigger( 'wc_fragments_refreshed' );

							setTimeout( function() {
								$body.trigger( 'added_to_cart' );
							}, 500 );
						} else {
							$text.text( response.message );
							$loading.addClass( 'error' );

							$.growl.error( {
								location: 'tr',
								title   : '',
								size    : 'large',
								message : '<ul class="error">' + response.message + '</ul>'
							} );
						}

						$( '#woo-quick-view .summary' ).animate( { scrollTop: 0 }, 300 );

						$loading.delay( 3200 ).fadeOut();

						// Redirect to cart option
						if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
							window.location = wc_add_to_cart_params.cart_url;
						}
					},
					error  : function( error ) {

						$loading.delay( 3200 ).fadeOut();

						$.growl.error( {
							location: 'tr',
							title   : '',
							size    : 'large',
							message : '<ul class="error">Sorry, something went wrong. Please try again</ul>'
						} );

						console.log( error );
					},
				} );
			} );
		};

		var variationHandler = function() {

			$( 'select.isw-selectbox' ).niceSelect();

			var $form = $quickView.find( 'form.isw-swatches.variations_form' );

			$form.on( 'show_variation', function( e, variation ) {

				if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {

					var $carousel    = $( '.quick-view-carousel.slick-slider' ),
						$slide       = $carousel.find( 'img[src="' + variation.image.src + '"]:not(.slick-cloned):not(.first-image)' ),
						index        = $slide.attr( 'data-slick-index' ),
						$product_img = $carousel.find( '.first-image' );

					if ( $slide.length ) {

						// found the slide
						if ( $carousel.hasClass( 'slick-initialized' ) ) {
							$carousel.slick( 'slickGoTo', parseInt( index ) );
						}

						$product_img.wc_reset_variation_attr( 'src' );
						$product_img.wc_reset_variation_attr( 'width' );
						$product_img.wc_reset_variation_attr( 'height' );
						$product_img.wc_reset_variation_attr( 'srcset' );
						$product_img.wc_reset_variation_attr( 'sizes' );
						$product_img.wc_reset_variation_attr( 'title' );
						$product_img.wc_reset_variation_attr( 'alt' );
					} else {

						if ( $carousel.hasClass( 'slick-initialized' ) ) {
							$carousel.slick( 'slickGoTo', parseInt( 0 ) );
						}

						$product_img.wc_set_variation_attr( 'src', variation.image.src );
						$product_img.wc_set_variation_attr( 'height', variation.image.src_h );
						$product_img.wc_set_variation_attr( 'width', variation.image.src_w );
						$product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
						$product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
						$product_img.wc_set_variation_attr( 'title', variation.image.title );
						$product_img.wc_set_variation_attr( 'alt', variation.image.alt );
					}
				}
			} );
		}

		var reInitEvents = function() {

			// set maxHeight
			$quickView.find( '.summary' ).css( 'max-height', $quickView.find( '.woocommerce-main-image' )
																	   .attr( 'height' ) + 'px' );

			// perfectScrollbar
			$quickView.find( '.summary' ).perfectScrollbar( { suppressScrollX: true } );

			// re init swatches
			amely.reInitSwatches();

			// quantity field
			amely.quantityField();

			variationHandler();
		};

		events();
		initAddToCart();
	}
})( jQuery );

// Notification
(
	function( $ ) {

		var $body = $( 'body' );

		amely.notification = function() {

			var config = {
				location: 'tr',
				title   : '',
				size    : 'large',
			};

			var events = function() {

				$body.on( 'click', 'a.add_to_cart_button', function() {
					$( 'a.add_to_cart_button' ).removeClass( 'recent-added' );
					$( this ).addClass( 'recent-added' );

					if ( $( this ).is( '.product_type_variable, .isw-ready' ) ) {
						$( this ).addClass( 'loading' );
					}

				} );

				// On single product page
				$body.on( 'click', 'button.single_add_to_cart_button', function() {
					$( 'button.single_add_to_cart_button' ).removeClass( 'recent-added' );
					$( this ).addClass( 'recent-added' );
				} );

				$body.on( 'click', '.add_to_wishlist', function() {
					$( this ).addClass( 'loading' );
				} );
			};

			var addToCartNotification = function() {

				$body.on( 'added_to_cart', function() {

					$( '.add_to_cart_button.product_type_variable.isw-ready' ).removeClass( 'loading' );

					var $recentAdded = $( '.add_to_cart_button.recent-added, button.single_add_to_cart_button.recent-added' ),
						$img         = $recentAdded.closest( '.product-thumb' ).find( 'img.wp-post-image' ),
						pName        = $recentAdded.attr( 'data-product_name' );

					// if add to cart from wishlist
					if ( ! $img.length ) {
						$img = $recentAdded.closest( '.wishlist_item' )
										   .find( '.wishlist_item_product_image img' );
					}

					// if add to cart from single product page
					if ( ! $img.length ) {
						$img = $recentAdded.closest( '.summary' )
										   .prev()
										   .find( '.woocommerce-main-image img' );
					}

					// reset state after 5 sec
					setTimeout( function() {
						$recentAdded.removeClass( 'added' ).removeClass( 'recent-added' );
						$recentAdded.next( '.added_to_cart' ).remove();
					}, 5000 );

					if ( typeof pName == 'undefined' || pName == '' ) {
						pName = $recentAdded.closest( '.summary' ).find( '.product_title' ).text().trim();
					}

					if ( typeof pName !== 'undefined' ) {

						config['message'] = (
												$img.length ? '<img src="' + $img.attr( 'src' ) + '"' + ' alt="' + pName + '" class="growl-thumb" />' : ''
											) + '<p class="growl-content">' + pName + ' ' + amelyConfigs.added_to_cart_notification_text + '&nbsp;<a href="' + amelyConfigs.wc_cart_url + '">' + amelyConfigs.view_cart_notification_text + '</a></p>';

					} else {
						config['message'] =
							amelyConfigs.added_to_cart_text + '&nbsp;<a href="' + amelyConfigs.wc_cart_url + '">' + amelyConfigs.view_cart_notification_text + '</a>';
					}

					$.growl.notice( config );
				} );
			};

			var addToWishlistNotification = function() {

				$body.on( 'added_to_wishlist', function() {

					$( '#yith-wcwl-popup-message' ).remove();

					config['message'] =
						'<p class="growl-content">' + amelyConfigs.added_to_wishlist_text + '&nbsp;<a href="' + amelyConfigs.wishlist_url + '">' + amelyConfigs.browse_wishlist_text + '</a></p>';

					$.growl.notice( config );
				} );
			};

			events();

			if ( amelyConfigs.shop_add_to_cart_notification_on ) {
				addToCartNotification();
			}

			if ( amelyConfigs.shop_wishlist_notification_on ) {
				addToWishlistNotification();
			}
		}
	}
)( jQuery );

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

// AJAX add to cart on single product page & quick view window
(function( $ ) {

		var $document = $( document ),
			$body     = $( 'body' );

		amely.ajaxAddToCart = function() {

			if ( wc_add_to_cart_params.cart_redirect_after_add === 'yes' ) {
				return;
			}

			$body.on( 'click', '.product .summary.ajax-add-to-cart .single_add_to_cart_button', function() {

				var $button = $( this );

				if ( $button.hasClass( 'product_type_variable' ) ) {
					return true;
				}

				if ( $button.closest( '.product-type-external' ).length ) {
					return true;
				}

				if ( $button.hasClass( 'disabled' ) || $button.hasClass( 'wc-variation-selection-needed' ) || $button.hasClass( 'wc-variation-is-unavailable' ) ) {
					return false;
				}

				if ( $document.data( 'processing' ) === 1 ) {
					return false;
				}

				$document.data( 'processing', 1 );
				$document.data( 'processing_once', 0 );

				var $form              = $button.closest( 'form.cart' ),
					buttonDefaultCusor = $button.css( 'cursor' ),
					data               = $.parseParams( $form.serialize() );

				// add data if product is a single product
				if ( ! $form.hasClass( 'variations_form' ) && ! $form.find( '.group_table' ).length ) {
					data['add-to-cart'] = $form.find( 'button[name="add-to-cart"]' ).val();
				}

				$body.css( 'cursor', 'wait' );
				$button.css( 'cursor', 'wait' ).blur().addClass( 'loading' );

				$.ajax( {
					type   : 'POST',
					url    : $form.attr( 'action' ),
					data   : data,
					success: function( response ) {

						if ( $( response ).find( '.woocommerce-error' ).length > 0 ) {
							appendMessageDiv( response, 'woocommerce-error' );

							$.growl.error( {
								location: 'tr',
								title   : '',
								size    : 'large',
								message : '<ul class="error">' + $( '.woocommerce-error' )
									.html() + '</ul>'
							} );
						} else if ( $( response ).find( '.woocommerce-message' ).length > 0 ) {
							appendMessageDiv( response, 'woocommerce-message' );

							$body.trigger( 'added_to_cart' );
							$body.trigger( 'wc_fragment_refresh' );
						}

						$document.data( 'processing_once', 1 );

						// reset cursor
						$body.css( 'cursor', 'default' );
						$button.css( 'cursor', buttonDefaultCusor ).removeClass( 'loading' );
					},
					error  : function( error ) {
						console.log( error );

						$document.data( 'processing_once', 1 );
						$document.data( 'processing', 0 );
						$button.removeClass( 'loading' );
					},
				} );

				return false;
			} );

			var isElementInViewport = function( $el ) {

				if ( ! $el.length ) {
					return true;
				}

				var rect = $el[0].getBoundingClientRect();

				return (
					rect.top >= 0 && rect.left >= 0 && rect.bottom <= (
						window.innerHeight || document.documentElement.clientHeight
					) && rect.right <= (
						window.innerWidth || document.documentElement.clientWidth
					)
				);
			};

			var getMessageParentDiv = function( response, woocommerce_msg ) {

				var $product = $( '.main-container>.site-content>.product.type-product:eq(0)' ),
					$result;

				if ( $product.length > 0 ) {
					$result = $product;
				} else {

					var id = $( response ).find( '.' + woocommerce_msg ).parent().attr( 'id' );

					if ( id ) {
						$result = $( '#' + id ).children().eq( $( '#' + id ).children().length - 1 );
					} else {
						var classes = $( response ).find( '' + woocommerce_msg ).parent().attr( 'class' );
						$result = $document.find( "div[class='" + classes + "']" )
										   .children()
										   .eq( $document.find( "div[class='" + classes + "']" )
														 .children().length - 1 );
					}
				}

				return $result.find( '>.container>.row>.col-xs-12>.row' );
			};

			var appendMessageDiv = function( response, woocommerce_msg ) {

				var divToInsert = getMessageParentDiv( response, woocommerce_msg ),
					message     = '.' + woocommerce_msg;

				$document.find( '.woocommerce-error' ).remove();
				$document.find( '.woocommerce-message' ).remove();

				$( divToInsert )
					.before( $( response ).find( message ).wrap( '<div>' ).parent().html() )
					.fadeIn();

				var isInViewport = isElementInViewport( $document.find( message ) );

				if ( ! isInViewport ) {

					var scrollTo = $( message ).offset().top;

					if ( amelyConfigs.sticky_header ) {
						scrollTo -= $( '.sticky-header' ).height();
					}

					$( 'html, body' ).animate( {
						scrollTop: scrollTo - 50
					}, 500 );
				}

				$document.data( 'processing', 0 );
			};
		};
	})( jQuery );

// AJAX load more post / product
(
	function( $ ) {

		amely.ajaxLoadMore = function() {

			var $switcherFiveColumns  = $( '.ti-layout-grid4-alt' ),
				$switcherFourColumns  = $( '.ti-layout-grid3-alt' ),
				$switcherThreeColumns = $( '.ti-layout-grid2-alt' ),
				$columnSwitcher       = amelyConfigs.categories_columns,
				$activeCol            = $( '.col-switcher' ).find( '.active' ),
				$col                  = $activeCol.attr( 'data-col' );

			if ( $col == 5 ) {
				$columnSwitcher = 5;
			}

			if ( $col == 4 ) {
				$columnSwitcher = 4;
			}

			if ( $col == 3 ) {
				$columnSwitcher = 3;
			}

			$switcherFiveColumns.on( 'click', function( e ) {
				e.preventDefault();
				$columnSwitcher = 5;
			} );

			$switcherFourColumns.on( 'click', function( e ) {
				e.preventDefault();
				$columnSwitcher = 4;
			} );

			$switcherThreeColumns.on( 'click', function( e ) {
				e.preventDefault();
				$columnSwitcher = 3;
			} );
			var	_loadMoreBtns = [].slice.call( document.querySelectorAll( '.amely-loadmore-btn' ) ),
				   loading       = false,
				   loadPosts     = function( _el ) {

					   var _loadMoreWrap  = _el.parentNode,
						   atts           = JSON.parse( _loadMoreWrap.getAttribute( 'data-atts' ) ),
						   paged          = parseInt( atts.paged ),
						   btn_columns    = parseInt( atts.columns ),
						   posts_per_page = parseInt( atts.posts_per_page ),
						   view           = atts.view,
						   _wrapContainer = document.querySelector( atts.container ),
						   pAttr          = JSON.parse( _wrapContainer.getAttribute( 'data-atts' ) ),
						   filter  		  = _loadMoreWrap.getAttribute( 'data-filter' ),
						   data           = {
							   action        : 'amely_ajax_load_more',
							   post_type     : atts.post_type,
							   posts_per_page: posts_per_page,
							   view          : view,
							   offset        : posts_per_page * paged,
							   columns       : btn_columns ? btn_columns : $columnSwitcher,
							   category      : filter,
							   exclude       : [],
						   };


					   var _wrapper = null;

					   if ( atts.post_type == 'post' ) {

						   if ( _loadMoreWrap.classList.contains( 'amely-pagination' ) ) {
							   _wrapper = _wrapContainer;
						   } else {
							   _wrapper = _wrapContainer.querySelector( '.posts' );
						   }
					   }

					   if ( atts.post_type == 'product' ) {

						   if ( _loadMoreWrap.classList.contains( 'woocommerce-pagination' ) ) {
							   _wrapper = _wrapContainer;
						   } else {
							   _wrapper = _wrapContainer.querySelector( '.products' );
						   }
					   }

					   if ( _wrapper == null || _loadMoreWrap.classList.contains( 'hidden' ) ) {
						   return;
					   }

					   if ( atts.post_type == 'post' ) {

						   if ( pAttr != null ) {

							   data.filter = pAttr.filter;
							   data.columns = pAttr.columns;

							   if ( pAttr.filter == 'category' ) {
								   data.cat_slugs = pAttr.cat_slugs;
							   }

							   if ( pAttr.filter == 'tag' ) {
								   data.tag_slugs = pAttr.tag_slugs;
							   }

							   if (atts.orderby !== null) {
								   data.orderby = pAttr.orderby;
							   }

							   if (atts.order !== null) {
								   data.order = pAttr.order;
							   }
						   }
					   }

					   if ( atts.post_type == 'product' ) {

						   if ( pAttr == null ) { // on product category page
							   if ( atts.data_source == null ) {
								   data.data_source = 'recent_products';
							   } else {
								   data.data_source = atts.data_source;
								   data.category = atts.category;
								   data.include_children = true;
							   }

							   if ( atts.data_source == 'categories' ) {
								   data.data_source = atts.data_source;
								   data.category = atts.category;
								   data.include_children = true;
							   }

							   if ( atts.data_source == 'filter' ) {
								   data.data_source = atts.data_source;
								   data.tax_array = atts.tax_array;
							   }

							   if (atts.orderby !== null) {
								   data.orderby = atts.orderby;
							   }

							   if (atts.order !== null) {
								   data.order = atts.order;
							   }

						   } else {

							   data.data_source = pAttr.data_source;

							   if ( pAttr.data_source == 'product_attribute' ) {
								   data.attribute = pAttr.attribute;
								   data.filter = pAttr.filter;
							   }

							   if ( pAttr.data_source == 'categories' ) {
								   data.product_cat_slugs = pAttr.product_cat_slugs;
								   data.include_children = pAttr.include_children == 'yes';
							   }

							   if ( pAttr.data_source == 'category' ) {
								   data.category = _loadMoreWrap.getAttribute( 'data-filter' );
								   data.include_children = pAttr.include_children == 'yes';
							   }

							   if (pAttr.orderby !== null) {
								   data.orderby = pAttr.orderby;
							   }

							   if (pAttr.order !== null) {
								   data.order = pAttr.order;
							   }
						   }
					   }

					   	//exclude queried posts
						var className = '.product-loop';

						if (atts.post_type === 'post') {
							var className = '.post-item';
						}

						var _posts = [].slice.call( _wrapper.querySelectorAll( className ) );

						_posts.forEach( function ( post ) {
						    var productID = post.className.match(/post-\d+/gi)[0];
						    productID     = productID.replace('post-', '');

						    data.exclude.push(productID);
						});

					   $.ajax( {
						   method    : 'POST',
						   url       : amelyConfigs.ajax_url,
						   data      : data,
						   beforeSend: function() {
							   loading = true;
							   _loadMoreWrap.classList.add( 'loading' );
						   },
						   success   : function( response ) {

							   if ( response ) {

								   var iso = Isotope.data( _wrapper );

								   $( _wrapper ).append( $( response ) );

								   imagesLoaded( _wrapper, function() {

									   var _items = [].slice.call( _wrapper.querySelectorAll( '.adding-item' ) ),
										   gridFx = new GridLoaderFx( _wrapper, '.adding-item' );

									   if ( atts.post_type == 'post' ) {
										   amely.fitVideo();
										   amely.thumbGallery();
									   }

									   if ( atts.post_type == 'product' ) {
										   amely.reInitSwatches();
									   }

									   if ( iso != null ) {
										   _items.forEach( function( item ) {
											   iso.appended( item );
										   } );
									   }

									   gridFx._render( 'Amun' );

									   _items.forEach( function( item ) {
										   item.classList.remove( 'adding-item' );
									   } );

									   if ( _items.length < posts_per_page ) {
										   _loadMoreWrap.classList.add( 'hidden' );
									   }

									   var c = $(_loadMoreWrap).parent();
									   var a = c.find('.product-filter li a.active').attr('data-page');
									   var k = a ++;
									   if( a ){
									   	atts.paged = a;
									   }else{
									   	atts.paged++;
									   }

									   c.find('.product-filter li a.active').attr('data-page', a);
									   _loadMoreWrap.setAttribute( 'data-atts', JSON.stringify( atts ) );
								   } );

							   } else {
								   _loadMoreWrap.classList.add( 'hidden' );
							   }

							   _loadMoreWrap.classList.remove( 'loading' );
							   loading = false;
						   },
						   error     : function( error ) {
							   console.log( error );
						   }
					   } );
				   };

			_loadMoreBtns.forEach( function( _btn ) {

				_btn.addEventListener( 'click', function( e ) {
					e.preventDefault();

					loadPosts( _btn );
				} );

				if ( _btn.classList.contains( 'load-on-scroll' ) ) {

					var _loadMoreWrap = _btn.parentNode;

					$( window ).on( 'scroll', function() {

						if ( $( '.amely-loadmore-wrap' ).length ) {

							if ( $( _loadMoreWrap ).offset().top <= $( this ).scrollTop() + $( this )
									.height() && ! loading ) {
								loadPosts( _btn );
							}
						}
					} )
				}

			} );
		};

	}
)( jQuery );

// Single Product Page
(function( $ ) {

	var $window = $( window ),
		$body   = $( 'body' );

	amely.product = function() {

		if ( ! document.body.classList.contains( 'single-product' ) ) {
			return;
		}

		var _productGallery   = document.querySelector( '.woocommerce-product-gallery' ),
			_mainImageSlider  = document.querySelector( '.woocommerce-product-gallery__slider' ),
			_thumbnailsSlider = document.querySelector( '.thumbnails-slider' );

		var mainImageSlider = function() {

			if ( amelyConfigs.product_page_layout == 'sticky' || amelyConfigs.product_page_layout == 'sticky-fullwidth' ) {
				return;
			}

			if ( $( _mainImageSlider ).attr( 'data-carousel' ) == null ) {
				$( _mainImageSlider ).css( {
					'opacity'   : 1,
					'visibility': 'visible'
				} );
				return;
			}

			if ( _productGallery.classList.contains( 'only-featured-image' ) ) {

				var _zoomTarget = _mainImageSlider.querySelector( '.woocommerce-product-gallery__image' );
				$( _zoomTarget ).trigger( 'zoom.destroy' );

				return;
			}

			var settings = JSON.parse( _mainImageSlider.getAttribute( 'data-carousel' ) );

			$( _mainImageSlider ).slick( settings );
		};

		var mainImageZoom = function() {

			if ( _productGallery.classList.contains( 'only-featured-image' ) ) {
				//return;
			}

			if ( _productGallery.classList.contains( 'product-zoom-on' ) ) {

				var _zoomTarget  = $( '.woocommerce-product-gallery__image' ),
					_imageToZoom = _zoomTarget.find( 'img' );

				// But only zoom if the img is larger than its container.
				if ( _imageToZoom.attr( 'data-large_image_width' ) > _productGallery.offsetWidth ) {
					_zoomTarget.trigger( 'zoom.destroy' );
					_zoomTarget.zoom( {
						touch: false
					} );
				}
			}
		};

		var thumbnailsSlider = function() {

			if ( amelyConfigs.product_page_layout == 'sticky' || amelyConfigs.product_page_layout == 'sticky-fullwidth' ) {
				return;
			}

			if ( ! _thumbnailsSlider ) {
				return;
			}

			var settings = JSON.parse( _thumbnailsSlider.getAttribute( 'data-carousel' ) );

			settings.responsive = [{
				breakpoint: 768,
				settings  : {
					slidesToShow   : 4,
					vertical       : false,
					verticalSwiping: false,
					arrows         : false,
					dots           : true,
				},
			}];

			$( _thumbnailsSlider ).slick( settings );

			[].slice.call( _thumbnailsSlider.querySelectorAll( 'a.slick-slide' ) ).forEach( function( _slide ) {
				_slide.addEventListener( 'click', function( e ) {
					e.preventDefault();
				} );
			} );
		};

		var lightBoxHandler = function() {

			$( _productGallery ).off( 'click', '.woocommerce-product-gallery__image a' );

			$( _productGallery ).on( 'click', '.lightbox-btn, .woocommerce-product-gallery__image a', function( e ) {

				e.preventDefault();

				openPhotoSwipe( getImageIndex( e ) );
			} );
		}

		var variationHandler = function() {

			var $form = $( 'form.isw-swatches.variations_form' );

			if ( amelyConfigs.product_page_layout == 'sticky' || amelyConfigs.product_page_layout == 'sticky-fullwidth' ) {
				return;
			}

			$form.on( 'show_variation', function( e, variation ) {

				if ( variation && variation.image && variation.image.src && variation.image.src.length > 1 ) {

					var $slide            = $( _mainImageSlider )
							.find( '.woocommerce-product-gallery__image[data-thumb="' + variation.image.thumb_src + '"]:not(.slick-cloned)' ),
						index             = $slide.index( '.woocommerce-product-gallery__image:not(.slick-cloned)' ),
						$product_img_wrap = $( _productGallery )
							.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' )
							.eq( 0 ),
						$product_img      = $( _productGallery.querySelector( '.wp-post-image' ) ),
						$product_link     = $product_img_wrap.find( 'a' ).eq( 0 );

					if ( $slide.length ) {

						// found the slide
						if ( $( _mainImageSlider ).hasClass( 'slick-initialized' ) ) {
							$( _mainImageSlider ).slick( 'slickGoTo', parseInt( index ) );
						}

						// reset image
						$product_img.wc_reset_variation_attr( 'src' );
						$product_img.wc_reset_variation_attr( 'width' );
						$product_img.wc_reset_variation_attr( 'height' );
						$product_img.wc_reset_variation_attr( 'srcset' );
						$product_img.wc_reset_variation_attr( 'sizes' );
						$product_img.wc_reset_variation_attr( 'title' );
						$product_img.wc_reset_variation_attr( 'alt' );
						$product_img.wc_reset_variation_attr( 'data-src' );
						$product_img.wc_reset_variation_attr( 'data-large_image' );
						$product_img.wc_reset_variation_attr( 'data-large_image_width' );
						$product_img.wc_reset_variation_attr( 'data-large_image_height' );
						$product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
						$product_link.wc_reset_variation_attr( 'href' );
					} else {

						if ( $( _mainImageSlider ).hasClass( 'slick-initialized' ) ) {
							$( _mainImageSlider ).slick( 'slickGoTo', parseInt( 0 ) );
						}

						// change the main image if the slider is not found
						$product_img.wc_set_variation_attr( 'src', variation.image.src );
						$product_img.wc_set_variation_attr( 'height', variation.image.src_h );
						$product_img.wc_set_variation_attr( 'width', variation.image.src_w );
						$product_img.wc_set_variation_attr( 'srcset', variation.image.srcset );
						$product_img.wc_set_variation_attr( 'sizes', variation.image.sizes );
						$product_img.wc_set_variation_attr( 'title', variation.image.title );
						$product_img.wc_set_variation_attr( 'alt', variation.image.alt );
						$product_img.wc_set_variation_attr( 'data-src', variation.image.full_src );
						$product_img.wc_set_variation_attr( 'data-large_image', variation.image.full_src );
						$product_img.wc_set_variation_attr( 'data-large_image_width', variation.image.full_src_w );
						$product_img.wc_set_variation_attr( 'data-large_image_height', variation.image.full_src_h );
						$product_img_wrap.wc_set_variation_attr( 'data-thumb', variation.image.thumb_src );
						$product_link.wc_set_variation_attr( 'href', variation.image.full_src );
					}
				}
			} );

			$form.on( 'reset_data', function() {

				var $product_img_wrap = $( _productGallery )
						.find( '.woocommerce-product-gallery__image, .woocommerce-product-gallery__image--placeholder' )
						.eq( 0 ),
					$product_img      = $( _productGallery.querySelector( '.wp-post-image' ) ),
					$product_link     = $product_img_wrap.find( 'a' ).eq( 0 ),
					variations        = $( '.variations' ).find( 'tr' ).length,
					$selects          = $form.find( 'select' ),
					chosen_count      = 0;

				$selects.each( function() {

					var value = $( this ).val() || '';

					if ( value.length ) {
						chosen_count ++;
					}
				} );

				if ( variations > 1 && chosen_count == variations ) {
					$( _mainImageSlider ).slick( 'slickGoTo', 0 );
				}

				// reset image
				$product_img.wc_reset_variation_attr( 'src' );
				$product_img.wc_reset_variation_attr( 'width' );
				$product_img.wc_reset_variation_attr( 'height' );
				$product_img.wc_reset_variation_attr( 'srcset' );
				$product_img.wc_reset_variation_attr( 'sizes' );
				$product_img.wc_reset_variation_attr( 'title' );
				$product_img.wc_reset_variation_attr( 'alt' );
				$product_img.wc_reset_variation_attr( 'data-src' );
				$product_img.wc_reset_variation_attr( 'data-large_image' );
				$product_img.wc_reset_variation_attr( 'data-large_image_width' );
				$product_img.wc_reset_variation_attr( 'data-large_image_height' );
				$product_img_wrap.wc_reset_variation_attr( 'data-thumb' );
				$product_link.wc_reset_variation_attr( 'href' );
			} );
		}

		var openPhotoSwipe = function( index ) {

			var pswpElement = document.querySelectorAll( '.pswp' )[0];

			// build item array
			var items = getImages();

			if ( $( 'body' ).hasClass( 'rtl' ) ) {
				index = items.length - index - 1;
				items = items.reverse();
			}

			var options = {
				history              : false,
				showHideOpacity      : true,
				hideAnimationDuration: 333,
				showAnimationDuration: 333,
				index                : index
			};

			var gallery = new PhotoSwipe( pswpElement, PhotoSwipeUI_Default, items, options );
			gallery.init();
		};

		var getImages = function() {

			var items = [];

			[].slice.call( _mainImageSlider.querySelectorAll( 'a > img' ) )
			  .forEach( function( _img ) {

				  var src    = _img.getAttribute( 'data-large_image' ),
					  width  = _img.getAttribute( 'data-large_image_width' ),
					  height = _img.getAttribute( 'data-large_image_height' );

				  if ( ! $( _img ).closest( '.woocommerce-product-gallery__image' ).hasClass( 'slick-cloned' ) ) {

					  items.push( {
						  src  : src,
						  w    : width,
						  h    : height,
						  title: false
					  } );
				  }

			  } );

			return items;
		};

		var getImageIndex = function( e ) {

			if ( _mainImageSlider.classList.contains( 'slick-slider' ) ) {
				return parseInt( _mainImageSlider.querySelector( '.slick-current' )
												 .getAttribute( 'data-slick-index' ) );
			} else {
				return $( e.currentTarget ).parent().index();
			}
		};

		var scrollToReviews = function() {

			if ( ! $( '#reviews' ).length ) {
				return;
			}

			$body.on( 'click', '.woocommerce-review-link', function( e ) {

				e.preventDefault();

				var scrollTo = $( '#reviews' ).offset().top;

				if ( amelyConfigs.sticky_header ) {
					scrollTo -= $( '.sticky-header' ).outerHeight() + $( '.woocommerce-Reviews-title' )
						.outerHeight( true );
				}

				$( 'html, body' ).animate( {
					scrollTop: scrollTo,
				}, 600 );
			} );
		};

		var upSellsandRelated = function() {

			if ( $( '.upsells .products' ).find( '.product' ).length < 4 && $( '.related .products' )
																				.find( '.product' ).length < 4 ) {
				return;
			}

			$( '.upsells .products, .related .products' ).slick( {
				slidesToShow  : 4,
				slidesToScroll: 4,
				dots          : true,
				responsive    : [{
					breakpoint: 992,
					settings  : {
						slidesToShow  : 3,
						slidesToScroll: 3,
					},
				}, {
					breakpoint: 768,
					settings  : {
						slidesToShow  : 2,
						slidesToScroll: 2,
					},
				}, {
					breakpoint: 544,
					settings  : {
						dots          : false,
						adaptiveHeight: true,
						centerPadding : '40px',
						centerMode    : true,
						slidesToShow  : 1,
						slidesToScroll: 1,
					},
				},],
			} );
		};

		// sticky details product page
		var stickyDetails = function() {

			var $details = $( '.sticky-row .entry-summary' );

			$body.trigger( 'sticky_kit:recalc' );

			if ( $window.width() < 992 ) {
				return;
			}

			if ( ! $details.length ) {
				return;
			}

			var rect = _productGallery.getBoundingClientRect(),
				left = rect.right,
				top  = 60;

			if ( $( '#wpadminbar' ).length ) {
				top += $( '#wpadminbar' ).height();
			}

			if ( $( '.sticky-header' ).length ) {
				top += $( '.sticky-header' ).height();
			}

			$details.stick_in_parent( { offset_top: top } ).on( 'sticky_kit:stick', function() {
				$( this ).removeClass( 'sticky_kit-bottom' ).css( {
					'left': left,
					'top' : top,
				} );
			} ).on( 'sticky_kit:unstick', function() {
				$( this ).removeClass( 'sticky_kit-bottom' ).css( {
					'left': 'auto',
					'top' : 'auto',
				} );
			} ).on( 'sticky_kit:bottom', function() {
				$( this ).addClass( 'sticky_kit-bottom' ).css( {
					'left': $( _productGallery ).outerWidth(),
				} );
			} ).on( 'sticky_kit:unbottom', function() {
				$( this ).removeClass( 'sticky_kit-bottom' ).css( {
					'left': left,
					'top' : top,
				} );
			} );
		};

		mainImageSlider();
		mainImageZoom();
		thumbnailsSlider();
		lightBoxHandler();
		variationHandler();
		upSellsandRelated();
		scrollToReviews();
		stickyDetails();

		$window.scroll( function() {

			var viewportHeight = $( window ).height();

			$( _productGallery ).find( '.thumbnails > a' ).each( function() {
				var offsetThumbnails = $( this ).offset().top;

				if ( $window.scrollTop() > offsetThumbnails - viewportHeight + 20 ) {

					$( this ).addClass( 'animate-images' );
				}

			} );
		} );

		$window.on( 'resize', function() {
			stickyDetails();
		} );
	};

	amely.crossSells = function() {

		if ( $( '.cross-sells .products' ).find( '.product' ).length < 4 ) {
			return;
		}

		$( '.cross-sells .products' ).slick( {
			slidesToShow  : 4,
			slidesToScroll: 4,
			dots          : true,
			responsive    : [{
				breakpoint: 992,
				settings  : {
					slidesToShow  : 3,
					slidesToScroll: 3,
					infinite      : true,
				},
			}, {
				breakpoint: 768,
				settings  : {
					slidesToShow  : 2,
					slidesToScroll: 2,
				},
			}, {
				breakpoint: 544,
				settings  : {
					dots          : false,
					adaptiveHeight: true,
					centerMode    : true,
					centerPadding : '40px',
					slidesToShow  : 1,
					slidesToScroll: 1,
				},
			},],
		} );
	};

})( jQuery );

// Swatches
(function( $ ) {

		var $body = $( 'body' );

		amely.swatches = function() {

			// on single product page
			$( 'form.isw-swatches.variations_form' ).on('woocommerce_update_variation_values', function() {
				$( 'select.isw-selectbox' ).niceSelect( 'update' );
			});

			$body.on( 'isw_change_add_to_cart_button_text', function() {

				var text    = '',
					$button = $( '.add_to_cart_button' );

				if ( $button.hasClass( 'isw-ready' ) ) {
					text = isw_vars.localization['add_to_cart_text'];
				} else {

					if ( $button.hasClass( 'isw-readmore' ) ) {
						text = isw_vars.localization['read_more_text'];
					} else {
						text = isw_vars.localization['select_options_text'];
					}
				}

				$button.parent().attr( 'aria-label', text );

				// if product doesn't have price
				if ( $( '.add_to_cart_button.isw-text-changed' )
						 .closest( '.product-loop' )
						 .find( '.price:not(.price-cloned)' )
						 .text().length == 0 ) {
					text = isw_vars.localization['read_more_text'];

					$( '.add_to_cart_button.isw-text-changed' )
						.removeClass( 'isw-ready' )
						.text( text )
						.parent()
						.attr( 'aria-label', text );
				}
			} );

			$body.on( 'isw_reset_add_to_cart_button_text', function() {

				$( '.add_to_cart_button.isw-text-changed' )
					.parent()
					.attr( 'aria-label', isw_vars.localization['select_options_text'] );
			} );
		};

		amely.reInitSwatches = function() {

			if ( typeof isw != 'undefined' && typeof isw.Swatches !== 'undefined' ) {
				isw.Swatches.init();
			}
		};
	})( jQuery );

(
	function( $ ) {

		var $document = $( document );

		amely.quantityField = function() {

			var build = function() {
				$( 'div.quantity:not(.amely_qty):not(.hidden), td.quantity:not(.amely_qty):not(.hidden)' )
					.addClass( 'amely_qty' )
					.append( '<span class="plus">+</span>' )
					.prepend( '<span class="minus">-</span>' );

				$( 'input.qty:not(.product-quantity input.qty)' ).each( function() {
					var min = parseFloat( $( this ).attr( 'min' ) );

					if ( min && min > 0 && parseFloat( $( this ).val() ) < min ) {
						$( this ).val( min );
					}
				} );

				$( '.plus, .minus' ).unbind( 'click' ).on( 'click', function() {

					// Get values
					var $qty = $( this ).closest( '.quantity' ).find( '.qty' ),
						currentVal = parseFloat( $qty.val() ),
						max        = parseFloat( $qty.attr( 'max' ) ),
						min        = parseFloat( $qty.attr( 'min' ) ),
						step       = $qty.attr( 'step' );

					// Format values
					if ( ! currentVal || currentVal === '' || currentVal === 'NaN' ) {
						currentVal = 0;
					}
					if ( max === '' || max === 'NaN' ) {
						max = '';
					}
					if ( min === '' || min === 'NaN' ) {
						min = 0;
					}
					if ( step === 'any' || step === '' || step === undefined || parseFloat( step ) === 'NaN' ) {
						step = 1;
					}

					// Change the value
					if ( $( this ).is( '.plus' ) ) {

						if ( max && (
								max == currentVal || currentVal > max
							) ) {
							$qty.val( max );
						} else {
							$qty.val( currentVal + parseFloat( step ) );
						}

					} else {

						if ( min && (
								min == currentVal || currentVal < min
							) ) {
							$qty.val( min );
						} else if ( currentVal > 0 ) {
							$qty.val( currentVal - parseFloat( step ) );
						}

					}

					// Trigger change event
					$qty.trigger( 'change' );
				} );
			};

			build();

			$document.ajaxComplete( function() {
				build();
			} );
		};
	}
)( jQuery );

(
	function( $ ) {

		amely.cookie = function() {

			if ( Cookies.get( 'amely_cookie_notice_accepted' ) == 'yes' ) {
				return;
			}

			var $cookieWrapper = $( '.cookie-wrapper' ),
				expires        = parseInt( $cookieWrapper.attr( 'data-expires' ) );

			setTimeout( function() {

				$cookieWrapper.addClass( 'animated fadeInUp' );

				$cookieWrapper.on( 'click', '.cookie-accept-btn', function( e ) {

					e.preventDefault();
					$cookieWrapper.removeClass( 'fadeInUp' ).addClass( 'fadeOutDown' );
					acceptCookie( expires );
				} );
			}, 500 );

			var acceptCookie = function( expires ) {
				Cookies.set( 'amely_cookie_notice_accepted', 'yes', {
					expires: expires,
					path   : '/'
				} );
			};
		};
	}
)( jQuery );

// integrate with WooCommerce Brand Pro plugin
(function( $ ) {

	var $body = $( 'body' );

	amely.brand = function() {

		var brandFilter = function( $el ) {

			if ( typeof $el == 'undefined' || ! $el.length ) {
				return;
			}

			var clazz = $el.attr( 'id' );

			$el.select2( {
				templateResult: function( str ) {

					if ( ! str.id ) {
						return str.text;
					}

					return $( '<span>' + str.text + '</span>' );
				},
			} );

			$el.next( '.select2' ).on( 'mousedown', function() {
				$( '#select2-' + clazz + '-results' ).perfectScrollbar();
			} );
		};

		brandFilter( $( 'select#pw_brand_category_filter' ) );
		brandFilter( $( 'select#pw_brand_category_filter_product' ) );

		var events = function() {

			$( '.wb-wb-allview-letters' ).unbind( 'click' ).on( 'click', function( e ) {
				e.preventDefault();

				//get the full url - like mysitecom/index.htm#home
				var full_url = this.href;

				//split the url by # and get the anchor target name - home in mysitecom/index.htm#home
				var parts    = full_url.split( "#" ),
					trgt     = parts[1],
					aTag     = $( "div[id='" + trgt + "" ),
					scrollTo = aTag.offset().top;

				if ( amelyConfigs.sticky_header ) {
					scrollTo -= $( '.sticky-header' ).height();
				}

				if ( $( '#wpadminbar' ).length && $( '#wpadminbar' ).css( 'position' ) == 'fixed' ) {
					scrollTo -= $( '#wpadminbar' ).height();
				}

				$body.animate( {
					scrollTop: scrollTo
				}, 600 );
			} );

			// Add go top link for Brand List shortcode
			var $allviewCat = $( '.wb-allview-amely' ).find( '.wb-allview-cat-cnt' );

			$allviewCat.each( function() {
				$( this )
					.append( '<a class="go-to-filter" href="#">' + amelyConfigs.go_to_filter_text + '</a>' );
			} );

			$( '.go-to-filter' ).on( 'click', function( e ) {
				e.preventDefault();

				var scrollTo = $( '.wb-allview-formcnt' ).offset().top - 30;

				if ( amelyConfigs.sticky_header ) {
					scrollTo -= $( '.sticky-header' ).height();
				}

				if ( $( '#wpadminbar' ).length && $( '#wpadminbar' ).css( 'position' ) == 'fixed' ) {
					scrollTo -= $( '#wpadminbar' ).height();
				}

				$body.animate( {
					scrollTop: scrollTo
				}, 600 );
			} );
		};

		events();
		brandFilter();

		var brandsCarousel = function() {

			$( '.amely-brands-carousel' ).each( function() {

				var $this = $( this ),
					atts  = JSON.parse( $this.attr( 'data-atts' ) );

				if ( atts == null ) {
					return;
				}

				if ( typeof atts.auto_play_speed === 'undefined' || isNaN( atts.auto_play_speed ) ) {
					atts.auto_play_speed = 5;
				}

				var configs = {
					accessibility : false,
					slidesToShow  : parseInt( atts.number ),
					slidesToScroll: 1,
					infinite      : (
						atts.loop == 'yes'
					),
					autoplay      : (
						atts.auto_play == 'yes'
					),
					autoplaySpeed : parseInt( atts.auto_play_speed ) * 1000,
					adaptiveHeight: true,
					speed         : 1000,
					responsive    : [{
						breakpoint: 992,
						settings  : {
							slidesToShow  : 2,
							slidesToScroll: 2,
						},
					}, {
						breakpoint: 544,
						settings  : {
							arrows        : true,
							dots          : false,
							adaptiveHeight: true,
							slidesToShow  : 1,
							slidesToScroll: 1,
						},
					},],
				};

				if ( ! atts.nav_type ) {
					configs.arrows = false;
					configs.dots = false;
				} else {
					if ( atts.nav_type == 'dots' ) {
						configs.arrows = false;
						configs.dots = true;
					}
					if ( atts.nav_type == 'both' ) {
						configs.arrows = true;
						configs.dots = true;
					}
				}

				if ( parseInt( atts.number_of_images_to_show ) == 1 ) {
					configs.responsive = [{
						breakpoint: 992,
						settings  : {
							adaptiveHeight: true,
							slidesToShow  : 1,
							slidesToScroll: 1,
						},
					}, {
						breakpoint: 544,
						settings  : {
							arrows        : true,
							dots          : false,
							adaptiveHeight: true,
							slidesToShow  : 1,
							slidesToScroll: 1,
						},
					},];
				}

				$this.slick( configs );
				$this.slick( 'setPosition' );
			} );
		}

		brandsCarousel();
	};
})( jQuery );

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

// Calculate overlay for instagram image
(function() {

	amely.instagram = function() {

		var overlaySize = function() {
			[].slice.call( document.querySelectorAll( '.tm-instagram-pics' ) ).forEach( function( _instagram ) {

				[].slice.call( _instagram.querySelectorAll( '.item' ) ).forEach( function( _item ) {

					var _overlay = _item.querySelector( '.overlay' ),
						_img     = _item.querySelector( '.item-image' );

					setTimeout( function() {

						_overlay.style.width = _img.getBoundingClientRect().width + 'px';
						_overlay.style.height = _img.getBoundingClientRect().height + 'px';
					}, 500 );
				} );
			} );
		}

		overlaySize();

		window.addEventListener('resize', function() {
			overlaySize();
		});
	};
})( jQuery );

// Mailchimp
(function( $ ) {

	amely.mailchimpSubscribe = function() {

		var _forms = [].slice.call( document.querySelectorAll( '.amely-mailchimp .mailchimp-form' ) );

		_forms.forEach( function( _form ) {

			_form.addEventListener( 'submit', function( e ) {

				e.preventDefault();

				_form.classList.add( 'mailchimp-loading' );

				var _message = _form.parentNode.querySelector( '.mailchimp-message' );

				_message.innerHTML = '';
				_message.classList.remove( 'success' );
				_message.classList.remove( 'error' );

				$.ajax( {
					url    : amelyConfigs.ajax_url,
					type   : 'POST',
					data   : {
						action : 'amely_ajax_subscribe',
						email  : _form.querySelector( '.mailchimp-email' ).value,
						list_id: _form.querySelector( '.mailchimp-list-id' ).value, //optin  : true
					},
					success: function( res ) {

						if (res) {

							var response = JSON.parse( res );

							_message.innerHTML = response.message;
							_message.classList.add( response.action_status ? 'success' : 'error' );
						}

						_form.classList.remove( 'mailchimp-loading' );
					}
				} );
			} );
		} );

	};
})( jQuery );

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
