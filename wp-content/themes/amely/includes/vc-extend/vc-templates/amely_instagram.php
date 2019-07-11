<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $username
 * @var $view
 * @var $number_items
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $number_of_items_to_show
 * @var $show_username
 * @var $spacing
 * @var $show_likes_comments
 * @var $link_new_page
 * @var $square_media
 * @var $el_class
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Instagram
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-instagram',
	'amely-instagram--' . $view,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$class = Amely_Helper::get_grid_item_class( array(
	'xs' => 2,
	'sm' => 2,
	'md' => $number_of_items_to_show,
) );

if ( $number_items > 1000 ) {
	$number_items = 1000;
}

?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ); ?>">

	<?php if ( ! empty( $username ) ) {

		$media_array    = Amely_Instagram::scrape_instagram( $username, $number_items, $square_media == 'yes' );
		$instagram_link = 'https://www.instagram.com/' . $username . '/';

		if ( $show_username == 'yes' ) { ?>
			<div class="user-name"><a
					href="<?php echo esc_url( $instagram_link ); ?>"> <?php echo '@' . esc_html( $username ); ?></a>
			</div>
		<?php }

		if ( is_wp_error( $media_array ) ) { ?>
			<div class="tm-instagram--error"><p><?php echo esc_attr( $media_array->get_error_message() ); ?></p></div>
		<?php } else { ?>
			<div class="tm-instagram-pics row" style="margin: 0 -<?php echo( $spacing / 2 ); ?>px">
				<?php foreach ( $media_array as $item ) { ?>
					<div class="item<?php echo ' ' . $class; ?>"
					     style="padding: 0 <?php echo esc_attr( $spacing / 2 ); ?>px <?php echo esc_attr( $spacing ); ?>px <?php echo esc_attr( $spacing / 2 ); ?>px;">
						<?php if ( $show_likes_comments == 'yes' ) { ?>
							<div class="item-info"
							     style="width:calc(100% - <?php echo esc_attr( $spacing ) . 'px'; ?>);left:<?php echo esc_attr( $spacing / 2 ) . 'px'; ?>">
								<div class="likes">
									<a href="<?php echo esc_url( $item['link'] ) ?>"
									   target="<?php echo esc_attr( ( $link_new_page == 'yes' ) ? '_blank' : '_self' ); ?>"
									   title="<?php $item['description']; ?>"><span><?php echo esc_attr( $item['likes'] ); ?></span>
									</a></div>
								<div class="comments">
									<a href="<?php echo esc_url( $item['link'] ) ?>"
									   target="<?php echo esc_attr( ( $link_new_page == 'yes' ) ? '_blank' : '_self' ); ?>"
									   title="<?php $item['description']; ?>"><span><?php echo esc_attr( $item['comments'] ); ?></span>
									</a></div>
							</div>
						<?php } ?>

						<img src="<?php echo esc_url( $item['thumbnail'] ); ?>" alt="" class="item-image"/>
						<?php if ( 'video' == $item['type'] ) { ?>
							<span class="play-button"><?php esc_html_e( 'Play', 'amely' ) ?></span>
						<?php } ?>

						<div class="overlay">
							<a href="<?php echo esc_url( $item['link'] ) ?>"
							   target="<?php echo esc_attr( ( $link_new_page == 'yes' ) ? '_blank' : '_self' ); ?>">
								See on Instagram</a>
						</div>

					</div>
				<?php } ?>
			</div>
		<?php } ?>
		<?php if ( $content ) { ?>
			<div class="tm-instagram-follow-links">
				<?php echo esc_attr( $content ); ?>
			</div>
		<?php }
	} ?>

</div>
