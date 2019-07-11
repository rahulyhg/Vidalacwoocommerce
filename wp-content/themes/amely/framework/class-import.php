<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initial OneClick import for this theme
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Import' ) ) {

	class Amely_Import {

		/**
		 * The constructor.
		 */
		public function __construct() {

			// Import Demo.
			add_filter( 'insight_core_import_demos', array( $this, 'import_demos' ) );

			// Import Dummies
			add_filter( 'insight_core_import_dummies', array( $this, 'import_dummies' ) );
		}

		/**
		 * Import Demo
		 *
		 * @since 1.0
		 */
		public function import_demos() {
			return array(
				'full'  => array(
					'screenshot'  => AMELY_THEME_URI . Amely_Helper::get_config( 'screenshot' ),
					'name'        => AMELY_THEME_NAME . esc_html__( ' - Full Demo', 'amely' ),
					'description' => esc_html__( 'This is a full import package. Once installed, everything looks like our demo. However, it is large and takes a lot of time.',
						'amely' ),
					'url'         => Amely_Helper::get_config( 'import_package_full' ),
				),
				'dummy' => array(
					'screenshot'  => AMELY_THEME_URI . Amely_Helper::get_config( 'screenshot' ),
					'name'        => AMELY_THEME_NAME . esc_html__( ' - Dummy', 'amely' ),
					'description' => esc_html__( 'This is a minimized import package. Images will be dimmed and reduced in size. If you have problems with the Full Demo package, try installing it.',
						'amely' ),
					'url'         => Amely_Helper::get_config( 'import_package_dummy' ),
				),
			);
		}

		/**
		 * Import dummies
		 */
		public function import_dummies() {

			$dummy_packages = Amely_Helper::get_config( 'dummy_packages' );
			$dummies        = array();

			if ( isset( $dummy_packages['images'] ) ) {
				$dummies['images'] = array(
					'screenshot' => esc_url( 'http://amely.thememove.com/wp-content/uploads/2017/12/home-1.png' ),
					'name'       => esc_html__( 'Images - Required', 'amely' ),
					'url'        => $dummy_packages['images'],
					'process'    => 'media',
				);
			}

			$dummies['content'] = array(
				'screenshot' => esc_url( 'http://amely.thememove.com/wp-content/uploads/2017/12/home-1.png' ),
				'name'       => esc_html__( 'Content (without sliders) - Required', 'amely' ),
				'process'    => 'xml,home,widgets,menus,woocommerce,attribute_swatches',
			);

			$dummies['sliders'] = array(
				'screenshot' => esc_url( 'http://document.thememove.com/amely/img/slider1.png' ),
				'name'       => esc_html__( 'Sliders - Required', 'amely' ),
				'process'    => 'sliders',
			);

			$dummies['ver_1_2'] = array(
				'screenshot' => esc_url( 'http://amely.thememove.com/wp-content/uploads/2018/03/home13.jpg' ),
				'name'       => esc_html__( '[1.2] 3 New Homepages', 'amely' ),
				'process'    => 'xml,sliders',
			);

			$dummies['popup'] = array(
				'screenshot' => esc_url( 'http://img.thememove.com/amely/popup.png' ),
				'name'       => esc_html__( 'Popup', 'amely' ),
				'process'    => 'xml',
			);

			return $dummies;
		}
	}

	new Amely_Import();
}
