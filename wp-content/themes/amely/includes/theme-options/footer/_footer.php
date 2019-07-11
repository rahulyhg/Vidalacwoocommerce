<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'  => esc_html__( 'Footer', 'amely' ),
		'id'     => 'panel_footer',
		'icon'   => 'fa fa-angle-double-down ',
		'fields' => array(

			array(
				'id'       => 'footer_layout',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Footer columns', 'amely' ),
				'subtitle' => esc_html__( 'Choose number of columns to display in footer area', 'amely' ),
				'desc'     => wp_kses( sprintf( __( 'Note: Each column represents one Footer Sidebar in <a href="%s">Appearance -> Widgets</a> settings.',
					'amely' ),
					admin_url( 'widgets.php' ) ),
					wp_kses_allowed_html( 'post' ) ),
				'options'  => array(
					'1_12' => array(
						'title' => esc_html__( '1 Column', 'amely' ),
						'img'   => get_template_directory_uri() . '/assets/admin/images/footer_col_1.png',
					),
					'2_6'  => array(
						'title' => esc_html__( '2 Columns', 'amely' ),
						'img'   => get_template_directory_uri() . '/assets/admin/images/footer_col_2.png',
					),
					'3_4'  => array(
						'title' => esc_html__( '3 Columns', 'amely' ),
						'img'   => get_template_directory_uri() . '/assets/admin/images/footer_col_3.png',
					),
					'4_3'  => array(
						'title' => esc_html__( '4 Columns', 'amely' ),
						'img'   => get_template_directory_uri() . '/assets/admin/images/footer_col_4.png',
					),
				),
				'default'  => '4_3',
			),

			array(
				'id'      => 'footer_width',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Footer Width', 'amely' ),
				'options' => array(
					'standard' => esc_html__( 'Standard', 'amely' ),
					'wide'     => esc_html__( 'Wide', 'amely' ),

				),
				'default' => 'standard',
			),

			array(
				'id'      => 'footer_color_scheme',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Footer Color Scheme', 'amely' ),
				'options' => array(
					'custom' => esc_html__( 'Custom', 'amely' ),
					'light'  => esc_html__( 'Light', 'amely' ),
					'dark'   => esc_html__( 'Dark', 'amely' ),

				),
				'default' => 'custom',
			),

			array(
				'id'          => 'footer_bgcolor',
				'type'        => 'color',
				'title'       => esc_html__( 'Background color', 'amely' ),
				'subtitle'    => esc_html__( 'Specify footer background color', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_bgcolor'],
				'default'     => '#ffffff',
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),

			array(
				'id'          => 'footer_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Text color', 'amely' ),
				'subtitle'    => esc_html__( 'This is the standard text color for footer', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_color'],
				'default'     => '#999',
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),

			array(
				'id'          => 'footer_accent_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Accent color', 'amely' ),
				'subtitle'    => esc_html__( 'This color will apply to buttons, links, etc...', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_accent_color'],
				'default'     => '#333333',
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),
		),
	) );

require_once AMELY_OPTIONS_DIR . DS . 'footer' . DS . 'footer_copyright.php';
