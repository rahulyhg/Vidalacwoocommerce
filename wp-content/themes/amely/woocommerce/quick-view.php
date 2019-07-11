<?php /**
 * Quickview template
 *
 * @author ThemeMove
 */

global $post, $product;
?>

	<div class="woocommerce single-product">
		<a href="#" class="quick-view-close"></a>
		<div class="quickview-loading"><span><?php esc_html_e( 'Adding to cart...', 'amely' ); ?></span></div>
		<div class="product container">
			<div class="row">
				<?php if ( post_password_required() ) { ?>
					<div class="col-xs-12">
						<?php echo get_the_password_form(); ?>
					</div>
				<?php } else { ?>
					<div class="images">
						<?php woocommerce_show_product_sale_flash(); ?>
						<?php
						$carousel_settings = apply_filters( 'amely_quickview_carousel_settings',
							array(
								'accessibility' => false,
								'arrows'        => true,
								'dots'          => true,
								'infinite'      => true,
							) )
						?>
						<div class="quick-view-carousel woocommerce-product-gallery__image"
						     data-carousel="<?php echo esc_attr( json_encode( $carousel_settings ) ); ?>">
							<?php
							$attachment_ids   = $product->get_gallery_image_ids();
							$attachment_count = count( $attachment_ids );

							if ( has_post_thumbnail() ) {

								$image_title     = esc_attr( get_the_title( get_post_thumbnail_id() ) );
								$cropping_width  = max( 1,
									get_option( 'woocommerce_thumbnail_cropping_custom_width', '3' ) );
								$cropping_height = max( 1,
									get_option( 'woocommerce_thumbnail_cropping_custom_height', '4' ) );
								$image_width     = intval( get_option( 'woocommerce_single_image_width', 432 ) ) * .8;
								$image_height    = absint( round( ( $image_width / $cropping_width ) * $cropping_height ) );

								$image_size = Amely_Woo::get_quickview_image_size();

								echo wp_get_attachment_image( get_post_thumbnail_id( $post->ID ),
									$image_size,
									false,
									array(
										'title' => $image_title,
										'class' => 'first-image quickview-image wp-post-image',
									) );

								if ( $attachment_count > 0 ) {
									foreach ( $attachment_ids as $attachment_id ) {

										echo wp_get_attachment_image( $attachment_id,
											$image_size,
											false,
											array(
												'title' => $image_title,
												'class' => 'quickview-image',
											) );

									}
								}

							} else {
								echo apply_filters( 'woocommerce_single_product_image_html',
									sprintf( '<img src="%s" alt="%s" />',
										wc_placeholder_img_src(),
										__( 'Placeholder', 'amely' ) ),
									$post->ID );
							}

							?>
						</div>
					</div>

					<div class="summary entry-summary">
						<?php do_action( 'woocommerce_single_product_summary' ); ?>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		/* <![CDATA[ */
		<?php
		$suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		$assets_path = esc_url( str_replace( array( 'http:', 'https:' ), '', WC()->plugin_url() ) ) . '/assets/';
		$frontend_script_path = $assets_path . 'js/frontend/';
		?>
		var wc_single_product_params = <?php echo json_encode( apply_filters( 'wc_single_product_params',
			array(
				'i18n_required_rating_text' => esc_attr__( 'Please select a rating', 'amely' ),
				'review_rating_required'    => get_option( 'woocommerce_review_rating_required' ),
			) ) ) ?>;
		var woocommerce_params = <?php echo json_encode( apply_filters( 'woocommerce_params',
			array(
				'ajax_url'    => WC()->ajax_url(),
				'wc_ajax_url' => WC_AJAX::get_endpoint( "%%endpoint%%" ),
			) ) ) ?>;
		var wc_cart_fragments_params = <?php echo json_encode( apply_filters( 'wc_cart_fragments_params',
			array(
				'ajax_url'      => WC()->ajax_url(),
				'fragment_name' => apply_filters( 'woocommerce_cart_fragment_name', 'wc_fragments' ),
			) ) ) ?>;
		var wc_add_to_cart_variation_params = <?php echo json_encode( apply_filters( 'wc_add_to_cart_variation_params',
			array(
				'i18n_no_matching_variations_text' => esc_attr__( 'Sorry, no products matched your selection. Please choose a different combination.',
					'amely' ),
				'i18n_make_a_selection_text'       => esc_attr__( 'Select product options before adding this product to your cart.',
					'amely' ),
				'i18n_unavailable_text'            => esc_attr__( 'Sorry, this product is unavailable. Please choose a different combination.',
					'amely' ),
			) ) ) ?>;
		jQuery( document ).ready( function( $ ) {

			$.getScript( '<?php echo esc_js( $frontend_script_path . 'single-product' . $suffix . '.js' ); ?>' );
			$.getScript( '<?php echo esc_js( $frontend_script_path . 'woocommerce' . $suffix . '.js' ); ?>' );
			$.getScript( '<?php echo esc_js( $frontend_script_path . 'add-to-cart-variation' . $suffix . '.js' ); ?>' );
			/* ]]> */
		} );

	</script>

<?php
die();
