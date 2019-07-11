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
