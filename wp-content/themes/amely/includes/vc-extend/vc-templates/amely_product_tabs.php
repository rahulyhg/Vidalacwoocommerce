<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $filter
 * @var $filter_type
 * @var $align
 * @var $product_cat_ids
 * @var $tabs
 * @var $number
 * @var $columns
 * @var $exclude
 * @var $include_children
 * @var $img_size
 * @var $pagination_type
 * @var $orderby
 * @var $order
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product_Tabs
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-product-tabs',
	'filter-by-' . $filter,
	'filter-type-' . $filter_type,
	'tabs-align-' . $align,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

// Get categories
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

// Get group tabs
$tabs = explode( ',', $tabs );

// Get datasource
if ( $filter == 'category' ) {
	$atts['data_source'] = $filter_type == 'filter' ? 'categories' : 'category';
} elseif ( $filter == 'group' ) {
	$atts['data_source'] = 'recent_products';
}

if ( $number > 1000 ) {
	$number = 1000;
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-product-tabs' );

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<ul class="product-filter">
		<?php if ( $filter == 'category' ) { ?>
			<?php if ( $filter_type == 'filter' ) { ?>
				<li><a href="#" class="active"
				       data-filter="*"><?php esc_html_e( 'All', 'amely' ) ?></a></li>
			<?php } elseif ( $filter_type == 'ajax' ) {
				$atts['category'] = $categories[0]->slug; // get the first category if filter type is ajax
			} ?>
			<?php foreach ( $categories as $index => $category ) { ?>
				<li><a href="#" class="<?php echo ( $filter_type == 'ajax' && ! $index ) ? 'active' : '' ?>" data-page="<?php echo esc_attr(1); ?>" data-category="<?php echo esc_attr($category->slug); ?>" data-filter="<?php echo esc_attr( '.product_cat-' . $category->slug ) ?>"><?php echo( $category->name ); ?></a>
				</li>
			<?php } ?>
		<?php } else { ?>
			<?php if ( $filter_type == 'filter' ) { ?>
				<li><a href="#" class="active"
				       data-filter="*"><?php esc_html_e( 'All', 'amely' ) ?></a></li>
			<?php } elseif ( $filter_type == 'ajax' ) {
				$atts['data_source'] = $tabs[0]; // get the first tab if filter type is ajax
			} ?>
			<?php foreach ( $tabs as $index => $tab ) {
				echo( $this->make_tab( $index, $tab ) );
			} ?>
		<?php } ?>
	</ul>

	<div class="products-tab-content">
		<?php

		$atts['include_children'] = ( $atts['include_children'] == 'yes' );

		$product_loop = Amely_Woo::get_products_by_datasource( $atts['data_source'], $atts );

		woocommerce_product_loop_start();

		while ( $product_loop->have_posts() ) {
			$product_loop->the_post();
			wc_get_template_part( 'content', 'product' );
		}

		wp_reset_postdata();

		woocommerce_product_loop_end();

		?>
	</div>

	<?php
	if ( $pagination_type && $product_loop->post_count >= $number ) {

		$load_more_atts = array(
			'container'      => '#' . $css_id,
			'post_type'      => 'product',
			'paged'          => 1,
			'posts_per_page' => $number,
			'columns'        => $columns,
		)
		?>
		<div class="amely-loadmore-wrap" data-filter="<?php echo esc_attr($categories[0]->slug); ?>" data-atts="<?php echo esc_attr( json_encode( $load_more_atts ) ); ?>">
			<span
				class="amely-loadmore-btn load-on-<?php echo ( $pagination_type == 'more-btn' ) ? 'click' : 'scroll'; ?>"><?php esc_html_e( 'Load More ...',
					'amely' ); ?></span>
		</div>
	<?php } ?>

</div>
