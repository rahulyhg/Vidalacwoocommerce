<?php

/**
 * Amely Brands Carousel
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Brands_Carousel extends WPBakeryShortCode {
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Brands Image Carousel', 'amely' ),
	'base'        => 'amely_brands_carousel',
	'icon'        => 'amely-element-icon-brand-image-carousel',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Show brands in a carousel.', 'amely' ),
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
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Number of brands to show', 'amely' ),
			'param_name' => 'number',
			'std'        => 6,
			'value'      => array(
				1,
				2,
				3,
				4,
				5,
				6,
			)
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
		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable carousel loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autolay', 'amely' ) => 'yes' ),
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
		Amely_VC::get_param( 'css' ),
	)
) );
