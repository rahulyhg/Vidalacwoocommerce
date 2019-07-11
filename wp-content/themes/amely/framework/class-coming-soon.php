<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper functions
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Coming_Soon' ) ) {

	class Amely_Coming_Soon {

		public function __construct() {

			add_action( 'template_redirect',
				array(
					$this,
					'redirect',
				) );
			add_action( 'admin_bar_menu',
				array(
					$this,
					'add_toolbar_notice',
				),
				100,
				1 );
		}

		public function add_toolbar_notice( $admin_bar ) {

			if ( amely_get_option( 'coming_soon_mode_on' ) && is_user_logged_in() ) {

				$coming_soon = Amely_Helper::get_pages_ids_from_template( 'coming-soon' );

				$class = $coming_soon ? 'coming-soon-success' : 'coming-soon-warning';
				$title = $coming_soon ? esc_html__( 'Coming Soon: On', 'amely' ) : esc_html__( 'Coming Soon',
					'amely' );

				$admin_bar->add_menu( array(
					'id'    => 'amely-coming-soon',
					'title' => $title,
					'meta'  => array(
						'class' => $class,
					),
					'href'  => add_query_arg( array(
						'page' => 'amely_options',
						'tab'  => '1',
					),
						admin_url() ),
				) );
			}
		}

		/**
		 * Check current page is coming soon page or not?
		 *
		 * @return bool
		 */
		public static function is_coming_soon_page() {

			$pages_ids = Amely_Helper::get_pages_ids_from_template( 'coming-soon' );

			return ( ! empty( $pages_ids ) && is_page( $pages_ids ) );
		}

		/**
		 * Redirect your site to the coming soon page
		 */
		public static function redirect() {

			if ( ! amely_get_option( 'coming_soon_mode_on' ) || is_user_logged_in() ) {
				return;
			}

			$page_id = Amely_Helper::get_pages_ids_from_template( 'coming-soon' );

			$page_id = current( $page_id );

			if ( ! $page_id ) {
				return;
			}

			if ( ! is_page( $page_id ) && ! is_user_logged_in() ) {
				wp_redirect( get_permalink( $page_id ) );
				exit();
			}
		}
	}

	new Amely_Coming_Soon();
}
