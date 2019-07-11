<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'      => esc_html__( 'Mobile Menu', 'amely' ),
	'id'         => 'section_mobile_menu',
	'subsection' => true,
	'fields'     => array(
		array(
			'id'       => 'mobile_menu_social',
			'type'     => 'switch',
			'title'    => esc_html__( 'Social in the mobile menu', 'amely' ),
			'subtitle' => esc_html__( 'Enable / Disable social in the mobile menu', 'amely' ),
			'default'  => true,
		),
		array(
			'id'          => 'mobile_menu_button_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Mobile Menu button color', 'amely' ),
			'output'      => $amely_selectors['mobile_menu_button_color'],
			'validate'    => 'color',
			'default'     => '#666666',
		),
	),
) );
