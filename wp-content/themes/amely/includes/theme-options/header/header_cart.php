<?php

if ( ! class_exists( 'WooCommerce' ) ) {
	return;
}

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Shopping Cart', 'amely' ),
		'id'         => 'section_header_cart',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'minicart_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable Shopping Cart', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable the shopping cart', 'amely' ),
				'default'  => true,
			),
			array(
				'id'       => 'minicart_message',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Shopping Cart Message', 'amely' ),
				'subtitle' => esc_html__( 'Insert the text you want to see in the shopping cart here.', 'amely' ),
				'default'  => esc_html__( 'Free Shipping on All Orders Over $100!', 'amely' ),
			),
			array(
				'id'       => 'minicart_message_pos',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Message Position', 'amely' ),
				'subtitle' => esc_html__( 'Set the position for shopping cart message in the dropdown', 'amely' ),
				'options'  => array(
					'top'    => esc_html__( 'Top', 'amely' ),
					'bottom' => esc_html__( 'Bottom', 'amely' ),
				),
				'default'  => 'bottom',
			),
			array(
				'id'      => 'minicart_icon',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Shopping Cart Icon', 'amely' ),
				'options' => array(
					'ti-shopping-cart'      => '<i class="ti-shopping-cart"></i>&nbsp;&nbsp;' . esc_html__( 'Cart',
							'amely' ),
					'ti-shopping-cart-full' => '<i class="ti-shopping-cart-full"></i>&nbsp;&nbsp;' . esc_html__( 'Cart Full',
							'amely' ),
					'ion-bag'               => '<i class="ion-bag"></i>&nbsp;&nbsp;' . esc_html__( 'Bag',
							'amely' ),
				),
				'default' => 'ti-shopping-cart',
			),
			array(
				'id'          => 'minicart_icon_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Cart Icon Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the shopping cart icon', 'amely' ),
				'output'      => $amely_selectors['minicart_icon_color'],
				'default'     => SECONDARY_COLOR,
			),
			array(
				'id'          => 'minicart_count_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Cart Item Count Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the text of shopping cart', 'amely' ),
				'output'      => $amely_selectors['minicart_count_color'],
				'default'     => '#ffffff',
			),
			array(
				'id'          => 'minicart_count_bg_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Cart Item Count Background Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a background color for the item count of shopping cart',
					'amely' ),
				'output'      => $amely_selectors['minicart_count_bg_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
			),
		),
	) );
