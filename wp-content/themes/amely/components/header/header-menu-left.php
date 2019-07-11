<?php
$container_classes          = array( '' );
$container_classes[]        = 'container ' . amely_get_option( 'header_width' );
$offcanvas_position         = amely_get_option( 'offcanvas_position' );
$header_left_column_content = amely_get_option( 'header_left_column_content' );
$header_right_column_layout = amely_get_option( 'header_right_column_layout' );

if ( $header_right_column_layout == 'only-mini-cart' ) {
	$header_right_column_layout = 'base';
}

?>
<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
	<div class="row">
		<div class="left-col content-<?php echo esc_attr( $header_left_column_content ); ?>">
			<?php
			if ( $offcanvas_position == 'left' ) {
				echo Amely_Templates::header_offcanvas_btn();
			}
			echo Amely_Templates::header_block_site_menu();
			?>
		</div>
		<?php echo Amely_Templates::header_block_logo(); ?>
		<?php ?>
		<div class="right-col header-tools layout-<?php echo esc_attr( $header_right_column_layout ); ?>">
			<?php echo Amely_Templates::header_block_search(); ?>
			<?php echo Amely_Templates::header_block_header_login(); ?>
			<?php echo Amely_Templates::header_block_wishlist(); ?>
			<?php echo Amely_Templates::header_block_cart(); ?>
			<?php echo Amely_Templates::header_block_mobile_btn(); ?>
			<?php
			if ( $offcanvas_position == 'right' ) {
				echo Amely_Templates::header_offcanvas_btn();
			}
			?>
		</div>
	</div>
</div>
