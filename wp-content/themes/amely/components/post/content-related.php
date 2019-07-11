<?php

$orig_post = $post;
global $post;

$categories = get_the_category( $post->ID );

$number_of_related = 3;

$classes  = 'post-related ';
$item_col = 'col-xs-12 col-md-6 col-lg-4';

if ( amely_get_option( 'post_sidebar_config' ) == 'no' ) {
	$number_of_related = 4;
	$item_col          = 'col-xs-12 col-md-6 col-lg-3';
}

$classes .= $item_col;

if ( $categories ) {

$category_ids = array();

foreach ( $categories as $individual_category ) {
	$category_ids[] = $individual_category->term_id;
}

$args = array(
	'category__in'        => $category_ids,
	'post__not_in'        => array( $post->ID ),
	'posts_per_page'      => $number_of_related, // Number of related posts that will be shown.
	'ignore_sticky_posts' => 1,
	'orderby'             => 'rand',
);

$my_query = new WP_Query( $args );
if ( $my_query->have_posts() ) { ?>
<div class="post-related">
	<h4 class="post-related__title"><span><?php esc_html_e( 'Related Posts', 'amely' ); ?></span></h4>
	<div class="row">
		<?php while ( $my_query->have_posts() ) {
			$my_query->the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>
				<?php if ( has_post_format( 'gallery' ) ) { // Gallery. ?>
					<?php $gallery_images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>
					<div class="entry-thumbnail">
						<div class="post-media post-gallery">
							<div class="slider owl-carousel">
								<?php if ( ! empty( $gallery_images ) ) { ?>
									<?php foreach ( $gallery_images as $image ) { ?>
										<?php $img = wp_get_attachment_image_src( $image, 'amely-single-thumb' ); ?>
										<?php $caption = get_post_field( 'post_excerpt', $image ); ?>
										<div class="single-image">
											<a href="<?php echo esc_url( $img[0] ); ?>">
												<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo ''; ?>">
											</a>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				<?php } elseif ( has_post_format( 'video' ) ) { // Video. ?>
					<div class="entry-thumbnail">
						<div class="post-media post-video">
							<?php $video = get_post_meta( get_the_ID(), '_format_video_embed', true ); ?>
							<?php if ( wp_oembed_get( $video ) ) { ?>
								<?php echo wp_oembed_get( $video ); ?>
							<?php } else { ?>
								<?php echo wp_kses_post( $video ); ?>
							<?php } ?>
						</div>
					</div>
				<?php } elseif ( has_post_format( 'audio' ) ) { // Audio. ?>
					<div class="entry-thumbnail">
						<div class="post-media post-audio">
							<?php $audio = get_post_meta( $post->ID, '_format_audio_embed', true ); ?>
							<?php if ( wp_oembed_get( $audio ) ) { ?>
								<?php echo wp_oembed_get( $audio ); ?>
							<?php } else { ?>
								<?php echo wp_kses_post( $audio ); ?>
							<?php } ?>
						</div>
					</div>
				<?php } elseif ( has_post_format( 'quote' ) ) { // Quote. ?>
					<?php $source_name = get_post_meta( $post->ID, '_format_quote_source_name', true ); ?>
					<?php $url = get_post_meta( $post->ID, '_format_quote_source_url', true ); ?>
					<?php $quote = get_post_meta( $post->ID, '_format_quote_text', true ); ?>

					<?php if ( $quote ) { ?>
						<div class="entry-thumbnail">
							<div class="post-media post-quote">
								<h2><?php echo esc_attr( $quote ); ?></h2>

								<div class="source-name">
									<?php if ( $source_name ) { ?>
										<?php if ( $url && filter_var( $url, FILTER_VALIDATE_URL ) ) { ?>
											<a href="<?php echo esc_url( $url ); ?>" class="source"
											   target="_blank"><?php echo esc_html( $source_name ); ?></a>
										<?php } else { ?>
											<span><?php echo esc_attr( $source_name ); ?></span>
											<em class="secondary-font"><?php echo esc_html( $url ); ?></em>
										<?php } ?>
										<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-link"><i
												class="fa fa-link"></i></a>
									<?php } ?>
								</div>
							</div>
						</div>
					<?php } ?>
				<?php } else {  // Default/Image. ?>
					<?php if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) { ?>
						<div class="entry-thumbnail">
							<div class="post-media post-thumb">
								<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( 'amely-misc-thumb' ); ?></a>
							</div>
						</div>
					<?php } ?>
				<?php } ?>

				<div class="entry-body">
					<div class="entry-header">
						<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

						<?php if ( amely_get_option( 'post_meta' ) ) {
							echo Amely_Templates::post_meta( array( 'sticky' => 0 ) );
						} ?>
					</div>
				</div>

			</article>
			<?php
		}
		echo '</div>';
		echo '</div>';
		}
		}
		$post = $orig_post;
		wp_reset_postdata();

		?>
