<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Item Tag', 'amely' ),
		'id'         => 'section_item_tag',
		'subsection' => true,
		'fields'     => array(
			// Hot
			array(
				'id'       => 'hot_tag_section_start',
				'type'     => 'section',
				'title'    => esc_html__( '\'Hot\' tag', 'amely' ),
				'subtitle' => esc_html__( '', 'amely' ),
				'indent'   => true,
			),
			array(
				'id'       => 'hot_tag_color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick color for the \'Hot\' tag items', 'amely' ),
				'output'   => $amely_selectors['hot_tag_color'],
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular' => '#ffffff',
					'hover'   => '#ffffff',
				),
			),
			array(
				'id'       => 'hot_tag_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color for the \'Hot\' tag items', 'amely' ),
				'output'   => $amely_selectors['hot_tag_bgcolor'],
				'default'  => '#da0e2b'
			),
			array(
				'id'       => 'hot_tag_bgcolor_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color on Hover', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color on hover for the \'Hot\' tag items', 'amely' ),
				'output'   => $amely_selectors['hot_tag_bgcolor_hover'],
				'default'  => '#da0e2b'
			),
			array(
				'id'     => 'hot_tag_section_end',
				'type'   => 'section',
				'indent' => false,
			),

			// New
			array(
				'id'       => 'new_tag_section_start',
				'type'     => 'section',
				'title'    => esc_html__( '\'New\' tag', 'amely' ),
				'subtitle' => esc_html__( '', 'amely' ),
				'indent'   => true,
			),
			array(
				'id'       => 'new_tag_color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick color for the \'New\' tag items', 'amely' ),
				'output'   => $amely_selectors['new_tag_color'],
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular' => '#ffffff',
					'hover'   => '#ffffff',
				),
			),
			array(
				'id'       => 'new_tag_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color for the \'New\' tag items', 'amely' ),
				'output'   => $amely_selectors['new_tag_bgcolor'],
				'default'  => '#fbaf5d'
			),
			array(
				'id'       => 'new_tag_bgcolor_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color on Hover', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color on hover for the \'New\' tag items', 'amely' ),
				'output'   => $amely_selectors['new_tag_bgcolor_hover'],
				'default'  => '#fbaf5d'
			),
			array(
				'id'     => 'new_tag_section_end',
				'type'   => 'section',
				'indent' => false,
			),

			// Sale
			array(
				'id'       => 'sale_tag_section_start',
				'type'     => 'section',
				'title'    => esc_html__( '\'Sale\' tag', 'amely' ),
				'subtitle' => esc_html__( '', 'amely' ),
				'indent'   => true,
			),
			array(
				'id'       => 'sale_tag_color',
				'type'     => 'link_color',
				'title'    => esc_html__( 'Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick color for the \'Sale\' tag items', 'amely' ),
				'output'   => $amely_selectors['sale_tag_color'],
				'active'   => false,
				'visited'  => false,
				'default'  => array(
					'regular' => '#ffffff',
					'hover'   => '#ffffff',
				),
			),
			array(
				'id'       => 'sale_tag_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color for the \'Sale\' tag items', 'amely' ),
				'output'   => $amely_selectors['sale_tag_bgcolor'],
				'default'  => '#4accb0'
			),
			array(
				'id'       => 'sale_tag_bgcolor_hover',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color on Hover', 'amely' ),
				'subtitle' => esc_html__( 'Pick background color on hover for the \'Sale\' tag items', 'amely' ),
				'output'   => $amely_selectors['sale_tag_bgcolor_hover'],
				'default'  => '#4accb0'
			),
			array(
				'id'     => 'sale_tag_section_end',
				'type'   => 'section',
				'indent' => false,
			),
		),
	) );
