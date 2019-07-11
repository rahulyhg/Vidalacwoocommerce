<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Configuration for Redux Framework
 *
 * @package Amely
 */

if ( ! class_exists( 'Amely_Redux' ) ) {

	class Amely_Redux {

		public static $opt_name = 'amely_options';

		public function __construct() {

			$this->setup();

			add_action( 'redux/page/' . self::$opt_name . '/enqueue', array( $this, 'custom_redux_css' ) );

			add_action( 'init', array( $this, 'remove_demo_link' ) );

			add_action( 'redux/extensions/' . self::$opt_name . '/before',
				array(
					$this,
					'redux_register_custom_extension_loader',
				),
				0 );

			add_action( 'customize_register', array( $this, 'remove_default_customizer' ), 11 );
		}

		public function setup() {

			$args = array(
				'opt_name'             => self::$opt_name,
				'display_name'         => AMELY_THEME_NAME,
				'display_version'      => AMELY_THEME_VERSION,
				'menu_type'            => 'menu',
				'allow_sub_menu'       => true,
				'menu_title'           => esc_html__( 'Theme Options', 'amely' ),
				'page_title'           => esc_html__( 'Theme Options', 'amely' ),
				'intro_text'           => wp_kses( sprintf( __( 'Thank you for using our theme, please reward it a full five-star &#9733;&#9733;&#9733;&#9733;&#9733; rating. <br/> <a href="%s" target="_blank">Need support?</a> | <a href="%s" target="_blank">Check Update</a> ',
					'amely' ),
					esc_url( Amely_Helper::get_config( 'support' ) ),
					esc_url( Amely_Helper::get_config( 'tf' ) ) ),
					array(
						'a'  => array(
							'target' => array(),
							'href'   => array(),
						),
						'br' => array(),
					) ),
				'google_api_key'       => '',
				'google_update_weekly' => false,
				'async_typography'     => false,
				'admin_bar'            => true,
				'admin_bar_icon'       => 'dashicons-portfolio',
				'admin_bar_priority'   => 50,
				'global_variable'      => '',
				'dev_mode'             => false,
				'update_notice'        => true,
				'customizer'           => true,
				'page_priority'        => 6,
				'page_parent'          => 'themes.php',
				'page_permissions'     => 'manage_options',
				'menu_icon'            => '', // TODO: change it
				'last_tab'             => '',
				'page_icon'            => 'icon-themes',
				'page_slug'            => 'amely_options',
				'save_defaults'        => true,
				'default_show'         => false,
				'default_mark'         => '',
				'show_import_export'   => true,
				'transient_time'       => 60 * MINUTE_IN_SECONDS,
				'output'               => true,
				'output_tag'           => true,
				'footer_credit'        => '',
				'database'             => '',
				'hide_reset'           => ! WP_DEBUG,
				'system_info'          => false,
				'hints'                => array(
					'icon'          => 'el el-question-sign',
					'icon_position' => 'right',
					'icon_color'    => 'lightgray',
					'icon_size'     => 'normal',
					'tip_style'     => array(
						'color'   => 'light',
						'shadow'  => true,
						'rounded' => false,
						'style'   => '',
					),
					'tip_position'  => array(
						'my' => 'top left',
						'at' => 'bottom right',
					),
					'tip_effect'    => array(
						'show' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'mouseover',
						),
						'hide' => array(
							'effect'   => 'slide',
							'duration' => '500',
							'event'    => 'click mouseleave',
						),
					),
				),
			);

			Redux::setArgs( self::$opt_name, $args );
		}

		/**
		 * Remove demo mode link
		 */
		public function remove_demo_link() { // Be sure to rename this function to something more unique
			if ( class_exists( 'ReduxFrameworkPlugin' ) ) {

				remove_filter( 'plugin_row_meta',
					array(
						ReduxFrameworkPlugin::get_instance(),
						'plugin_metalinks',
					),
					null,
					2 );

				remove_action( 'admin_notices', array( ReduxFrameworkPlugin::get_instance(), 'admin_notices' ) );
			}
		}

		/**
		 * Add custom Redux CSS
		 */
		public function custom_redux_css() {
			// add Font Awesome
			wp_enqueue_style( 'font-awesome',
				AMELY_THEME_URI . '/assets/libs/font-awesome/css/font-awesome.min.css' );

			// ionicons
			wp_enqueue_style( 'font-ion-icons',
				AMELY_THEME_URI . '/assets/libs/Ionicons/css/ionicons.min.css' );

			// themify icons
			wp_enqueue_style( 'font-themify-icons',
				AMELY_THEME_URI . '/assets/libs/themify-icons/css/themify-icons.css' );
		}

		/**
		 * Extension loader
		 *
		 * @param $ReduxFramework
		 */
		public function redux_register_custom_extension_loader( $ReduxFramework ) {

			$path    = AMELY_THEME_DIR . DS . 'includes' . DS . 'extensions' . DS;
			$folders = scandir( $path, 1 );

			foreach ( $folders as $folder ) {

				if ( $folder === '.' or $folder === '..' or ! is_dir( $path . $folder ) ) {
					continue;
				}

				$extension_class = 'ReduxFramework_extension_' . $folder;

				if ( ! class_exists( $extension_class ) ) {
					// In case you wanted override your override, hah.
					$class_file = $path . $folder . '/extension_' . $folder . '.php';
					$class_file = apply_filters( 'redux/extension/' . $ReduxFramework->args['opt_name'] . '/' . $folder,
						$class_file );
					if ( $class_file ) {
						require_once( $class_file );
					}
				}
				if ( ! isset( $ReduxFramework->extensions[ $folder ] ) ) {
					$ReduxFramework->extensions[ $folder ] = new $extension_class( $ReduxFramework );
				}
			}
		}

		public function remove_default_customizer() {
			global $wp_customize;

			$wp_customize->remove_section( 'colors' );
			$wp_customize->remove_section( 'header_image' );
			$wp_customize->remove_section( 'background_image' );
		}
	}

	new Amely_Redux();

	require_once AMELY_OPTIONS_DIR . DS . 'redux-selectors.php';
	require_once AMELY_OPTIONS_DIR . DS . 'features' . DS . '_features.php';
	require_once AMELY_OPTIONS_DIR . DS . 'logo' . DS . '_logo.php';
	require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . '_header.php';
	require_once AMELY_OPTIONS_DIR . DS . 'page-title' . DS . '_page-title.php';
	require_once AMELY_OPTIONS_DIR . DS . 'breadcrumbs' . DS . '_breadcrumbs.php';
	require_once AMELY_OPTIONS_DIR . DS . 'menu' . DS . '_menu.php';
	require_once AMELY_OPTIONS_DIR . DS . 'pages' . DS . '_pages.php';
	require_once AMELY_OPTIONS_DIR . DS . 'blog' . DS . '_blog.php';
	require_once AMELY_OPTIONS_DIR . DS . 'woo' . DS . '_woo.php';
	require_once AMELY_OPTIONS_DIR . DS . 'social' . DS . '_social.php';
	require_once AMELY_OPTIONS_DIR . DS . 'footer' . DS . '_footer.php';
	require_once AMELY_OPTIONS_DIR . DS . 'cookie' . DS . '_cookie.php';
	require_once AMELY_OPTIONS_DIR . DS . 'style' . DS . '_style.php';
	require_once AMELY_OPTIONS_DIR . DS . 'custom' . DS . '_custom.php';
	require_once AMELY_OPTIONS_DIR . DS . 'api' . DS . '_api.php';
}
