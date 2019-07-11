<?php

$pageID = Amely_Helper::get_the_ID();

$container_classes          = array( '' );
$container_classes[]        = 'container ' . amely_get_option( 'header_width' );
$offcanvas_position         = amely_get_option( 'offcanvas_position' );
$header_left_column_content = amely_get_option( 'header_left_column_content' );
$header_right_column_layout = amely_get_option( 'header_right_column_layout' );
$left_sidebar               = amely_get_option( 'header_left_sidebar' );

?>
<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
	<div class="row">
		<div class="left-col content-<?php echo esc_attr( $header_left_column_content ); ?>">
			<?php
			if ( $header_left_column_content == 'switchers' ) {
				echo Amely_Templates::language_switcher();
				echo Amely_Templates::currency_switcher();
			} elseif ( $header_left_column_content == 'social' ) {
				echo Amely_Templates::social_links();
			} elseif ( $header_left_column_content == 'search' ) {
				echo Amely_Templates::header_block_search();
			} else { ?>
				<div class="header-widget header-widget-left">
					<?php
					if ( $left_sidebar ) {
						dynamic_sidebar( $left_sidebar );
					} ?>
				</div>
			<?php } ?>
		</div>
		<?php echo Amely_Templates::header_block_logo(); ?>
		<div class="right-col header-tools layout-<?php echo esc_attr( $header_right_column_layout ); ?>">
			<?php
			if ( $header_right_column_layout != 'only-mini-cart' ) {

				if ( $header_left_column_content != 'search' ) {
					echo Amely_Templates::header_block_search();
				}

				echo Amely_Templates::header_block_header_login();
				echo Amely_Templates::header_block_wishlist();
				echo Amely_Templates::header_block_cart();
			} else {
				echo Amely_Templates::header_block_cart();
			}
			echo Amely_Templates::header_block_mobile_btn();
			?>
		</div>
	</div>
</div>
<div class="site-menu-wrap">
	<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
		<?php

		if ( $offcanvas_position == 'left' ) {
			echo Amely_Templates::header_offcanvas_btn();
		}

		echo Amely_Templates::header_block_site_menu();

		if ( $offcanvas_position == 'right' ) {
			echo Amely_Templates::header_offcanvas_btn();
		}
		?>
	</div>
</div>
