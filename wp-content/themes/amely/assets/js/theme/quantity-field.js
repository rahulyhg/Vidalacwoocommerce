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
