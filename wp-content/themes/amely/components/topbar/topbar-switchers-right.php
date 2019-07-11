<?php
$container_classes   = array( '' );
$container_classes[] = 'container ' . amely_get_option( 'topbar_width' );

$topbar               = amely_get_option( 'topbar' );
$topbar_bgcolor       = amely_get_option( 'topbar_bgcolor' );
$topbar_scheme        = amely_get_option( 'topbar_scheme' );
$topbar_divider_style = amely_get_option( 'topbar_divider_style' );

if ( is_page() ) {
	$topbar_bgcolor = get_post_meta( Amely_Helper::get_the_ID(), 'amely_topbar_bgcolor' );
}

$topbar_classes   = array( 'topbar' );
$topbar_classes[] = 'topbar-' . $topbar;
$topbar_classes[] = 'topbar-scheme--' . $topbar_scheme;
$topbar_classes[] = 'topbar-divider--' . $topbar_divider_style;

if ( $topbar_scheme == 'custom' && ( $topbar_bgcolor == 'transparent' || empty( $topbar_bgcolor ) ) ) {
	$topbar_classes[] = 'topbar-transparent';
}
?>
<!-- Top bar -->
<div class="<?php echo esc_attr( implode( ' ', $topbar_classes ) ); ?>">
	<div class="<?php echo implode( ' ', $container_classes ) ?>">
		<div class="row">
			<div class="topbar-left col-xs-12 col-lg-6">
				<?php
				if ( amely_get_option( 'topbar_social' ) ) {
					echo Amely_Templates::social_links();
				}
				?>
				<div class="topbar-text">
					<?php echo amely_get_option( 'topbar_text' ); ?>
				</div>
			</div>
			<div class="topbar-right col-xs-12 col-lg-6 hidden-md-down">

				<?php

				echo Amely_Templates::currency_switcher();
				echo Amely_Templates::language_switcher();

				if ( amely_get_option( 'topbar_menu' ) ) {
					// Top bar menu.
					$args = array(
						'theme_location'  => 'top_bar',
						'menu_id'         => 'topbar-menu',
						'container_class' => 'topbar-menu',
						'fallback_cb'     => false,
						'walker'          => new Amely_Walker_Nav_Menu(),
					);

					if ( is_user_logged_in() ) {
						$args['menu'] = amely_get_option( 'topbar_logged_in_menu' );
					}

					wp_nav_menu( $args );
				}

				?>
			</div>
		</div>
	</div>
</div>
<!-- / End top bar -->
