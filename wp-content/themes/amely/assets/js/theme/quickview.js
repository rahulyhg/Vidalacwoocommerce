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
