<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Shop Page', 'amely' ),
		'id'         => 'section_shop',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'shop_sidebar_config',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Shop Sidebar Position', 'amely' ),
				'subtitle' => esc_html__( 'Controls the position of sidebars for the shop pages.', 'amely' ),
				'options'  => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . '2cl.png',
					),
					'no'    => array(
						'title' => esc_html__( 'Disable', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . '1c.png',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . '2cr.png',
					),
				),
				'default'  => 'no',
			),

			array(
				'id'       => 'shop_filters',
				'type'     => 'switch',
				'title'    => esc_html__( 'Shop Filters', 'amely' ),
				'subtitle' => esc_html__( 'Enable shop filters widget\'s area above the products.', 'amely' ),
				'default'  => true,
			),

			array(
				'id'       => 'always_open_shop_filters',
				'type'     => 'switch',
				'title'    => esc_html__( 'Always open shop filter', 'amely' ),
				'default'  => false,
				'required' => array(
					array( 'shop_filters', '!=', array( false ) ),
				),
			),

			array(
				'id'       => 'shop_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Shop Sidebar', 'amely' ),
				'subtitle' => esc_html__( 'Choose the sidebar for archive pages.', 'amely' ),
				'data'     => 'sidebars',
				'default'  => 'sidebar-shop',
				'required' => array(
					array( 'shop_sidebar_config', '!=', 'no' ),
				),
			),

			array(
				'id'      => 'full_width_shop',
				'type'    => 'switch',
				'title'   => esc_html__( 'Full width shop', 'amely' ),
				'default' => true,
			),

			array(
				'id'      => 'shop_categories_menu',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show categories menu in the page title', 'amely' ),
				'default' => false,
			),

			array(
				'id'      => 'column_switcher',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show column switcher', 'amely' ),
				'default' => true,
			),

			array(
				'id'       => 'categories_layout',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Categories Layout', 'amely' ),
				'subtitle' => esc_html__( 'Select layout for the categories block', 'amely' ),
				'options'  => array(
					'grid'     => esc_html__( 'Grid', 'amely' ),
					'carousel' => esc_html__( 'Carousel', 'amely' ),
				),
				'default'  => 'carousel',
			),

			array(
				'id'       => 'categories_columns',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Categories columns', 'amely' ),
				'subtitle' => esc_html__( 'How many categories you want to show per row on the shop page?',
					'amely' ),
				'options'  => array(
					2 => '2',
					3 => '3',
					4 => '4',
					5 => '5',
					6 => '6',
				),
				'default'  => 4,
			),

			array(
				'id'      => 'shop_ajax_on',
				'type'    => 'switch',
				'title'   => esc_html__( 'Enable AJAX functionality on shop', 'amely' ),
				'default' => true,
			),

			array(
				'id'       => 'shop_pagination',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Pagination Type', 'amely' ),
				'subtitle' => esc_html__( 'Select pagination type', 'amely' ),
				'options'  => array(
					'default'  => esc_html__( 'Default', 'amely' ),
					'more-btn' => esc_html__( 'Load More Button', 'amely' ),
					'infinite' => esc_html__( 'Infinite Scroll', 'amely' ),
				),
				'default'  => 'default',
				'required' => array(
					array( 'shop_ajax_on', '=', array( true ) ),
				),
			),
		),
	) );
