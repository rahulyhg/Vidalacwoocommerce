<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $image
 * @var $top_text
 * @var $title
 * @var $price
 * @var $link
 * @var $style_hover
 * @var $el_class
 * @var $css
 * @var $animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$animation_classes = $this->getCSSAnimation( $animation );

$css_class = array(
	'tm-shortcode',
	'amely-product',
	$style_hover,
	$animation_classes,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$image = wp_get_attachment_image_src( $atts['image'], 'full' );
$src   = $image[0];
$image = sprintf( '<img alt="%s" src="%s">', esc_attr( $atts['title'] ), esc_url( $image[0] ) );

$background_image = '';
if ( $src ) {
	$background_image = 'background-image: url(\'' . $src . '\')';
}

//parse link
if ( ! empty( $link ) ) {
	$a_link = vc_build_link( $link );

	$a_href   = $a_link['url'];
	$a_title  = $a_link['title'];
	$a_target = $a_link['target'];
	$a_rel    = $a_link['rel'];
}

// get price
$price = floatval( $atts['price'] );

if ( shortcode_exists( 'woocs_show_custom_price' ) ) {
	$price = do_shortcode( '[woocs_show_custom_price value="' . $price . '"]' );
} else {
	$price = wc_price( $price );
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-product' );
$this->shortcode_css( $css_id );

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">
	<?php if ($style_hover == 'display_info'){ ?>
		<a class="product-link" href="<?php echo esc_url( $a_href ); ?>"></a>
	<?php } ?>
	<div class="product-image" style="<?php echo esc_attr( $background_image ); ?>">
		<?php if ( ! empty( $link ) ) { ?><span class="background-overlay"></span><?php } ?>
		<img src="<?php echo esc_url( $src ) ?>" alt="<?php echo esc_attr( $atts['title'] ) ?> "/>
	</div>

	<div class="product-top-text"><?php echo( $top_text ) ?></div>

	<div class="product-info">
		<div class="product-title"><?php echo( $title ); ?></div>
		<div class="product-price"><?php echo( $price ) ?></div>
	</div>

	<?php if ( ! empty( $a_title ) ) { ?>
		<a class="button link" href="<?php echo esc_url( $a_href ); ?>"
			<?php echo $a_title ? 'title="' . esc_attr( $a_title ) . '"' : ''; ?>
			<?php echo $a_target ? 'target="' . esc_attr( $a_target ) . '"' : ''; ?>
			<?php echo $a_rel ? 'rel="' . esc_attr( $a_rel ) . '"' : ''; ?>>
			<?php echo esc_html( $a_title ); ?>
		</a>
	<?php } ?>

</div>
