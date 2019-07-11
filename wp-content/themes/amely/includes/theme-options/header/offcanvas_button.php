<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Off-Canvas Sidebar', 'amely' ),
		'id'         => 'section_off_canvas',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'offcanvas_button_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Off-canvas Button', 'amely' ),
				'subtitle' => esc_html__( 'Turn on / off off-canvas button', 'amely' ),
				'default'  => false,
			),

			array(
				'id'      => 'offcanvas_action',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Action', 'amely' ),
				'options' => array(
					'sidebar' => esc_html__( 'Open Sidebar', 'amely' ),
					'menu'    => esc_html__( 'Open Full-screen Menu', 'amely' ),
				),
				'default' => 'sidebar',
			),

			array(
				'id'       => 'offcanvas_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Select Sidebar', 'amely' ),
				'subtitle' => esc_html__( 'Choose the custom off-canvas sidebar.', 'amely' ),
				'data'     => 'sidebars',
				'default'  => 'sidebar-offcanvas',
				'required' => array(
					array( 'offcanvas_action', '=', array( 'sidebar' ) ),
				),
			),

			array(
				'id'       => 'offcanvas_notice',
				'type'     => 'info',
				'style'    => 'warning',
				'title'    => esc_html__( 'Note', 'amely' ),
				'desc'     => esc_html__( 'Note: Please add a menu to the Full-screen Menu location on Appearance >> Menus page', 'amely' ),
				'required' => array(
					array( 'offcanvas_action', '=', array( 'menu' ) ),
				),
			),

			array(
				'id'      => 'offcanvas_position',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Position', 'amely' ),
				'options' => array(
					'left'  => esc_html__( 'Left', 'amely' ),
					'right' => esc_html__( 'Right', 'amely' ),
				),
				'default' => 'left',
			),
			array(
				'id'          => 'offcanvas_button_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Off-canvas button color', 'amely' ),
				'output'      => $amely_selectors['offcanvas_button_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
			),
		),
	) );
