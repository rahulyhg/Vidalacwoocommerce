<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Top Bar', 'amely' ),
		'id'         => 'section_topbar',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'topbar_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Top bar', 'amely' ),
				'subtitle' => esc_html__( 'Enabling this option will display top area', 'amely' ),
				'default'  => false,
			),
			array(
				'id'       => 'topbar',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Topbar Layout', 'amely' ),
				'subtitle' => esc_html__( 'Select your topbar layout', 'amely' ),
				'options'  => array(
					'switchers-left'  => array(
						'title' => esc_html__( 'Switchers on the left, social links on the right', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'topbar-switcher-left.png',
					),
					'switchers-right' => array(
						'title' => esc_html__( 'Switchers on the right, social links on the left', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'topbar-switcher-right.png',
					),
					'only-text'       => array(
						'title' => esc_html__( 'The topbar has only text',
							'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'topbar-only-text.png',
					),
					'text-switchers'       => array(
						'title' => esc_html__( 'Switchers on the right, custom text on the left', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'topbar-text-switcher.png',
					),
				),
				'default'  => 'switchers-left',
			),
			array(
				'id'       => 'topbar_can_close',
				'type'     => 'switch',
				'title'    => esc_html__( 'Top bar can be close', 'amely' ),
				'subtitle' => esc_html__( 'Enabling this option if you want to show a close button on the top bar',
					'amely' ),
				'default'  => true,
				'required' => array(
					array( 'topbar', '==', array( 'only-text' ) ),
				),
			),
			array(
				'id'       => 'topbar_text',
				'type'     => 'textarea',
				'title'    => esc_html__( 'Text in the top bar', 'amely' ),
				'subtitle' => esc_html__( 'Insert the text you want to see in the top bar here. You can use HTML or shortcodes',
					'amely' ),
				'args'     => array(
					'textarea_rows' => 3,
				),
				'default'  => 'Order Online Call Us <a href="tel:0123456789">(0123) 456789</a>',
			),
			array(
				'id'            => 'topbar_height',
				'type'          => 'slider',
				'title'         => esc_html__( 'Top bar height', 'amely' ),
				'default'       => 44,
				'min'           => 30,
				'step'          => 1,
				'max'           => 60,
				'display_value' => 'label',
			),
			array(
				'id'      => 'topbar_width',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Top bar width', 'amely' ),
				'options' => array(
					'standard'         => esc_html__( 'Standard', 'amely' ),
					'wide'             => esc_html__( 'Wide', 'amely' ),
					'full'             => esc_html__( 'Full width', 'amely' ),
					'full-no-paddings' => esc_html__( 'Full width (no paddings)', 'amely' ),

				),
				'default' => 'wide',
			),
			array(
				'id'       => 'topbar_social',
				'type'     => 'switch',
				'title'    => esc_html__( 'Social links', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable the social links on the top bar', 'amely' ),
				'default'  => true,
				'required' => array(
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),
			array(
				'id'       => 'topbar_menu',
				'type'     => 'switch',
				'title'    => esc_html__( 'Menu', 'amely' ),
				'subtitle' => esc_html__( 'Enable / Disable the top bar menu', 'amely' ),
				'default'  => true,
				'required' => array(
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),
			array(
				'id'       => 'topbar_logged_in_menu',
				'type'     => 'select',
				'title'    => esc_html__( 'Top bar menu (for logged-in users)', 'amely' ),
				'subtitle' => esc_html__( 'Select a menu to display in the top bar for logged-in users', 'amely' ),
				'options'  => Amely_Helper::get_all_menus(),
				'default'  => 'none',
				'required' => array(
					array( 'topbar_menu', '=', array( true ) ),
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),

			array(
				'id'       => 'topbar_divider_style',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Divider Style', 'amely' ),
				'options'  => array(
					'line'   => array(
						'title' => esc_html__( 'Line', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'divider-line.png',
					),
					'dotted' => array(
						'title' => esc_html__( 'Dotted', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'divider-dotted.png',
					),
				),
				'default'  => 'square',
				'required' => array(
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),
			array(
				'id'      => 'topbar_scheme',
				'type'    => 'button_set',
				'title'   => esc_html__( 'Top bar color scheme', 'amely' ),
				'options' => array(
					'dark'   => esc_html__( 'Dark', 'amely' ),
					'light'  => esc_html__( 'Light', 'amely' ),
					'custom' => esc_html__( 'Custom', 'amely' ),

				),
				'default' => 'light',
			),
			array(
				'id'          => 'topbar_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Text Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a text color for the top bar.', 'amely' ),
				'output'      => $amely_selectors['topbar_color'],
				'validate'    => 'color',
				'default'     => '#777777',
				'required'    => array(
					array( 'topbar_scheme', '=', array( 'custom' ) ),
				),
			),
			array(
				'id'          => 'topbar_link_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Link Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a link color for the top bar.', 'amely' ),
				'output'      => $amely_selectors['topbar_link_color'],
				'validate'    => 'color',
				'default'     => '#777777',
				'required'    => array(
					array( 'topbar_scheme', '=', array( 'custom' ) ),
				),
			),
			array(
				'id'          => 'topbar_link_color_hover',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Link Color on hover', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a link color on hover for the top bar.', 'amely' ),
				'output'      => $amely_selectors['topbar_link_color_hover'],
				'validate'    => 'color',
				'default'     => PRIMARY_COLOR,
				'required'    => array(
					array( 'topbar_scheme', '=', array( 'custom' ) ),
				),
			),
			array(
				'id'       => 'topbar_bgcolor',
				'type'     => 'color',
				'title'    => esc_html__( 'Background Color', 'amely' ),
				'subtitle' => esc_html__( 'Pick a background color for the top bar', 'amely' ),
				'output'   => $amely_selectors['topbar_bgcolor'],
				'validate' => 'color',
				'default'  => 'transparent',
				'required' => array(
					array( 'topbar_scheme', '=', array( 'custom' ) ),
				),
			),
			array(
				'id'          => 'topbar_bdcolor',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'Border Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a border color for the top bar. Only avaiable if the text color scheme is Custom',
					'amely' ),
				'output'      => $amely_selectors['topbar_bdcolor'],
				'validate'    => 'color',
				'default'     => '#eee',
				'required'    => array(
					array( 'topbar_scheme', '=', array( 'custom' ) ),
				),
			),
			array(
				'id'       => 'topbar_language_switcher_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Language Switcher', 'amely' ),
				'subtitle' => wp_kses( sprintf( __( 'Enable / Disable the Language Switcher in the top bar instead of the Language Menu. This feature requires <a href="%s" target="_blank">WPML</a> or <a href="%s" target="_blank">Polylang</a> plugin.',
					'amely' ),
					esc_url( 'https://wpml.org/' ),
					esc_url( 'https://wordpress.org/plugins/polylang/' ) ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'desc'     => esc_html__( 'The switchers was customized to compatible with our theme', 'amely' ),
				'default'  => false,
				'required' => array(
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),
			array(
				'id'       => 'topbar_currency_switcher_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Currency Switcher', 'amely' ),
				'subtitle' => wp_kses( sprintf( __( 'Enable / Disable the Currency Switcher in the top bar instead of the Currency Menu. This feature requires <a href="%s" target="_blank">WooCommerce Multilingual</a> or <a href="%s" target="_blank">WooCommerce Currency Switcher</a> plugin.',
					'amely' ),
					esc_url( 'https://wordpress.org/plugins/woocommerce-multilingual/' ),
					esc_url( 'https://wordpress.org/plugins/woocommerce-currency-switcher/' ) ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'desc'     => esc_html__( 'The switchers was customized to compatible with our theme', 'amely' ),
				'default'  => false,
				'required' => array(
					array( 'topbar', '!=', array( 'only-text' ) ),
				),
			),
		),
	) );
