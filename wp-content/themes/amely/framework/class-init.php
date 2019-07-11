<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initial setup for this theme
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Init' ) ) {

	class Amely_Init {

		/**
		 * The constructor.
		 */
		public function __construct() {

			// Adjust the content-width.
			add_action( 'after_setup_theme', array( $this, 'content_width' ), 0 );

			// Load the theme's textdomain.
			add_action( 'after_setup_theme', array( $this, 'load_theme_textdomain' ) );

			// Register navigation menus.
			add_action( 'after_setup_theme', array( $this, 'register_nav_menus' ) );

			// Add theme supports.
			add_action( 'after_setup_theme', array( $this, 'add_theme_supports' ) );

			// Register widget areas.
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );

			// Core filters.
			add_filter( 'insight_core_info', array( $this, 'core_info' ) );

			// Active Revslider
			add_action( 'after_setup_theme', array( $this, 'active_revslider' ) );

			if ( ! class_exists( 'Redux' ) ) {
				$this->load_base_options();
			}

			add_action( 'after_setup_theme', array( $this, 'amely_gutenberg_color_palette' ) );

		}

		/**
		 * Registers the Menus.
		 *
		 * @access public
		 */
		public function register_nav_menus() {
			// This theme uses wp_nav_menu() in one location.
			register_nav_menus( array(
				'primary' => esc_html__( 'Primary', 'amely' ),
			) );

			register_nav_menus( array(
				'top_bar' => esc_html__( 'Top Bar Menu', 'amely' ),
			) );

			register_nav_menus( array(
				'full_screen' => esc_html__( 'Full-screen Menu', 'amely' ),
			) );

			register_nav_menus( array(
				'language_switcher' => esc_html__( 'Language Switcher', 'amely' ),
			) );

			register_nav_menus( array(
				'currency_switcher' => esc_html__( 'Currency Switcher', 'amely' ),
			) );
		}

		/**
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 *
		 * @access public
		 */
		public function load_theme_textdomain() {
			load_theme_textdomain( 'amely', AMELY_THEME_DIR . '/languages' );
		}

		/**
		 * Set the content width in pixels, based on the theme's design and stylesheet.
		 *
		 * Priority 0 to make it available to lower priority callbacks.
		 *
		 * @access public
		 * @global int $content_width
		 */
		public function content_width() {
			$GLOBALS['content_width'] = apply_filters( 'content_width', 640 );
		}

		/**
		 * Sets up theme defaults and registers support for various WordPress features.
		 *
		 * Note that this function is hooked into the after_setup_theme hook, which
		 * runs before the init hook. The init hook is too late for some features, such
		 * as indicating support for post thumbnails.
		 *
		 * @access public
		 */
		public function add_theme_supports() {
			/*
			 * Add default posts and comments RSS feed links to head.
			 */
			add_theme_support( 'automatic-feed-links' );

			/*
			 * Let WordPress manage the document title.
			 * By adding theme support, we declare that this theme does not use a
			 * hard-coded <title> tag in the document head, and expect WordPress to
			 * provide it for us.
			 */
			add_theme_support( 'title-tag' );

			/*
			 * Enable support for Post Thumbnails on posts and pages.
			 *
			 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
			 */
			add_theme_support( 'post-thumbnails' );
			add_image_size( 'amely-single-thumb', 1170, 770, true );
			add_image_size( 'amely-misc-thumb', 270, 182, true ); // Content related.
			add_image_size( 'amely-search-thumb', 110, 70, true ); // Content related.
			add_image_size( 'amely-small-thumb', 50, 50, true );
			add_image_size( 'amely-post-grid', 370, 370, true );
			add_image_size( 'amely-single-navigation', 70, 70, true );
			add_image_size( 'amely-product-categories-square', 400, 400, true );
			add_image_size( 'amely-product-categories-rectangle', 570, 350, true );
			/*
			 * Switch default core markup for search form, comment form, and comments
			 * to output valid HTML5.
			 */
			add_theme_support( 'html5',
				array(
					'search-form',
					'comment-form',
					'comment-list',
					'gallery',
					'caption',
				) );

			/*
			 * Enable support for Post Formats.
			 * See https://developer.wordpress.org/themes/functionality/post-formats/
			 */
			add_theme_support( 'post-formats',
				array(
					'gallery',
					'video',
					'audio',
					'quote',
				) );

			/*
			 * Set up the WordPress core custom background feature.
			 */
			add_theme_support( 'custom-background',
				apply_filters( 'custom_background_args',
					array(
						'default-color' => '#ffffff',
						'default-image' => '',
					) ) );

			/*
			 * Support woocommerce
			 */
			add_theme_support( 'woocommerce',

				array(
					'gallery_thumbnail_image_width' => 100,
					// Product grid theme settings
					'product_grid'                  => array(
						'default_rows'    => 3,
						'min_rows'        => 1,
						'max_rows'        => apply_filters( 'amely_shop_max_rows', 10 ),
						'default_columns' => 5,
						'min_columns'     => 3,
						'max_columns'     => 6,
					),
				) );

			/*
			 * Support selective refresh for widget
			 */
			add_theme_support( 'customize-selective-refresh-widgets' );

			/*
			 * Add theme support
			 */

			add_theme_support( 'custom-header' );

			add_theme_support( 'insight-core' );

			add_theme_support( 'insight-detect' );

			add_theme_support( 'insight-megamenu' );

			add_theme_support( 'insight-popup' );

			add_theme_support( 'insight-swatches' );

			add_theme_support( 'insight-sidebars' );

			add_theme_support( 'wc-product-gallery-lightbox' );

			if ( Amely_Helper::get_option( 'product_zoom_on' ) ) {
				add_theme_support( 'wc-product-gallery-zoom' );
			}

			/*
			 * For WordPress 5.0
			 */
			add_theme_support( 'wp-block-styles' );
			add_theme_support( 'align-wide' );
		}

		/**
		 * Add support for custom color palettes in Gutenberg.
		 */
		function amely_gutenberg_color_palette() {
			add_theme_support( 'editor-color-palette',
				array(
					array(
						'name'  => esc_html__( 'Black', 'amely' ),
						'slug'  => 'black',
						'color' => '#2a2a2a',
					),
					array(
						'name'  => esc_html__( 'White', 'amely' ),
						'slug'  => 'white',
						'color' => '#ffffff',
					),
					array(
						'name'  => esc_html__( 'Gray', 'amely' ),
						'slug'  => 'gray',
						'color' => '#828282',
					),
					array(
						'name'  => esc_html__( 'Yellow', 'amely' ),
						'slug'  => 'yellow',
						'color' => '#fff200',
					),
					array(
						'name'  => esc_html__( 'Orange', 'amely' ),
						'slug'  => 'orange',
						'color' => '#fc6600',
					),
					array(
						'name'  => esc_html__( 'Red', 'amely' ),
						'slug'  => 'red',
						'color' => '#d30000',
					),
					array(
						'name'  => esc_html__( 'Pink', 'amely' ),
						'slug'  => 'pink',
						'color' => '#fc0fc0',
					),
					array(
						'name'  => esc_html__( 'Violet', 'amely' ),
						'slug'  => 'violet',
						'color' => '#b200ed',
					),
					array(
						'name'  => esc_html__( 'Blue', 'amely' ),
						'slug'  => 'blue',
						'color' => '#0018f9',
					),
					array(
						'name'  => esc_html__( 'Green', 'amely' ),
						'slug'  => 'green',
						'color' => '#3bb143',
					),
					array(
						'name'  => esc_html__( 'Brown', 'amely' ),
						'slug'  => 'brown',
						'color' => '#7c4700',
					),
				) );
		}

		/**
		 * Register widget area.
		 *
		 * @access public
		 * @link   https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
		 */
		public function widgets_init() {

			/* Default Sidebar */
			register_sidebar( array(
				'id'            => 'sidebar',
				'name'          => esc_html__( 'Sidebar', 'amely' ),
				'description'   => esc_html__( 'Add widgets here.', 'amely' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			/* Off-canvas Sidebar */
			register_sidebar( array(
				'id'            => 'sidebar-offcanvas',
				'name'          => esc_html__( 'Off-canvas Sidebar', 'amely' ),
				'description'   => esc_html__( 'Add widgets here.', 'amely' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			if ( class_exists( 'WooCommerce' ) ) {
				/* Shop Widget Area */
				register_sidebar( array(
					'id'            => 'sidebar-shop',
					'name'          => esc_html__( 'Sidebar for Shop', 'amely' ),
					'description'   => esc_html__( 'Add widgets here.', 'amely' ),
					'before_widget' => '<section id="%1$s" class="widget %2$s">',
					'after_widget'  => '</section>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );

				/* Filters Area */
				$filter_widget_class = Amely_Helper::get_widget_column_class();

				register_sidebar( array(
					'name'          => esc_html__( 'Shop filters', 'amely' ),
					'id'            => 'filters-area',
					'description'   => esc_html__( 'Widget Area for shop filters above the products', 'amely' ),
					'class'         => '',
					'before_widget' => '<div id="%1$s" class="widget widget-filter ' . esc_attr( $filter_widget_class ) . ' %2$s">',
					'after_widget'  => '</div>',
					'before_title'  => '<h3 class="widget-title">',
					'after_title'   => '</h3>',
				) );
			}

			/* Header Left Widget Area */
			register_sidebar( array(
				'id'            => 'sidebar-header-left',
				'name'          => esc_html__( 'Header Left Widget Area', 'amely' ),
				'description'   => esc_html__( 'Only works with Header Menu Bottom.', 'amely' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			/* Search Widget Area */
			register_sidebar( array(
				'id'            => 'sidebar-search',
				'name'          => esc_html__( 'Search Widget Area', 'amely' ),
				'description'   => esc_html__( 'Add widgets here.', 'amely' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			/* Footer Sidebar Area 1*/
			register_sidebar( array(
				'id'            => 'sidebar-footer-1',
				'name'          => esc_html__( 'Footer | #1', 'amely' ),
				'description'   => esc_html__( 'This is footer area column 1.', 'amely' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );

			/* Footer Sidebar Area 2*/
			register_sidebar( array(
				'id'            => 'sidebar-footer-2',
				'name'          => esc_html__( 'Footer | #2', 'amely' ),
				'description'   => esc_html__( 'This footer area column 2.', 'amely' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );

			/* Footer Sidebar Area 3*/
			register_sidebar( array(
				'id'            => 'sidebar-footer-3',
				'name'          => esc_html__( 'Footer | #3', 'amely' ),
				'description'   => esc_html__( 'This footer area column 3.', 'amely' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );

			/* Footer Sidebar Area 4 */
			register_sidebar( array(
				'id'            => 'sidebar-footer-4',
				'name'          => esc_html__( 'Footer | #4', 'amely' ),
				'description'   => esc_html__( 'This is footer area column 4.', 'amely' ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h4 class="widget-title">',
				'after_title'   => '</h4>',
			) );
		}

		/**
		 * Core info
		 *
		 * @param $info
		 *
		 * @return mixed
		 */
		public function core_info( $info ) {
			$info['api']     = Amely_Helper::get_config( 'api' );
			$info['docs']    = Amely_Helper::get_config( 'docs' );
			$info['icon']    = AMELY_THEME_URI . Amely_Helper::get_config( 'icon' );
			$info['support'] = Amely_Helper::get_config( 'support' );
			$info['tf']      = Amely_Helper::get_config( 'tf' );

			return $info;
		}

		public function active_revslider() {

			if ( ! get_option( 'revslider-valid' ) || get_option( 'revslider-valid' ) === 'false' ) {
				update_option( 'revslider-valid', 'true' );
			}
		}

		private function load_base_options() {

			global $amely_options;

			$amely_options = apply_filters( 'amely_get_base_options',
				array(

					// Logo
					'logo_width'                  => 15,

					// Header
					'sticky_header'               => true,
					'header_overlap'              => false,
					'right_column_width'          => 10,
					'header'                      => 'base',
					'header_left_sidebar'         => 'sidebar-header-left',
					'header_social'               => true,
					'header_bgcolor'              => '#ffffff',
					'header_bdcolor'              => 'transparent',
					'header_color_scheme'         => 'dark',
					'header_height'               => 90,
					'search_on'                   => true,
					'search_post_type'            => class_exists( 'WooCommerce' ) ? 'product' : 'post',
					'search_ajax_on'              => true,
					'search_min_chars'            => 1,
					'search_limit'                => 6,
					'wishlist_on'                 => class_exists( 'YITH_WCWL' ),
					'wishlist_icon'               => 'heart',
					'minicart_on'                 => class_exists( 'WooCommerce' ),
					'minicart_icon'               => 'shopping-basket',

					// Page title
					'page_title_height'           => 300,
					'page_title_style'            => 'bg_color',
					'page_title_on'               => true,
					'page_title_text_color'       => '#333333',
					'page_subtitle_color'         => '#ababab',
					'page_title_bg_color'         => '#f9f9f9',
					'page_title_overlay_color'    => array(
						'color' => '#000000',
						'rgba'  => 'rgba(0,0,0,0)',
					),
					'page_title_bg_image'         => array(
						'background-image' => AMELY_IMAGES . '/page-title-bg.jpg',
					),

					// Breadcrumbs
					'breadcrumbs'                 => true,
					'breadcrumbs_position'        => 'inside',

					// Navigation
					'site_menu_items_color'       => array(
						'regular' => '#696969',
						'hover'   => '#333333',
					),
					'site_menu_subitems_color'    => array(
						'regular' => '#696969',
						'hover'   => '#333333',
					),

					// Pages
					'page_sidebar_config'         => 'no',
					'search_sidebar_config'       => 'right',
					'archive_sidebar_config'      => 'right',
					'post_sidebar_config'         => 'right',
					'404_bg'                      => array(
						'background-image' => AMELY_IMAGES . DS . '404-bg.jpg',
					),

					// Blog
					'archive_display_type'        => 'standard',
					'archive_content_output'      => 'content',

					// WooCommerce
					'product_buttons_scheme'      => 'dark',
					'shop_sidebar_config'         => 'no',
					'product_page_layout'         => 'basic',
					'product_thumbnails_position' => 'left',
					'product_sidebar_config'      => 'right',

					// Footer
					'footer_width'                => 'standard',
					'footer_layout'               => '3_4',
				) );
		}

	}

	new Amely_Init();
}
