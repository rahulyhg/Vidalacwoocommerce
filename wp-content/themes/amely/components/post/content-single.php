<?php
/**
 * Template part for displaying single posts.
 *
 * @package Amely
 */
$post_show_tags   = amely_get_option( 'post_show_tags' );
$post_show_share  = amely_get_option( 'post_show_share' );
$post_share_links = amely_get_option( 'post_share_links' );

$no_share_links = true;

if ( is_array( $post_share_links ) ) {

	foreach ( $post_share_links as $link ) {
		if ( $link ) {
			$no_share_links = false;
		}
	}
}

$header_classes = array( 'entry-header' );

if ( amely_get_option( 'single_nav_on' ) ) {
	$header_classes[] = 'single-nav-on';
}

?>

<article <?php post_class(); ?>>

	<?php if ( get_post_meta( get_the_ID(), 'amely_post_title_on_top', true )  == 'on' ) { ?>
		<div class="<?php echo implode( ' ', $header_classes ) ?>">
			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			<?php echo Amely_Templates::single_navigation(); ?>
		</div>
	<?php } ?>

	<?php if ( amely_get_option( 'post_meta' ) ) {
		echo Amely_Templates::post_meta( array(
			'author' => amely_get_option( 'post_meta_author' ),
			'cats'   => amely_get_option( 'post_meta_categories' ),
		) );
	} ?>

	<div class="entry-content">
		<?php if ( has_post_format( 'gallery' ) ) { // Gallery. ?>
			<?php $gallery_images = get_post_meta( get_the_ID(), '_format_gallery_images', true ); ?>
			<div class="entry-thumbnail">
				<div class="post-media post-gallery">
					<div class="slider">
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
						<?php echo wp_kses( $video ); ?>
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
						<?php the_post_thumbnail( 'amely-single-thumb' ); ?>
					</div>
				</div>
			<?php } ?>
		<?php } ?>

		<?php
		the_content();
		wp_link_pages( array(
			'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:',
					'amely' ) . '</span>',
			'after'       => '</div>',
			'link_before' => '<span>',
			'link_after'  => '</span>',
			'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'amely' ) . ' </span>%',
		) );
		?>
	</div>

	<hr class="post-single-hr">

	<div class="row flex-items-xs-middle">

		<?php if ( $post_show_share && ! $no_share_links && is_array( $post_share_links ) ) { ?>
			<div class="post-share col-xs-12 col-sm-6">
				<ul class="list-inline share-list">
					<li class="list-inline-item"><h3
							class="share-list__title"><?php echo esc_html__( 'Share', 'amely' ); ?>
							: </h3></li>
					<?php do_action( 'amely_before_post_share' ); ?>
					<?php if ( isset( $post_share_links['facebook'] ) && $post_share_links['facebook'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;">
								<i class="fa fa-facebook"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( isset( $post_share_links['twitter'] ) && $post_share_links['twitter'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php echo rawurlencode( the_title( '',
								'',
								false ) ); ?>%20-%20<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;">
								<i class="fa fa-twitter"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( isset( $post_share_links['google'] ) && $post_share_links['google'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;">
								<i class="fa fa-google-plus"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( isset( $post_share_links['pinterest'] ) && $post_share_links['pinterest'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;"
							   title="<?php esc_attr_e( 'Pinterest', 'amely' ) ?>">
								<i class="fa fa-pinterest"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( isset( $post_share_links['email'] ) && $post_share_links['email'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="mailto:?subject=I%20wanted%20you%20to%20see%20this%20site&amp;body=<?php the_permalink(); ?>&amp"
							   title="<?php esc_attr_e( 'Email', 'amely' ) ?>">
								<i class="fa fa-envelope-o"></i>
							</a>
						</li>
					<?php } ?>
					<?php do_action( 'amely_after_post_share' ); ?>
				</ul>
			</div>
		<?php } ?>

		<?php if ( $post_show_tags ) { ?>
			<div
				class="post-tags<?php echo ( $post_show_share && ! $no_share_links && is_array( $post_share_links ) ) ? '  col-sm-6 flex-items-xs-right text-sm-right' : ' col-xs-12'; ?>">
				<?php the_tags( '<ul class="tagcloud"><li class="tag-cloud__item">',
					'</li><li class="tag-cloud__item">',
					'</li></ul>' ); ?>
			</div>
		<?php } ?>
	</div>

</article>
