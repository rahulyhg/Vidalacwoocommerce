<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'  => esc_html__( 'Pages', 'amely' ),
	'id'     => 'panel_pages',
	'icon'   => 'fa fa-file-text-o',
	'fields' => array(

		array(
			'id'       => 'page_sidebar_config',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Page Sidebar Position', 'amely' ),
			'subtitle' => esc_html__( 'Controls the position of sidebars for page.', 'amely' ),
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
			'id'       => 'search_sidebar_config',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Search Sidebar Position', 'amely' ),
			'subtitle' => esc_html__( 'Controls the position of sidebars for search result page.', 'amely' ),
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
			'default'  => 'right',
		),

		array(
			'id'       => 'search_sidebar',
			'type'     => 'select',
			'title'    => esc_html__( 'Search Sidebar', 'amely' ),
			'subtitle' => esc_html__( 'Choose the sidebar for search result page.', 'amely' ),
			'data'     => 'sidebars',
			'default'  => 'sidebar',
			'required' => array(
				array( 'search_sidebar_config', '!=', 'no' ),
			),
		),

		array(
			'id'       => '404_bg',
			'type'     => 'background',
			'title'    => esc_html__( '404 Background', 'amely' ),
			'subtitle' => esc_html__( 'Set background image or color for 404 page.', 'amely' ),
			'output'   => array( '.area-404' ),
			'default'  => array(
				'background-image' => AMELY_IMAGES . DS . '404-bg.jpg',
			),
		),

	),
) );
