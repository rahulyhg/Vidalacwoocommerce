<?php

/**
 * Amely Product Tabs Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Product_Tabs extends WPBakeryShortCode {

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

		return isset( $atts['img_size'] ) ? Amely_Helper::convert_image_size( $atts['img_size'] ) : 'woocommerce_thumbnail';
	}

	public function make_tab( $index, $tab ) {

		$atts = $this->getAtts();

		switch ( $tab ) {
			case 'featured_products':
				$filter = ( isset( $atts['filter_type'] ) && $atts['filter_type'] == 'ajax' ) ? 'featured_products' : '.featured';
				$name   = esc_html__( 'Trendy Items', 'amely' );
				break;
			case 'sale_products':
				$filter = ( isset( $atts['filter_type'] ) && $atts['filter_type'] == 'ajax' ) ? 'sale_products' : '.sale';
				$name   = esc_html__( 'Items Sale', 'amely' );
				break;
			case 'best_selling_products':
				$filter = 'best_selling_products';
				$name   = esc_html__( 'Best Sellings', 'amely' );
				break;
			case 'top_rated_products':
				$filter = 'top_rated_products';
				$name   = esc_html__( 'Top Rated', 'amely' );
				break;
			case 'recent_products':
			default:
				$filter = ( isset( $atts['filter_type'] ) && $atts['filter_type'] == 'ajax' ) ? 'recent_products' : '.product';
				$name   = esc_html__( 'New Arrivals', 'amely' );
				break;
		}

		return sprintf( '<li><a class="%s" href="#" data-filter="%s">%s</a></li>',
			( isset( $atts['filter_type'] ) && $atts['filter_type'] == 'ajax' && ! $index ) ? 'active' : '',
			$filter,
			$name );
	}
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Product Tabs', 'amely' ),
	'base'        => 'amely_product_tabs',
	'icon'        => 'amely-element-icon-product-tabs',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Product grid grouped by tabs', 'amely' ),
	'params'      => array(

		array(
			'heading'     => esc_html__( 'Tabs', 'amely' ),
			'description' => esc_html__( 'Select how to group products in tabs', 'amely' ),
			'param_name'  => 'filter',
			'type'        => 'dropdown',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Group by category', 'amely' ) => 'category',
				esc_html__( 'Group by feature', 'amely' )  => 'group',
			),
		),

		array(
			'heading'     => esc_html__( 'Tabs Effect', 'amely' ),
			'description' => esc_html__( 'Select the way tabs load products', 'amely' ),
			'param_name'  => 'filter_type',
			'type'        => 'dropdown',
			'value'       => array(
				esc_html__( 'Filter', 'amely' )    => 'filter',
				esc_html__( 'Ajax Load', 'amely' ) => 'ajax',
			),
		),

		array(
			'heading'    => esc_html__( 'Tabs Alignment', 'amely' ),
			'param_name' => 'align',
			'type'       => 'dropdown',
			'value'      => array(
				esc_html__( 'Left', 'amely' )   => 'left',
				esc_html__( 'Center', 'amely' ) => 'center',
				esc_html__( 'Right', 'amely' )  => 'right',
			),
		),

		Amely_VC::get_param( 'product_cat_autocomplete',
			'',
			array(
				'element' => 'filter',
				'value'   => array( 'category' ),
			) ),

		array(
			'type'        => 'chosen',
			'heading'     => esc_html__( 'Tab', 'amely' ),
			'description' => esc_html__( 'Select which tabs you want to show', 'amely' ),
			'param_name'  => 'tabs',
			'options'     => array(
				'multiple' => true,
				'values'   => array(
					array( 'label' => esc_html__( 'Featured Products', 'amely' ), 'value' => 'featured_products' ),
					array( 'label' => esc_html__( 'New Products', 'amely' ), 'value' => 'recent_products' ),
					array( 'label' => esc_html__( 'On Sale Products', 'amely' ), 'value' => 'sale_products' ),
					array(
						'label' => esc_html__( 'Best-Selling Products (only Ajax Load)', 'amely' ),
						'value' => 'best_selling_products',
					),
					array(
						'label' => esc_html__( 'Top Rated Products (only Ajax Load)', 'amely' ),
						'value' => 'top_rated_products',
					),
				),
			),
			'dependency'  => array( 'element' => 'filter', 'value' => array( 'group' ) ),
		),

		array(
			'type'        => 'number',
			'param_name'  => 'number',
			'heading'     => esc_html__( 'Number', 'amely' ),
			'description' => esc_html__( 'Total number of products will be display in single tab (-1 is all, limited to 1000)',
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
			'dependency'  => array( 'element' => 'data_source', 'value' => array( 'category' ) ),
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
			'type'       => 'dropdown',
			'param_name' => 'pagination_type',
			'heading'    => esc_html__( 'Pagination type', 'amely' ),
			'value'      => array(
				esc_html__( 'None', 'amely' )             => '',
				esc_html__( 'Load More Button', 'amely' ) => 'more-btn',
				esc_html__( 'Infinite Scroll', 'amely' )  => 'infinite',
			),
			'dependency' => array(
				'element'            => 'data_source',
				'value_not_equal_to' => array( 'products' ),
			),
		),
		Amely_VC::get_param( 'el_class' ),
		// Data settings.
		Amely_VC::get_param( 'order_product', esc_html__( 'Data Settings', 'amely' ) ),
		Amely_VC::get_param( 'order_way', esc_html__( 'Data Settings', 'amely' ) ),
		Amely_VC::get_param( 'css' ),
	),
) );


//Filters For autocomplete param:
//For suggestion: vc_autocomplete_[shortcode_name]_[param_name]_callback
add_filter( 'vc_autocomplete_amely_product_tabs_exclude_callback',
	array(
		'Amely_VC',
		'product_id_callback',
	),
	10,
	1 );

add_filter( 'vc_autocomplete_amely_product_tabs_exclude_render',
	array(
		'Amely_VC',
		'product_id_render',
	),
	10,
	1 );
