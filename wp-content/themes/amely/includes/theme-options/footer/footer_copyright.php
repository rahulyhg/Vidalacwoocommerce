<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Copyright', 'amely' ),
		'id'         => 'section_bottom_bar',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'footer_copyright',
				'type'     => 'switch',
				'title'    => esc_html__( 'Display copyright', 'amely' ),
				'subtitle' => esc_html__( 'Check if you want to display the copyright', 'amely' ),
				'default'  => false,
			),

			array(
				'id'       => 'footer_copyright_text',
				'type'     => 'editor',
				'title'    => esc_html__( 'Copyright', 'amely' ),
				'subtitle' => esc_html__( 'Specify the copyright text to show at the bottom of the website',
					'amely' ),
				'default'  => wp_kses( sprintf( __( '<p>Copyright &copy; 2017. Created by <a href="%s" target="_blank">ThemeMove</a>. Powered by <a href="%s" target="_blank">WordPress</a></p>',
					'amely' ),
					esc_url( 'http://thememove.com' ),
					esc_url( 'http://www.wordpress.org' ) ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'args'     => array(
					'textarea_rows'  => 3,
					'default_editor' => 'html',
				),
			),

			array(
				'id'          => 'footer_copyright_bgcolor',
				'type'        => 'color',
				'title'       => esc_html__( 'Copyright background color', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_copyright_bgcolor'],
				'default'     => '#ffffff',
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),

			array(
				'id'          => 'footer_copyright_color',
				'type'        => 'color',
				'title'       => esc_html__( 'Copyright text color', 'amely' ),
				'subtitle'    => esc_html__( 'This is the standard text color for footer', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_copyright_color'],
				'default'     => '#999',
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),

			array(
				'id'          => 'footer_copyright_link_color',
				'type'        => 'link_color',
				'title'       => esc_html__( 'Copyright link color', 'amely' ),
				'subtitle'    => esc_html__( 'This color will apply to buttons, links, etc...', 'amely' ),
				'transparent' => false,
				'output'      => $amely_selectors['footer_copyright_link_color'],
				'active'      => false,
				'visited'     => false,
				'default'     => array(
					'regular' => SECONDARY_COLOR,
					'hover'   => PRIMARY_COLOR,
				),
				'required'    => array(
					'footer_color_scheme',
					'=',
					'custom',
				),
			),

		),
	) );
