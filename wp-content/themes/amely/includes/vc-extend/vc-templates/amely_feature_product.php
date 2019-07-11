<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $animation
 * @var $product_slugs
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $img_size
 * @var $style
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Feature_Product
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$animation_classes = $this->getCSSAnimation( $animation );

$css_class = array(
	'tm-shortcode',
	'amely-feature-product',
	$animation_classes,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

//$image = wp_get_attachment_image_src( $atts['image'], 'full' );
$img = false;
if ( ! $img_size ) {
	$img_size = 'full';
}
// Get banner image
switch ( $source ) {
	case 'media_library':

		if ( ! $img_size ) {
			$img_size = 'full';
		}

		if ( $image ) {
			$dimensions = vcExtractDimensions( $img_size );
			$hwstring   = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

			$img = array(
				'thumbnail' => '<img ' . $hwstring . ' src="' . wp_get_attachment_image_src( $image,
						$img_size )[0] . '" alt="" />',
				'src'       => wp_get_attachment_image_src( $image, $img_size )[0],
			);
		}

		break;

	case 'external_link':

		$dimensions = vcExtractDimensions( $external_img_size );
		$hwstring   = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

		$custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;

		$img = array(
			'thumbnail' => '<img ' . $hwstring . 'src="' . $custom_src . '" alt="" />',
			'src'       => $custom_src,
		);

		break;

	default:
		break;
}
$_product = wc_get_product( $product_slugs );

$rating = get_post_meta( $product_slugs, '_wc_average_rating', true );
$css_id = Amely_VC::get_amely_shortcode_id( 'amely-feature-product' );
?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<div class="row products-feature">
		<?php if ($style == 'left'){ ?>
			<div class="col-sm-12 col-lg-6 product-image">
				<?php echo '' . $img['thumbnail']; ?>
			</div>
		<?php } ?>
		<div class="col-sm-12 col-lg-6">
			<div class="rate">
				<?php $rating_count = $_product->get_rating_count();
				$average            = $_product->get_average_rating();
				echo wc_get_rating_html( $average, $rating_count ); ?>
			</div>
			<div class="title"><?php echo esc_attr( $_product->get_title() ); ?></div>
			<div class="price">

				<?php if ( $_product->is_on_sale() ) { ?>
					<span class="sale-price"><?php echo get_woocommerce_currency_symbol() . esc_attr( $_product->get_regular_price() ); ?></span>
				<?php } ?>
				<?php echo get_woocommerce_currency_symbol() . esc_attr( $_product->get_price() ); ?>
			</div>
			<div class="description"><?php echo esc_attr( $_product->get_description() ); ?></div>
			<?php

			echo do_shortcode( '[add_to_cart id="' . $product_slugs . '"]' );
			?>
		</div>
		<?php if ($style == 'right'){ ?>
			<div class="col-sm-12 col-lg-6 product-image">
				<?php echo '' . $img['thumbnail']; ?>
			</div>
		<?php } ?>
	</div>
</div>

</div>
