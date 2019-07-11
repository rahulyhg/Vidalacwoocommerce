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
