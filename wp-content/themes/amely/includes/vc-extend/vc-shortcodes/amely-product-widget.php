<?php

/**
 * Amely Product Widget Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Product_Widget extends WPBakeryShortCode {

	public function get_query( $atts ) {
		return Amely_Woo::get_products_by_datasource( $atts['data_source'], $atts );
	}

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;
		$css   = '';

		if ( isset( $atts['img_size'] ) ) {

			if ( empty( $atts['img_size'] ) ) {
				$atts['img_size'] = 'woocommerce_thumbnail';
			}

			$size  = Amely_Helper::convert_image_size( $atts['img_size'] );
			$width = '';

			if ( is_array( $size ) ) {
				$width = $size[0];
			} elseif ( is_string( $size ) && $w = Amely_Helper::get_image_width( $size ) ) {
				$width = $w;
			}

			if ( $width ) {
				$css .= $cssID . ' .product_list_widget .product-thumb{width:' . $width . 'px}';
			}
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}

}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Product Widget', 'amely' ),
	'base'        => 'amely_product_widget',
	'icon'        => 'amely-element-icon-product-widget',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Add products in a widget', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'amely' ),
			'param_name'  => 'title',
			'admin_label' => true,
		),
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
				esc_html__( 'Top Rated Products', 'amely' )    => 'top_rated_products',
				esc_html__( 'Product Attribute', 'amely' )     => 'product_attribute',
				esc_html__( 'List of Products', 'amely' )      => 'products',
				esc_html__( 'Category', 'amely' )              => 'category',
			),
			'description' => esc_html__( 'Select data source for your product widget', 'amely' ),
		),
		Amely_VC::get_param( 'product_cat_dropdown', '', array(
			'element' => 'data_source',
			'value'   => array( 'category' ),
		) ),
		Amely_VC::get_param( 'product_autocomplete', '', array(
			'element' => 'data_source',
			'value'   => array( 'products' ),
		) ),
		Amely_VC::get_param( 'product_attribute', '', array(
			'element' => 'data_source',
			'value'   => array( 'product_attribute' ),
		) ),
		Amely_VC::get_param( 'product_term', '', array(
			'element' => 'data_source',
			'value'   => array( 'product_attribute' ),
		) ),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'include_children',
			'description' => esc_html__( 'Whether or not to include children categories', 'amely' ),
			'value'       => array( esc_html__( 'Include children', 'amely' ) => 'yes' ),
			'std'         => 'yes',
			'dependency'  => array( 'element' => 'data_source', 'value' => array( 'category' ) ),
		),
		array(
			'type'        => 'number',
			'param_name'  => 'number',
			'heading'     => esc_html__( 'Number', 'amely' ),
			'description' => esc_html__( 'Number of products in the widget (-1 is all, limited to 1000)', 'amely' ),
			'value'       => 4,
			'max'         => 1000,
			'min'         => - 1,
		),
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
			'type'       => 'checkbox',
			'param_name' => 'enable_carousel',
			'value'      => array( esc_html__( 'Enable Carousel', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'number',
			'param_name' => 'number_per_slide',
			'heading'    => esc_html__( 'Number of products per slide', 'amely' ),
			'value'      => 2,
			'max'        => 1000,
			'min'        => 1,
			'dependency' => array(
				'element' => 'enable_carousel',
				'value'   => array( 'yes' ),
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array(
				'element' => 'enable_carousel',
				'value'   => array( 'yes' ),
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autoplay', 'amely' ) => 'yes' ),
			'dependency' => array(
				'element' => 'enable_carousel',
				'value'   => array( 'yes' ),
			),
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
			'dependency' => array(
				'element' => 'enable_carousel',
				'value'   => array( 'yes' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'arrows_position',
			'heading'    => esc_html__( 'Arrows Position', 'amely' ),
			'value'      => array(
				esc_html__( 'In the title', 'amely' )   => 'title',
				esc_html__( 'Left and Right', 'amely' ) => 'left-right',
				esc_html__( 'Bottom', 'amely' )         => 'bottom',
			),
			'dependency' => array(
				'element' => 'nav_type',
				'value'   => array( 'arrows', 'both' ),
			),
		),
		array(
			'type'        => 'checkbox',
			'param_name'  => 'enable_buttons',
			'value'       => array( esc_html__( 'Show Buttons?', 'amely' ) => 'yes' ),
			'description' => esc_html__( 'Show Add to cart, Wishlist & Quick view buttons', 'amely' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image size', 'amely' ),
			'param_name'  => 'img_size',
			'value'       => 'shop_thumbnail',
			'description' => esc_html__( 'Enter image size . Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme . Alternatively enter image size in pixels: 200x100( Width x Height). Leave empty to use "shop_thumbnail" size . ', 'amely' ),
		),
		Amely_VC::get_param( 'el_class' ),
		// Data settings.
		Amely_VC::get_param( 'order_product', esc_html__( 'Data Settings', 'amely' ), array(
			'element'            => 'data_source',
			'value_not_equal_to' => array(
				'recent_products',
				'best_selling_products',
				'top_rated_products',
			),
		) ),
		Amely_VC::get_param( 'order_way', esc_html__( 'Data Settings', 'amely' ), array(
			'element'            => 'data_source',
			'value_not_equal_to' => array(
				'recent_products',
				'best_selling_products',
				'top_rated_products',
			),
		) ),
		Amely_VC::get_param( 'css' )
	),
) );


//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_amely_product_widget_product_ids_callback', array(
	'Amely_VC',
	'product_id_callback',
), 10, 1 );

add_filter( 'vc_autocomplete_amely_product_widget_product_ids_render', array(
	'Amely_VC',
	'product_id_render',
), 10, 1 );

add_filter( 'vc_autocomplete_amely_product_widget_exclude_callback', array(
	'Amely_VC',
	'product_id_callback',
), 10, 1 );

add_filter( 'vc_autocomplete_amely_product_widget_exclude_render', array(
	'Amely_VC',
	'product_id_render',
), 10, 0 );

//For param: "filter" param value
//vc_form_fields_render_field_{shortcode_name}_{param_name}_param
add_filter( 'vc_form_fields_render_field_amely_product_widget_filter_param', array(
	'Amely_VC',
	'product_attribute_filter_param_value',
), 10, 4 ); // Defines default value for param if not provided. Takes from other param value.

