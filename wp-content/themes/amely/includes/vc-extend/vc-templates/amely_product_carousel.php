<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $data_source
 * @var $product_cat_slugs
 * @var $product_cat_slugs
 * @var $include_children
 * @var $product_ids
 * @var $product_attribute
 * @var $product_term
 * @var $number
 * @var $columns
 * @var $exclude
 * @var $orderby
 * @var $order
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product_Carousel
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-product-carousel',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$next_page = 0;

if ( $data_source == 'categories' && empty( $product_cat_slugs ) ) {
	return;
}

$product_cat_slugs = explode( ',', $product_cat_slugs );

$product_cat_ids = array();

foreach ( $product_cat_slugs as $slug ) {

	$term = get_term_by( 'slug', $slug, 'product_cat' );

	if ( ! empty( $term ) ) {
		$product_cat_ids[] = $term->term_id;
	}
}

$categories = get_terms( array(
	'taxonomy' => 'product_cat',
	'orderby'  => 'include',
	'include'  => $product_cat_ids,
) );

if ( $number > 1000 ) {
	$number = 1000;
}

$css_id = uniqid( 'amely-product-carousel-' );

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>" data-paged="1"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<?php

	$atts['include_children'] = ( $atts['include_children'] == 'yes' );
	$product_loop             = Amely_Woo::get_products_by_datasource( $data_source, $atts );

	if ( $product_loop->max_num_pages > 1 ) {
		$next_page = 2;
	}

	woocommerce_product_loop_start();

	while ( $product_loop->have_posts() ) {
		$product_loop->the_post();
		wc_get_template_part( 'content', 'product' );
	}

	wp_reset_postdata();

	woocommerce_product_loop_end();

	?>


</div>
