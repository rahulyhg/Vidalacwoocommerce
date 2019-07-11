<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $image
 * @var $name
 * @var $role
 * @var $biography
 * @var $link_new_page
 * @var $social_links
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Team_Member
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-team-members',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

if ( $image ) {
	$image_attr = wp_get_attachment_image_src( $image, 'full' );
}

?>

<div class="<?php echo esc_attr( trim( $css_class ) ) ?> ">
	<div class="member-image">
		<?php if ( ! empty( $image_attr ) && is_array( $image_attr ) ) { ?>
			<img src="<?php echo esc_attr( $image_attr[0] ); ?>" alt="<?php echo esc_attr( $name ); ?>">
		<?php }
		$social_links_arr = $this->getSocialLinks( $atts ); ?>
		<?php if ( ! empty( $social_links_arr ) ) { ?>
			<div class="social-inside">
				<ul class="social-list">
					<?php foreach ( $social_links_arr as $key => $link ) { ?>
						<li class="social-list__item">
							<a class="social-list__link" href="<?php echo esc_attr( $link ) ?>"
							   target="<?php echo esc_attr( $link_new_page == 'yes' ? '_blank' : '_self' ); ?>"><?php echo( $key ); ?>
								<i class="fa fa-<?php echo esc_attr( $key ); ?>  social-list__icon"></i>
							</a>
						</li>
					<?php } ?>
				</ul>
			</div>
		<?php } ?>
	</div>

	<div class="memeber-caption">

		<?php if ( $name ) { ?>
			<h2 class="name"><?php echo '' . $name; ?></h2>
		<?php }
		if ( $role ) { ?>
			<span class="role text-hightlight subtext"><?php echo '' . $role; ?></span>
		<?php }
		if ( $biography ) { ?>
			<p class="biography"><?php echo '' . $biography; ?></p>
		<?php } ?>
	</div>
</div>
