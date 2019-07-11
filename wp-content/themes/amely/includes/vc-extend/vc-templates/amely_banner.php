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
 * @var $desc
 * @var $content
 * @var $text_position
 * @var $link
 * @var $font_size
 * @var $use_theme_fonts
 * @var $google_fonts
 * @var $button_text
 * @var $button_visibility
 * @var $button_style
 * @var $button_color
 * @var $button_color_hover
 * @var $button_bg_color
 * @var $button_bg_color_hover
 * @var $button_border_color
 * @var $button_border_color_hover
 * @var $color_description
 * @var $color_content
 * @var $hover_style
 * @var $animation
 * @var $color_description
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Banner
 */
extract( $this->getAttributes( $atts ) );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

extract( $this->getStyles( $el_class, $css, $google_fonts_data, $atts ) );

$settings = get_option( 'wpb_js_google_fonts_subsets' );
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
} else {
	$subsets = '';
}

if ( isset( $google_fonts_data['values']['font_family'] ) ) {
	wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ),
		'//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
}

if ( ! empty( $styles ) ) {
	$style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
} else {
	$style = '';
}

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

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-banner' );
$this->shortcode_css( $css_id );

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">
	<a class="banner-link"
	   href="<?php echo esc_url( $a_href ); ?>"
		<?php echo $a_title ? 'title="' . esc_attr( $a_title ) . '"' : ''; ?>
		<?php echo $a_target ? 'target="' . esc_attr( $a_target ) . '"' : ''; ?>
		<?php echo $a_rel ? 'rel="' . esc_attr( $a_rel ) . '"' : ''; ?>>

		<?php echo '' . $img['thumbnail']; ?>

		<span class="banner-content">

		<?php if ( $desc ) { ?>
			<span class="banner-desc"><?php echo '' . $desc; ?></span>
		<?php } ?>

			<?php if ( $content ) { ?>
				<span
					class="banner-text" <?php echo '' . $style; ?>><?php echo $content; ?></span>
			<?php } ?>
			<?php if ( $button_visibility != 'hidden' ) { ?>
				<span
					class="amely-button banner-button <?php echo esc_attr( $button_style ); ?>"><?php echo '' . $button_text; ?></span>
			<?php } ?>
	</span>

	</a>
</div>
