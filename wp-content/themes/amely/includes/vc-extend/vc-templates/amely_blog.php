<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $title
 * @var $title_alignment
 * @var $title_color
 * @var $view
 * @var $grid_align
 * @var $total_posts
 * @var $posts_per_page
 * @var $pagination_type
 * @var $loop
 * @var $auto_play
 * @var $auto_play_speed
 * @var $nav_type
 * @var $columns
 * @var $el_class
 * @var $orderby
 * @var $order
 * @var $filter
 * @var $cat_slugs
 * @var $tag_slugs
 * @var $responsive
 * @var $slider_responsive
 * @var $css
 *
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Blog
 */
global $amely_options;

$amely_options['archive_display_type'] = 'standard';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$this->get_query( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-blog',
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$col_lg = 'col-lg-' . Amely_VC::calculate_column_width( $columns );

$shortcode_post_class = 'col-md-6 ' . $col_lg . ' post post-item';

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-blog' );

?>
<div id="<?php echo esc_attr( $css_id ); ?>"
     class="<?php echo esc_attr( trim( $css_class ) ); ?>" data-atts="<?php echo esc_attr( json_encode( $atts ) ) ?>">

	<?php if ( 'grid' == $view ) { ?>
	<div class="post-grid-layout <?php echo esc_attr( $grid_align ); ?> posts row">
		<?php } ?>

		<?php if ( 'masonry' == $view ) { ?>
		<div class="post-masonry-layout <?php echo esc_attr( $grid_align ); ?> posts row">
			<?php } ?>

			<?php if ( 'carousel' == $view ) { ?>
			<div class="js-post-carousel post-carousel-layout <?php echo esc_attr( $grid_align ); ?> posts row"
			     data-atts="<?php echo esc_attr( json_encode( $atts ) ); ?>">
				<?php } ?>

				<?php if ( $this->query->have_posts() ) { ?>

					<?php while ( $this->query->have_posts() ) :
						$this->query->the_post();
						include( locate_template( 'components/post/content.php' ) );
					endwhile; // end of the loop. ?>

					<?php wp_reset_postdata(); ?>

				<?php } else { ?>

					<?php get_template_part( 'components/content', 'none' ); ?>

				<?php } ?>

			</div>


			<?php if ( $this->num_pages >= 2 && $pagination_type == 'default' && $view != 'carousel' ) { ?>
				<div class="amely-pagination posts-pagination">
					<?php echo '' . $this->get_paging_nav(); ?>
				</div>
			<?php } ?>

			<?php
			if ( $this->num_pages >= 2 && $pagination_type != 'default' && $view != 'carousel' ) {

				$load_more_atts = array(
					'container'      => '#' . $css_id,
					'post_type'      => 'post',
					'paged'          => 1,
					'posts_per_page' => apply_filters( 'amely_ajax_posts_per_page', $posts_per_page ),
					'view'           => $view,
					'columns'        => $columns,
					'orderby'        => $orderby,
					'order'          => $order
				) ?>
				<div class="amely-loadmore-wrap"
				     data-atts="<?php echo esc_attr( json_encode( $load_more_atts ) ); ?>">
					<span class="amely-loadmore-btn load-on-<?php echo ( $pagination_type == 'more-btn' ) ? 'click' : 'scroll'; ?>"><?php esc_html_e( 'Load More...',
							'amely' ); ?></span>
				</div>
			<?php } ?>

		</div>
