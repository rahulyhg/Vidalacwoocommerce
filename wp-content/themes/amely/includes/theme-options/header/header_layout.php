<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Header Layout', 'amely' ),
		'id'         => 'section_header_layout',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'sticky_header',
				'type'     => 'switch',
				'title'    => esc_html__( 'Sticky Header', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable sticky header option', 'amely' ),
				'default'  => true,
				'required' => array(
					array( 'header', '!=', 'vertical' ),
				),
			),

			array(
				'id'       => 'header_layout_notice',
				'type'     => 'info',
				'style'    => 'critical',
				'title'    => esc_html__( 'Note', 'amely' ),
				'desc'     => esc_html__( 'Note: The width of the Split Header and Menu Left Header should be Wide or Full width',
					'amely' ),
				'required' => array(
					array( 'header', '=', array( 'split', 'menu-left' ) ),
					array( 'header_width', '=', array( 'header_width', 'standard' ) ),
				),
			),

			array(
				'id'       => 'header_width',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Header Width', 'amely' ),
				'options'  => array(
					'standard'         => esc_html__( 'Standard', 'amely' ),
					'wide'             => esc_html__( 'Wide', 'amely' ),
					'full'             => esc_html__( 'Full-width', 'amely' ),
					'full-no-paddings' => esc_html__( 'Full-width (no paddings)', 'amely' ),
				),
				'default'  => 'wide',
				'required' => array(
					array( 'header', '!=', 'vertical' ),
				),
			),

			array(
				'id'            => 'header_v_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Header Width', 'amely' ),
				'default'       => 270,
				'min'           => 200,
				'step'          => 10,
				'max'           => 300,
				'display_value' => 'label',
				'required'      => array(
					array( 'header', '=', 'vertical' ),
				),
			),

			array(
				'id'            => 'header_height',
				'type'          => 'slider',
				'title'         => esc_html__( 'Header Height', 'amely' ),
				'default'       => 90,
				'min'           => 60,
				'step'          => 1,
				'max'           => 150,
				'display_value' => 'label',
				'required'      => array(
					array( 'header', '!=', 'vertical' ),
				),
			),

			array(
				'id'       => 'header_overlap',
				'type'     => 'switch',
				'title'    => esc_html__( 'Header above the content', 'amely' ),
				'default'  => true,
				'required' => array(
					array( 'header', '!=', 'menu-bottom' ),
					array( 'header', '!=', 'vertical' ),
				),
			),

			array(
				'id'       => 'header',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Header Type', 'amely' ),
				'subtitle' => esc_html__( 'Select your header layout', 'amely' ),
				'options'  => array(
					'base'        => array(
						'title' => esc_html__( 'Base Header', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'header-base.png',
					),
					'split'       => array(
						'title' => esc_html__( 'Split Header (logo in center of the menu)', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'header-split.png',
					),
					'menu-bottom' => array(
						'title' => esc_html__( 'Menu Bottom Header', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'header-menu-bottom.png',
					),
					'menu-left'   => array(
						'title' => esc_html__( 'Menu Left Header', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'header-menu-left.png',
					),
					'vertical'    => array(
						'title' => esc_html__( 'Vertical Header', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'header-vertical.png',
					),
				),
				'default'  => 'base',
			),
		),
	) );
