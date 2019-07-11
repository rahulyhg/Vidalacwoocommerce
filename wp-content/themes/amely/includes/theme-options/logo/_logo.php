<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'  => esc_html__( 'Logo & Favicon', 'amely' ),
	'id'     => 'panel_logo',
	'icon'   => 'fa fa-picture-o',
	'fields' => array(

		array(
			'id'      => 'logo',
			'type'    => 'media',
			'desc'    => esc_html__( 'Upload image: png, jpg or gif file', 'amely' ),
			'title'   => esc_html__( 'Logo Image', 'amely' ),
			'default' => array(
				'url' => AMELY_IMAGES . '/logo.png'
			),
		),
		array(
			'id'       => 'logo_alt',
			'type'     => 'media',
			'subtitle' => esc_html__( 'for the header above the content', 'amely' ),
			'desc'     => esc_html__( 'Upload image: png, jpg or gif file', 'amely' ),
			'title'    => esc_html__( 'Alternative Logo Image ', 'amely' ),
			'default'  => array(
				'url' => AMELY_IMAGES . '/logo.png'
			),
		),
		array(
			'id'      => 'logo_mobile',
			'type'    => 'media',
			'title'   => esc_html__( 'Logo in mobile devices', 'amely' ),
			'desc'    => esc_html__( 'Upload image: png, jpg or gif file', 'amely' ),
			'default' => array(
				'url' => AMELY_IMAGES . '/logo.png'
			),
		),
		array(
			'id'      => 'logo_mobile_alt',
			'type'    => 'media',
			'title'   => esc_html__( 'Alternative logo in mobile devices', 'amely' ),
			'desc'    => esc_html__( 'Upload image: png, jpg or gif file', 'amely' ),
			'default' => array(
				'url' => AMELY_IMAGES . '/logo.png'
			),
		),
		array(
			'id'            => 'logo_width',
			'type'          => 'slider',
			'title'         => esc_html__( 'Logo width', 'amely' ),
			'subtitle'      => esc_html__( 'Set width for logo area in the header (in %)', 'amely' ),
			'default'       => 10,
			'min'           => 1,
			'max'           => 50,
			'step'          => 1,
			'display_value' => 'label',
			'required'      => array(
				array( 'header', '=', array( 'base' ) ),
			),
		),

		array(
			'id'    => 'favico',
			'type'  => 'media',
			'title' => esc_html__( 'Favico', 'amely' ),
			'desc'  => esc_html__( 'Upload image: png, jpg or gif file. Optimal dimension: 32px x 32px', 'amely' ),
		),

		array(
			'id'       => 'apple_touch',
			'type'     => 'media',
			'title'    => esc_html__( 'Apple touch icon', 'amely' ),
			'subtitle' => esc_html__( 'The Apple Touch Icon is a file used for a web page icon on the Apple iPhone, iPod Touch, and iPad. When someone bookmarks your web page or adds your web page to their home screen this icon is used.', 'amely' ),
			'desc'     => esc_html__( 'File must be .png format. Optimal dimension: 152px x 152px', 'amely' ),
		),
	),
) );
