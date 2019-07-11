<?php
if ( ! function_exists( 'add_action' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! WP_DEBUG && ( ! isset( $_GET['debug'] ) || 'true' != $_GET['debug'] ) ) {
	return;
}

class InsightCore_Export {

	function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_export' ) );
		add_filter( 'export_wp_filename', array( $this, 'wp_filename' ) );
	}

	function init() {
		if ( isset( $_REQUEST['export_option'] ) ) {
			$export_option = $_REQUEST['export_option'];

			switch ( $export_option ) {
				case 'content':
					$this->export_content();
					break;
				case 'sidebars':
					$this->export_sidebars();
					break;
				case 'widgets':
					$this->export_widgets();
					break;
				case 'menus':
					$this->export_menus();
					break;
				case 'page_options':
					$this->export_page_options();
					break;
				case 'customizer_options':
					$this->export_customizer_options();
					break;
				case 'woocommerce':
					if ( class_exists( 'WooCommerce' ) ) {
						$this->export_woocommerce();
					}
					break;
				case 'isw':
					if ( class_exists( 'WooCommerce' ) && class_exists( 'Insight_Attribute_Swatches' ) ) {
						$this->export_insight_attribute_swatches();
					}
					break;
				case 'rev_sliders':
					$this->export_rev_sliders();
					break;
				case 'media_package':
					if ( class_exists( 'RevSliderAdmin' ) ) {
						$this->export_media_packages();
					}
					break;
				default:
					break;
			}
		}
	}

	function admin_export() {
		if ( isset( $_REQUEST['export'] ) ) {
			$this->init();
		}

		add_submenu_page( 'insight-core', 'Export', 'Export', 'manage_options', 'insight-core-export', array(
			&$this,
			'export_page',
		) );
	}

	function export_page() {
		include_once( untrailingslashit( plugin_dir_path( __FILE__ ) . 'export-page.php' ) );
	}

	function wp_filename() {
		return 'content.xml';
	}

	function save_as_txt_file( $file_name, $output ) {
		header( "Content-type: application/text", true, 200 );
		header( "Content-Disposition: attachment; filename=$file_name" );
		header( "Pragma: no-cache" );
		header( "Expires: 0" );
		echo $output;
		exit;
	}

	function available_widgets() {
		global $wp_registered_widget_controls;

		$widget_controls = $wp_registered_widget_controls;

		$available_widgets = array();

		foreach ( $widget_controls as $widget ) {

			if ( ! empty( $widget['id_base'] ) && ! isset( $available_widgets[ $widget['id_base'] ] ) ) { // no dupes

				$available_widgets[ $widget['id_base'] ]['id_base'] = $widget['id_base'];
				$available_widgets[ $widget['id_base'] ]['name']    = $widget['name'];

			}

		}

		return $available_widgets;
	}

	function export_content() {

		require_once( ABSPATH . 'wp-admin/includes/export.php' );

		$args = array();

		$args['content'] = 'all';

		export_wp( $args );
	}

	function export_sidebars() {

		$sidebars = json_encode( get_option( 'kungfu_sidebars', '' ) );

		$this->save_as_txt_file( 'sidebars.txt', $sidebars );
	}

	function export_widgets() {

		// Get all available widgets site supportsss
		$available_widgets = $this->available_widgets();

		// Get all widget instances for each widget
		$widget_instances = array();
		foreach ( $available_widgets as $widget_data ) {

			// Get all instances for this ID base
			$instances = get_option( 'widget_' . $widget_data['id_base'] );

			// Have instances
			if ( ! empty( $instances ) ) {

				// Loop instances
				foreach ( $instances as $instance_id => $instance_data ) {

					// Key is ID (not _multiwidget)
					if ( is_numeric( $instance_id ) ) {
						$unique_instance_id                      = $widget_data['id_base'] . '-' . $instance_id;
						$widget_instances[ $unique_instance_id ] = $instance_data;
					}

				}

			}

		}


		// Gather sidebars with their widget instances
		$sidebars_widgets          = get_option( 'sidebars_widgets' ); // get sidebars and their unique widgets IDs
		$sidebars_widget_instances = array();
		foreach ( $sidebars_widgets as $sidebar_id => $widget_ids ) {

			// Skip inactive widgets
			if ( 'wp_inactive_widgets' == $sidebar_id ) {
				continue;
			}

			// Skip if no data or not an array (array_version)
			if ( ! is_array( $widget_ids ) || empty( $widget_ids ) ) {
				continue;
			}

			// Loop widget IDs for this sidebar
			foreach ( $widget_ids as $widget_id ) {

				// Is there an instance for this widget ID?
				if ( isset( $widget_instances[ $widget_id ] ) ) {

					// Add to array
					$sidebars_widget_instances[ $sidebar_id ][ $widget_id ] = $widget_instances[ $widget_id ];

				}

			}

		}

		$data = json_encode( $sidebars_widget_instances );

		$this->save_as_txt_file( 'widgets.txt', $data );
	}

	function export_menus() {
		global $wpdb;

		$this->data = array();
		$locations  = get_nav_menu_locations();

		$terms_table = $wpdb->prefix . "terms";
		foreach ( (array) $locations as $location => $menu_id ) {
			$menu_slug = $wpdb->get_results( "SELECT * FROM $terms_table where term_id={$menu_id}", ARRAY_A );
			if ( ! empty( $menu_slug ) ) {
				$this->data[ $location ] = $menu_slug[0]['slug'];
			}
		}

		$output = serialize( $this->data );
		$this->save_as_txt_file( "menus.txt", $output );
	}

	function export_page_options() {
		$show_on_front = get_option( "show_on_front" );

		$settings_pages = array(
			'show_on_front' => $show_on_front,
		);

		if ( $static_page_id = get_option( "page_on_front" ) ) {
			$static_page                     = get_post( $static_page_id );
			$settings_pages['page_on_front'] = $static_page->post_title;
		}

		if ( $post_page_id = get_option( 'page_for_posts' ) ) {
			$post_page                        = get_post( $post_page_id );
			$settings_pages['page_for_posts'] = $post_page->post_title;
		}

		$output = serialize( $settings_pages );

		$this->save_as_txt_file( "page_options.txt", $output );
	}

	function export_customizer_options() {

		$options = get_theme_mods();
		unset( $options['nav_menu_locations'] );

		$this->save_as_txt_file( 'customizer.txt', serialize( $options ) );
	}

	function export_woocommerce() {

		if ( version_compare( WC_VERSION, '3.3.0', '<' ) ) {

			$data = array(
				'images' => array(
					'catalog'   => wc_get_image_size( 'shop_catalog' ),
					'thumbnail' => wc_get_image_size( 'shop_thumbnail' ),
					'single'    => wc_get_image_size( 'shop_single' ),
				),
			);
		} else {
			$data = array(
				'images' => array(
					'single'                 => get_option( 'woocommerce_single_image_width' ),
					'thumbnail'              => get_option( 'woocommerce_thumbnail_image_width' ),
					'cropping'               => get_option( 'woocommerce_thumbnail_cropping' ),
					'cropping_custom_width'  => get_option( 'woocommerce_thumbnail_cropping_custom_width', 1 ),
					'cropping_custom_height' => get_option( 'woocommerce_thumbnail_cropping_custom_height', 1 ),
				),
			);
		}

		$output = serialize( $data );

		$this->save_as_txt_file( 'woocommerce.txt', $output );
	}

	function export_insight_attribute_swatches() {

		$settings = get_option( 'isw_settings', '' );

		$this->save_as_txt_file( 'attribute_swatches.txt', serialize( $settings ) );
	}

	function export_rev_sliders() {
		$tables = array(
			"wp_revslider_css",
			"wp_revslider_layer_animations",
			"wp_revslider_navigations",
			"wp_revslider_sliders",
			"wp_revslider_slides",
			"wp_revslider_static_slides",
		);
		$this->export_tables( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, $tables, "rev_sliders.txt" );
	}

	function export_tables(
		$host, $user, $pass, $name, $tables = false, $backup_name = false, $replacements = array(
		'OLD_DOMAIN.com',
		'NEW_DOMAIN.com',
	)
	) {
		set_time_limit( 3000 );
		$mysqli = new mysqli( $host, $user, $pass, $name );
		$mysqli->select_db( $name );
		$mysqli->query( "SET NAMES 'utf8'" );
		$queryTables = $mysqli->query( 'SHOW TABLES' );
		while ( $row = $queryTables->fetch_row() ) {
			$target_tables[] = $row[0];
		}
		if ( $tables !== false ) {
			$target_tables = array_intersect( $target_tables, $tables );
		}
		$content = "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";\r\nSET time_zone = \"+00:00\";\r\n\r\n\r\n/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;\r\n/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;\r\n/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;\r\n/*!40101 SET NAMES utf8 */;\r\n--\r\n-- Database: `" . $name . "`\r\n--\r\n\r\n\r\n";
		foreach ( $target_tables as $table ) {
			if ( empty( $table ) ) {
				continue;
			}
			$result        = $mysqli->query( 'SELECT * FROM `' . $table . '`' );
			$fields_amount = $result->field_count;
			$rows_num      = $mysqli->affected_rows;
			$res           = $mysqli->query( 'SHOW CREATE TABLE ' . $table );
			$TableMLine    = $res->fetch_row();
			$content .= "\n\n" . $TableMLine[1] . ";\n\n";
			for ( $i = 0, $st_counter = 0; $i < $fields_amount; $i ++, $st_counter = 0 ) {
				while ( $row = $result->fetch_row() ) { //when started (and every after 100 command cycle):
					if ( $st_counter % 100 == 0 || $st_counter == 0 ) {
						$content .= "\nINSERT INTO " . $table . " VALUES";
					}
					$content .= "\n(";
					for ( $j = 0; $j < $fields_amount; $j ++ ) {
						$row[ $j ] = str_replace( "\n", "\\n", addslashes( $row[ $j ] ) );
						if ( isset( $row[ $j ] ) ) {
							$content .= '"' . $row[ $j ] . '"';
						} else {
							$content .= '""';
						}
						if ( $j < ( $fields_amount - 1 ) ) {
							$content .= ',';
						}
					}
					$content .= ")";
					//every after 100 command cycle [or at last line] ....p.s. but should be inserted 1 cycle eariler
					if ( ( ( $st_counter + 1 ) % 100 == 0 && $st_counter != 0 ) || $st_counter + 1 == $rows_num ) {
						$content .= ";";
					} else {
						$content .= ",";
					}
					$st_counter = $st_counter + 1;
				}
			}
			$content .= "\n\n\n";
		}
		$content .= "\r\n\r\n/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;\r\n/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;\r\n/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;";
		if ( function_exists( 'DOMAIN_or_STRING_modifier_in_DB' ) ) {
			$content = DOMAIN_or_STRING_modifier_in_DB( $replacements[0], $replacements[1], $content );
		}
		$backup_name = $backup_name ? $backup_name : $name . "___(" . date( 'H-i-s' ) . "_" . date( 'd-m-Y' ) . ")__rand" . rand( 1, 11111111 ) . ".sql";
		ob_get_clean();
		header( 'Content-Type: application/octet-stream' );
		header( "Content-Transfer-Encoding: Binary" );
		header( "Content-disposition: attachment; filename=\"" . $backup_name . "\"" );
		echo $content;
		exit;
	}

	function export_media_packages() {
		$demo = isset( $_POST['demo'] ) ? sanitize_key( $_POST['demo'] ) : '';
		$src  = WP_CONTENT_DIR . '/uploads';
		$dst  = WP_CONTENT_DIR . INSIGHT_CORE_DS . INSIGHT_CORE_THEME_SLUG . '-' . $demo;

		$this->recurse_copy( $src, $dst );
	}

	function recurse_copy( $src, $dst ) {

		if ( is_dir( $src ) ) {

			$dir = opendir( $src );

			if ( ! is_dir( $dst ) ) {
				@mkdir( $dst );
			}

			while ( false !== ( $file = readdir( $dir ) ) ) {
				if ( ( $file != '.' ) && ( $file != '..' ) ) {
					if ( is_dir( $src . '/' . $file ) ) {
						$this->recurse_copy( $src . '/' . $file, $dst . '/' . $file );
					} else {
						if ( false == preg_match( '/-\d{1,}x\d{1,}+\.\w{3,}$/', $file ) ) {
							copy( $src . '/' . $file, $dst . '/' . $file );
						}
					}
				}
			}
			closedir( $dir );
		}

	}
}

new InsightCore_Export();