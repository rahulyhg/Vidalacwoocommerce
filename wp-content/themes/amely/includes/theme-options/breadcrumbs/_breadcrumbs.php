<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'  => esc_html__( 'Breadcrumbs', 'amely' ),
	'id'     => 'panel_breadcrumbs',
	'icon'   => 'fa fa-angle-double-right',
	'fields' => array(

		array(
			'id'       => 'breadcrumbs',
			'type'     => 'switch',
			'title'    => esc_html__( 'Breadcrumbs', 'amely' ),
			'subtitle' => esc_html__( 'Displays a full chain of links to the current page.', 'amely' ),
			'default'  => true,
		),

		array(
			'id'      => 'breadcrumbs_position',
			'type'    => 'button_set',
			'title'   => esc_html__( 'Breadcrumbs Position', 'amely' ),
			'options' => array(
				'inside' => esc_html__( 'Inside Page Title', 'amely' ),
				'below'  => esc_html__( 'Below Page Title', 'amely' ),
			),
			'default' => 'inside',
		),

		array(
			'id'          => 'breadcrumbs_text_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Breadcrumbs Text Color', 'amely' ),
			'output'      => $amely_selectors['breadcrumbs_text_color'],
			'default'     => '#333333',
		),

		array(
			'id'          => 'breadcrumbs_seperator_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Breadcrumbs Separator Color', 'amely' ),
			'output'      => $amely_selectors['breadcrumbs_seperator_color'],
			'default'     => '#333333',
		),

		array(
			'id'          => 'breadcrumbs_link_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Breadcrumbs Link Color', 'amely' ),
			'output'      => $amely_selectors['breadcrumbs_link_color'],
			'default'     => '#999999',
		),

		array(
			'id'          => 'breadcrumbs_link_color_hover',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Breadcrumbs Link Color: Hover', 'amely' ),
			'output'      => $amely_selectors['breadcrumbs_link_color_hover'],
			'default'     => '#999999',
		),
	),
) );
