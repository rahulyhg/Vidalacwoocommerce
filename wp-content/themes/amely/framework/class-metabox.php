<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Add Insight
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Metabox' ) ) {

	class Amely_Metabox {

		private $prefix = 'amely_';
		private $transfer_options = array();

		/**
		 * Insight_Metabox constructor.
		 */
		public function __construct() {

			add_action( 'wp', array( $this, 'modify_global_settings' ), 10 );

			// Use CMB2 Meta box for taxonomies & terms
			add_action( 'cmb2_init', array( $this, 'page_meta_boxes' ) );
			add_action( 'cmb2_init', array( $this, 'post_meta_boxes' ) );
			add_action( 'cmb2_init', array( $this, 'product_meta_boxes' ) );
			add_action( 'cmb2_init', array( $this, 'testimonial_meta_boxes' ) );
			add_action( 'cmb2_init', array( $this, 'post_category_meta_boxes' ) );
			add_action( 'cmb2_init', array( $this, 'product_category_meta_boxes' ) );
		}

		/**
		 * Meta boxes for page
		 */
		public function page_meta_boxes() {

			$offcanvas_fields = $menu_fields = $page_title_fields = $breadcrumbs_fields = $footer_fields = array();

			$page_sidebar_config = $this->redux2metabox( 'page_sidebar_config' );

			$logo            = amely_get_option( 'logo' );
			$logo_alt        = amely_get_option( 'logo_alt' );
			$logo_mobile     = amely_get_option( 'logo_mobile' );
			$logo_mobile_alt = amely_get_option( 'logo_mobile_alt' );

			$logo_fields = array(

				array(
					'name'    => esc_html__( 'Custom Logo', 'amely' ),
					'id'      => $this->prefix . 'custom_logo',
					'type'    => 'select',
					'desc'    => esc_html__( 'Use custom logo on this page.', 'amely' ),
					'options' => array(
						'on' => esc_html__( 'Yes', 'amely' ),
						''   => esc_html__( 'No', 'amely' ),
					),
					'default' => '',
				),
				array(
					'name'    => esc_html__( 'Logo Image', 'amely' ),
					'id'      => $this->prefix . 'logo',
					'type'    => 'file',
					'default' => ( isset( $logo['url'] ) && $logo['url'] ) ? $logo['url'] : '',
				),
				array(
					'name'    => esc_html__( 'Alternative Logo Image', 'amely' ),
					'id'      => $this->prefix . 'logo_alt',
					'desc'    => esc_html__( 'for the header above the content', 'amely' ),
					'type'    => 'file',
					'default' => ( isset( $logo_alt['url'] ) && $logo_alt['url'] ) ? $logo_alt['url'] : '',
				),
				array(
					'name'    => esc_html__( 'Logo in mobile devices', 'amely' ),
					'id'      => $this->prefix . 'logo_mobile',
					'type'    => 'file',
					'default' => ( isset( $logo_mobile['url'] ) && $logo_mobile['url'] ) ? $logo_mobile['url'] : '',
				),
				array(
					'name'    => esc_html__( 'Logo in mobile devices', 'amely' ),
					'id'      => $this->prefix . 'logo_mobile_alt',
					'type'    => 'file',
					'default' => ( isset( $logo_mobile_alt['url'] ) && $logo_mobile_alt['url'] ) ? $logo_mobile_alt['url'] : '',
				),
			);

			$header_transfer_options = array(
				'header_overlap',
				'sticky_header',
			);

			$offcanvas_transfer_options = array(
				'offcanvas_button_on',
				'offcanvas_action',
				'offcanvas_position',
				'offcanvas_button_color',
			);

			$menu_transfer_options = array(
				'site_menu_align',
				'site_menu_hover_style',
				'site_menu_items_color',
				'site_menu_subitems_color',
				'site_menu_bgcolor',
				'site_menu_bdcolor',
				'mobile_menu_button_color',
			);

			$page_title_fields = array(
				// custom page title
				array(
					'name' => esc_html__( 'Custom Page Title', 'amely' ),
					'id'   => $this->prefix . 'custom_page_title',
					'type' => 'text',
				),
				// custom subtitle
				array(
					'name' => esc_html__( 'Sub Title', 'amely' ),
					'id'   => $this->prefix . 'subtitle',
					'type' => 'text',
				),
			);

			$page_title_transfer_options = array(
				'page_title_on',
				'disable_parallax',
				'remove_whitespace',
				'page_title_style',
				'page_title_text_color',
				'page_subtitle_color',
				'page_title_bg_color',
				'page_title_overlay_color',
				'page_title_bg_image',
			);

			$breadcrumbs_transfer_options = array(
				'breadcrumbs',
				'breadcrumbs_position',
			);

			// Footer
			$footer_fields[] = array(
				'name'    => esc_html__( 'Footer Visibility', 'amely' ),
				'id'      => $this->prefix . 'disable_footer',
				'type'    => 'select',
				'desc'    => esc_html__( 'Enable or disable footer on this page.', 'amely' ),
				'options' => array(
					''   => esc_html__( 'Enable', 'amely' ),
					'on' => esc_html__( 'Disable', 'amely' ),
				),
				'default' => '',
			);

			$footer_transfer_options = array(
				'footer_layout',
				'footer_width',
				'footer_color_scheme',
				'footer_bgcolor',
				'footer_color',
				'footer_accent_color',
				'footer_copyright_bgcolor',
				'footer_copyright_color',
				'footer_copyright_link_color',
				'footer_copyright',
			);

			foreach ( $header_transfer_options as $option ) {
				$header_fields[] = $this->redux2metabox( $option );
			}

			foreach ( $offcanvas_transfer_options as $option ) {
				$offcanvas_fields[] = $this->redux2metabox( $option );
			}

			$menu_fields[] = array(
				'name' => esc_html__( 'Disable Menu', 'amely' ),
				'desc' => esc_html__( 'Disable Menu on this page', 'amely' ),
				'id'   => $this->prefix . 'disable_site_menu',
				'type' => 'checkbox',
			);

			foreach ( $page_title_transfer_options as $option ) {
				$page_title_fields[] = $this->redux2metabox( $option );
			}

			foreach ( $breadcrumbs_transfer_options as $option ) {
				$breadcrumbs_fields[] = $this->redux2metabox( $option );
			}

			$box_options = array(
				'id'           => $this->prefix . 'page_meta_box',
				'title'        => esc_html__( 'Page Settings (custom metabox from theme)', 'amely' ),
				'object_types' => array( 'page' ),
			);

			// tabs
			$tabs = array(
				'config' => $box_options,
				'layout' => 'vertical',
				'tabs'   => array(),
			);

			// logo
			$tabs['tabs'][] = array(
				'id'     => 'tab1',
				'title'  => esc_html__( 'Custom Logo', 'amely' ),
				'fields' => $logo_fields,
			);

			// Header
			$tabs['tabs'][] = array(
				'id'     => 'tab2',
				'title'  => esc_html__( 'Header', 'amely' ),
				'fields' => $header_fields,
			);

			// Off-Canvas Sidebar
			$offcanvas_fields[] = array(
				'name'    => esc_html__( 'Custom off-canvas sidebar', 'amely' ),
				'id'      => $this->prefix . 'offcanvas_custom_sidebar',
				'type'    => 'select',
				'options' => Amely_Helper::get_registered_sidebars( true ),
				'default' => 'sidebar-offcanvas',
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab3',
				'title'  => esc_html__( 'Off-Canvas Sidebar', 'amely' ),
				'fields' => $offcanvas_fields,
			);

			// Menu
			$tabs['tabs'][] = array(
				'id'     => 'tab4',
				'title'  => esc_html__( 'Menu', 'amely' ),
				'fields' => $menu_fields,
			);

			// Page title
			$tabs['tabs'][] = array(
				'id'     => 'tab5',
				'title'  => esc_html__( 'Page Title', 'amely' ),
				'fields' => $page_title_fields,
			);

			// Breadcrumb
			$tabs['tabs'][] = array(
				'id'     => 'tab6',
				'title'  => esc_html__( 'Breadcrumbs', 'amely' ),
				'fields' => $breadcrumbs_fields,
			);

			// Sidebar
			$tabs['tabs'][] = array(
				'id'     => 'tab7',
				'title'  => esc_html__( 'Page Sidebar Options', 'amely' ),
				'fields' => array(
					$page_sidebar_config,

					// Custom sidebar.
					array(
						'name'     => esc_html__( 'Custom sidebar for this page', 'amely' ),
						'id'       => $this->prefix . 'page_custom_sidebar',
						'type'     => 'select',
						'options'  => Amely_Helper::get_registered_sidebars(),
						'multiple' => false,
						'default'  => 'sidebar',
					),
				),
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab8',
				'title'  => esc_html__( 'Footer', 'amely' ),
				'fields' => $footer_fields,
			);

			// Page Meta
			$tabs['tabs'][] = array(
				'id'     => 'tab9',
				'title'  => esc_html__( 'Page Meta', 'amely' ),
				'fields' => array(
					// Extra Page Class.
					array(
						'name' => esc_html__( 'Page extra class name', 'amely' ),
						'id'   => $this->prefix . 'page_extra_class',
						'type' => 'text',
						'desc' => esc_html__( 'If you wish to add extra classes to the body class of the page (for custom css use), then please add the class(es) here.',
							'amely' ),
					),
				),
			);

			$cmb = new_cmb2_box( $box_options );

			$cmb->add_field( array(
				'id'   => $this->prefix . 'page_tabs',
				'type' => 'tabs',
				'tabs' => $tabs,
			) );

			$this->transfer_options = array_merge( $this->transfer_options,
				$header_transfer_options,
				$offcanvas_transfer_options,
				$menu_transfer_options,
				$page_title_transfer_options,
				$breadcrumbs_transfer_options,
				$footer_transfer_options,
				array(
					'page_sidebar_config',
				) );
		}

		/**
		 * Meta boxes for posts
		 */
		public function post_meta_boxes() {

			$breadcrumbs_fields = array();

			$post_sidebar_config = $this->redux2metabox( 'post_sidebar_config' );

			$post_fields = array(
				// Show the post title on top
				array(
					'name'        => esc_html__( 'Display the Post title on top', 'amely' ),
					'id'          => $this->prefix . 'post_title_on_top',
					'type'        => 'checkbox',
					'description' => esc_html__( 'Enabling this option will display the title of this post on top',
						'amely' ),
				),
				// custom page title
				array(
					'name' => esc_html__( 'Custom Page Title', 'amely' ),
					'id'   => $this->prefix . 'custom_page_title',
					'type' => 'text',
				),
				// custom subtitle
				array(
					'name' => esc_html__( 'Sub Title', 'amely' ),
					'id'   => $this->prefix . 'subtitle',
					'type' => 'text',
				),
			);

			$post_transfer_options = array(
				'page_title_on',
				'disable_parallax',
				'remove_whitespace',
				'page_title_style',
				'page_title_text_color',
				'page_subtitle_color',
				'page_title_bg_color',
				'page_title_overlay_color',
				'page_title_bg_image',
			);

			$breadcrumbs_transfer_options = array(
				'breadcrumbs',
				'breadcrumbs_position',
			);

			foreach ( $post_transfer_options as $option ) {
				$post_fields[] = $this->redux2metabox( $option );
			}

			foreach ( $breadcrumbs_transfer_options as $option ) {
				$breadcrumbs_fields[] = $this->redux2metabox( $option );
			}

			$box_options = array(
				'id'           => $this->prefix . 'post_meta_box',
				'title'        => esc_html__( 'Post Settings (custom metabox from theme)', 'amely' ),
				'object_types' => array( 'post' ),
			);

			// tabs
			$tabs = array(
				'config' => $box_options,
				'layout' => 'vertical',
				'tabs'   => array(),
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab1',
				'title'  => esc_html__( 'Page Title', 'amely' ),
				'fields' => $post_fields,
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab2',
				'title'  => esc_html__( 'Breadcrumbs', 'amely' ),
				'fields' => $breadcrumbs_fields,
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab3',
				'title'  => esc_html__( 'Sidebar Options', 'amely' ),
				'fields' => array(
					$post_sidebar_config,

					// Custom sidebar.
					array(
						'name'     => esc_html__( 'Custom sidebar for this post', 'amely' ),
						'id'       => $this->prefix . 'post_custom_sidebar',
						'type'     => 'select',
						'options'  => Amely_Helper::get_registered_sidebars(),
						'multiple' => false,
						'default'  => 'sidebar',
					),
				),
			);

			$cmb = new_cmb2_box( $box_options );

			$cmb->add_field( array(
				'id'   => $this->prefix . 'post_tabs',
				'type' => 'tabs',
				'tabs' => $tabs,
			) );

			$this->transfer_options = array_merge( $this->transfer_options,
				$post_transfer_options,
				$breadcrumbs_transfer_options,
				array(
					'post_sidebar_config',
				) );
		}

		/**
		 * Meta boxes for Testimonials
		 *
		 * @return array
		 */
		public function testimonial_meta_boxes() {

			new_cmb2_box( array(
				'id'           => $this->prefix . 'testimonial_meta_box',
				'title'        => esc_html__( 'Testimonial Settings (custom metabox from theme)', 'amely' ),
				'object_types' => array( 'testimonials' ),
				'fields'       => array(
					array(
						'name' => esc_html__( 'Testimonial Cite', 'amely' ),
						'id'   => $this->prefix . 'testimonial_cite',
						'desc' => esc_html__( 'Enter the cite name for the testimonial.', 'amely' ),
						'type' => 'text',
					),

					array(
						'name' => esc_html__( 'Testimonial Cite Subtext', 'amely' ),
						'id'   => $this->prefix . 'testimonial_cite_subtext',
						'desc' => esc_html__( 'Enter the cite subtext for the testimonial (optional).', 'amely' ),
						'type' => 'text',
					),

					array(
						'name' => esc_html__( 'Testimonial Cite Image', 'amely' ),
						'desc' => esc_html__( 'Enter the cite image for the testimonial (optional).', 'amely' ),
						'id'   => $this->prefix . 'testimonial_cite_image',
						'type' => 'file',
					),
				),
			) );

		}

		/**
		 * Meta boxes for product
		 */
		public function product_meta_boxes() {

			$product_sidebar_config = $this->redux2metabox( 'product_sidebar_config' );

			$product_title_fields = array(
				// Show the post title on top
				array(
					'name'        => esc_html__( 'Display the Product title on top', 'amely' ),
					'id'          => $this->prefix . 'product_title_on_top',
					'type'        => 'checkbox',
					'description' => esc_html__( 'Enabling this option will display the title of this product on top',
						'amely' ),
				),
				// custom page title
				array(
					'name' => esc_html__( 'Custom Page Title', 'amely' ),
					'id'   => $this->prefix . 'custom_page_title',
					'type' => 'text',
				),
			);

			$product_fields = array(

				// Hide Related Products.
				array(
					'name'    => esc_html__( 'Hide Related Products', 'amely' ),
					'id'      => $this->prefix . 'hide_related_products',
					'type'    => 'checkbox',
					'desc'    => esc_html__( 'Check to hide related products on this page', 'amely' ),
					'default' => false,
				),

				// Instagram hash tag.
				array(
					'name' => esc_html__( 'Instagram Hashtag', 'amely' ),
					'id'   => $this->prefix . 'product_hashtag',
					'type' => 'text',
					'desc' => esc_html__( 'Enter hashtag will be used to display images from Instagram. (For example: <strong>#women</strong>)',
						'amely' ),
				),
			);

			$product_transfer_options = array(
				'show_featured_images',
				'product_thumbnails_position',
				'product_page_layout',
				'product_bgcolor',
			);

			$product_title_transfer_options = array(
				'page_title_on',
				'disable_parallax',
				'remove_whitespace',
				'page_title_style',
				'page_title_text_color',
				'page_subtitle_color',
				'page_title_bg_color',
				'page_title_overlay_color',
				'page_title_bg_image',
			);

			$breadcrumbs_transfer_options = array(
				'breadcrumbs',
				'breadcrumbs_position',
			);

			foreach ( $product_transfer_options as $option ) {
				$product_fields[] = $this->redux2metabox( $option, '', true );
			}

			foreach ( $product_title_transfer_options as $option ) {
				$product_title_fields[] = $this->redux2metabox( $option );
			}

			foreach ( $breadcrumbs_transfer_options as $option ) {
				$breadcrumbs_fields[] = $this->redux2metabox( $option );
			}

			$box_options = array(
				'id'           => $this->prefix . 'product_meta_box',
				'title'        => esc_html__( 'Product Settings (custom metabox from theme)', 'amely' ),
				'object_types' => array( 'product' ),
			);

			// tabs
			$tabs = array(
				'config' => $box_options,
				'layout' => 'vertical',
				'tabs'   => array(),
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab1',
				'title'  => esc_html__( 'General', 'amely' ),
				'fields' => $product_fields,
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab2',
				'title'  => esc_html__( 'Page Title', 'amely' ),
				'fields' => $product_title_fields,
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab3',
				'title'  => esc_html__( 'Breadcrumbs', 'amely' ),
				'fields' => $breadcrumbs_fields,
			);

			$tabs['tabs'][] = array(
				'id'     => 'tab4',
				'title'  => esc_html__( 'Sidebar Options', 'amely' ),
				'fields' => array(
					$product_sidebar_config,

					// Custom sidebar.
					array(
						'name'     => esc_html__( 'Custom sidebar for this product', 'amely' ),
						'id'       => $this->prefix . 'product_custom_sidebar',
						'type'     => 'select',
						'options'  => Amely_Helper::get_registered_sidebars(),
						'multiple' => false,
						'default'  => 'sidebar-shop',
					),
				),
			);

			$cmb = new_cmb2_box( $box_options );

			$cmb->add_field( array(
				'id'   => $this->prefix . 'product_tabs',
				'type' => 'tabs',
				'tabs' => $tabs,
			) );

			$this->transfer_options = array_merge( $this->transfer_options,
				$product_transfer_options,
				$product_title_transfer_options,
				$breadcrumbs_transfer_options,
				array(
					'product_sidebar_config',
				) );

		}

		/**
		 * Meta boxes for post category
		 */
		public function post_category_meta_boxes() {

			$archive_fields = array();

			$archive_transfer_options = array(
				'archive_display_type',
				'page_title_on',
				'disable_parallax',
				'remove_whitespace',
				'page_title_style',
				'page_title_text_color',
				'page_title_bg_color',
				'page_title_overlay_color',
				'page_title_bg_image',
			);

			foreach ( $archive_transfer_options as $option ) {
				$archive_fields[] = $this->redux2metabox( $option );
			}

			new_cmb2_box( array(
				'id'           => $this->prefix . 'post_categories_meta_box',
				'title'        => esc_html__( 'Category Meta Box', 'amely' ),
				'object_types' => array( 'term' ),
				'taxonomies'   => array( 'category' ),
				'fields'       => $archive_fields,
			) );

			$this->transfer_options = array_merge( $this->transfer_options,
				$archive_transfer_options );
		}

		/**
		 * Meta box for product category
		 */
		public function product_category_meta_boxes() {

			$archive_fields = array(
				array(
					'name' => esc_html__( 'Thumbnail for Masonry layout', 'amely' ),
					'desc' => esc_html__( 'Use for \'Product Categories\' shortcode (WPBakery Page Builder)', 'amely' ),
					'id'   => $this->prefix . 'product_cat_thumbnail_masonry',
					'type' => 'file',
				),
			);

			$archive_transfer_options = array(
				'page_title_on',
				'disable_parallax',
				'remove_whitespace',
				'page_title_style',
				'page_title_text_color',
				'page_title_bg_color',
				'page_title_overlay_color',
				'page_title_bg_image',
			);

			foreach ( $archive_transfer_options as $option ) {
				$archive_fields[] = $this->redux2metabox( $option );
			}

			new_cmb2_box( array(
				'id'           => $this->prefix . 'product_categories_meta_box',
				'title'        => esc_html__( 'Product Category Meta Box', 'amely' ),
				'object_types' => array( 'term' ),
				'taxonomies'   => array( 'product_cat' ),
				'fields'       => $archive_fields,
			) );

			$this->transfer_options = array_merge( $this->transfer_options,
				$archive_transfer_options );

		}

		/**
		 * Convert function from redux to CMB2
		 *
		 * @param string $field field slug in Redux options
		 * @param string $type field type
		 * @param string $default default value
		 * @param array $unset unset options
		 *
		 * @return array  $cmb_field  CMB compatible field config array
		 */
		private function redux2metabox( $field, $type = '', $default = '', $unset = array() ) {

			if ( ! class_exists( 'Redux' ) ) {

				return array(
					'id'      => '',
					'type'    => '',
					'name'    => '',
					'desc'    => '',
					'options' => '',
					'std'     => 'default',
					'default' => 'default',
				);
			}

			$field = Redux::getField( Amely_Redux::$opt_name, $field );

			$options = $settings = array();

			switch ( $field['type'] ) {

				case 'image_select':

					$type    = $type ? $type : 'select';
					$default = $default ? $default : 'default';

					$options = ( ! empty( $field['options'] ) ) ? array_merge( array(
						'default' => array(
							'title' => esc_html__( 'Default',
								'amely' ),
						),
					),
						$field['options'] ) : array();
					foreach ( $options as $key => $option ) {
						$options[ $key ] = ( isset( $options[ $key ]['alt'] ) ) ? $options[ $key ]['alt'] : $options[ $key ]['title'];

						foreach ( $unset as $u ) {
							unset( $options[ $u ] );
						}
					}

					break;

				case 'button_set':

					$type    = $type ? $type : 'select';
					$default = $default ? $default : 'default';

					$options['default'] = esc_html__( 'Default', 'amely' );
					foreach ( $field['options'] as $key => $value ) {
						$options[ $key ] = $value;

						foreach ( $unset as $u ) {
							unset( $options[ $u ] );
						}
					}

					break;

				case 'select':

					$type    = $type ? $type : 'select';
					$default = $default ? $default : 'default';

					$options['default'] = esc_html__( 'Default', 'amely' );

					foreach ( $field['options'] as $key => $value ) {
						$options[ $key ] = $value;

						foreach ( $unset as $u ) {
							unset( $options[ $u ] );
						}
					}

					break;

				case 'switch':

					$type    = $type ? $type : 'select';
					$default = $default ? $default : 'default';

					$options['default'] = esc_html__( 'Default', 'amely' );
					$options['on']      = esc_html__( 'On', 'amely' );
					$options['off']     = esc_html__( 'Off', 'amely' );

					break;

				case 'slider':

					$type = 'slider';

					$settings = array(
						'min'  => isset( $field['min'] ) ? $field['min'] : 0,
						'max'  => isset( $field['max'] ) ? $field['max'] : 100,
						'step' => isset( $field['step'] ) ? $field['step'] : 1,
					);

					$default = amely_get_option( $field['id'] );

					break;

				case 'color':

					$type = 'colorpicker';

					if ( amely_get_option( $field['id'] ) == 'transparent' ) {
						$default = '';
					} else {
						$default = amely_get_option( $field['id'] );
					}

					break;

				case 'link_color':

					$type = 'colorpicker';

					if ( amely_get_option( $field['id'] ) == 'transparent' ) {
						$default = '';
					} else {
						$default = amely_get_option( $field['id'] );

						if ( is_array( $default ) && isset( $default['regular'] ) ) {
							$default = $default['regular'];
						} else {
							$default = '';
						}
					}

					break;

				case 'color_rgba':

					$type = 'rgba_colorpicker';
					$val  = amely_get_option( $field['id'] );

					if ( isset( $val['color'] ) && $val['color'] ) {
						$default = Amely_Helper::hex2rgba( $val['color'],
							( isset( $val['alpha'] ) && $val['alpha'] ) ? $val['alpha'] : 0 );
					}

					break;

				case 'media':


					$type = 'file';
					$val  = amely_get_option( $field['id'] );

					if ( isset( $val['url'] ) && $val['url'] ) {
						$default = $val['url'];
					}

					break;

				case 'background':

					$type = 'file';

					if ( isset( $field['default']['background-image'] ) && $field['default']['background-image'] ) {
						$default = $field['default']['background-image'];
					}

					break;

				default:
					$type    = $type ? $type : $field['type'];
					$default = $default ? $default : amely_get_option( $field['id'] );

					break;
			}

			$mb_field = array_merge( array(
				'id'      => $this->prefix . $field['id'],
				'type'    => $type,
				'name'    => $field['title'],
				'desc'    => isset( $field['subtitle'] ) ? $field['subtitle'] : '',
				'options' => $options,
				'default' => $default,
			),
				$settings );

			return $mb_field;
		}

		/**
		 * Modify global $amely_options variables
		 */
		public function modify_global_settings() {

			global $amely_options;

			if ( ! empty( $this->transfer_options ) ) {
				foreach ( $this->transfer_options as $field ) {
					$meta = get_post_meta( Amely_Helper::get_the_ID(), $this->prefix . $field, true );

					if ( isset( $meta ) && $meta != '' && $meta != 'inherit' && $meta != 'default' ) {

						if ( $meta == 'on' ) {
							$meta = true;
						} elseif ( $meta == 'off' ) {
							$meta = false;
						}

					} else {
						if ( isset( $amely_options[ $field ] ) ) {
							$meta = $amely_options[ $field ];
						}
					}

					$amely_options[ $field ] = $meta;
				}
			}
		}

	}

	new Amely_Metabox();
}
