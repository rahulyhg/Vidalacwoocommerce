<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $brand_slugs
 * @var $columns
 * @var $hide_empty
 * @var $display_featured
 * @var $show_title
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Brands_Grid
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-brands-grid',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$args = array(
	'taxonomy'   => 'product_brand',
	'slug'       => explode( ',', $atts['brand_slugs'] ),
	'orderby'    => 'name',
	'order'      => 'ASC',
	'hide_empty' => ( $hide_empty == 'yes' ),
	'meta_query' => array(
		'meta_key'   => 'featured',
		'meta_value' => '1',
	)
);

$brands = get_terms( $args );

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-brands-grid' );

$column_width = Amely_VC::calculate_column_width( $columns );

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<div class="container">
		<div class="row">

			<?php

			foreach ( $brands as $brand ) {

				$featured = get_term_meta( $brand->term_id, 'featured', true );

				$url = get_term_meta( $brand->term_id, 'url', true );

				if ( ! $url ) {
					$url = get_term_link( $brand->slug, 'product_brand' );
				}

				$image        = '';
				$thumbnail_id = get_term_meta( $brand->term_id, 'thumbnail_id', true );

				if ( $thumbnail_id ) {
					$image = current( wp_get_attachment_image_src( $thumbnail_id, 'full' ) );
				} else {

					if ( get_option( 'pw_woocommerce_brands_default_image' ) ) {
						$image = wp_get_attachment_thumb_url( get_option( 'pw_woocommerce_brands_default_image' ) );
					} else {
						$image = WP_PLUGIN_URL . '/woo-brand/img/default.png';
					}
				}
				?>
				<div
					class="tm-brand-item col-sm-6 col-md-6 col-lg-4 col-xl-<?php echo esc_attr( $column_width ); ?>">
					<a href="<?php echo esc_url( $url ); ?>" title="<?php echo esc_attr( $brand->name ); ?>"
					   target="<?php echo esc_attr( $new_tab == 'yes' ? '_blank' : '_self' ); ?>">
						<img src="<?php echo esc_url( $image ); ?>" alt="<?php echo esc_attr( $brand->name ); ?>">
						<?php if ( $show_title == 'yes' ) { ?>
							<span><?php echo esc_html( $brand->name ); ?></span>
						<?php } ?>
					</a>
				</div>
				<?php
			}

			?>

		</div>
	</div>
</div>
