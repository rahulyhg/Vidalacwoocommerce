<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue child scripts
 */
add_action( 'wp_enqueue_scripts', 'amely_child_enqueue_scripts' );
if ( ! function_exists( 'amely_child_enqueue_scripts' ) ) {

	function amely_child_enqueue_scripts() {
		wp_enqueue_style( 'amely-main-style', trailingslashit( get_template_directory_uri() ) . '/style.css' );
		wp_enqueue_style( 'amely-child-style', trailingslashit( get_stylesheet_directory_uri() ) . 'style.css' );
		wp_enqueue_script( 'amely-child-script',
			trailingslashit( get_stylesheet_directory_uri() ) . 'script.js',
			array( 'jquery' ),
			null,
			true );
	}

}
