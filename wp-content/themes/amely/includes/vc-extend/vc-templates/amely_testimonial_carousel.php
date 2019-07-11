<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $text_size
 * @var $text_color
 * @var $style_testimonial
 * @var $item_count
 * @var $items_to_show
 * @var $order
 * @var $category
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Testimonial_Carousel
 */
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-testimonial-carousel',
	'text-size-' . $text_size,
	'text-color-' . $text_color,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

// TESTIMONIAL QUERY SETUP.
$args = array(
	'orderby'        => $order,
	'post_type'      => 'testimonials',
	'post_status'    => 'publish',
	'posts_per_page' => $item_count,
	'no_found_rows'  => 1,
);

if ( $category && $category != '0' ) {
	$args['tax_query'] = array(
		array(
			'taxonomy' => 'testimonials-category',
			'field'    => 'slug',
			'terms'    => $category,
		),
	);
}

$testimonials = new WP_Query( $args );
?>

<div class="<?php echo esc_attr( trim( $css_class ) ); ?>"
     data-atts="<?php echo esc_attr( json_encode( $atts ) ); ?>">
	<?php
	// TESTIMONIAL LOOP.
	while ( $testimonials->have_posts() ) : $testimonials->the_post();
		$testimonial_text         = get_the_content();
		$testimonial_cite         = get_post_meta( Amely_Helper::get_the_ID(), 'amely_testimonial_cite', true );
		$testimonial_cite_subtext = get_post_meta( Amely_Helper::get_the_ID(),
			'amely_testimonial_cite_subtext',
			true );

		if ( $style_testimonial == '1' ) { ?>
			<div class="amely-testimonial-carousel__item image-above-center">

				<?php // Testimonial Image setup.
				$testimonial_image = get_post_meta( Amely_Helper::get_the_ID(),
					'amely_testimonial_cite_image',
					true );

				if ( ! $testimonial_image ) {
					$testimonial_image     = get_post_thumbnail_id();
					$testimonial_image_url = wp_get_attachment_url( $testimonial_image, 'full' );
				}
				// Testimonial Image.
				if ( $testimonial_image ) {
					?>
					<div class="cite-image amely-testimonial-carousel__img"><img
							src="<?php echo esc_url( $testimonial_image ); ?>"
							width="80" height="80"
							alt="<?php echo esc_attr( $testimonial_cite ) ?>"/></div>
				<?php } ?>

				<div class="amely-testimonial-carousel__text"><?php echo do_shortcode( $testimonial_text ) ?></div>

				<div class="box-cite">
					<div class="amely-testimonial-carousel__cite">
						<?php echo esc_html( $testimonial_cite ); ?>
					</div>
					<?php if ( $testimonial_cite_subtext != '' ) { ?>
						<div
							class="amely-testimonial-carousel__sub-cite"><?php echo esc_html( $testimonial_cite_subtext ); ?></div>
					<?php } ?>
				</div>

			</div>
		<?php }

		if ( $style_testimonial == '2' ) { ?>
			<div class="amely-testimonial-carousel__item image-above-left">

				<?php // Testimonial Image setup.
				$testimonial_image = get_post_meta( Amely_Helper::get_the_ID(),
					'amely_testimonial_cite_image',
					true );

				if ( ! $testimonial_image ) {
					$testimonial_image     = get_post_thumbnail_id();
					$testimonial_image_url = wp_get_attachment_url( $testimonial_image, 'full' );
				}
				// Testimonial Image.
				if ( $testimonial_image ) {
					?>
					<div class="cite-image amely-testimonial-carousel__img"><img
							src="<?php echo esc_url( $testimonial_image ); ?>"
							width="80" height="80"
							alt="<?php echo esc_attr( $testimonial_cite ) ?>"/></div>
				<?php } ?>

				<div class="box-cite">
					<div class="amely-testimonial-carousel__cite">
						<?php echo esc_html( $testimonial_cite ); ?>
					</div>
					<?php if ( $testimonial_cite_subtext != '' ) { ?>
						<div
							class="amely-testimonial-carousel__sub-cite"><?php echo esc_html( $testimonial_cite_subtext ); ?></div>
					<?php } ?>
				</div>

				<div class="amely-testimonial-carousel__text"><?php echo do_shortcode( $testimonial_text ) ?></div>

			</div>
		<?php }

		if ( $style_testimonial == '3' ) { ?>
			<div class="amely-testimonial-carousel__item image-below">

				<div class="amely-testimonial-carousel__text"><?php echo do_shortcode( $testimonial_text ) ?></div>

				<?php // Testimonial Image setup.
				$testimonial_image = get_post_meta( Amely_Helper::get_the_ID(),
					'amely_testimonial_cite_image',
					true );

				if ( ! $testimonial_image ) {
					$testimonial_image     = get_post_thumbnail_id();
					$testimonial_image_url = wp_get_attachment_url( $testimonial_image, 'full' );
				}
				// Testimonial Image.
				if ( $testimonial_image ) {
					?>
					<div class="cite-image amely-testimonial-carousel__img"><img
							src="<?php echo esc_url( $testimonial_image ); ?>"
							width="80" height="80"
							alt="<?php echo esc_attr( $testimonial_cite ) ?>"/></div>
				<?php } ?>

				<div class="box-cite">
					<div class="amely-testimonial-carousel__cite">
						<?php echo esc_html( $testimonial_cite ); ?>
					</div>
					<?php if ( $testimonial_cite_subtext != '' ) { ?>
						<div
							class="amely-testimonial-carousel__sub-cite"><?php echo esc_html( $testimonial_cite_subtext ); ?></div>
					<?php } ?>
				</div>

			</div>
		<?php }


		?>
		<?php
	endwhile;
	wp_reset_postdata();
	?>
</div>
