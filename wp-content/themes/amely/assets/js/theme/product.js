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
