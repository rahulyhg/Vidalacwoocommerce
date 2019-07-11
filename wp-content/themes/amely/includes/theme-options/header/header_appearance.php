<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Header Appearance', 'amely' ),
		'id'         => 'section_header_appearance',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'header_white',
				'type'     => 'switch',
				'title'    => esc_html__( 'Header White mode', 'amely' ),
				'subtitle' => esc_html__( 'Make everything (such as text, icon, menu, etc...) on the header to white color. Only works when the "Header above the content" option (in Header > Header Layout) is enabled.',
					'amely' ),
				'default'  => false,
				'required' => array(
					array( 'header', '!=', 'menu-bottom' ),
				),
			),
			array(
				'id'       => 'header_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick a background color for the header', 'amely' ),
				'output'   => $amely_selectors['header_bgcolor'],
				'default'  => '#ffffff',
			),
			array(
				'id'       => 'header_bdcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Border Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick a border color for the header', 'amely' ),
				'output'   => $amely_selectors['header_bdcolor'],
				'validate' => 'color',
				'default'  => 'transparent',
			),
		),
	) );
