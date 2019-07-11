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
