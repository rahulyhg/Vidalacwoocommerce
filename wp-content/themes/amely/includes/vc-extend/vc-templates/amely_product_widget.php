<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $title
 * @var $data_source
 * @var $category
 * @var $product_ids
 * @var $product_attribute
 * @var $product_term
 * @var $include_children
 * @var $number
 * @var $number_per_slide
 * @var $exclude
 * @var $enable_carousel
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $arrows_position
 * @var $orderby
 * @var $order
 * @var $enable_buttons
 * @var $img_size
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product_Widget
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-product-widget',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

if ( $enable_carousel == 'yes' ) {
	$css_class .= 'enable-carousel';
}

if ( $img_size ) {
	$css_class .= ' custom-image-size';
}

if ( $number > 1000 ) {
	$number = 1000;
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-product-widget' );
$this->shortcode_css( $css_id );

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<div class="title">
		<?php echo esc_html( $title ); ?>
		<?php if ( $enable_carousel == 'yes' && $arrows_position == 'title' ) { ?>
			<button type="button" data-role="none" class="slick-prev slick-arrow small" aria-label="Previous">
				Previous
			</button>
			<button type="button" data-role="none" class="slick-next slick-arrow small" aria-label="Next">
				Next
			</button>
		<?php } ?>
	</div>

	<?php

	$atts['include_children'] = ( $atts['include_children'] == 'yes' );
	$product_loop             = Amely_Woo::get_products_by_datasource( $data_source, $atts );

	echo apply_filters( 'woocommerce_before_widget_product_list', '<div class="product_list_widget">' );
	?>
	<?php if ( $enable_carousel == 'yes' ) { ?>
	<div class="item">
		<?php } ?>
		<?php

		$i = 1;

		while ( $product_loop->have_posts() ) {

			$product_loop->the_post();
			wc_get_template( 'content-widget-product.php',
				array(
					'show_rating'  => true,
					'show_buttons' => ( $enable_buttons == 'yes' ),
					'img_size'     => Amely_Helper::convert_image_size( $img_size ),
				) );

			if ( $enable_carousel == 'yes' && $i % $number_per_slide == 0 && $i < $product_loop->post_count ) {
				echo '</div><div class="item">';
			}

			$i ++;
		}

		wp_reset_postdata();
		?>
		<?php if ( $enable_carousel == 'yes' ) { ?>
	</div>
<?php } ?>
	<?php
	echo apply_filters( 'woocommerce_after_widget_product_list', '</div>' );
	?>

	<?php if ( $enable_carousel == 'yes' && $arrows_position == 'bottom' ) { ?>
		<div class="slick-arrows-bottom">
			<button type="button" data-role="none" class="slick-prev slick-arrow small" aria-label="Previous">
				Previous
			</button>
			<button type="button" data-role="none" class="slick-next slick-arrow small" aria-label="Next">
				Next
			</button>
		</div>
	<?php } ?>
</div>
