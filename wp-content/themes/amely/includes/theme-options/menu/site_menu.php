<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Main Menu', 'amely' ),
		'id'         => 'section_site_menu',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'          => 'site_menu_font',
				'type'        => 'typography',
				'title'       => esc_html__( 'Text Font', 'amely' ),
				'all_styles'  => true,
				'google'      => true,
				'font-backup' => true,
				'line-height' => false,
				'color'       => false,
				'output'      => $amely_selectors['site_menu_font'],
				'units'       => 'px',
				'subtitle'    => esc_html__( 'These settings control the typography for the mobile menu text.',
					'amely' ),
				'text-align'  => false,
				'default'     => array(
					'font-family' => 'Poppins',
					'google'      => true,
					'font-backup' => 'Arial, Helvetica, sans-serif',
					'font-weight' => '500',
					'font-size'   => '14px',
				),
			),

			array(
				'id'       => 'site_menu_align',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Main menu align', 'amely' ),
				'subtitle' => esc_html__( 'Set the text align for the main menu of your site', 'amely' ),
				'options'  => array(
					'left'   => esc_html__( 'Left', 'amely' ),
					'center' => esc_html__( 'Center', 'amely' ),
					'right'  => esc_html__( 'Right', 'amely' ),
				),
				'default'  => 'center',
				'required' => array(
					array( 'header', '=', array( 'base', 'menu-left' ) ),
				),
			),
			array(
				'id'       => 'site_menu_hover_style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Hover Style', 'amely' ),
				'options'  => array(
					'bottom' => array(
						'title' => esc_html__( 'Style 1', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'menu-hover-bottom.png',
					),
					'top'    => array(
						'title' => esc_html__( 'Style 2', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'menu-hover-top.png',
					),
				),
				'default'  => 'bottom',
				'required' => array(
					array( 'header', '=', array( 'menu-bottom' ) ),
				),
			),

			array(
				'id'       => 'site_menu_items_color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Menu Item Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick color for the menu items', 'amely' ),
				'output'   => $amely_selectors['site_menu_items_color'],
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular' => '#696969',
					'hover'   => '#333333',
				),
			),

			array(
				'id'       => 'site_menu_subitems_color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Menu Sub Item Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick color for the menu sub items', 'amely' ),
				'output'   => $amely_selectors['site_menu_subitems_color'],
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular' => '#696969',
					'hover'   => PRIMARY_COLOR,
				),
			),

			array(
				'id'       => 'site_menu_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Menu Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Only works with Menu Bottom Header', 'amely' ),
				'output'   => $amely_selectors['site_menu_bgcolor'],
				'active'   => false,
				'visited'  => false,
				'default'  => '#ffffff',
				'required' => array(
					array( 'header', '=', array( 'menu-bottom' ) ),
				),
			),

			array(
				'id'       => 'site_menu_bdcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Menu Border Color', 'amely' ),
				'subtitle' => esc_html__( 'Only works with Menu Bottom Header', 'amely' ),
				'output'   => $amely_selectors['site_menu_bdcolor'],
				'active'   => false,
				'visited'  => false,
				'default'  => '#eeeeee',
				'required' => array(
					array( 'header', '=', array( 'menu-bottom' ) ),
				),
			),
		),
	) );
