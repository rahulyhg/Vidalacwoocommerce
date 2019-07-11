<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amely
 */

get_header(); ?>

<?php

global $amely_has_blog;
$amely_has_blog = true;

// Variables.
$page_wrap_class       = $content_class = '';
$remove_bottom_spacing = $remove_top_spacing = '';

// Sidebar config.
$page_sidebar_config = amely_get_option( 'page_sidebar_config' );

if ( $page_sidebar_config == 'left' ) {
	$page_wrap_class = 'has-sidebar-left row';
	$content_class   = 'col-xs-12 col-md-8 col-lg-9';
} else if ( $page_sidebar_config == 'right' ) {
	$page_wrap_class = 'has-sidebar-right row';
	$content_class   = 'col-xs-12 col-md-8 col-lg-9';
} else {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

$sidebar = Amely_Helper::get_active_sidebar();

if ( ! $sidebar ) {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}
?>


	<div class="container">
		<div class="inner-page-wrap <?php echo esc_attr( $page_wrap_class ); ?>">
			<div id="main" class="site-content <?php echo esc_attr( $content_class ); ?>" role="main">

				<?php
				while ( have_posts() ) : the_post();

					get_template_part( 'components/page/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;

				endwhile; // End of the loop.
				?>

			</div>

			<?php get_sidebar(); ?>
		</div>
	</div>
<?php
get_footer();
