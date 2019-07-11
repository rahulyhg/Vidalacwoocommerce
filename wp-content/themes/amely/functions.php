<?php

/**
 * Define constants
 *
 * @since 1.0
 */
$insight_theme = wp_get_theme();

if ( ! empty( $insight_theme['Template'] ) ) {
	$insight_theme = wp_get_theme( $insight_theme['Template'] );
}

if ( ! defined( 'DS' ) ) {
	define( 'DS', DIRECTORY_SEPARATOR );
}

define( 'AMELY_THEME_NAME', $insight_theme['Name'] );
define( 'AMELY_THEME_SLUG', $insight_theme['Template'] );
define( 'AMELY_THEME_VERSION', $insight_theme['Version'] );
define( 'AMELY_THEME_DIR', get_template_directory() );
define( 'AMELY_THEME_URI', get_template_directory_uri() );
define( 'AMELY_CHILD_THEME_URI', get_stylesheet_directory_uri() );
define( 'AMELY_CHILD_THEME_DIR', get_stylesheet_directory() );

define( 'AMELY_LIBS_URI', AMELY_THEME_URI . '/assets/libs' );

define( 'AMELY_IMAGES', AMELY_THEME_URI . '/assets/images' );
define( 'AMELY_ADMIN_IMAGES', AMELY_THEME_URI . '/assets/admin/images' );

define( 'AMELY_INC_DIR', AMELY_THEME_DIR . DS . 'includes' );
define( 'AMELY_INC_URI', AMELY_THEME_URI . '/includes' );
define( 'AMELY_FRAMEWORK_DIR', AMELY_THEME_DIR . DS . 'framework' );
define( 'AMELY_FRAMEWORK_URI', AMELY_THEME_URI . '/framework' );

define( 'AMELY_OPTIONS_DIR', AMELY_INC_DIR . DS . 'theme-options' );

/**
 * Load Insight Framework.
 *
 * @since 1.0
 */
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-coming-soon.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-compatible.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-enqueue.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-extras.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-helper.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-import.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-init.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-instagram.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-mailchimp.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-metabox.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-plugins.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-tgm-plugin-activation.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-post-types.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-security.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-templates.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-walker-nav-menu.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-walker-nav-menu-edit.php' );
require_once( AMELY_FRAMEWORK_DIR . DS . 'class-video-product.php' );

if ( class_exists( 'Redux' ) ) {
	require_once( AMELY_FRAMEWORK_DIR . DS . 'class-redux.php' );
}

if ( class_exists( 'WooCommerce' ) ) {
	require_once( AMELY_FRAMEWORK_DIR . DS . 'class-woo.php' );
}

if ( class_exists( 'WPBakeryVisualComposerAbstract' ) ) {
	require_once( AMELY_FRAMEWORK_DIR . DS . 'class-vc.php' );
}

/**
 * Widgets.
 *
 * @since 1.0
 */
require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'wph-widget-class.php' );
require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-contact-info.php' );
require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-instagram.php' );
require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-social.php' );

if ( class_exists( 'WooCommerce' ) ) {
	require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-layered-nav.php' );
	require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-sorting.php' );
	require_once( AMELY_INC_DIR . DS . 'widgets' . DS . 'widget-price-filter.php' );
}

/**
 * Get option from Theme Options
 */
if ( ! function_exists( 'amely_get_option' ) ) {
	function amely_get_option( $option ) {
		return Amely_Helper::get_option( $option );
	}
}
