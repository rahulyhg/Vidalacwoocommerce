<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Header Left Column', 'amely' ),
		'id'         => 'section_header_left_column',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'header_left_column_notice',
				'type'     => 'info',
				'style'    => 'success',
				'title'    => esc_html__( 'Note', 'amely' ),
				'desc'     => esc_html__( '<b>ONLY works with the Menu Bottom Header.</b>', 'amely' ),
				'required' => array(
					array( 'header', '=', array( 'menu-bottom' ) ),
				),
			),

			array(
				'id'       => 'header_left_column_content',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Header Left Column Content', 'amely' ),
				'subtitle' => esc_html__( 'Select the content is displayed in the header left column layout.',
					'amely' ),
				'options'  => array(
					'switchers' => array(
						'title' => esc_html__( 'Switchers', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'left-col-switchers.png',
					),
					'social'    => array(
						'title' => esc_html__( 'Social Links', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'left-col-social.png',
					),
					'widget'    => array(
						'title' => esc_html__( 'Widget', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'left-col-widget.png',
					),
					'search'    => array(
						'title' => esc_html__( 'Search box', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'search-input.png',
					),
				),
				'required' => array(
					array( 'header', '=', array( 'split', 'menu-bottom' ) ),
				),
				'default'  => 'widget',
			),

			array(
				'id'       => 'header_left_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Header Left Sidebar', 'amely' ),
				'data'     => 'sidebars',
				'default'  => 'sidebar-header-left',
				'required' => array(
					array( 'header', '=', array( 'split', 'menu-bottom' ) ),
					array( 'header_left_column_content', '=', array( 'widget' ) ),
				),
			),
		),
	) );
