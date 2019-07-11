<?php

Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Header Right Column', 'amely' ),
		'id'         => 'section_header_right_column',
		'subsection' => true,
		'fields'     => array(

			array(
				'id'       => 'header_right_column_layout',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Header Right Column Layout', 'amely' ),
				'subtitle' => esc_html__( 'Select the header right column layout.',
					'amely' ),
				'options'  => array(
					'base'           => array(
						'title' => esc_html__( 'Base', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'icons-base.png',
					),
					'no-line'        => array(
						'title' => esc_html__( 'No straight line', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'icons-no-line.png',
					),
					'big'            => array(
						'title' => esc_html__( 'Big', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'icons-big.png',
					),
					'only-mini-cart' => array(
						'title' => esc_html__( 'Only Mini cart (only works with Menu Bottom Header)', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . DS . 'icons-mini-cart.png',
					),
				),
				'default'  => 'base',
			),

			array(
				'id'            => 'right_column_width',
				'type'          => 'slider',
				'title'         => esc_html__( 'Header right column width', 'amely' ),
				'subtitle'      => esc_html__( 'Set width for icons area in the header (search, wishlist, shopping cart) (in %)',
					'amely' ),
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
				'id'       => 'header_login',
				'type'     => 'switch',
				'title'    => esc_html__( 'My Account link in header', 'amely' ),
				'subtitle' => sprintf( __( 'Show links to login/register or my accout page in the header. Please set up the My account page <a href="%s" target="_blank">here</a>.',
					'amely' ),
					admin_url() . 'admin.php?page=wc-settings&tab=account' ),
				'default'  => false,
			),

			array(
				'id'          => 'header_login_icon_color',
				'type'        => 'color',
				'transparent' => false,
				'title'       => esc_html__( 'My Account Icon Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a color for the my \'account\' icon', 'amely' ),
				'output'      => $amely_selectors['header_login_icon_color'],
				'validate'    => 'color',
				'default'     => SECONDARY_COLOR,
				'required'    => array(
					array( 'header_login', '=', true ),
				),
			),
		),
	) );
