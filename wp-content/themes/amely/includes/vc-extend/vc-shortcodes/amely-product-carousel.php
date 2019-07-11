<?php

/**
 * Amely Product Carousel Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Product_Carousel extends WPBakeryShortCode {

	public function __construct( $settings ) {
		parent::__construct( $settings );
		add_filter( 'amely_shop_products_columns', array( $this, 'product_columns' ) );
		add_filter( 'amely_product_loop_thumbnail_size', array( $this, 'image_size' ) );
	}

	public function product_columns() {
		$atts = $this->getAtts();

		return array(
			'xs' => 1,
			'sm' => 2,
			'md' => 3,
			'lg' => 4,
			'xl' => $atts['columns'],
		);
	}

	public function image_size() {

		$atts = $this->getAtts();

		if ( empty( $atts['img_size'] ) ) {
			$atts['img_size'] = 'woocommerce_thumbnail';
		}

		return isset( $atts['img_size'] ) ? Amely_Helper::convert_image_size( $atts['img_size'] ) : 'shop_catalog';
	}

	public function get_query( $atts ) {

		return Amely_Woo::get_products_by_datasource( $atts['data_source'], $atts );

	}
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Product Carousel', 'amely' ),
	'base'        => 'amely_product_carousel',
	'icon'        => 'amely-element-icon-product-carousel',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Add products in a carousel', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'dropdown',
			'param_name'  => 'data_source',
			'admin_label' => true,
			'heading'     => esc_html__( 'Data source', 'amely' ),
			'value'       => array(
				esc_html__( 'Recent Products', 'amely' )       => 'recent_products',
				esc_html__( 'Featured Products', 'amely' )     => 'featured_products',
				esc_html__( 'On Sale Products', 'amely' )      => 'sale_products',
				esc_html__( 'Best-Selling Products', 'amely' ) => 'best_selling_products',
				esc_html__( 'Related Products', 'amely' )      => 'related_products',
				esc_html__( 'Top Rated Products', 'amely' )    => 'top_rated_products',
				esc_html__( 'Product Attribute', 'amely' )     => 'product_attribute',
				esc_html__( 'List of Products', 'amely' )      => 'products',
				esc_html__( 'Categories', 'amely' )            => 'categories',
			),
			'description' => esc_html__( 'Select data source for your product carousel', 'amely' ),
		),
		Amely_VC::get_param( 'product_cat_autocomplete',
			'',
			array(
				'element' => 'data_source',
				'value'   => array( 'categories' ),
			) ),
		Amely_VC::get_param( 'product_autocomplete',
			'',
			array(
				'element' => 'data_source',
				'value'   => array( 'products' ),
			) ),
		Amely_VC::get_param( 'product_attribute',
			'',
			array(
				'element' => 'data_source',
				'value'   => array( 'product_attribute' ),
			) ),
		Amely_VC::get_param( 'product_term',
			'',
			array(
				'element' => 'data_source',
				'value'   => array( 'product_attribute' ),
			) ),
		array(
			'type'        => 'number',
			'param_name'  => 'number',
			'heading'     => esc_html__( 'Number', 'amely' ),
			'description' => esc_html__( 'Number of products in the carousel (-1 is all, limited to 1000)',
				'amely' ),
			'value'       => 12,
			'max'         => 1000,
			'min'         => - 1,
		),
		Amely_VC::get_param( 'columns' ),
		array(
			'type'       => 'autocomplete',
			'heading'    => esc_html__( 'Exclude products', 'amely' ),
			'param_name' => 'exclude',
			'settings'   => array(
				'multiple' => true,
				'sortable' => true,
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'include_children',
			'description' => esc_html__( 'Whether or not to include children categories', 'amely' ),
			'value'       => array( esc_html__( 'Include children', 'amely' ) => 'yes' ),
			'std'         => 'yes',
			'dependency'  => array( 'element' => 'data_source', 'value' => array( 'categories' ) ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image size', 'amely' ),
			'param_name'  => 'img_size',
			'value'       => 'woocommerce_thumbnail',
			'description' => esc_html__( 'Enter image size . Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme . Alternatively enter image size in pixels: 200x100( Width x Height). Leave empty to use "woocommerce_thumbnail" size . ',
				'amely' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autoplay', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'number',
			'param_name' => 'auto_play_speed',
			'heading'    => esc_html__( 'Auto play speed', 'amely' ),
			'value'      => 5,
			'max'        => 10,
			'min'        => 3,
			'step'       => 0.5,
			'suffix'     => 'seconds',
			'dependency' => array(
				'element' => 'auto_play',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'nav_type',
			'heading'    => esc_html__( 'Navigation type', 'amely' ),
			'value'      => array(
				esc_html__( 'Arrows', 'amely' ) => 'arrows',
				esc_html__( 'Dots', 'amely' )   => 'dots',
				__( 'Arrows & Dots', 'amely' )  => 'both',
				esc_html__( 'None', 'amely' )   => '',
			),
		),
		Amely_VC::get_param( 'el_class' ),
		// Data settings.
		Amely_VC::get_param( 'order_product',
			esc_html__( 'Data Settings', 'amely' ),
			array(
				'element'            => 'data_source',
				'value_not_equal_to' => array(
					'recent_products',
					'best_selling_products',
					'top_rated_products',
				),
			) ),
		Amely_VC::get_param( 'order_way',
			esc_html__( 'Data Settings', 'amely' ),
			array(
				'element'            => 'data_source',
				'value_not_equal_to' => array(
					'recent_products',
					'best_selling_products',
					'top_rated_products',
				),
			) ),
		Amely_VC::get_param( 'css' ),
	),
) );


//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_amely_product_carousel_product_ids_callback',
	array(
		'Amely_VC',
		'product_id_callback',
	),
	10,
	1 );

add_filter( 'vc_autocomplete_amely_product_carousel_product_ids_render',
	array(
		'Amely_VC',
		'product_id_render',
	),
	10,
	1 );

add_filter( 'vc_autocomplete_amely_product_carousel_exclude_callback',
	array(
		'Amely_VC',
		'product_id_callback',
	),
	10,
	1 );

add_filter( 'vc_autocomplete_amely_product_carousel_exclude_render',
	array(
		'Amely_VC',
		'product_id_render',
	),
	10,
	1 );

//For param: "filter" param value
//vc_form_fields_render_field_{shortcode_name}_{param_name}_param
add_filter( 'vc_form_fields_render_field_amely_product_carousel_filter_param',
	array(
		'Amely_VC',
		'product_attribute_filter_param_value',
	),
	10,
	4 ); // Defines default value for param if not provided. Takes from other param value.
