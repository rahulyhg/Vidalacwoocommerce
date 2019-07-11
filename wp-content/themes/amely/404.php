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

global $amely_options;

$amely_options['offcanvas_button_on']        = true;
$amely_options['offcanvas_action']           = 'menu';
$amely_options['sticky_header']              = false;
$amely_options['topbar_on']                  = false;
$amely_options['header']                     = 'base';
$amely_options['search_on']                  = true;
$amely_options['wishlist_on']                = false;
$amely_options['minicart_on']                = true;
$amely_options['header_right_column_layout'] = 'big';


get_header(); ?>

	<div id="main" class="site-content" role="main">

		<div class="area-404">
			<div class="container">
				<div class="area-404__content row flex-items-xs-middle">
					<div class="col-xs-12 col-xl-6 col-404">
						<h1 class="area-404__heading"><?php esc_html_e( 'Oops!', 'amely' ); ?></h1>
						<h1 class="area-404__sub-heading"><?php esc_html_e( 'Page not found!', 'amely' ); ?></h1>
						<p class="area-404__content-heading"><?php esc_html_e( "please go back to ", 'amely' ); ?>
							<a href="<?php echo esc_url( home_url( '/' ) ); ?>"
							   class="button 404-button"><?php esc_html_e( 'Homepage', 'amely' ); ?></a>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
get_footer();
