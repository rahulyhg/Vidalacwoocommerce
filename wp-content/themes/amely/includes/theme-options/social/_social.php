<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'  => esc_html__( 'Social', 'amely' ),
	'id'     => 'panel_social',
	'icon'   => 'fa fa-share-alt',
	'fields' => array(
		array(
			'id'       => 'tooltip',
			'type'     => 'switch',
			'title'    => esc_html__( 'Display tooltip', 'amely' ),
			'subtitle' => esc_html__( 'Enabling tooltip for the social icons when hover.', 'amely' ),
			'default'  => true,
		),

		array(
			'id'      => 'social_open_in_new_tab',
			'type'    => 'switch',
			'title'   => esc_html__( 'Open link in new tab', 'amely' ),
			'default' => false,
		),

		array
		(
			'id'         => 'social_links',
			'type'       => 'repeater',
			'title'      => esc_html__( 'Social Items', 'amely' ),
			'item_name'  => esc_html__( 'Items', 'amely' ),
			'bind_title' => 'icon',
			'fields'     => array(

				array(
					'id'      => 'icon',
					'title'   => esc_html__( 'Icon', 'amely' ),
					'type'    => 'select',
					'desc'    => esc_html__( 'Select a social network to automatically add its icon', 'amely' ),
					'options' => Amely_Helper::social_icons(),
					'default' => 'none',
				),

				array(
					'id'          => 'icon_class',
					'title'       => esc_html__( 'Custom Icon', 'amely' ),
					'type'        => 'text',
					'placeholder' => esc_html__( 'Font Awesome Class', 'amely' ),
					'desc'        => wp_kses( sprintf( __( 'Use your custom icon. You can find Font Awesome icon class <a target="_blank" href="%s">here</a>.', 'amely' ), 'http://fontawesome.io/cheatsheet/' ), array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				),

				array(
					'id'          => 'url',
					'type'        => 'text',
					'title'       => esc_html__( 'Link (URL)', 'amely' ),
					'placeholder' => esc_html__( 'http://', 'amely' ),
					'desc'        => esc_html__( 'Add an URL to your social network', 'amely' ),
				),

				array(
					'id'          => 'title',
					'title'       => esc_html__( 'Title', 'amely' ),
					'type'        => 'text',
					'placeholder' => esc_html__( 'Title', 'amely' ),
					'desc'        => esc_html__( 'Insert your custom title here', 'amely' ),
				),

				array(
					'id'    => 'custom_class',
					'title' => esc_html__( 'Custom CSS class', 'amely' ),
					'type'  => 'text',
					'desc'  => esc_html__( 'Insert your custom CSS class here', 'amely' ),
				),
			),
		),
	),
) );
