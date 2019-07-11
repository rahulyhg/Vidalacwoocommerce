<?php

if ( ! class_exists( 'YITH_WCWL' ) ) {
	return;
}

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Wishlist', 'amely' ),
		'id'         => 'section_header_wishlist',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'wishlist_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Wishlist', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable the wishlist icon in the header', 'amely' ),
				'default'  => false,
			),
			array(
				'id'      => 'wishlist_icon',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Wishlist Icon', 'amely' ),
				'options' => array(
					'ti-heart' => '<i class="ti-heart"></i>&nbsp;&nbsp;' . esc_html__( 'Heart', 'amely' ),
					'ti-star'  => '<i class="ti-star"></i>&nbsp;&nbsp;' . esc_html__( 'Star', 'amely' ),
				),
				'default' => 'ti-heart',
			),
			array(
				'id'      => 'wishlist_add_to_cart_on',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show Add To Cart Button', 'amely' ),
				'default' => true,
			),
			array(
				'id'      => 'wishlist_target',
				'type'    => 'switch',
				'title'   => esc_html__( 'Open Wishlist page in a new tab', 'amely' ),
				'default' => false,
			),
			array(
				'id'          => 'wishlist_icon_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Wishlist Icon Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the wishlist icon', 'amely' ),
				'output'      => $amely_selectors['wishlist_icon_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
			),
			array(
				'id'          => 'wishlist_count_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Wishlist Item Count Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the text of wishlist widget', 'amely' ),
				'output'      => $amely_selectors['wishlist_count_color'],
				'validate'    => 'color',
				'default'     => '#ffffff',
			),
			array(
				'id'          => 'wishlist_count_bg_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Wishlist Item Count Background Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a background color for the item count of wishlist widget',
					'amely' ),
				'output'      => $amely_selectors['wishlist_count_bg_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
			),
		),
	) );
