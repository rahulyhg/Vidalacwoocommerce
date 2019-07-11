<?php
$container_classes = array( 'container' );

?>
<div class="<?php echo esc_attr( implode( ' ', $container_classes ) ); ?>">
	<div class="row">
		<?php echo Amely_Templates::header_block_logo(); ?>
		<div class="menu-wrapper">
			<?php echo Amely_Templates::header_block_site_menu(); ?>
		</div>
		<div class="header-tools layout-base">
			<?php echo Amely_Templates::header_block_search(); ?>
			<?php echo Amely_Templates::header_block_header_login(); ?>
			<?php echo Amely_Templates::header_block_wishlist(); ?>
			<?php echo Amely_Templates::header_block_cart(); ?>
			<?php echo Amely_Templates::header_block_mobile_btn(); ?>
		</div>
		<?php
		if ( amely_get_option( 'mobile_menu_social' ) ) {
			echo Amely_Templates::social_links();
		}
		?>
	</div>
</div>
