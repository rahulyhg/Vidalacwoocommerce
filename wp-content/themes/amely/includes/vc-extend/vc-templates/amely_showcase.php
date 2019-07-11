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
 * @var $title
 * @var $show_number
 * @var $number
 * @var $style
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Showcase
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$animation_classes = $this->getCSSAnimation( $animation );

$css_class = array(
	'tm-shortcode',
	'amely-showcase-product',
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
$css_id   = Amely_VC::get_amely_shortcode_id( 'amely-showcase-product' );

$class = '';
if ( $style == 'left' ) {
	$class = 'image-align-left';
} else {
	$class = 'image-align-right';
}

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<div class="row showcase-product <?php echo esc_attr( $class ); ?>">
		<?php if ( $style == 'left' ) { ?>
			<div class="col-sm-12 col-lg-6 product-image align-left"
			     style="background-image: url('<?php echo $img['src'] ?>');">
				<div class="number-squence"><?php echo esc_attr( $number ); ?></div>
				<img class="showcase-image hidden-lg-up" src="<?php echo esc_url($img['src']); ?>" />
			</div>
		<?php } ?>
		<div class="col-sm-12 col-lg-6 single-product">
			<div class="title"><?php echo esc_attr( $title ); ?></div>
			<?php
			echo do_shortcode( '[product id="' . $product_slugs . '"]' );
			?>
		</div>
		<?php if ( $style == 'right' ) { ?>
			<div class="col-sm-12 col-lg-6 product-image align-right"
			     style="background-image: url('<?php echo $img['src'] ?>');">
				<div class="number-squence"><?php echo esc_attr( $number ); ?></div>
				<img class="showcase-image hidden-lg-up" src="<?php echo esc_url($img['src']); ?>" />
			</div>
		<?php } ?>
	</div>
</div>

