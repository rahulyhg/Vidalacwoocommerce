<?php
$container_classes   = array( '' );
$container_classes[] = 'container ' . amely_get_option( 'topbar_width' );

$topbar         = amely_get_option( 'topbar' );
$topbar_bgcolor = amely_get_option( 'topbar_bgcolor' );
$topbar_scheme  = amely_get_option( 'topbar_scheme' );

if ( is_page() ) {
	$topbar_bgcolor = get_post_meta( Amely_Helper::get_the_ID(), 'amely_topbar_bgcolor' );
}

$topbar_classes   = array( 'topbar' );
$topbar_classes[] = 'topbar-' . $topbar;
$topbar_classes[] = 'topbar-scheme--' . $topbar_scheme;

if ( $topbar_scheme == 'custom' && ( $topbar_bgcolor == 'transparent' || empty( $topbar_bgcolor ) ) ) {
	$topbar_classes[] = 'topbar-transparent';
}
?>
<!-- Top bar -->
<div class="<?php echo esc_attr( implode( ' ', $topbar_classes ) ); ?>">
	<div class="<?php echo implode( ' ', $container_classes ) ?>">
		<div class="row">
			<div class="topbar-center col-xs-12 text-xs-center">
				<div class="topbar-text">
					<?php echo amely_get_option( 'topbar_text' ); ?>
				</div>
			</div>
		</div>
	</div>
	<?php if ( amely_get_option( 'topbar_can_close' ) ) { ?>
		<a href="#" class="topbar-close-btn"><?php echo esc_html_e( 'Close', 'amely' ); ?></a>
	<?php } ?>
</div>
<?php if ( amely_get_option( 'topbar_can_close' ) ) { ?>
	<a href="#" class="hint--left hint--bounce topbar-open-btn"
	   aria-label="<?php echo esc_html_e( 'Open the top bar', 'amely' ); ?>"><i
			class="ti-angle-up"></i><?php echo esc_html_e( 'Open the top bar', 'amely' ); ?></a>
<?php } ?>
<!-- / End top bar -->
