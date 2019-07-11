<?php

/*
 * Amely Brands Grid
 *
 * @version 1.0
 * @package Amely
 */

class WPBakeryShortCode_Amely_Brands_Grid extends WPBakeryShortCode {
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Brands Image Grid', 'amely' ),
	'base'        => 'amely_brands_grid',
	'icon'        => 'amely-element-icon-brand-image-grid',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Show brands in a grid.', 'amely' ),
	'params'      => array(
		array(
			'type'       => 'chosen',
			'heading'    => esc_html__( 'Select Brand', 'amely' ),
			'param_name' => 'brand_slugs',
			'options'    => array(
				'type'  => 'taxonomy',
				'get'   => 'product_brand',
				'field' => 'slug',
			)
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'hide_empty',
			'std'        => 'yes',
			'value'      => array( esc_html__( 'Hide empty brands', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'display_featured',
			'value'      => array( esc_html__( 'Display only feature brands', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_title',
			'value'      => array( esc_html__( 'Show brand\'s title', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'new_tab',
			'value'      => array( esc_html__( 'Open link in a new tab', 'amely' ) => 'yes' ),
		),
		Amely_VC::get_param( 'columns' ),
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	)
) );
