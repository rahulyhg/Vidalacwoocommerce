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
