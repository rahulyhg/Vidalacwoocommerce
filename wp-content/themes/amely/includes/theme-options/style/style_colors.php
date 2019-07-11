<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'            => esc_html__( 'Colors', 'amely' ),
	'id'               => 'section_colors',
	'subsection'       => true,
	'customizer_width' => '450px',
	'fields'           => array(
		array(
			'id'    => 'info_color',
			'type'  => 'info',
			'style' => 'warning',
			'title' => esc_html__( 'IMPORTANT NOTE', 'amely' ),
			'icon'  => 'el-icon-info-sign',
			'desc'  => esc_html__( 'This tab contains general color options. Additional color options for specific areas, can be found within other tabs. Example: For menu color options go to the menu tab.', 'amely' ),
		),

		array(
			'id'          => 'primary_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Primary Color', 'amely' ),
			'default'     => PRIMARY_COLOR,
			'validate'    => 'color',
			'output'      => $amely_selectors['primary_color'],
		),

		array(
			'id'          => 'secondary_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Secondary Color', 'amely' ),
			'default'     => SECONDARY_COLOR,
			'validate'    => 'color',
			'output'      => $amely_selectors['secondary_color'],
		),

		array(
			'id'          => 'tertiary_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Tertiary Color', 'amely' ),
			'default'     => TERTIARY_COLOR,
			'validate'    => 'color',
			'output'      => $amely_selectors['tertiary_color'],
		),

		array(
			'id'          => 'link_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Links Color', 'amely' ),
			'subtitle'    => esc_html__( 'Controls the color of all text links.', 'amely' ),
			'default'     => '#777777',
			'validate'    => 'color',
			'output'      => $amely_selectors['link_color'],
		),
		array(
			'id'          => 'link_hover_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Links Hover Color', 'amely' ),
			'subtitle'    => esc_html__( 'Controls the color of all text links when hover.', 'amely' ),
			'default'     => PRIMARY_COLOR,
			'validate'    => 'color',
			'output'      => $amely_selectors['link_hover_color'],
		),
	),
) );
