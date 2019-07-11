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
 * @var $color_content
 * @var $content
 * @var $text_align
 * @var $align_vertical
 * @var $link
 * @var $button_text
 * @var $button_visibility
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
 * @var $this WPBakeryShortCode_Amely_Banner3
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = array(
	'tm-shortcode',
	'amely-banner3',
	'hover-' . $hover_style,
	'text-align-' . $text_align,
	'vertical-align-' . $align_vertical,
	'button-visible-' . $button_visibility,
	$this->getCSSAnimation( $animation ),
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$img = false;

// parse banner link
$a_href   = '';
$a_title  = '';
$a_target = '';
$a_rel    = '';
if ( ! empty( $link ) && "||" !== $link && "|||" !== $link ) {
	$link = vc_build_link( $link );

	$a_href   = $link['url'];
	$a_title  = $link['title'];
	$a_target = $link['target'];
	$a_rel    = $link['rel'];

	if ( $a_title && ! $button_text ) {
		$button_text = $a_title;
	}
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

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-banner3' );
$this->shortcode_css( $css_id );

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">

	<?php echo '' . $img['thumbnail']; ?>

	<div class="banner-content">

		<?php if ( $content ) { ?>
			<div class="banner-text"><?php echo wpb_js_remove_wpautop( $content ); ?></div>
		<?php } ?>

		<?php if ( $button_visibility != 'hidden' ) { ?>
			<span
				class="amely-button banner-button <?php echo esc_attr( $button_style ); ?>"><?php echo '' . $button_text; ?></span>
		<?php } ?>
	</div>
	<a class="banner-link"
	   href="<?php echo esc_url( $a_href ); ?>"
		<?php echo $a_title ? 'title="' . esc_attr( $a_title ) . '"' : ''; ?>
		<?php echo $a_target ? 'target="' . esc_attr( $a_target ) . '"' : ''; ?>
		<?php echo $a_rel ? 'rel="' . esc_attr( $a_rel ) . '"' : ''; ?>>
		<?php echo $a_title ? esc_html( $a_title ) : esc_html__( 'View Details', 'amely' ); ?></a>
</div>
