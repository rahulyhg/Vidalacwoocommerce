<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'      => esc_html__( 'General', 'amely' ),
	'id'         => 'section_woo_general',
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'product_buttons_scheme',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Product Buttons scheme', 'amely' ),
			'subtitle' => esc_html__( 'Select color scheme for product buttons', 'amely' ),
			'options'  => array(
				'dark'   => array(
					'title' => esc_html__( 'Dark', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . 'product-buttons-dark.png',
				),
				'light'  => array(
					'title' => esc_html__( 'Light', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . 'product-buttons-light.png',
				),
				'custom' => array(
					'title' => esc_html__( 'Custom', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . 'product-buttons-custom.png',
				),
			),
			'default'  => 'dark',
		),

		array(
			'id'          => 'product_buttons_bg_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Product Buttons Background Color', 'amely' ),
			'default'     => PRIMARY_COLOR,
			'validate'    => 'color',
			'output'      => $amely_selectors['product_buttons_bg_color'],
			'required'    => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'          => 'product_buttons_hover_bg_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Product Buttons Background Color on hover', 'amely' ),
			'default'     => '#fcb916',
			'validate'    => 'color',
			'output'      => $amely_selectors['product_buttons_hover_bg_color'],
			'required'    => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'       => 'product_buttons_bd_color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Product Buttons Border Color', 'amely' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => 0.4,
			),
			'validate' => 'rgba',
			'options'  => array(
				'show_buttons' => false,
			),
			'output'   => $amely_selectors['product_buttons_bd_color'],
			'required' => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'       => 'product_buttons_hover_bd_color',
			'type'     => 'color_rgba',
			'title'    => esc_html__( 'Product Buttons Border Color on hover', 'amely' ),
			'default'  => array(
				'color' => '#ffffff',
				'alpha' => 0.4,
			),
			'validate' => 'rgba',
			'options'  => array(
				'show_buttons' => false,
			),
			'output'   => $amely_selectors['product_buttons_hover_bd_color'],
			'required' => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'          => 'product_buttons_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Product Buttons Color', 'amely' ),
			'default'     => '#ffffff',
			'validate'    => 'color',
			'output'      => $amely_selectors['product_buttons_color'],
			'required'    => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'          => 'product_buttons_hover_color',
			'type'        => 'color',
			'transparent' => false,
			'title'       => esc_html__( 'Product Buttons Color on hover', 'amely' ),
			'default'     => '#ffffff',
			'validate'    => 'color',
			'output'      => $amely_selectors['product_buttons_hover_color'],
			'required'    => array(
				'product_buttons_scheme',
				'=',
				'custom',
			),
		),

		array(
			'id'      => 'shop_new_badge_on',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show "New" badge', 'amely' ),
			'default' => true,
		),

		array(
			'id'            => 'shop_new_days',
			'type'          => 'slider',
			'title'         => esc_html__( 'New Product with how many days?', 'amely' ),
			'min'           => 1,
			'max'           => 60,
			'default'       => 10,
			'display_value' => 'label',
		),

		array(
			'id'      => 'shop_hot_badge_on',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show "Hot" badge', 'amely' ),
			'default' => true,
		),

		array(
			'id'      => 'shop_sale_badge_on',
			'type'    => 'switch',
			'title'   => esc_html__( 'Show "Sale" badge', 'amely' ),
			'default' => true,
		),

		array(
			'id'       => 'shop_sale_percent_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show saved sale price percentage', 'amely' ),
			'subtitle' => wp_kses( sprintf( __( 'Show percentage instead of text on "Sale" label. Only available with Simple & External/Affiliate product type. You can see <a href="%s" target="_blank">here</a> for more information about product type.', 'amely' ), esc_url( 'https://docs.woocommerce.com/document/managing-products/#product-types' ) ), array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			) ),
			'default'  => true,
		),

		array(
			'id'      => 'shop_quick_view_on',
			'type'    => 'switch',
			'title'   => esc_html__( 'Quick View', 'amely' ),
			'default' => true,
		),

		array(
			'id'       => 'animated_quick_view_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Animated Quick View', 'amely' ),
			'default'  => true,
			'required' => array(
				array(
					'shop_quick_view_on',
					'=',
					true,
				),
			),
		),

		array(
			'id'       => 'shop_compare_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show "Compare" button', 'amely' ),
			'subtitle' => wp_kses( sprintf( __( 'This feature requires <a href="%s" target="_blank">YITH WooCommerce Compare</a> plugin.', 'amely' ), esc_url( 'https://wordpress.org/plugins/yith-woocommerce-compare/' ) ), array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			) ),
			'default'  => true,
		),

		array(
			'id'       => 'shop_wishlist_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Show "Wishlist" button', 'amely' ),
			'subtitle' => wp_kses( sprintf( __( 'This feature requires <a href="%s" target="_blank">YITH WooCommerce Wishlist</a> plugin.', 'amely' ), esc_url( 'https://wordpress.org/plugins/yith-woocommerce-wishlist/' ) ), array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			) ),
			'default'  => true,
		),

		array(
			'id'       => 'animated_wishlist_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Animated "Wishlist" button', 'amely' ),
			'default'  => true,
			'required' => array(
				array(
					'shop_wishlist_on',
					'=',
					true,
				),
			),
		),

		array(
			'id'       => 'shop_add_to_cart_favico_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable "Add to cart" notification on favicon', 'amely' ),
			'subtitle' => esc_html__( 'Allows you to show number of cart item via favicon like Facebook', 'amely' ),
			'default'  => true,
		),

		array(
			'id'      => 'shop_add_to_cart_notification_on',
			'type'    => 'switch',
			'title'   => esc_html__( 'Enable "Add to cart" notification', 'amely' ),
			'default' => true,
		),

		array(
			'id'       => 'shop_wishlist_notification_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable "Add to wishlist" notification', 'amely' ),
			'subtitle' => wp_kses( sprintf( __( 'This feature requires <a href="%s" target="_blank">YITH WooCommerce Wishlist</a> plugin.', 'amely' ), esc_url( 'https://wordpress.org/plugins/yith-woocommerce-wishlist/' ) ), array(
				'a' => array(
					'href'   => array(),
					'target' => array(),
				),
			) ),
			'default'  => true,
		),
	),
) );
