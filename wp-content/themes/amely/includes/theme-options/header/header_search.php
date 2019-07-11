<?php

$search_post_type = array(
	'post' => esc_html__( 'Post', 'amely' ),
);

if ( class_exists( 'WooCommerce' ) ) {
	$search_post_type['product'] = esc_html__( 'Product', 'amely' );
	$search_post_type['']        = esc_html__( 'All post type', 'amely' );
}

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Search', 'amely' ),
		'id'         => 'section_header_search',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'search_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Search', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable the search box', 'amely' ),
				'default'  => true,
			),
			array(
				'id'       => 'search_style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Search Style', 'amely' ),
				'options'  => array(
					'icon'  => array(
						'title' => esc_html__( 'Only Icon', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'search-icon.png',
					),
					'input' => array(
						'title' => esc_html__( 'With input', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'search-input.png',
					),
				),
				'default'  => 'icon',
			),
			array(
				'id'       => 'search_post_type',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Search content type', 'amely' ),
				'subtitle' => esc_html__( 'Select content type you want to use in the search box', 'amely' ),
				'options'  => $search_post_type,
				'default'  => class_exists( 'WooCommerce' ) ? '' : 'post',
			),
			array(
				'id'       => 'search_by',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Search product by', 'amely' ),
				'options'  => array(
					'title' => esc_html__( 'Title', 'amely' ),
					'sku'   => esc_html__( 'SKU', 'amely' ),
					'both'  => esc_html__( 'Both title & SKU', 'amely' ),
				),
				'default'  => 'both',
				'required' => array(
					array( 'search_post_type', '=', array( 'product' ) ),
				),
			),
			array(
				'id'       => 'search_categories_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Categories select box', 'amely' ),
				'subtitle' => esc_html__( 'Turn on this option if you want to show categories select box',
					'amely' ),
				'default'  => true,
			),
			array(
				'id'      => 'search_ajax_on',
				'type'    => 'switch',
				'title'   => esc_html__( 'Live Search', 'amely' ),
				'default' => true,
			),
			array(
				'id'            => 'search_min_chars',
				'type'          => 'slider',
				'title'         => esc_html__( 'Minimum number of characters', 'amely' ),
				'subtitle'      => esc_html__( 'Minimum number of characters required to trigger autosuggest',
					'amely' ),
				'min'           => 1,
				'max'           => 10,
				'step'          => 1,
				'default'       => 1,
				'display_value' => 'label',
				'required'      => array(
					array( 'search_ajax_on', '=', array( true ) ),
				),
			),
			array(
				'id'            => 'search_limit',
				'type'          => 'slider',
				'title'         => esc_html__( 'Maximum number of results', 'amely' ),
				'subtitle'      => esc_html__( 'Maximum number of results showed within the autosuggest box',
					'amely' ),
				'min'           => 1,
				'max'           => 20,
				'step'          => 1,
				'default'       => 6,
				'display_value' => 'label',
				'required'      => array(
					array( 'search_ajax_on', '=', array( true ) ),
				),
			),
			array(
				'id'       => 'search_excerpt_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show excerpt', 'amely' ),
				'subtitle' => esc_html__( 'Show the excerpt of search result', 'amely' ),
				'default'  => false,
				'required' => array(
					array( 'search_ajax_on', '=', array( true ) ),
				),
			),
			array(
				'id'          => 'search_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Search Icon Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the search icon', 'amely' ),
				'output'      => $amely_selectors['search_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
			),
		),
	) );
