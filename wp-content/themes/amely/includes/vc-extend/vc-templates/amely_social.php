<?php
/**
 * Shortcode attributes
 *
 * @var $icon_color
 * @var $spacing
 * @var $icon_shape
 * @var $source
 * @var $social_links
 * @var $atts
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Social
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-social',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$social_links_arr = $this->getSocialLinks( $atts );
$social_icon_arr  = Amely_Helper::social_icons( false );

if ( 'none' != $icon_shape ) {
	$css_class .= ' shape-' . $icon_shape;
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-social' );
$this->shortcode_css( $css_id );

$class_tooltip = '';

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">
	<?php
	if ( $source == 'default' ) {
		echo Amely_Templates::social_links();
	} else {
		if ( ! empty( $social_links_arr ) ) { ?>
			<ul class="social-links">
				<?php

				foreach ( $social_links_arr as $key => $link ) {

					$social = $social_icon_arr[ $key ];

					if ( amely_get_option( 'tooltip' ) ) {
						$class_tooltip = "hint--top hint--bounce";
					}
					?>
					<li class="<?php echo esc_attr( $class_tooltip ); ?>"
					    aria-label="<?php echo esc_attr( $social ); ?>">
						<a href="<?php echo esc_url( $link ); ?>">
							<i class="fa fa-<?php echo esc_attr( $key ); ?>"></i>
						</a>
					</li>
				<?php } ?>
			</ul>
		<?php } ?>
	<?php } ?>
</div>
