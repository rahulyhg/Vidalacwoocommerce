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
