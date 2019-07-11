<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Extend Visual Composer
 *
 * Class Insight_VC
 */
if ( ! class_exists( 'Amely_VC' ) ) {

	class Amely_VC {

		public function __construct() {

			// Define VC-Templates folder for shortcodes
			if ( function_exists( 'vc_set_shortcodes_templates_dir' ) ) {
				$new_vc_dir = AMELY_THEME_DIR . '/includes/vc-extend/vc-templates';
				vc_set_shortcodes_templates_dir( $new_vc_dir );
			}

			// active VC
			add_action( 'vc_before_init', array( $this, 'set_as_theme' ) );

			add_filter( 'vc_shortcodes_css_class', array( $this, 'rewrite_class_name' ), 10, 2 );
			add_filter( 'vc_google_fonts_get_fonts_filter', array( $this, 'update_vc_google_fonts' ) );

			add_action( 'vc_after_init', array( $this, 'load_params' ) );
			add_action( 'vc_after_init', array( $this, 'load_font_libs' ) );
			add_action( 'vc_after_init', array( $this, 'load_shortcodes' ) );
			add_action( 'vc_after_init', array( $this, 'update_shortcode_params' ) );
			add_action( 'vc_after_init', array( $this, 'add_icons_param_to_shortcode' ) );

			add_action( 'amely_after_page_container', array( $this, 'shortcode_css' ), 999 );
		}

		public function set_as_theme() {
			vc_set_as_theme();
		}

		public function shortcode_css() {

			global $amely_shortcode_css;
			$js_output = '';
			$js_output .= 'if ( _amelyInlineStyle !== null ) {';
			$js_output .= '_amelyInlineStyle.textContent+=\'' . Amely_Helper::text2line( $amely_shortcode_css ) . '\';';
			$js_output .= '}';
			wp_add_inline_script( 'amely-main-js', Amely_Helper::text2line( $js_output ) );
		}

		public static function get_amely_shortcode_id( $name ) {

			global $amely_shortcode_id;

			if ( ! $amely_shortcode_id ) {
				$amely_shortcode_id = 1;
			}

			return $name . '-' . ( $amely_shortcode_id ++ );
		}

		/**
		 * Rewrite class name for rows and columns
		 *
		 * @param $class_string
		 * @param $tag
		 *
		 * @return mixed
		 */
		public function rewrite_class_name( $class_string, $tag ) {

			if ( $tag == 'vc_row' || $tag == 'vc_row_inner' ) {
				$class_string = str_replace( 'vc_row-fluid', 'row', $class_string );
			}
			if ( $tag == 'vc_column' || $tag == 'vc_column_inner' ) {
				$class_string = preg_replace( '/vc_col-xs-(\d{1,2})/', 'col-xs-$1', $class_string );
				$class_string = preg_replace( '/vc_col-sm-(\d{1,2})/', 'col-sm-$1', $class_string );
				$class_string = preg_replace( '/vc_col-md-(\d{1,2})/', 'col-md-$1', $class_string );
				$class_string = preg_replace( '/vc_col-lg-(\d{1,2})/', 'col-lg-$1', $class_string );
				$class_string = preg_replace( '/vc_col-xs-offset-(\d{1,2})/', 'offset-xs-$1', $class_string );
				$class_string = preg_replace( '/vc_col-sm-offset-(\d{1,2})/', 'offset-sm-$1', $class_string );
				$class_string = preg_replace( '/vc_col-md-offset-(\d{1,2})/', 'offset-md-$1', $class_string );
				$class_string = preg_replace( '/vc_col-lg-offset-(\d{1,2})/', 'offset-lg-$1', $class_string );
			}

			return $class_string;
		}

		/**
		 * Update missing Google fonts
		 *
		 * @return array|mixed|object
		 */
		public function update_vc_google_fonts( $fonts ) {

			$fonts[] = (object) array(
				'font_family' => 'Poppins',
				'font_styles' => '300,regular,500,600,700',
				'font_types'  => '300 light regular:300:normal,400 regular:400:normal,500 medium regular:500:normal,600 semi-bold regular:600:normal,700 bold regular:700:normal',
			);

			usort( $fonts, array( $this, 'sort_fonts' ) );

			return $fonts;
		}

		/**
		 * Sort fonts base on name
		 *
		 * @param object $a
		 * @param object $b
		 *
		 * @return int
		 */
		private function sort_fonts( $a, $b ) {
			return strcmp( $a->font_family, $b->font_family );
		}

		/**
		 * Load VC Params
		 */
		public function load_params() {
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-params/amely-ajax-search/amely_ajax_search.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-params/amely-chosen/amely_chosen.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-params/amely-datetime-picker/amely_datetime_picker.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-params/amely-number/amely_number.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-params/amely-social-links/amely_social_links.php';
		}

		/**
		 * Load icon fonts
		 */
		public function load_font_libs() {
			require_once get_template_directory() . '/includes/fontlibs/pe7stroke.php';
			require_once get_template_directory() . '/includes/fontlibs/themify-icons.php';
			require_once get_template_directory() . '/includes/fontlibs/ionicons.php';
		}

		/**
		 * Load shortcode
		 */
		public function load_shortcodes() {
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner2.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner3.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner4.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner-grid-5.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner-grid-6.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner-grid-6v2.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-blog.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-button.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-countdown.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-gmaps.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-icon-box.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-instagram.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-image-carousel.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-mailchimp.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-space.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-social.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-team-member.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-testimonial-carousel.php';
			require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-banner-grid-group.php';

			if ( class_exists( 'WooCommerce' ) ) {
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-feature-product.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-carousel.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-grid.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-tabs.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-widget.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-categories.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-product-category-banner.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-showcase.php';
			}

			if ( class_exists( 'woo_brands' ) ) {
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-brands-grid.php';
				require_once AMELY_THEME_DIR . '/includes/vc-extend/vc-shortcodes/amely-brands-carousel.php';
			}
		}

		/**
		 * Update param for shortcodes
		 */
		public function update_shortcode_params() {

			if ( function_exists( 'vc_update_shortcode_param' ) ) {

				/* Row */
				vc_update_shortcode_param( 'vc_row',
					array(
						'param_name' => 'full_width',
						'value'      => array(
							esc_html__( 'Default', 'amely' )                 => '',
							esc_html__( 'Wide row (from theme)', 'amely' )   => 'amely_wide_row',
							esc_html__( 'Stretch row', 'amely' )             => 'stretch_row',
							esc_html__( 'Stretch row and content', 'amely' ) => 'stretch_row_content',
							esc_html__( 'Stretch row and content (no paddings)',
								'amely' )                                    => 'stretch_row_content_no_spaces',
						),
					) );

				/* Column */
				vc_update_shortcode_param( 'vc_column',
					array(
						'param_name'  => 'sticky_column',
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Make this column to sticky?', 'amely' ),
						'description' => esc_html__( 'Attach this column to the page when the user scrolls such that it is always visible',
							'amely' ),
						'value'       => array( esc_html__( 'Yes', 'amely' ) => 'yes' ),
						'weight'      => 100,
					) );

				/* Custom Heading */
				vc_update_shortcode_param( 'vc_custom_heading',
					array(
						'param_name' => 'use_theme_fonts',
						'std'        => 'yes',
					) );

				/* Tab */
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Amely (from theme)', 'amely' ) => 'amely',
							esc_html__( 'Classic', 'amely' )            => 'classic',
							esc_html__( 'Modern', 'amely' )             => 'modern',
							esc_html__( 'Flat', 'amely' )               => 'flat',
							esc_html__( 'Outline', 'amely' )            => 'outline',
						),
					) );
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'spacing',
						'std'        => '0',
					) );
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'shape',
						'std'        => 'square',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'color',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'no_fill_content_area',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );
				vc_update_shortcode_param( 'vc_tta_tabs',
					array(
						'param_name' => 'no_fill_content_area',
						'std'        => 'true',
					) );

				/* Accordion */
				vc_update_shortcode_param( 'vc_tta_accordion',
					array(
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Amely (from theme)', 'amely' ) => 'amely',
							esc_html__( 'Classic', 'amely' )            => 'classic',
							esc_html__( 'Modern', 'amely' )             => 'modern',
							esc_html__( 'Flat', 'amely' )               => 'flat',
							esc_html__( 'Outline', 'amely' )            => 'outline',
						),
					) );

				vc_update_shortcode_param( 'vc_tta_accordion',
					array(
						'param_name' => 'shape',
						'std'        => 'square',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );

				vc_update_shortcode_param( 'vc_tta_accordion',
					array(
						'param_name' => 'color',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );

				vc_update_shortcode_param( 'vc_tta_accordion',
					array(
						'param_name' => 'no_fill',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );

				vc_update_shortcode_param( 'vc_tta_accordion',
					array(
						'param_name' => 'no_fill',
						'std'        => 'true',
					) );

				/* Toggle */
				vc_update_shortcode_param( 'vc_toggle',
					array(
						'param_name' => 'style',
						'value'      => array(
							esc_html__( 'Default', 'amely' )            => 'default',
							esc_html__( 'Amely (from theme)', 'amely' ) => 'amely',
							esc_html__( 'Simple', 'amely' )             => 'simple',
							esc_html__( 'Round', 'amely' )              => 'round',
							esc_html__( 'Round Outline', 'amely' )      => 'round_outline',
							esc_html__( 'Rounded', 'amely' )            => 'rounded',
							esc_html__( 'Rounded Outline', 'amely' )    => 'rounded_outline',
							esc_html__( 'Square', 'amely' )             => 'square',
							esc_html__( 'Square Outline', 'amely' )     => 'square_outline',
							esc_html__( 'Arrow', 'amely' )              => 'arrow',
							esc_html__( 'Text Only', 'amely' )          => 'text_only',
						),
						'std'        => 'amely',
					) );
				vc_update_shortcode_param( 'vc_toggle',
					array(
						'param_name' => 'color',
						'dependency' => array(
							'element'            => 'style',
							'value_not_equal_to' => array( 'amely' ),
						),
					) );

				// Woo Brand Pro
				if ( class_exists( 'woo_brands' ) ) {

					vc_update_shortcode_param( 'pw_brand_vc_az_view',
						array(
							'param_name' => 'pw_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-filter-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-filter-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-filter-style3',
								esc_html__( 'Style 4', 'amely' )            => 'wb-filter-style4',
								esc_html__( 'Style 5', 'amely' )            => 'wb-filter-style5',
								esc_html__( 'Style 6', 'amely' )            => 'wb-filter-style6',
								esc_html__( 'Style 7', 'amely' )            => 'wb-filter-style7',
								esc_html__( 'Style 8', 'amely' )            => 'wb-filter-style8',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-filter-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_az_view',
						array(
							'param_name' => 'pw_brand_list_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-brandlist-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-brandlist-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-brandlist-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-brandlist-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_all_vc_view',
						array(
							'param_name' => 'pw_filter_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-multi-filter-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-multi-filter-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-multi-filter-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-multi-filter-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_all_vc_view',
						array(
							'param_name' => 'pw_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-allview-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-allview-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-allview-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-allview-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_carousel',
						array(
							'param_name' => 'pw_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-car-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-car-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-car-style3',
								esc_html__( 'Style 4', 'amely' )            => 'wb-car-style3',
								esc_html__( 'Style 5', 'amely' )            => 'wb-car-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-car-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_carousel',
						array(
							'param_name' => 'pw_carousel_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-carousel-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-carousel-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-carousel-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-carousel-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_carousel',
						array(
							'param_name' => 'pw_round_corner',
							'dependency' => array(
								'element'            => 'pw_style',
								'value_not_equal_to' => 'wb-car-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_carousel',
						array(
							'param_name' => 'pw_carousel_skin_style',
							'dependency' => array(
								'element'            => 'pw_carousel_style',
								'value_not_equal_to' => 'wb-carousel-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_prodcut_carousel',
						array(
							'param_name' => 'pw_title_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-brandpro-car-header-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-brandpro-car-header-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-brandpro-car-header-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-brandpro-car-header-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_prodcut_carousel',
						array(
							'param_name' => 'pw_item_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-brandpro-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-brandpro-style2',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-brandpro-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_prodcut_carousel',
						array(
							'param_name' => 'pw_carousel_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-carousel-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-carousel-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-carousel-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-carousel-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_prodcut_carousel',
						array(
							'param_name' => 'pw_carousel_skin_style',
							'dependency' => array(
								'element'            => 'pw_carousel_style',
								'value_not_equal_to' => 'wb-carousel-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_prodcut_carousel',
						array(
							'param_name' => 'pw_item_marrgin',
							'dependency' => array(
								'element'            => 'pw_carousel_style',
								'value_not_equal_to' => 'wb-carousel-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_product_grid',
						array(
							'param_name' => 'pw_title_style',
							'value'      => array(
								esc_html__( 'Style 1', 'amely' )            => 'wb-brandpro-car-header-style1',
								esc_html__( 'Style 2', 'amely' )            => 'wb-brandpro-car-header-style2',
								esc_html__( 'Style 3', 'amely' )            => 'wb-brandpro-car-header-style3',
								esc_html__( 'Amely (from theme)', 'amely' ) => 'wb-brandpro-car-header-amely',
							),
						) );

					vc_update_shortcode_param( 'pw_brand_vc_product_grid',
						array(
							'param_name' => 'pw_columns',
							'std'        => 4,
						) );
				}
			}
		}

		/**
		 * Add params for shortcodes
		 */
		public function add_icons_param_to_shortcode() {

			/* vc_tta_section */
			$this->add_icon_fonts( 'vc_tta_section',
				'i_type',
				'i_icon_material',
				array(
					'p7stroke' => 'i_icon_pe7stroke',
				) );

			/* vc_btn */
			$this->add_icon_fonts( 'vc_btn',
				'i_type',
				'i_icon_pixelicons',
				array(
					'p7stroke' => 'i_icon_pe7stroke',
				) );

			/* Icon */
			$this->add_icon_fonts();
		}

		/**
		 * Add custom icon libraries to the shortcodes which made by VC
		 *
		 * @param        $shortcode
		 * @param        $param_name
		 * @param        $break_param_name
		 * @param        $params_name
		 */
		function add_icon_fonts(
			$shortcode = 'vc_icon', $param_name = 'type', $break_param_name = 'icon_material', $params_name = array(
			'p7stroke' => 'icon_pe7stroke',
		)
		) {
			$icon_arr = array(
				esc_html__( 'Font Awesome', 'amely' )  => 'fontawesome',
				esc_html__( 'Open Iconic', 'amely' )   => 'openiconic',
				esc_html__( 'Typicons', 'amely' )      => 'typicons',
				esc_html__( 'Entypo', 'amely' )        => 'entypo',
				esc_html__( 'Linecons', 'amely' )      => 'linecons',
				esc_html__( 'Mono Social', 'amely' )   => 'monosocial',
				esc_html__( 'Material', 'amely' )      => 'material',
				esc_html__( 'P7 Stroke', 'amely' )     => 'pe7stroke',
				esc_html__( 'Themify Icons', 'amely' ) => 'themifyicons',
				esc_html__( 'Ionicons', 'amely' )      => 'ionicons',
			);

			if ( $shortcode == 'vc_btn' ) {
				$icon_arr = array(
					esc_html__( 'Font Awesome', 'amely' )  => 'fontawesome',
					esc_html__( 'Open Iconic', 'amely' )   => 'openiconic',
					esc_html__( 'Typicons', 'amely' )      => 'typicons',
					esc_html__( 'Entypo', 'amely' )        => 'entypo',
					esc_html__( 'Linecons', 'amely' )      => 'linecons',
					esc_html__( 'Mono Social', 'amely' )   => 'monosocial',
					esc_html__( 'Material', 'amely' )      => 'material',
					esc_html__( 'Pixel', 'amely' )         => 'pixelicons',
					esc_html__( 'P7 Stroke', 'amely' )     => 'pe7stroke',
					esc_html__( 'Themify Icons', 'amely' ) => 'themifyicons',
					esc_html__( 'Ionicons', 'amely' )      => 'ionicons',
				);
			}

			vc_update_shortcode_param( $shortcode,
				array(
					'param_name' => $param_name,
					'value'      => $icon_arr,
				) );

			$params = vc_get_shortcode( $shortcode )['params'];
			$weight = count( $params ) * 2;

			foreach ( $params as $param ) {

				vc_update_shortcode_param( $shortcode,
					array(
						'param_name' => $param['param_name'],
						'weight'     => $weight,
					) );

				if ( $break_param_name == $param['param_name'] ) {
					vc_add_params( $shortcode,
						array(
							array(
								'type'        => 'iconpicker',
								'heading'     => esc_html__( 'Icon', 'amely' ),
								'param_name'  => $params_name['p7stroke'],
								'value'       => 'pe-7s-album',
								'settings'    => array(
									'emptyIcon'    => false,
									'type'         => 'pe7stroke',
									'iconsPerPage' => 400,
								),
								'dependency'  => array(
									'element' => $param_name,
									'value'   => 'pe7stroke',
								),
								'description' => esc_html__( 'Select icon from library.', 'amely' ),
								'weight'      => $weight - 1,
							),

							array(
								'type'        => 'iconpicker',
								'heading'     => esc_html__( 'Icon', 'amely' ),
								'param_name'  => 'icon_themifyicons',
								'value'       => 'ti-arrow-up',
								'settings'    => array(
									'emptyIcon'    => false,
									'type'         => 'themifyicons',
									'iconsPerPage' => 400,
								),
								'dependency'  => array(
									'element' => $param_name,
									'value'   => 'themifyicons',
								),
								'description' => esc_html__( 'Select icon from library.', 'amely' ),
								'weight'      => $weight - 1,
							),

							array(
								'type'        => 'iconpicker',
								'heading'     => esc_html__( 'Icon', 'amely' ),
								'param_name'  => 'icon_ionicons',
								'value'       => 'ion-ionic',
								'settings'    => array(
									'emptyIcon'    => false,
									'type'         => 'ionicons',
									'iconsPerPage' => 500,
								),
								'dependency'  => array(
									'element' => $param_name,
									'value'   => 'ionicons',
								),
								'description' => esc_html__( 'Select icon from library.', 'amely' ),
								'weight'      => $weight - 1,
							),

						) );
				}

				$weight -= 2;
			}
		}

		/**
		 * Icon libraries for our theme
		 *
		 * @param array $dependency
		 * @param bool $admin_label
		 * @param bool $allow_none
		 *
		 * @return array icon_array
		 */
		public static function icon_libraries( $dependency = array(), $admin_label = true, $allow_none = false ) {

			$icon_arr = array(
				esc_html__( 'Font Awesome', 'amely' )  => 'fontawesome',
				esc_html__( 'Open Iconic', 'amely' )   => 'openiconic',
				esc_html__( 'Typicons', 'amely' )      => 'typicons',
				esc_html__( 'Entypo', 'amely' )        => 'entypo',
				esc_html__( 'Linecons', 'amely' )      => 'linecons',
				esc_html__( 'Mono Social', 'amely' )   => 'monosocial',
				esc_html__( 'Material', 'amely' )      => 'material',
				esc_html__( 'P7 Stroke', 'amely' )     => 'pe7stroke',
				esc_html__( 'Themify Icons', 'amely' ) => 'themifyicons',
				esc_html__( 'Ionicons', 'amely' )      => 'ionicons',
			);

			if ( $allow_none ) {
				$icon_arr = array( esc_html__( 'None', 'amely' ) => '' ) + $icon_arr;
			}

			return array(
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon library', 'amely' ),
					'admin_label' => $admin_label,
					'value'       => $icon_arr,
					'param_name'  => 'type',
					'description' => esc_html__( 'Select icon library.', 'amely' ),
					'dependency'  => $dependency,
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fa fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'fontawesome',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'openiconic',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_typicons',
					'value'       => 'typcn typcn-adjust-brightness',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'typicons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_entypo',
					'value'       => 'entypo-icon entypo-icon-note',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'entypo',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'entypo',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'linecons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_monosocial',
					'value'       => 'vc-mono vc-mono-fivehundredpx',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'monosocial',
						'iconsPerPage' => 400,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'monosocial',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_meterial',
					'value'       => 'vc-material vc-material-cake',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'material',
						'iconsPerPage' => 400,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'material',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_pe7stroke',
					'value'       => 'pe-7s-album',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'pe7stroke',
						'iconsPerPage' => 400,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'pe7stroke',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_themifyicons',
					'value'       => 'ti-arrow-up',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'themifyicons',
						'iconsPerPage' => 400,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'themifyicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),

				array(
					'group'       => esc_html__( 'Icon', 'amely' ),
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'amely' ),
					'param_name'  => 'icon_ionicons',
					'value'       => 'ion-ionic',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'ionicons',
						'iconsPerPage' => 500,
					),
					'dependency'  => array(
						'element' => 'type',
						'value'   => 'ionicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'amely' ),
				),
			);
		}

		/**
		 * Get common param for shortcodes
		 *
		 * @param        $param_name
		 * @param string $group
		 * @param string $dependency
		 *
		 * @return array
		 */
		public static function get_param( $param_name, $group = '', $dependency = '' ) {

			$param = array();

			switch ( $param_name ) {
				case 'css':
					$param = array(
						'group'      => esc_html__( 'Design Options', 'amely' ),
						'type'       => 'css_editor',
						'heading'    => esc_html__( 'CSS box', 'amely' ),
						'param_name' => 'css',
					);
					break;
				case 'columns':
					$param = array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Number of columns', 'amely' ),
						'description' => esc_html__( 'Select number of columns in a row', 'amely' ),
						'param_name'  => 'columns',
						'value'       => array(
							2,
							3,
							4,
							5,
							6,
						),
						'std'         => 4,
					);
					break;
				case 'el_class':
					$param = array(
						'type'        => 'textfield',
						'heading'     => esc_html__( 'Extra class name', 'amely' ),
						'param_name'  => 'el_class',
						'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.',
							'amely' ),
					);
					break;
				case 'animation':
					$param = array(
						'type'        => 'animation_style',
						'heading'     => esc_html__( 'Animation Style', 'amely' ),
						'param_name'  => 'animation',
						'description' => esc_html__( 'Choose your animation style', 'amely' ),
						'admin_label' => false,
						'weight'      => 0,
					);
					break;
				case 'order':
					$param = array(
						'group'       => $group,
						'type'        => 'dropdown',
						'param_name'  => 'orderby',
						'heading'     => esc_html__( 'Order by', 'amely' ),
						'value'       => array(
							'',
							esc_html__( 'Date', 'amely' )                  => 'date',
							esc_html__( 'Post ID', 'amely' )               => 'ID',
							esc_html__( 'Author', 'amely' )                => 'author',
							esc_html__( 'Title', 'amely' )                 => 'title',
							esc_html__( 'Last modified date', 'amely' )    => 'modified',
							esc_html__( 'Number of comments', 'amely' )    => 'comment_count',
							esc_html__( 'Menu order/Page Order', 'amely' ) => 'menu_order',
							esc_html__( 'Random order', 'amely' )          => 'rand',
						),
						'description' => sprintf( wp_kses( __( 'Select how to sort retrieved posts. More at <a href="%s" target="_blank">WordPress codex page</a>.',
							'amely' ),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							) ),
							esc_url( 'http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters' ) ),
						'dependency'  => $dependency,
					);
					break;
				case 'order_product':
					$param = array(
						'group'      => $group,
						'type'       => 'dropdown',
						'param_name' => 'orderby',
						'heading'    => esc_html__( 'Order by', 'amely' ),
						'value'      => array(
							esc_html__( 'None', 'amely' )               => 'none',
							esc_html__( 'Date', 'amely' )               => 'date',
							esc_html__( 'Price', 'amely' )              => 'price',
							esc_html__( 'Sales', 'amely' )              => 'sales',
							esc_html__( 'Rating', 'amely' )             => 'rating',
							esc_html__( 'Post ID', 'amely' )            => 'ID',
							esc_html__( 'Title', 'amely' )              => 'title',
							esc_html__( 'Last modified date', 'amely' ) => 'modified',
							esc_html__( 'Random order', 'amely' )       => 'rand',
						),
						'dependency' => $dependency,
					);
					break;
				case 'order_way':
					$param = array(
						'group'       => $group,
						'type'        => 'dropdown',
						'param_name'  => 'order',
						'heading'     => esc_html__( 'Sort order', 'amely' ),
						'value'       => array(
							'',
							esc_html__( 'Descending', 'amely' ) => 'DESC',
							esc_html__( 'Ascending', 'amely' )  => 'ASC',
						),
						'description' => sprintf( wp_kses( __( 'Designates the ascending or descending order. More at <a href="%s" target="_blank">WordPress codex page</a>.',
							'amely' ),
							array(
								'a' => array(
									'href'   => array(),
									'target' => array(),
								),
							) ),
							esc_url( 'http://codex.wordpress.org/Class_Reference/WP_Query#Order_.26_Orderby_Parameters' ) ),
						'dependency'  => $dependency,
					);
					break;
				case 'product_autocomplete':
					$param = array(
						'type'        => 'autocomplete',
						'heading'     => esc_html__( 'Products', 'amely' ),
						'param_name'  => 'product_ids',
						'description' => esc_html__( 'List of product', 'amely' ),
						'settings'    => array(
							'multiple' => true,
							'sortable' => true,
						),
						'dependency'  => $dependency,
					);
					break;
				case 'product_cat_autocomplete':
					$param = array(
						'type'        => 'chosen',
						'heading'     => esc_html__( 'Categories', 'amely' ),
						'param_name'  => 'product_cat_slugs',
						'options'     => array(
							'multiple' => true, // multiple or not
							'type'     => 'taxonomy', // taxonomy or post_type
							'get'      => 'product_cat', // term or post type name, split by comma
							'field'    => 'slug', // slug or id
						),
						'description' => esc_html__( 'Select what categories you want to use. Leave it empty to use all categories.',
							'amely' ),
						'dependency'  => $dependency,
					);
					break;
				case 'product_cat_dropdown':
					$args = array(
						'type'         => 'post',
						'child_of'     => 0,
						'parent'       => '',
						'orderby'      => 'id',
						'order'        => 'ASC',
						'hide_empty'   => false,
						'hierarchical' => 1,
						'exclude'      => '',
						'include'      => '',
						'number'       => '',
						'taxonomy'     => 'product_cat',
						'pad_counts'   => false,
					);

					$categories = get_categories( $args );

					$product_categories_dropdown = array();

					$first_value = array(
						'label' => esc_html__( 'Select category', 'amely' ),
						'value' => '',
					);

					if ( ! class_exists( 'TM_Vendor_Woocommerce' ) ) {
						return $param;
					}

					$vc_vendor_woo = new TM_Vendor_Woocommerce();

					$vc_vendor_woo->getCategoryChildsFull( 0, 0, $categories, 0, $product_categories_dropdown );

					array_unshift( $product_categories_dropdown, $first_value );

					$param = array(
						'type'        => 'dropdown',
						'heading'     => esc_html__( 'Category', 'amely' ),
						'value'       => $product_categories_dropdown,
						'param_name'  => 'category',
						'description' => esc_html__( 'Select a product category', 'amely' ),
						'dependency'  => $dependency,
					);
					break;
				case 'product_attribute':

					if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {

						$attributes_tax = wc_get_attribute_taxonomies();
						$attributes     = array();
						foreach ( $attributes_tax as $attribute ) {
							$attributes[ $attribute->attribute_label ] = $attribute->attribute_name;
						}
						$param = array(
							'type'        => 'dropdown',
							'heading'     => esc_html__( 'Attribute', 'amely' ),
							'param_name'  => 'attribute',
							'save_always' => true,
							'value'       => $attributes,
							'description' => esc_html__( 'List of product taxonomy attribute', 'amely' ),
							'dependency'  => $dependency,
						);
					}
					break;
				case 'product_term':
					$dependency['callback'] = 'amelyProductAttributeFilterDependencyCallback'; // on admin.js

					$param = array(
						'type'        => 'checkbox',
						'heading'     => esc_html__( 'Filter', 'amely' ),
						'param_name'  => 'filter',
						'save_always' => true,
						'value'       => array( 'empty' => 'empty' ),
						'description' => esc_html__( 'Taxonomy values', 'amely' ),
						'dependency'  => $dependency,
					);
					break;
			}

			return $param;
		}

		/**
		 * Calculate the width of columns
		 *
		 * @param $number_of_cols
		 *
		 * @return float|int|string
		 */
		public static function calculate_column_width( $number_of_cols ) {
			$total_cols = 12;

			if ( 0 == $total_cols % $number_of_cols ) {
				$width = $total_cols / $number_of_cols;
			} else {
				if ( 5 == $number_of_cols ) {
					$width = 'is-5';
				}
			}

			return $width;
		}

		/**
		 * Get taxonomy for autocomplete field of Blog Shortcode
		 *
		 * @param string $tax
		 *
		 * @return array
		 */
		public static function get_tax_for_autocomplete( $tax = '' ) {

			$results = array();

			if ( 'category' == $tax ) {
				$categories = get_categories();
				foreach ( $categories as $category ) {
					$cat_arr          = array();
					$cat_arr['label'] = $category->cat_name;
					$cat_arr['value'] = $category->cat_ID;
					$cat_arr['group'] = 'CATEGORY';

					$results[] = $cat_arr;
				}
			}

			if ( 'tag' == $tax ) {
				$tags = get_tags();
				foreach ( $tags as $tag ) {
					$tag_arr          = array();
					$tag_arr['label'] = $tag->name;
					$tag_arr['value'] = $tag->term_id;
					$tag_arr['group'] = 'TAG';

					$results[] = $tag_arr;
				}
			}

			return $results;
		}

		public function product_id_callback( $query ) {

			if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
				$vc_vendor_wc = new Vc_Vendor_Woocommerce();

				return $vc_vendor_wc->productIdAutocompleteSuggester( $query );
			}

			return '';
		}

		public function product_id_render( $query ) {

			if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
				$vc_vendor_wc = new Vc_Vendor_Woocommerce();

				return $vc_vendor_wc->productIdAutocompleteRender( $query );
			}

			return '';
		}

		public static function product_categories_slugs_callback( $query ) {

			if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
				$vc_vendor_wc = new Vc_Vendor_Woocommerce();

				return $vc_vendor_wc->productCategoryCategoryAutocompleteSuggesterBySlug( $query );
			}

			return '';
		}

		public static function product_categories_slugs_render( $query ) {

			if ( class_exists( 'Vc_Vendor_Woocommerce' ) ) {
				$vc_vendor_wc = new Vc_Vendor_Woocommerce();

				return $vc_vendor_wc->productCategoryCategoryRenderBySlugExact( $query );
			}

			return '';
		}

		/**
		 * Defines default value for param if not provided. Takes from other param value.
		 *
		 * @param array $param_settings
		 * @param       $current_value
		 * @param       $map_settings
		 * @param       $atts
		 *
		 * @return array
		 */
		public static function product_attribute_filter_param_value( $param_settings, $current_value, $map_settings, $atts ) {
			if ( isset( $atts['attribute'] ) ) {
				$value = self::get_attribute_terms( $atts['attribute'] );
				if ( is_array( $value ) && ! empty( $value ) ) {
					$param_settings['value'] = $value;
				}
			}

			return $param_settings;
		}

		/**
		 * Get attribute terms suggester
		 *
		 * @param $attribute
		 *
		 * @return array
		 */
		public static function get_attribute_terms( $attribute ) {
			$terms = get_terms( 'pa_' . $attribute ); // return array. take slug
			$data  = array();
			if ( ! empty( $terms ) && empty( $terms->errors ) ) {
				foreach ( $terms as $term ) {
					$data[ $term->name ] = $term->slug;
				}
			}

			return $data;
		}
	}

	new Amely_VC();
}

/**
 * Class TM_Vendor_Woocommerce
 */
if ( ! class_exists( 'TM_Vendor_Woocommerce' ) ) {
	class TM_Vendor_Woocommerce {

		public function getCategoryChildsFull( $parent_id, $pos, $array, $level, &$dropdown ) {

			for ( $i = $pos; $i < count( $array ); $i ++ ) {
				if ( $array[ $i ]->category_parent == $parent_id ) {
					$name       = str_repeat( '- ', $level ) . $array[ $i ]->name;
					$value      = $array[ $i ]->slug;
					$dropdown[] = array(
						'label' => $name,
						'value' => $value,
					);
					$this->getCategoryChildsFull( $array[ $i ]->term_id, $i, $array, $level + 1, $dropdown );
				}
			}
		}
	}
}
