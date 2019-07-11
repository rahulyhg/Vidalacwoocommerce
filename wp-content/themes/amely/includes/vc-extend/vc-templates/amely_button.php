<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $style
 * @var $size
 * @var $text
 * @var $link
 * @var $font_size
 * @var $add_icon
 * @var $type
 * @var $icon_fontawesome
 * @var $icon_openiconic
 * @var $icon_typicons
 * @var $icon_entypo
 * @var $icon_linecons
 * @var $icon_pe7stroke
 * @var $icon_pos
 * @var $font_color
 * @var $font_color_hover
 * @var $button_bg_color
 * @var $button_bg_color_hover
 * @var $button_border_color
 * @var $button_border_color_hover
 * @var $el_class
 * @var $css
 * @var $css_id
 * @var $animation
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Button
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$animation_classes = $this->getCSSAnimation( $animation );

$css_class = array(
	'tm-shortcode',
	'amely-button',
	'button',
	$style,
	$animation_classes,
	$size,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$element = 'div';

$css_id        = Amely_VC::get_amely_shortcode_id( 'amely-button' );
$shortcode_css = $this->shortcode_css( $css_id );

//parse link
if ( ! empty( $link ) && "||" !== $link && "|||" !== $link ) {
	$link = vc_build_link( $link );

	$a_href   = $link['url'];
	$a_title  = $link['title'];
	$a_target = $link['target'];
	$a_rel    = $link['rel'];

	$element = 'a';
}

// Enqueue needed icon font.
vc_icon_element_fonts_enqueue( $type );
$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';

?>

<<?php echo esc_attr( $element ); ?> class="<?php echo esc_attr( trim( $css_class ) ); ?>"
<?php if ( 'a' === $element ) { ?>
	href="<?php echo esc_url( $a_href ); ?>"
	title="<?php echo esc_attr( $a_title ); ?>"
	target="<?php echo esc_attr( $a_target ? $a_target : '_self' ); ?>"
	rel="<?php echo esc_attr( $a_rel ); ?>"
<?php } ?>
<?php if ( 'custom' === $style ) { ?>
	id="<?php echo esc_attr( $css_id ); ?>"
<?php } ?>>
<span>
    <?php if ( 'yes' === $add_icon && 'left' == $icon_pos ) { ?>
    <i class="icon-left <?php echo esc_attr( $iconClass ); ?>"></i><?php } ?>
	<?php if ( 'a' === $element && $a_title && ! $text ) { ?>
		<?php echo '' . $a_title; ?>
	<?php } else { ?>
		<?php echo '' . $text; ?>
	<?php } ?>
	<?php if ( 'yes' === $add_icon && 'right' == $icon_pos ) { ?>
	<i class="icon-right <?php echo esc_attr( $iconClass ); ?>"></i><?php } ?>
</span>
</<?php echo esc_attr( $element ); ?>>

