<?php

/**
 * Amely Instagram shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Instagram extends WPBakeryShortCode {

}

// Mapping shortcode
vc_map( array(
	'name'        => esc_html__( 'Instagram', 'amely' ),
	'base'        => 'amely_instagram',
	'icon'        => 'amely-element-icon-instagram',
	'category'    => sprintf( esc_html__( 'by % s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Displays latest Instagram photos', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Instagram Username', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'username',
			'value'       => '',
			'description' => wp_kses( __( 'Enter Instagram username (not include @). Example: <b>thememove</b>',
				'amely' ),
				array( 'b' => array() ) ),
		),

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'View mode', 'amely' ),
			'description' => esc_html__( 'Select a template to display instagram', 'amely' ),
			'param_name'  => 'view',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Grid', 'amely' )     => 'grid',
				esc_html__( 'Carousel', 'amely' ) => 'carousel',
			),
		),

		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Number of items', 'amely' ),
			'param_name'  => 'number_items',
			'value'       => 1,
			'max'         => 1000,
			'min'         => 1,
			'step'        => 1,
			'description' => esc_html__( 'Set number of items in grid (limited to 1000)',
				'amely' ),
		),

		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array( 'element' => 'view', 'value' => array( 'carousel' ) ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autoplay', 'amely' ) => 'yes' ),
			'dependency' => array(
				'element' => 'view',
				'value'   => array( 'carousel' ),
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
				esc_html__( 'Arrows & Dots', 'amely' )  => 'both',
				esc_html__( 'None', 'amely' )   => '',
			),
			'dependency' => array(
				'element' => 'view',
				'value'   => array( 'carousel' ),
			),
		),

		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Number of images to show', 'amely' ),
			'param_name' => 'number_of_items_to_show',
			'value'      => array(
				1,
				2,
				3,
				4,
				5,
				6,
			),
			'std'        => 4,
		),

		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Item spacing', 'amely' ),
			'param_name' => 'spacing',
			'value'      => 15,
			'max'        => 50,
			'min'        => 5,
			'step'       => 1,
			'suffix'     => 'px',
		),
		array(
			'type'        => 'textarea_html',
			'heading'     => esc_html__( 'Text', 'amely' ),
			'param_name'  => 'content',
			'value'       => esc_html__( 'Follow us on Instagram', 'amely' ),
			'description' => esc_html__( 'Leave empty to hide it', 'amely' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_username',
			'value'      => array(
				esc_html__( 'Show Instagram username', 'amely' ) => 'yes',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_likes_comments',
			'value'      => array(
				esc_html__( 'Show likes and comments', 'amely' ) => 'yes',
			),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'link_new_page',
			'value'      => array(
				esc_html__( 'Open links in new page', 'amely' ) => 'yes',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'square_media',
			'value'      => array(
				esc_html__( 'Show square media', 'amely' ) => 'yes',
			),
			'std'        => 'yes',
		),
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	),

) );
