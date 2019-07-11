<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Security setups
 *
 * @since     1.0
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Security' ) ) {

	class Amely_Security {

		public function __construct() {
			// Disable XMLRPC
			add_filter( 'xmlrpc_enabled', '__return_false' );
			add_filter( 'pre_option_enable_xmlrpc', '__return_false' );

			// Remove WordPress version from any enqueued scripts
			add_filter( 'style_loader_src', array( $this, 'at_remove_wp_ver_css_js' ), 9999 );
			add_filter( 'script_loader_src', array( $this, 'at_remove_wp_ver_css_js' ), 9999 );

			// Disable support for trackbacks in post types
			add_action( 'admin_init', array( $this, 'posttype_disable_trackbacks' ) );

			// Prefill form fields with comment author cookie
			add_action( 'wp_head', array( $this, 'comment_author_cookie' ) );
		}

		/**
		 * @param $src
		 *
		 * @return mixed|string
		 */
		public function at_remove_wp_ver_css_js( $src ) {
			$override = apply_filters( 'pre_at_remove_wp_ver_css_js', false, $src );
			if ( $override !== false ) {
				return $override;
			}

			if ( strpos( $src, 'ver=' ) ) {
				$src = remove_query_arg( 'ver', $src );
			}

			return $src;
		}

		public function posttype_disable_trackbacks() {
			$post_types = get_post_types();
			foreach ( $post_types as $post_type ) {
				remove_post_type_support( $post_type, 'trackbacks' );
			}
		}

		public function comment_author_cookie() {
			echo '<script>';
			if ( isset( $_COOKIE[ 'comment_author_' . COOKIEHASH ] ) ) {
				$commentAuthorName  = $_COOKIE[ 'comment_author_' . COOKIEHASH ];
				$commentAuthorEmail = $_COOKIE[ 'comment_author_email_' . COOKIEHASH ];
				echo 'cookieAuthorName = "' . $commentAuthorName . '";';
				echo 'cookieAuthorEmail = "' . $commentAuthorEmail . '";';
			} else {
				echo 'cookieAuthorName = "";';
				echo 'cookieAuthorEmail = "";';
			}
			echo '</script>';
		}

	}

	new Amely_Security();
}
