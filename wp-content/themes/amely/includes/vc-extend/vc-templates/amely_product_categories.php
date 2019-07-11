<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $product_cat_slugs
 * @var $hide_count
 * @var $orderby
 * @var $order
 * @var $layout
 * @var $item_style
 * @var $spacing
 * @var $number_of_items_to_show
 * @var $columns
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $center_mode
 * @var $center_padding
 * @var $hide_empty
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product_Categories
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

global $woocommerce_loop;

$css_class = array(
	'tm-shortcode',
	'amely-product-categories',
	'row',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

if ( empty( $product_cat_slugs ) ) {
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

if ( $orderby == 'include' ) {
	$order = 'ASC';
}

$args = array(
	'taxonomy'   => 'product_cat',
	'orderby'    => $orderby,
	'order'      => $order,
	'hide_empty' => ( $hide_empty == 'yes' ),
	'include'    => $product_cat_ids,
);

$product_categories = get_terms( $args );

$columns = absint( $columns );

if ( $hide_count == 'yes' ) {
	$css_class .= ' hide_count';
}

$css_class .= ' categories-space-' . $atts['spacing'];
$css_class .= ' categories-layout-' . $layout;
$css_class .= ' categories-item-' . $item_style;

$woocommerce_loop['columns'] = $columns;
$woocommerce_loop['layout']  = $layout;

?>
<div class="<?php echo esc_attr( trim( $css_class ) ) ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ); ?>">
	<?php
	// Reset loop/columns globals when starting a new loop.
	$woocommerce_loop['loop'] = '';

	if ( $product_categories ) {

		foreach ( $product_categories as $category ) {

			wc_get_template( 'content-product_cat.php', array(
				'category'   => $category,
				'layout'     => $layout,
				'item_style' => $item_style,
			) );
		}
	}

	unset( $woocommerce_loop['different_sizes'] );
	woocommerce_reset_loop();
	?>
</div>
