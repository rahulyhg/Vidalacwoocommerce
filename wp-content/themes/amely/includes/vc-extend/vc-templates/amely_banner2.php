<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $img_size
 * @var $external_img_size
 * @var $buttons
 * @var $text
 * @var $link
 * @var $button_style
 * @var $button_color
 * @var $button_color_hover
 * @var $button_bg_color
 * @var $button_bg_color_hover
 * @var $button_border_color
 * @var $button_border_color_hover
 * @var $hover_style
 * @var $animation
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Banner2
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$animation_classes = $this->getCSSAnimation( $animation );

$css_class = array(
	'tm-shortcode',
	'amely-banner2',
	'hover-' . $hover_style,
	$this->getCSSAnimation( $animation ),
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);


$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );


$img = false;

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

$buttons        = vc_param_group_parse_atts( $atts['buttons'] );
$buttons_output = array();
foreach ( (array) $buttons as $index => $button ) {

	if ( isset( $button['link'] ) ) {

		$link             = vc_build_link( $button['link'] );
		$buttons_output[] = sprintf( '<a href="%s" target="%s" title="%s" rel="%s" class="amely-button banner-button banner-button-%s %s">%s</a>',
			esc_url( $link['url'] ),
			esc_attr( $link['target'] ? $link['target'] : '_self' ),
			esc_attr( $link['title'] ? $link['title'] : '' ),
			esc_attr( $link['rel'] ? $link['rel'] : '' ),
			esc_attr( $index + 1 ),
			esc_attr( isset( $button['button_style'] ) ? $button['button_style'] : '' ),
			esc_html( $button['text'] ) );
	}
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-banner2' );
$this->shortcode_css( $css_id );

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">

	<?php echo '' . $img['thumbnail']; ?>

	<?php if ( $buttons ) { ?>
		<div class="banner-buttons">
			<?php echo implode( '', $buttons_output ); ?>
		</div>
	<?php } ?>
</div>
