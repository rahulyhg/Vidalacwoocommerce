<?php

/**
 * Testimonial Carousel Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Testimonial_Carousel extends WPBakeryShortCode {

}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Testimonials Carousel', 'amely' ),
	'base'        => 'amely_testimonial_carousel',
	'icon'        => 'amely-element-icon-testimonials',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Show testimonials in a carousel', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Text Size', 'amely' ),
			'param_name'  => 'text_size',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Large', 'amely' )    => 'large',
				esc_html__( 'Standard', 'amely' ) => 'standard',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Text Color', 'amely' ),
			'param_name'  => 'text_color',
			'value'       => array(
				__( 'Dark', 'amely' )  => 'dark',
				__( 'Light', 'amely' ) => 'light',
			),
			'description' => esc_html__( 'Choose the text color of the testimonials.', 'amely' ),
		),

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'amely' ),
			'param_name'  => 'style_testimonial',
			'description' => esc_html__( 'Choose the style of testimonial ', 'amely' ),
			'value'       => array(
				__( 'Image above and align center', 'amely' ) => 1,
				__( 'Image above and align left', 'amely' )   => 2,
				__( 'Image below', 'amely' )                  => 3,
			),

		),

		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Number of items', 'amely' ),
			'param_name'  => 'item_count',
			'description' => esc_html__( 'The number of testimonials to show. Enter -1 to show ALL testimonials (limited to 1000)',
				'amely' ),
			'value'       => - 1,
			'max'         => 1000,
			'min'         => - 1,
			'step'        => 1,
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Number of items to show', 'amely' ),
			'param_name'  => 'items_to_show',
			'description' => esc_html__( 'The number items testimonials to show on page. Enter -1 to show ALL testimonials (limited to 1000)',
				'amely' ),
			'value'       => array(
				__( '1 testimonial', 'amely' )  => 1,
				__( '2 testimonials', 'amely' ) => 2,
				__( '3 testimonials', 'amely' ) => 3,
				__( '4 testimonials', 'amely' ) => 4,
			),

		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Testimonials Order', 'amely' ),
			'param_name'  => 'order',
			'value'       => array(
				__( 'Random', 'amely' ) => 'rand',
				__( 'Latest', 'amely' ) => 'date',
			),
			'description' => esc_html__( 'Choose the order of the testimonials.', 'amely' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Testimonials category', 'amely' ),
			'param_name'  => 'category',
			'value'       => Amely_Helper::get_category_list( 'testimonials-category' ),
			'description' => esc_html__( 'Choose the category for the testimonials.', 'amely' ),
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
	),
) );
