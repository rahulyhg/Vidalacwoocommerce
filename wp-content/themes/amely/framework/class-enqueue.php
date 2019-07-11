<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueue scripts and styles.
 *
 * @package   InsightFramework
 */

if ( ! class_exists( 'Amely_Enqueue' ) ) {

	class Amely_Enqueue {

		/**
		 * The constructor.
		 */
		public function __construct() {

			add_action( 'wp_enqueue_scripts',
				array(
					$this,
					'enqueue_libs',
				),
				1 );

			add_action( 'wp_enqueue_scripts',
				array(
					$this,
					'enqueue',
				) );
			add_action( 'wp_enqueue_scripts',
				array(
					$this,
					'custom_css',
				),
				999 );
			add_action( 'wp_enqueue_scripts',
				array(
					$this,
					'custom_js',
				),
				999 );

			add_action( 'admin_enqueue_scripts',
				array(
					$this,
					'admin_css',
				),
				999 );
			add_action( 'admin_enqueue_scripts',
				array(
					$this,
					'admin_js',
				) );
		}

		public function enqueue_libs() {
			/*
			 * Enqueue the default font (Poppins) if Redux isn't installed
			 */
			if ( ! class_exists( 'Redux' ) ) {
				$font_url = add_query_arg( 'family',
					'Poppins:100,100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800,800i,900,900i',
					'http://fonts.googleapis.com/css' );
				wp_enqueue_style( 'google-fonts', $font_url, null, AMELY_THEME_VERSION );
			}

			/*
			 * Enqueue font awesome
			 */
			wp_enqueue_style( 'font-awesome',
				AMELY_THEME_URI . '/assets/libs/font-awesome/css/font-awesome.min.css' );

			/*
			 * Enqueue pe-icon-7-stroke
			 */
			wp_enqueue_style( 'font-pe-icon-7-stroke',
				AMELY_THEME_URI . '/assets/libs/pixeden-stroke-7-icon/css/pe-icon-7-stroke.min.css' );

			/*
			 * Enqueue Ionicons
			 */
			wp_enqueue_style( 'font-ion-icons',
				AMELY_THEME_URI . '/assets/libs/Ionicons/css/ionicons.min.css' );

			/*
			 * Enqueue Themify-icons
			 */
			wp_enqueue_style( 'font-themify-icons',
				AMELY_THEME_URI . '/assets/libs/themify-icons/css/themify-icons.css' );

			/*
			 * Enqueue third-party CSS
			 */
			wp_enqueue_style( 'animate-css', AMELY_LIBS_URI . '/animate.css/css/animate.min.css' );
			wp_enqueue_style( 'hint-css', AMELY_LIBS_URI . '/hint.css/css/hint.min.css' );
			wp_enqueue_style( 'jquery-nice-select', AMELY_LIBS_URI . '/jquery-nice-select/css/nice-select.css' );
			wp_enqueue_style( 'magnific-popup', AMELY_LIBS_URI . '/magnific-popup/css/magnific-popup.css' );
			wp_enqueue_style( 'perfect-scrollbar',
				AMELY_LIBS_URI . '/perfect-scrollbar/css/perfect-scrollbar.min.css' );
			wp_enqueue_style( 'select2', AMELY_LIBS_URI . '/select2/css/select2.min.css' );
			wp_enqueue_style( 'onepage-scroll', AMELY_LIBS_URI . '/onepage-scroll/css/onepage-scroll.css' );

			/*
			 * Enqueue jQuery plugins
			 */
			wp_enqueue_script( 'devbridge-autocomplete',
				AMELY_LIBS_URI . '/devbridge-autocomplete/js/jquery.autocomplete.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'fitvids',
				AMELY_LIBS_URI . '/fitvids/js/jquery.fitvids.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'imagesloaded' );

			wp_enqueue_script( 'isotope',
				AMELY_LIBS_URI . '/isotope/js/isotope.pkgd.min.js',
				array( 'jquery', 'imagesloaded' ),
				null,
				true );

			wp_enqueue_script( 'jquery-nice-select',
				AMELY_LIBS_URI . '/jquery-nice-select/js/jquery.nice-select.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'js-cookie',
				AMELY_LIBS_URI . '/js-cookie/js/js.cookie.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'magnific-popup',
				AMELY_LIBS_URI . '/magnific-popup/js/jquery.magnific-popup.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'mobile-detect',
				AMELY_LIBS_URI . '/mobile-detect/js/mobile-detect.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'perfect-scrollbar',
				AMELY_LIBS_URI . '/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'slick-carousel',
				AMELY_LIBS_URI . '/slick-carousel/js/slick.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'select2',
				AMELY_LIBS_URI . '/select2/js/select2.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'onepage-croll',
				AMELY_LIBS_URI . '/onepage-scroll/js/jquery.onepage-scroll.min.js',
				array( 'jquery' ),
				null,
				true );

			wp_enqueue_script( 'animejs',
				AMELY_LIBS_URI . '/animejs/js/anime.min.js',
				array(),
				null,
				true );

			if ( get_post_meta( Amely_Helper::get_the_ID(), 'amely_disable_site_menu', true ) != 'on' ) {

				wp_enqueue_script( 'superfish',
					AMELY_LIBS_URI . '/superfish/js/superfish.min.js',
					array(),
					null,
					true );

				wp_enqueue_script( 'hoverIntent',
					AMELY_LIBS_URI . '/superfish/js/hoverIntent.js',
					array(),
					null,
					true );
			}

			if ( class_exists( 'WooCommerce' ) ) {

				if ( amely_get_option( 'shop_add_to_cart_favico_on' ) ) {
					wp_enqueue_script( 'favico-js',
						AMELY_LIBS_URI . '/favico.js/js/favico-0.3.10.min.js',
						array( 'jquery' ),
						null,
						true );
				}

				if ( amely_get_option( 'shop_add_to_cart_notification_on' ) || amely_get_option( 'shop_wishlist_notification_on' ) ) {

					wp_enqueue_style( 'growl', AMELY_LIBS_URI . '/growl/css/jquery.growl.css' );

					wp_enqueue_script( 'growl',
						AMELY_LIBS_URI . '/growl/js/jquery.growl.js',
						array( 'jquery' ),
						null,
						true );
				}

				if ( Amely_Woo::is_shop() ) {
					wp_enqueue_script( 'jquery-pjax',
						AMELY_LIBS_URI . '/jquery-pjax/js/jquery.pjax.js',
						array( 'jquery' ),
						null,
						true );
				}

				if ( is_singular( 'product' ) && strpos( amely_get_option( 'product_page_layout' ),
						'sticky' ) > - 1 ) {
					wp_enqueue_script( 'sticky-kit',
						AMELY_LIBS_URI . '/sticky-kit/js/jquery.sticky-kit.min.js',
						array( 'jquery' ),
						null,
						true );
				}
			}

			if ( class_exists( 'YITH_WCWL' ) && 'yes' == get_option( 'yith_wcwl_enabled' ) && amely_get_option( 'shop_wishlist_on' ) && amely_get_option( 'animated_wishlist_on' ) ) {
				wp_enqueue_script( 'mojs',
					AMELY_LIBS_URI . '/mojs/js/mo.min.js',
					null,
					null,
					true );
			}
		}

		/**
		 * Enqueue scrips & styles.
		 *
		 * @access public
		 */
		public function enqueue() {

			/*
			 * The comment-reply script.
			 */
			if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
				wp_enqueue_script( 'comment-reply' );
			}

			/*
			 * Enqueue minified CSS
			 */
			if ( amely_get_option( 'minified_on' ) ) {

				add_filter( 'stylesheet_uri',
					function ( $stylesheet_uri, $stylesheet_dir_uri ) {
						return $stylesheet_dir_uri . '/style.min.css';
					},
					10,
					2 );
			}

			/*
			 * Enqueue the theme's styles.css.
			 * This is recommended because we can add inline styles there
			 * and some plugins use it to do exactly that.
			 */
			wp_enqueue_style( 'amely-main-style', get_stylesheet_uri() );

			/*
			 * Enqueue main JS
			 */
			wp_enqueue_script( 'amely-main-js',
				AMELY_THEME_URI . '/assets/js/theme' . ( amely_get_option( 'minified_on' ) ? '.min' : '' ) . '.js',
				array( 'jquery' ),
				AMELY_THEME_VERSION,
				true );

			wp_add_inline_script( 'amely-main-js',
				'var _amelyInlineStyle = document.getElementById( \'amely-main-style-inline-css\' );' );

			$ajax_url     = admin_url( 'admin-ajax.php' );
			$current_lang = apply_filters( 'wpml_current_language', null );

			if ( $current_lang ) {
				$ajax_url = add_query_arg( 'lang', $current_lang, $ajax_url );
			}

			wp_localize_script( 'amely-main-js',
				'amelyConfigs',
				array(
					'ajax_url'                         => esc_url( $ajax_url ),
					'wc_cart_url'                      => ( function_exists( 'wc_get_cart_url' ) ? esc_url( wc_get_cart_url() ) : '' ),
					'quickview_image_width'            => class_exists( 'WooCommerce' ) ? Amely_Woo::get_quickview_image_size()[0] : 600,
					'quickview_image_height'           => class_exists( 'WooCommerce' ) ? Amely_Woo::get_quickview_image_size()[1] : 600,
					'logged_in'                        => is_user_logged_in(),
					'sticky_header'                    => amely_get_option( 'sticky_header' ) == '1' ? true : false,
					'search_by'                        => amely_get_option( 'search_by' ),
					'search_min_chars'                 => amely_get_option( 'search_min_chars' ),
					'search_limit'                     => amely_get_option( 'search_limit' ),
					'search_excerpt_on'                => amely_get_option( 'search_excerpt_on' ) == '1' ? true : false,
					'adding_to_cart_text'              => apply_filters( 'amely_adding_to_cart_text',
						esc_html__( 'Adding to cart...', 'amely' ) ),
					'added_to_cart_text'               => apply_filters( 'amely_adding_to_cart_text',
						esc_html__( 'Product has been added to cart!', 'amely' ) ),
					'shop_add_to_cart_notification_on' => amely_get_option( 'shop_add_to_cart_notification_on' ) == '1' ? true : false,
					'shop_add_to_cart_favico_on'       => amely_get_option( 'shop_add_to_cart_favico_on' ) == '1' ? true : false,
					'shop_favico_badge_bg_color'       => apply_filters( 'amely_shop_favico_badge_bg_color',
						'#ff0000' ),
					'shop_favico_badge_text_color'     => apply_filters( 'amely_shop_favico_badge_text_color',
						'#ffffff' ),
					'added_to_cart_notification_text'  => apply_filters( 'amely_added_to_cart_notification_text',
						esc_html__( 'has been added to cart!', 'amely' ) ),
					'view_cart_notification_text'      => apply_filters( 'amely_view_cart_notification_text',
						esc_html__( 'View Cart', 'amely' ) ),
					'shop_wishlist_notification_on'    => amely_get_option( 'shop_wishlist_notification_on' ) == '1' ? true : false,
					'added_to_wishlist_text'           => get_option( 'yith_wcwl_product_added_text',
						esc_html__( 'Product has been added to wishlist!', 'amely' ) ),
					'browse_wishlist_text'             => get_option( 'yith_wcwl_browse_wishlist_text',
						esc_html__( 'Browse Wishlist', 'amely' ) ),
					'wishlist_url'                     => ( function_exists( 'YITH_WCWL' ) ? esc_url( YITH_WCWL()->get_wishlist_url() ) : '' ),
					'shop_ajax_on'                     => amely_get_option( 'shop_ajax_on' ) == '1' ? true : false,
					'categories_toggle'                => apply_filters( 'amely_categories_toggle', true ),
					'product_page_layout'              => amely_get_option( 'product_page_layout' ),
					'categories_columns'               => amely_get_option( 'categories_columns' ),
					'go_to_filter_text'                => apply_filters( 'amely_go_to_filter_text',
						esc_html__( 'Back to top', 'amely' ) ),
					'wishlist_burst_color'             => apply_filters( 'amely_wishlist_burst_color',
						amely_get_option( 'primary_color' ) ),
					'is_shop'                          => ( class_exists( 'WooCommerce' ) && Amely_Woo::is_shop() ),
				) );
		}

		/**
		 * Add admin css
		 *
		 * @since 1.0
		 */
		public function admin_css() {
			/*
			 * Enqueue main JS
			 */
			wp_enqueue_style( 'admin-font-awesome',
				AMELY_THEME_URI . '/assets/libs/font-awesome/css/font-awesome.min.css' );
			wp_enqueue_style( 'amely-css-admin', AMELY_THEME_URI . '/assets/admin/css/admin.css' );
		}

		/**
		 * Add admin js
		 *
		 * @since 1.0
		 */
		public function admin_js() {
			/*
			 * Enqueue main JS
			 */
			wp_enqueue_script( 'amely-admin-js',
				AMELY_THEME_URI . '/assets/admin/js/admin.js',
				array(
					'jquery',
					'jquery-ui-tabs',
				),
				null,
				true );
		}

		/**
		 * Include the generated CSS and JS in the page header.
		 */
		public function custom_css() {

			$id = Amely_Helper::get_the_ID();

			$topbar_on     = amely_get_option( 'topbar_on' );
			$topbar_height = $topbar_on ? amely_get_option( 'topbar_height' ) : 0;

			$logo_width         = amely_get_option( 'logo_width' );
			$right_column_width = amely_get_option( 'right_column_width' );

			$header                   = amely_get_option( 'header' );
			$header_white             = amely_get_option( 'header_white' );
			$header_height            = amely_get_option( 'header_height' );
			$header_sticky_height     = $header_height - 20;
			$site_menu_items_color    = amely_get_option( 'site_menu_items_color' );
			$site_menu_subitems_color = amely_get_option( 'site_menu_subitems_color' );

			$page_title_height = amely_get_option( 'page_title_height' );

			$custom_css = amely_get_option( 'custom_css' );

			$output = '';

			if ( $topbar_on ) {
				$output .= '.topbar{min-height:' . $topbar_height . 'px} .topbar .social-links li i{height:' . $topbar_height . 'px}';
				$output .= '.topbar .topbar-close-btn{height:' . $topbar_height . 'px;width:' . $topbar_height . 'px}';
				$output .= '.topbar-open-btn{top:' . $topbar_height . 'px}';
				$output .= '.topbar .topbar-left, .topbar .topbar-right, .topbar .topbar-center, 
				.topbar .social-links li i, .topbar .social-links li span.title,
				.topbar .switcher .nice-select,.topbar .topbar-close-btn:before, .topbar-open-btn i{line-height:' . $topbar_height . 'px}';
				$output .= '.header-overlap .site-header:not(.sticky-header){top:' . ( $topbar_height ) . 'px}'; // 1px is border height
			}

			if ( $header_white && $header != 'menu-bottom' && amely_get_option( 'header_overlap' ) ) {
				$output .= '.site-menu .menu > ul > li > a, 
				.site-menu .menu > li > a{color: #fff !important;}';
				$output .= '.site-header.sticky-header .site-menu .menu > ul > li > a, 
				.site-header.sticky-header .site-menu .menu > li > a, 
				.header-overlap .site-header:hover .site-menu .menu > ul > li > a, 
				.header-overlap .site-header:hover .site-menu .menu > li > a{color:' . $site_menu_items_color['regular'] . ' !important;}';

				$output .= '.header-search a.toggle{color:#fff !important}';
				$output .= '.site-header.sticky-header .header-search a.toggle, 
				.header-overlap .site-header:hover .header-search a.toggle{color:' . amely_get_option( 'search_color' ) . ' !important}';

				$output .= '.header-minicart a.toggle{color: #fff !important;}';
				$output .= '.site-header.sticky-header .header-minicart a.toggle, .header-overlap .site-header:hover .header-minicart a.toggle{color: ' . amely_get_option( 'minicart_icon_color' ) . ' !important;}';

				$output .= '.mobile-menu-btn path{stroke: #fff !important;}';
				$output .= '.site-header.sticky-header .mobile-menu-btn path, .header-overlap .site-header:hover .mobile-menu-btn path{stroke: ' . amely_get_option( 'mobile_menu_button_color' ) . ' !important;}';

				$output .= '.header-minicart a.toggle .minicart-count{color: #333 !important; background-color: #fff !important;}';
				$output .= '.header-tools.layout-only-mini-cart .header-minicart a.toggle .minicart-count, .site-header.sticky-header .header-minicart a.toggle .minicart-count, .header-overlap .site-header:hover .header-minicart a.toggle .minicart-count{
				color: ' . amely_get_option( 'minicart_count_color' ) . ' !important;
				background-color: ' . amely_get_option( 'minicart_count_bg_color' ) . ' !important;
				}';
			}

			if ( $header != 'vertical' ) {
				$output .= '@media (min-width: 1200px) {';
				$output .= '.site-logo{line-height:' . $header_height . 'px}';
				$output .= '.site-logo img{max-height:' . $header_height . 'px}';
				$output .= '.site-header.header-split .site-logo{height:' . $header_height . 'px}';
				$output .= '.site-header.sticky-header{height:' . $header_sticky_height . 'px}';
				$output .= '.site-header.header-split.sticky-header .site-logo{height:' . $header_sticky_height . 'px}';
				$output .= '.site-header.sticky-header .site-logo{line-height:' . $header_sticky_height . 'px}';
				$output .= '.site-header.sticky-header .site-logo img{max-height:' . $header_sticky_height . 'px}';
				$output .= '}';
			}

			if ( $header != 'split' && $header != 'menu-bottom' ) {
				$output .= '.site-logo{width:' . $logo_width . '%}';
				$output .= '.header-tools{width:' . $right_column_width . '%}';
				$output .= '.site-menu .menu > ul > li, .site-menu .menu > li{height:' . $header_height . 'px;line-height:' . $header_height . 'px}';
			} elseif ( $header == 'split' ) {
				$output .= '.site-menu .menu > ul > li, .site-menu .menu > li{height:' . $header_height . 'px;line-height:' . $header_height . 'px}';
			} elseif ( $header == 'menu-bottom' ) {
				$output .= '.site-header.sticky-header .site-menu .menu > ul > li, .hidden-sticky-header .site-menu .menu > li{height:' . $header_sticky_height . 'px;line-height:' . $header_sticky_height . 'px}';
				$output .= '@media (min-width: 1200px) {';
				$output .= '.site-header.sticky-header .site-logo{line-height:' . $header_sticky_height . 'px}';
				$output .= '.site-header.sticky-header .site-logo img{max-height:' . $header_sticky_height . 'px}';
				$output .= '.site-header.sticky-header .site-logo{width:' . $logo_width . '%}';
				$output .= '.site-header.sticky-header .header-tools{width:' . $right_column_width . '%}';
				$output .= '}';
			}
			$output .= '.site-header.sticky-header .site-menu .menu > ul > li, .site-header.sticky-header .site-menu .menu > li{height:' . $header_sticky_height . 'px;line-height:' . $header_sticky_height . 'px}';

			if ( $header == 'vertical' ) {
				$output .= '@media (min-width: 1200px) {';
				$output .= '.site-header.header-vertical{width:' . amely_get_option( 'header_v_width' ) . 'px}';
				$output .= 'body.site-header-vertical{margin-left:' . amely_get_option( 'header_v_width' ) . 'px}';
				$output .= '.site-header.header-vertical .header-minicart .minicart-dropdown-wrapper{left:' . ( amely_get_option( 'header_v_width' ) - 20 ) . 'px}';
				$output .= '.site-header.header-vertical .header-minicart.minicart-open .minicart-dropdown-wrapper{left:' . amely_get_option( 'header_v_width' ) . 'px}';
				$output .= '.site-header.header-vertical .header-wishlist .wishlist-dropdown-wrapper{left:' . ( amely_get_option( 'header_v_width' ) - 20 ) . 'px}';
				$output .= '.site-header.header-vertical .header-wishlist.wishlist-open .wishlist-dropdown-wrapper{left:' . amely_get_option( 'header_v_width' ) . 'px}';
				$output .= 'body.mobile-wishlist-opened .site-header:after, body.mobile-minicart-opened .site-header:after{margin-left:' . amely_get_option( 'header_v_width' ) . 'px}';
				$output .= '}';
			}

			if ( is_array( $site_menu_items_color ) && isset( $site_menu_items_color['regular'] ) && isset( $site_menu_items_color['hover'] ) ) {
				$output .= '.site-menu .menu > ul > li:hover > a, .site-menu .menu > li:hover > a{color:' . $site_menu_items_color['regular'] . '}';
				$output .= '.site-menu .menu > ul > li.current_page_item > a,.site-menu .menu > li.current-menu-item > a{color:' . $site_menu_items_color['hover'] . '}';
				$output .= '.site-menu .menu > ul > li > a:after, .site-menu .menu > li > a:after{background-color:' . $site_menu_items_color['hover'] . '}';
			}

			if ( is_array( $site_menu_subitems_color ) && isset( $site_menu_subitems_color['hover'] ) ) {
				$output .= '.site-menu .menu > ul > li .children li.page_item:before, .site-menu .menu > li .sub-menu li.menu-item:before  { background-color:' . $site_menu_subitems_color['hover'] . '}';

				$output .= '.site-menu .menu > ul > li .children li.page_item:hover > a,
				.site-menu .menu > li .sub-menu li.menu-item:hover > a,
				.site-menu .menu > ul > li .children li.page_item:hover:after,
				.site-menu .menu > li .sub-menu li.menu-item:hover:after,
				.site-menu .menu > ul > li .children li.page_item.current_page_item > a,
				.site-menu .menu > li .sub-menu li.menu-item.current-menu-item > a { color: ' . $site_menu_subitems_color['hover'] . '}';
			}

			// Page title for post or page
			$output .= '@media (min-width: 1200px) {';
			$output .= '.page-title > .container > .row{height:' . $page_title_height . 'px}';
			$output .= '}';

			// Page title for post or page
			if ( $id || is_category() || is_tax( 'product_cat' ) || is_home() ) {

				// Page & Post
				$page_title_on            = get_post_meta( $id, 'amely_page_title_on', true );
				$page_title_style         = get_post_meta( $id, 'amely_page_title_style', true );
				$page_title_text_color    = get_post_meta( $id, 'amely_page_title_text_color', true );
				$page_subtitle_color      = get_post_meta( $id, 'amely_page_subtitle_color', true );
				$page_title_bg_color      = get_post_meta( $id, 'amely_page_title_bg_color', true );
				$page_title_overlay_color = get_post_meta( $id, 'amely_page_title_overlay_color', true );
				$page_title_bg_image      = get_post_meta( $id, 'amely_page_title_bg_image', true );

				// Page title on category page
				if ( is_category() ) {
					$term_id                  = get_category( get_query_var( 'cat' ) )->term_id;
					$page_title_on            = get_term_meta( $term_id, 'amely_page_title_on', true );
					$page_title_style         = get_term_meta( $term_id, 'amely_page_title_style', true );
					$page_title_text_color    = get_term_meta( $term_id, 'amely_page_title_text_color', true );
					$page_subtitle_color      = get_term_meta( $term_id, 'amely_page_subtitle_color', true );
					$page_title_bg_color      = get_term_meta( $term_id, 'amely_page_title_bg_color', true );
					$page_title_overlay_color = get_term_meta( $term_id, 'amely_page_title_overlay_color', true );
					$page_title_bg_image      = get_term_meta( $term_id, 'amely_page_title_bg_image', true );
				}

				// Page title on product category page
				if ( is_tax( 'product_cat' ) ) {
					$term_id                  = get_term_by( 'slug',
						get_query_var( 'product_cat' ),
						'product_cat' )->term_id;
					$page_title_on            = get_term_meta( $term_id, 'amely_page_title_on', true );
					$page_title_style         = get_term_meta( $term_id, 'amely_page_title_style', true );
					$page_title_text_color    = get_term_meta( $term_id, 'amely_page_title_text_color', true );
					$page_subtitle_color      = get_term_meta( $term_id, 'amely_page_subtitle_color', true );
					$page_title_bg_color      = get_term_meta( $term_id, 'amely_page_title_bg_color', true );
					$page_title_overlay_color = get_term_meta( $term_id, 'amely_page_title_overlay_color', true );
					$page_title_bg_image      = get_term_meta( $term_id, 'amely_page_title_bg_image', true );
				}

				if ( $page_title_on == 'default' || ! $page_title_on ) {
					$page_title_on = amely_get_option( 'page_title_on' );
				}

				if ( $page_title_on && $page_title_style != 'default' ) {

					$output .= '.page-title h1,
					.page-title .site-breadcrumbs,
					.page-title .site-breadcrumbs ul li:after,
					.page-title .site-breadcrumbs .insight_core_breadcrumb a:hover{color:' . $page_title_text_color . ' !important}';
					$output .= '.page-title .page-subtitle,
					.page-title .site-breadcrumbs .insight_core_breadcrumb a{color:' . $page_subtitle_color . ' !important}';

					if ( $page_title_style == 'bg_color' ) {
						$output .= '.page-title.page-title-bg_color{background-color:' . $page_title_bg_color . ' !important}';
					}

					if ( $page_title_style == 'bg_image' ) {
						$output .= '.page-title.page-title-bg_image{background-image:url(\'' . $page_title_bg_image . '\')}';
						$output .= '.page-title:before{background-color:' . $page_title_overlay_color . ' !important}';
					}

					if ( $page_title_style == 'default' || ! $page_title_style ) {
						$page_title_style = amely_get_option( 'page_title_style' );
					}
				}
			}

			// Custom color for page
			if ( $id && ( is_page() || is_home() || Amely_Woo::is_shop() ) ) {
				$offcanvas_button_color = get_post_meta( $id, 'amely_offcanvas_button_color', true );

				// Off-canvas
				if ( $offcanvas_button_color ) {
					$output .= '.offcanvas-btn .ti-menu.ti-menu{color:' . $offcanvas_button_color . '}';
				}
			}

			// If Redux is not installed
			if ( ! class_exists( 'Redux' ) ) {

				$bg_404 = amely_get_option( '404_bg' );

				$output .= '.area-404{background-color:#f7f7f7;background-image:url(\'' . $bg_404['background-image'] . '\')';
			}

			if ( $custom_css ) {
				$output .= $custom_css;
			}

			$output = Amely_Helper::text2line( $output );
			$output = apply_filters( 'amely_custom_css', $output );

			wp_add_inline_style( 'amely-main-style', $output );
		}

		/**
		 * Load custom JS
		 */
		public function custom_js() {

			$custom_js = amely_get_option( 'custom_js' );

			if ( $custom_js ) {
				wp_add_inline_script( 'amely-main-js', $custom_js );
			}
		}

	}

	new Amely_Enqueue();
}
