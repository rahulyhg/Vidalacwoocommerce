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
