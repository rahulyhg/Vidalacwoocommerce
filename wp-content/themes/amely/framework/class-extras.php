<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Extras' ) ) {

	class Amely_Extras {

		public function __construct() {

			// Adds custom classes to the array of body classes.
			add_filter( 'body_class', array(
				$this,
				'body_classes',
			) );

			// Extra Info.
			add_action( 'wp_footer', array(
				$this,
				'extra_info',
			) );

			add_action( 'vp_pfui_after_quote_meta', array( $this, 'add_quote_text_field' ) );
			add_action( 'admin_init', array( $this, 'admin_init' ) );

			add_filter( 'widget_tag_cloud_args', array( $this, 'tag_cloud_args' ) );

			add_filter( 'comment_form_fields', array( $this, 'move_comment_field_to_bottom' ) );
		}

		/**
		 * Adds custom classes to the array of body classes.
		 *
		 * @param array $classes Classes for the body element.
		 *
		 * @return array
		 */
		public function body_classes( $classes ) {

			$box_mode_on = amely_get_option( 'box_mode_on' );

			$header           = amely_get_option( 'header' );
			$header_overlap   = amely_get_option( 'header_overlap' );
			$page_extra_class = get_post_meta( Amely_Helper::get_the_ID(), 'amely_page_extra_class', true );

			if ( is_multi_author() ) {
				$classes[] = 'group-blog';
			}

			if ( $box_mode_on ) {
				$classes[] = 'body-boxed';
			}

			$classes [] = 'site-header-' . $header;

			if ( $header_overlap && $header != 'menu-bottom' && $header != 'vertical' ) {
				$classes[] = 'header-overlap';
			}

			if ( ! class_exists( 'Redux' ) ) {
				$classes[] = 'no-redux';
			}

			if ( $page_extra_class ) {
				$classes[] = $page_extra_class;
			}

			return $classes;
		}

		/**
		 * Extra Info
		 *
		 * @since 1.0
		 */
		public function extra_info() {
			if ( isset( $_GET['debug'] ) && 'true' === $_GET['debug'] ) {
				global $wp_version, $wpdb;

				$child_theme        = wp_get_theme();
				$child_theme_in_use = false;

				if ( AMELY_THEME_NAME != $child_theme->name ) {
					$child_theme_in_use = true;
				}

				if ( ! function_exists( 'get_plugins' ) ) {
					require_once ABSPATH . 'wp-admin/includes/plugin.php';
				}

				$plugins   = get_plugins();
				$active    = get_option( 'active_plugins', array() );
				$frontpage = get_option( 'page_on_front' );
				$frontpost = get_option( 'page_for_posts' );
				$wpdebug   = defined( 'WP_DEBUG' ) ? WP_DEBUG ? esc_html__( 'Enabled', 'amely' ) : esc_html__( 'Disabled', 'amely' ) : esc_html__( 'Not Set', 'amely' );
				$jquchk    = wp_script_is( 'jquery', 'registered' ) ? $GLOBALS['wp_scripts']->registered['jquery']->ver : esc_html__( 'n/a', 'amely' );
				$fr_page   = $frontpage ? get_the_title( $frontpage ) . ' (ID# ' . $frontpage . ')' . '' : esc_html__( 'n/a', 'amely' );
				$fr_post   = $frontpage ? get_the_title( $frontpost ) . ' (ID# ' . $frontpost . ')' . '' : esc_html__( 'n/a', 'amely' );
				?>
				<!--
=====WORDPRESS DATA=====<?php echo "\n"; ?>
* WordPress: v<?php echo esc_html( $wp_version ) . "\n"; ?>
* Theme: <?php echo AMELY_THEME_NAME; ?> v<?php echo AMELY_THEME_VERSION; ?><?php echo "\n"; ?>
* Child Theme: <?php if ( $child_theme_in_use == true ) { ?>Activated<?php } else { ?>Not activated<?php } ?><?php echo "\n"; ?>
* Site URL: <?php echo esc_html( site_url() ) . "\n"; ?>
* Home URL: <?php echo esc_html( home_url( '/' ) ) . "\n"; ?>
* Permarlink: <?php echo get_option( 'permalink_structure' ) . "\n"; ?>
* User count: <?php echo count( get_users() ) . "\n"; ?>
=====WORDPRESS CONFIG=====<?php echo "\n"; ?>
* WP_DEBUG: <?php echo esc_html( $wpdebug ) . "\n"; ?>
* WP Memory Limit: <?php echo esc_html( $this->num_convt( WP_MEMORY_LIMIT ) / ( 1024 ) ) . 'MB' . "\n"; ?>
* Table Prefix: <?php echo esc_html( $wpdb->base_prefix ) . "\n"; ?>
* Show On Front: <?php echo get_option( 'show_on_front' ) . "\n"; ?>
* Page On Front: <?php echo esc_html( $fr_page ) . "\n"; ?>
* Page For Posts: <?php echo esc_html( $fr_post ) . "\n"; ?>
=====SERVER DATA=====<?php echo "\n"; ?>
* jQuery Version: <?php echo esc_html( $jquchk ) . "\n"; ?>
* PHP Version: <?php echo PHP_VERSION . "\n"; ?>
* MySQL Version: <?php echo esc_html( $wpdb->db_version() ) . "\n"; ?>
* Server Software: <?php echo esc_html( $_SERVER['SERVER_SOFTWARE'] ) . "\n"; ?>
=====PHP CONFIGURATION=====<?php echo "\n"; ?>
* Memory Limit: <?php echo ini_get( 'memory_limit' ) . "\n"; ?>
* Upload Max: <?php echo ini_get( 'upload_max_filesize' ) . "\n"; ?>
* Post Max: <?php echo ini_get( 'post_max_size' ) . "\n"; ?>
* Time Limit: <?php echo ini_get( 'max_execution_time' ) . "\n"; ?>
* Max Input Vars: <?php echo ini_get( 'max_input_vars' ) . "\n"; ?>
=====PLUGIN INFORMATION=====<?php echo "\n"; ?>
* Active Plugins: <?php echo count( $active ) . "\n"; ?>
<?php foreach ( $plugins as $plugin_path => $plugin ) : if ( ! in_array( $plugin_path, $active ) ) {
					continue;
				}
					echo '- ' . $plugin['Name'] . ' ' . $plugin['Version'] . "\n"; endforeach; ?>
-->
			<?php }

		}

		/**
		 * @param $v
		 *
		 * @return int|string
		 */
		public function num_convt( $v ) {
			$l   = substr( $v, - 1 );
			$ret = substr( $v, 0, - 1 );

			switch ( strtoupper( $l ) ) {
				case 'P': // fall-through
				case 'T': // fall-through
				case 'G': // fall-through
				case 'M': // fall-through
				case 'K': // fall-through
					$ret *= 1024;
					break;
				default:
					break;
			}

			return $ret;
		}

		/**
		 *  Adding new field for Quote Post Format
		 */
		public function add_quote_text_field() {
			global $post;
			?>
			<div class="vp-pfui-elm-block">
				<label for="vp-pfui-format-quote-text"><?php esc_html_e( 'Quote', 'amely' ); ?></label>

				<textarea name="_format_quote_text" id="vp-pfui-format-quote-text" cols="30"
				          rows="10"><?php echo esc_attr( get_post_meta( $post->ID, '_format_quote_text', true ) ); ?></textarea>

			</div>
		<?php }

		public function admin_init() {
			$post_formats = get_theme_support( 'post-formats' );
			if ( ! empty( $post_formats[0] ) && is_array( $post_formats[0] ) ) {
				if ( in_array( 'quote', $post_formats[0] ) ) {
					add_action( 'save_post', array( $this, 'custom_save_post' ) );
				}
			}
		}

		public function custom_save_post( $post_id ) {
			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}
			if ( ! defined( 'XMLRPC_REQUEST' ) ) {
				if ( isset( $_POST['_format_quote_text'] ) ) {
					update_post_meta( $post_id, '_format_quote_text', $_POST['_format_quote_text'] );
				}
			}
		}

		/**
		 * WordPress tag cloud widget mods
		 */
		public function tag_cloud_args( $args ) {
			$args['largest']  = 14;
			$args['smallest'] = 14;
			$args['unit']     = 'px';
			$args['format']   = 'list';

			return $args;
		}

		public function move_comment_field_to_bottom( $fields ) {

			$comment_field = $fields['comment'];

			unset( $fields['comment'] );

			$fields['comment'] = $comment_field;

			return $fields;

		}
	}

	new Amely_Extras();
}
