<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Amely
 */

get_header();

global $amely_has_blog;
$amely_has_blog = true;

// Variables.
$page_wrap_class = $content_class = '';

// Sidebar config.
$archive_sidebar_config = amely_get_option( 'archive_sidebar_config' );

if ( $archive_sidebar_config == 'left' ) {
	$page_wrap_class = 'has-sidebar-left row';
	$content_class   = 'col-xs-12 col-md-8 col-lg-9';
} elseif ( $archive_sidebar_config == 'right' ) {
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
				<?php do_action( 'amely_base_loop' ); ?>
			</div>
			<?php get_sidebar(); ?>
		</div>
	</div>

<?php
get_footer();
