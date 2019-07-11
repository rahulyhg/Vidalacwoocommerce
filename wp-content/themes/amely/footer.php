<?php
/**a
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amely
 */

?>
<?php

do_action( 'amely_main_container_bottom' );

$pageID         = Amely_Helper::get_the_ID();
$disable_footer = get_post_meta( $pageID, 'amely_disable_footer', true );

$footer_width        = amely_get_option( 'footer_width' );
$footer_color_scheme = amely_get_option( 'footer_color_scheme' );

$footer_sidebars = array(
	'sidebar-footer-1',
	'sidebar-footer-2',
	'sidebar-footer-3',
	'sidebar-footer-4',
);

$layout = explode( '_', amely_get_option( 'footer_layout' ) );

?>

</div>

<?php if ( ! $disable_footer ) : ?>

	<div id="footer" class="site-footer site-footer--<?php echo esc_attr( $footer_color_scheme ); ?> ">
		<div class="container<?php echo ( $footer_width == 'wide' ) ? ' wide' : ''; ?>">
			<div class="row">
				<?php

				$columns = $layout[0];
				$col_xl  = $layout[1];
				$col_lg  = $columns > 1 ? 4 : 12;

				?>

				<?php for ( $i = 0; $i < $columns; $i ++ ) : ?>
					<div
						class="col-xs-12 col-lg-<?php echo esc_attr( $col_lg ); ?> col-xl-<?php echo esc_attr( $col_xl ); ?>">
						<?php if ( is_active_sidebar( $footer_sidebars[ $i ] ) ) : ?>
							<?php dynamic_sidebar( $footer_sidebars[ $i ] ); ?>
						<?php endif; ?>
					</div>
				<?php endfor; ?>

			</div>
		</div>

		<?php if ( amely_get_option( 'footer_copyright' ) ): ?>
			<div class="site-copyright">
				<div class="container<?php echo ( $footer_width == 'wide' ) ? ' wide' : ''; ?>">
					<div class="row flex-items-xs-middle">
						<div class="col-xs-12 text-xs-center">
							<?php echo wp_kses_post( amely_get_option( 'footer_copyright_text' ) ); ?>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>

	</div>
<?php endif; ?>

<?php do_action( 'amely_site_bottom' ); ?>

<?php echo Amely_Templates::back_to_top() ?>
<?php echo Amely_Templates::cookie_notice() ?>

</div>

<?php do_action( 'amely_after_page_container' ); ?>
<?php wp_footer(); ?>

</body>

</html>
