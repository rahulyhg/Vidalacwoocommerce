<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amely
 */
$display_type = amely_get_option( 'archive_display_type' );

if ( is_category() ) {
	$term_id      = get_category( get_query_var( 'cat' ) )->term_id;
	$display_type = get_term_meta( $term_id, 'amely_archive_display_type', true );

	if ( $display_type == 'default' || ! $display_type ) {
		$display_type = amely_get_option( 'archive_display_type' );
	}
}

$content_output         = amely_get_option( 'archive_content_output' );
$excerpt_length         = amely_get_option( 'excerpt_length' );
$archive_sidebar_config = amely_get_option( 'archive_sidebar_config' );
$img_size               = ( $display_type == 'grid' ) ? 'amely-post-grid' : 'amely-single-thumb';
$img_size               = apply_filters( 'amely_blog_image_size', $img_size );

$classes  = array('post-item');

/* from amely-blog shortcode */
if ( isset( $view ) ) {
	$display_type = $view;
}

if ( isset( $shortcode_post_class ) ) {
	$classes[] = $shortcode_post_class;
}

if ( $display_type == 'grid' ) {
	$classes[] = 'grid-item';

	if ( $archive_sidebar_config == 'no' ) {
		$classes[] = 'col-xs-12 col-md-6 col-lg-4';
	} else {
		$classes[] = 'col-xs-12 col-md-6';
	}
}

if ( $display_type == 'masonry' ) {
	$classes[] = 'masonry-item';

	if ( $archive_sidebar_config == 'no' ) {
		$classes[] = 'grid-sizer-3';
	} else {
		$classes[] = 'grid-sizer-2';
	}
}

if ( $display_type == 'standard' ) {
	$classes[] = 'col-lg-12';
}

?>

<article id="post-<?php the_ID(); ?>" <?php post_class( $classes ); ?>>

	<?php if ( has_post_format( 'gallery' ) ) { // Gallery. ?>
		<?php $gallery_images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>
		<div class="entry-thumbnail">
			<div class="post-media post-gallery">
				<?php if ( ! empty( $gallery_images ) ) { ?>
					<div class="slider">
						<?php foreach ( $gallery_images as $image ) { ?>
							<?php
							$img     = wp_get_attachment_image_src( $image, $img_size );
							$caption = get_post_field( 'post_excerpt', $image ); ?>
							<div class="single-image">
								<a href="<?php echo esc_url( $img[0] ); ?>">
									<img src="<?php echo esc_url( $img[0] ); ?>" alt="<?php echo ''; ?>">
								</a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
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
				<?php $audio = get_post_meta( get_the_ID(), '_format_audio_embed', true ); ?>
				<?php if ( wp_oembed_get( $audio ) ) { ?>
					<?php echo wp_oembed_get( $audio ); ?>
				<?php } else { ?>
					<?php echo wp_kses_post( $audio ); ?>
				<?php } ?>
			</div>
		</div>
	<?php } elseif ( has_post_format( 'quote' ) ) { // Quote. ?>
		<?php $source_name = get_post_meta( get_the_ID(), '_format_quote_source_name', true ); ?>
		<?php $url = get_post_meta( get_the_ID(), '_format_quote_source_url', true ); ?>
		<?php $quote = get_post_meta( get_the_ID(), '_format_quote_text', true ); ?>

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
						<?php } ?>
						<a href="<?php echo esc_url( get_permalink() ); ?>" class="post-link"><i class="fa fa-link"></i></a>
					</div>
				</div>
			</div>
		<?php } ?>
	<?php } else {  // Default/Image. ?>
		<?php if ( ! post_password_required() && ! is_attachment() && has_post_thumbnail() ) { ?>
			<div class="entry-thumbnail">
				<div class="post-media post-thumb">
					<a href="<?php echo esc_url( get_permalink() ); ?>"><?php the_post_thumbnail( $img_size ); ?></a>
				</div>
			</div>
		<?php } ?>
	<?php } ?>
	<div class="entry-body">
		<div class="entry-header">
			<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">',
				esc_url( get_permalink() ) ),
				'</a></h2>' ); ?>
		</div>

		<?php if ( amely_get_option( 'post_meta' ) ) {
			echo Amely_Templates::post_meta();
		} ?>

		<div class="entry-content">
			<?php if ( $content_output == 'content' ) {
				echo Amely_Templates::get_the_content_with_formatting();
			} else {
				echo Amely_Templates::excerpt( $excerpt_length );
			} ?>
		</div>

		<div class="entry-aux">
			<?php
			wp_link_pages( array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:',
						'amely' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'amely' ) . ' </span>%',
			) );
			?>

			<?php if ( $content_output == 'excerpt' ) { ?>
				<a class="readmore-button"
				   href="<?php the_permalink( get_the_ID() ) ?>"><?php esc_html_e( 'Read more', 'amely' ); ?></a>
			<?php } ?>


		</div>

	</div>

</article>
