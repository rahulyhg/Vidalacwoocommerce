<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $images
 * @var $img_size
 * @var $onclick
 * @var $custom_links
 * @var $custom_links_target
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $number_of_images_to_show
 * @var $show_title
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Image_Carousel
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-image-carousel',
	$onclick,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

if ( $images == '' ) {
	return;
}

$images = explode( ',', $images );
$i      = - 1;

if ( 'custom_link' == $onclick ) {
	$custom_links = vc_value_from_safe( $custom_links );
	$custom_links = explode( ',', $custom_links );
}

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-image-carousel' );
$this->shortcode_css( $css_id );

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ); ?>">

	<?php

	foreach ( $images as $attach_id ) {
		$i ++;

		if ( $attach_id > 0 ) {
			$post_thumbnail = wpb_getImageBySize( array(
				'attach_id'  => $attach_id,
				'thumb_size' => $img_size,
			) );
		}
		$thumbnail = $post_thumbnail['thumbnail'];
		?>

		<div class="tm-carousel-item">
			<?php if ( 'link_image' === $onclick ) { ?>
				<?php $p_img_large = $post_thumbnail['p_img_large']; ?>
				<a class="tm-carousel-open-popup" href="<?php echo '' . $p_img_large[0] ?>">
					<?php echo '' . $thumbnail; ?>
				</a>
			<?php } elseif ( 'custom_link' === $onclick && isset( $custom_links[ $i ] ) && '' !== $custom_links[ $i ] ) { ?>
				<a href="<?php echo esc_attr( $custom_links[ $i ] ) ?>"<?php echo( ! empty( $custom_links_target ) ? ' target="' . $custom_links_target . '"' : '' ) ?>>
					<?php echo '' . $thumbnail; ?>
				</a>
			<?php } else { ?>
				<?php echo '' . $thumbnail; ?>
			<?php } ?>
			<?php if ( 'yes' === $show_title ) { ?>
				<p class="title"><?php echo get_the_title( $attach_id ); ?></p>
			<?php } ?>
		</div>
	<?php } ?>
</div>
