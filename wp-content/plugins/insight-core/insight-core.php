<?php
/*
Plugin Name: Insight Core
Description: Core functions for ThemeMove's themes
Author: ThemeMove
Version: 1.0
Author URI: https://thememove.com
Text Domain: insight-core
Domain Path: /languages/
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

$ic_theme = wp_get_theme();
if ( ! empty( $ic_theme['Template'] ) ) {
	$ic_theme = wp_get_theme( $ic_theme['Template'] );
}
define( 'INSIGHT_CORE_SITE_URI', site_url() );
define( 'INSIGHT_CORE_DS', DIRECTORY_SEPARATOR );
define( 'INSIGHT_CORE_DIR', dirname( __FILE__ ) );
define( 'INSIGHT_CORE_PATH', plugin_dir_url( __FILE__ ) );
define( 'INSIGHT_CORE_INC_DIR', dirname( __FILE__ ) . '/includes' );
define( 'INSIGHT_CORE_THEME_NAME', $ic_theme['Name'] );
define( 'INSIGHT_CORE_THEME_SLUG', $ic_theme['Template'] );
define( 'INSIGHT_CORE_THEME_VERSION', $ic_theme['Version'] );
define( 'INSIGHT_CORE_THEME_DIR', get_template_directory() );
define( 'INSIGHT_CORE_THEME_URI', get_template_directory_uri() );

if ( ! class_exists( 'InsightCore' ) ) {
	class InsightCore {
		public static $info = array(
			'support' => 'http://support.thememove.com',
			'faqs'    => 'http://support.thememove.com/support/solutions',
			'docs'    => 'http://document.thememove.com',
			'api'     => 'http://api.insightstud.io/update/thememove',
			'child'   => 'http://api.insightstud.io/update/thememove-child',
			'icon'    => INSIGHT_CORE_PATH . '/assets/images/tm-icon.png',
			'desc'    => 'Thank you for using our theme, please reward it a full five-star &#9733;&#9733;&#9733;&#9733;&#9733; rating.'
		);

		function __construct() {
			add_action( 'init', array( $this, 'load_textdomain' ), 99 );
			add_action( 'after_setup_theme', array( $this, 'after_setup_theme' ), 99 );
			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
			add_action( 'wp_ajax_insight_core_patcher', array( $this, 'ajax_patcher' ) );
			add_action( 'wp_ajax_insight_core_get_changelogs', array( $this, 'ajax_get_changelogs' ) );

			// Custom Functions
			include_once( INSIGHT_CORE_INC_DIR . '/functions.php' );

			// Pages
			include_once( INSIGHT_CORE_INC_DIR . '/pages.php' );

			// Register Posttypes
			include_once( INSIGHT_CORE_INC_DIR . '/register-posttypes.php' );

			// TGM
			include_once( INSIGHT_CORE_INC_DIR . '/tgm-plugin-activation.php' );
			require_once( INSIGHT_CORE_INC_DIR . '/tgm-plugin-registration.php' );

			// Import & Export
			include_once( INSIGHT_CORE_INC_DIR . '/export/export.php' );
			include_once( INSIGHT_CORE_INC_DIR . '/import/import.php' );

			// Kirki
			include_once( INSIGHT_CORE_DIR . '/libs/kirki/kirki.php' );
			add_filter( 'kirki/config', array( $this, 'kirki_update_url' ) );

			// Update
			include_once( INSIGHT_CORE_INC_DIR . '/update/class-updater.php' );

			// Others
			include_once( INSIGHT_CORE_INC_DIR . '/customizer/io.php' );
			include_once( INSIGHT_CORE_INC_DIR . '/breadcrumb.php' );
		}

		function load_textdomain() {
			load_plugin_textdomain( 'insight-core', false, basename( dirname( __FILE__ ) ) . '/languages/' );
		}

		public function admin_scripts( $hook ) {
			if ( strpos( $hook, 'insight-core' ) !== false ) {
				wp_enqueue_style( 'hint', INSIGHT_CORE_PATH . 'assets/css/hint.css' );
				wp_enqueue_style( 'pe-icon-7-stroke', INSIGHT_CORE_PATH . 'assets/css/pe-icon-7-stroke.css' );
				wp_enqueue_style( 'insight-core', INSIGHT_CORE_PATH . 'assets/css/insight-core.css' );
				wp_enqueue_script( 'insight-core', INSIGHT_CORE_PATH . 'assets/js/insight-core.js', array( 'jquery' ), INSIGHT_CORE_THEME_VERSION, true );
				wp_localize_script( 'insight-core', 'ic_vars', array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
					'ic_nonce' => wp_create_nonce( 'ic_nonce' ),
				) );
			}
		}

		public function after_setup_theme() {
			self::$info = apply_filters( 'insight_core_info', self::$info );
			require_if_theme_supports( 'insight-detect', INSIGHT_CORE_DIR . '/libs/mobile-detect/mobile.php' );
		}

		public function kirki_update_url( $config ) {
			$config['url_path'] = INSIGHT_CORE_PATH . '/libs/kirki';

			return $config;
		}

		public function ajax_patcher() {
			if ( ! isset( $_POST['ic_nonce'] ) || ! wp_verify_nonce( $_POST['ic_nonce'], 'ic_nonce' ) ) {
				die( 'Permissions check failed!' );
			}
			$ic_patcher       = sanitize_key( $_POST['ic_patcher'] );
			$ic_patcher_url   = self::$info['api'] . '/' . $ic_patcher . '.zip';
			$ic_patcher_error = false;
			require_once( ABSPATH . 'wp-admin/includes/file.php' );
			WP_Filesystem();
			// create temp folder
			$_tmp = wp_tempnam( $ic_patcher_url );
			@unlink( $_tmp );
			@ob_flush();
			@flush();
			if ( is_writable( INSIGHT_CORE_THEME_DIR ) ) {
				$package = download_url( $ic_patcher_url, 18000 );
				$unzip   = unzip_file( $package, INSIGHT_CORE_THEME_DIR );
				if ( ! is_wp_error( $package ) ) {
					if ( ! is_wp_error( $unzip ) ) {
						self::update_option_array( 'insight_core_patcher', $ic_patcher );
					} else {
						$ic_patcher_error = true;
					}
				} else {
					$ic_patcher_error = true;
				}
			} else {
				$ic_patcher_error = true;
			}

			echo $ic_patcher_error ? esc_html__( 'Error', 'insight-core' ) : esc_html__( 'Done', 'insight-core' );
			die;
		}

		public function ajax_get_changelogs() {
			require_once( INSIGHT_CORE_INC_DIR . '/update/changelogs.php' );
			die;
		}

		public static function has_changelogs() {
			$request = wp_remote_get( self::$info['api'] . '/changelogs.json', array( 'timeout' => 120 ) );
			if ( is_wp_error( $request ) ) {
				return false;
			} else {
				return $request;
			}
		}

		public static function get_changelogs( $table = true ) {
			$changelogs = '';
			if ( $request = self::has_changelogs() ) {
				$logs = json_decode( wp_remote_retrieve_body( $request ), true );
				if ( is_array( $logs ) && count( $logs ) > 0 ) {
					foreach ( $logs as $logkey => $logval ) {
						if ( $table ) {
							$changelogs .= '<tr>';
							$changelogs .= '<td>' . $logval['time'] . '</td>';
							$changelogs .= '<td>' . $logkey . '</td>';
							$changelogs .= '<td>';
							if ( is_array( $logval['desc'] ) ) {
								$changelogs .= implode( '<br/>', $logval["desc"] );
							} else {
								$changelogs .= $logval['desc'];
							}
							$changelogs .= '</td>';
							$changelogs .= '</tr>';
						} else {
							$changelogs .= '<h4>' . $logkey . ' - <span>' . $logval['time'] . '</span></h4>';
							$changelogs .= '<pre>';
							if ( is_array( $logval['desc'] ) ) {
								$changelogs .= implode( '<br/>', $logval['desc'] );
							} else {
								$changelogs .= $logval['desc'];
							}
							$changelogs .= '</pre>';

						}
					}
				}
			}
			$changelogs = apply_filters( 'insight_core_changelogs', $changelogs );

			return $changelogs;
		}

		public static function get_patcher() {
			$request = wp_remote_get( self::$info['api'] . '/patcher.json', array( 'timeout' => 120 ) );
			if ( is_wp_error( $request ) ) {
				return false;
			}
			$patchers = json_decode( wp_remote_retrieve_body( $request ), true );

			return $patchers;
		}

		public static function check_theme_patcher() {
			$request = wp_remote_get( self::$info['api'] . '/patcher.json', array( 'timeout' => 120 ) );
			if ( is_wp_error( $request ) ) {
				return false;
			}
			$patchers = json_decode( wp_remote_retrieve_body( $request ), true );
			if ( isset( $patchers[ INSIGHT_CORE_THEME_VERSION ] ) && ( count( $patchers[ INSIGHT_CORE_THEME_VERSION ] ) > 0 ) ) {
				$patchers_status = (array) get_option( 'insight_core_patcher' );
				foreach ( $patchers[ INSIGHT_CORE_THEME_VERSION ] as $key => $value ) {
					if ( ! in_array( $key, $patchers_status ) ) {
						return true;
					}
				}

				return false;
			} else {
				return false;
			}
		}

		public static function check_theme_update() {
			$update_data = array();
			$has_update  = false;
			if ( self::$info['api'] ) {
				$request = wp_remote_get( self::$info['api'] . '/changelogs.json', array( 'timeout' => 120 ) );
				if ( is_wp_error( $request ) ) {
					return;
				}
				$updates = json_decode( wp_remote_retrieve_body( $request ), true );
				if ( is_array( $updates ) ) {
					foreach ( $updates as $key => $val ) {
						if ( version_compare( $key, INSIGHT_CORE_THEME_VERSION ) == 1 ) {
							$update_data['new_version'] = $key;
							$update_data['package']     = self::$info['api'] . '/' . $key . '.zip';
							$update_data['time']        = $val['time'];
							$update_data['desc']        = $val['desc'];
							$has_update                 = true;
							break;
						}
					}
				}
			}
			if ( $has_update ) {
				return $update_data;
			} else {
				return false;
			}
		}

		public static function check_valid_update() {
			return true;
		}

		public static function update_option_count( $option ) {

			if ( get_option( $option ) != false ) {
				update_option( $option, get_option( $option ) + 1 );
			} else {
				update_option( $option, '1' );
			}
		}

		public static function update_option_array( $option, $value ) {
			if ( get_option( $option ) ) {
				$options = get_option( $option );
				if ( ! in_array( $value, $options ) ) {
					$options[] = $value;
					update_option( $option, $options );
				}
			} else {
				update_option( $option, array( $value ) );
			}
		}

		public static function plugin_action( $item ) {
			$installed_plugins        = get_plugins();
			$item['sanitized_plugin'] = $item['name'];
			$actions                  = array();
			// We have a repo plugin
			if ( ! $item['version'] ) {
				$item['version'] = TGM_Plugin_Activation::$instance->does_plugin_have_update( $item['slug'] );
			}
			if ( ! isset( $installed_plugins[ $item['file_path'] ] ) ) {
				// Display install link
				$actions = sprintf( '<a href="%1$s" title="Install %2$s">Install</a>', esc_url( wp_nonce_url( add_query_arg( array(
					'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
					'plugin'        => urlencode( $item['slug'] ),
					'plugin_name'   => urlencode( $item['sanitized_plugin'] ),
					'plugin_source' => urlencode( $item['source'] ),
					'tgmpa-install' => 'install-plugin',
				), TGM_Plugin_Activation::$instance->get_tgmpa_url() ), 'tgmpa-install', 'tgmpa-nonce' ) ), $item['sanitized_plugin'] );
			} elseif ( is_plugin_inactive( $item['file_path'] ) ) {
				// Display activate link
				$actions = sprintf( '<a href="%1$s" title="Activate %2$s">Activate</a>', esc_url( add_query_arg( array(
					'plugin'               => urlencode( $item['slug'] ),
					'plugin_name'          => urlencode( $item['sanitized_plugin'] ),
					'plugin_source'        => urlencode( $item['source'] ),
					'tgmpa-activate'       => 'activate-plugin',
					'tgmpa-activate-nonce' => wp_create_nonce( 'tgmpa-activate' ),
				), admin_url( 'admin.php?page=insight-core' ) ) ), $item['sanitized_plugin'] );
			} elseif ( version_compare( $installed_plugins[ $item['file_path'] ]['Version'], $item['version'], '<' ) ) {
				// Display update link
				$actions = sprintf( '<a href="%1$s" title="Install %2$s">Update</a>', wp_nonce_url( add_query_arg( array(
					'page'          => urlencode( TGM_Plugin_Activation::$instance->menu ),
					'plugin'        => urlencode( $item['slug'] ),
					'tgmpa-update'  => 'update-plugin',
					'plugin_source' => urlencode( $item['source'] ),
					'version'       => urlencode( $item['version'] ),
				), TGM_Plugin_Activation::$instance->get_tgmpa_url() ), 'tgmpa-update', 'tgmpa-nonce' ), $item['sanitized_plugin'] );
			} elseif ( is_plugin_active( $item['file_path'] ) ) {
				// Display deactivate link
				$actions = sprintf( '<a href="%1$s" title="Deactivate %2$s">Deactivate</a>', esc_url( add_query_arg( array(
					'plugin'                 => urlencode( $item['slug'] ),
					'plugin_name'            => urlencode( $item['sanitized_plugin'] ),
					'plugin_source'          => urlencode( $item['source'] ),
					'tgmpa-deactivate'       => 'deactivate-plugin',
					'tgmpa-deactivate-nonce' => wp_create_nonce( 'tgmpa-deactivate' ),
				), admin_url( 'admin.php?page=insight-core' ) ) ), $item['sanitized_plugin'] );
			}

			return $actions;
		}

		public static function let_to_num( $size ) {
			$l   = substr( $size, - 1 );
			$ret = substr( $size, 0, - 1 );
			switch ( strtoupper( $l ) ) {
				case 'P':
					$ret *= 1024;
				case 'T':
					$ret *= 1024;
				case 'G':
					$ret *= 1024;
				case 'M':
					$ret *= 1024;
				case 'K':
					$ret *= 1024;
			}

			return $ret;
		}
	}

	new InsightCore();
}
