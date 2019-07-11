<?php
Redux::setSection( Amely_Redux::$opt_name,
	array(
		'title'      => esc_html__( 'Single Product Page', 'amely' ),
		'id'         => 'section_product',
		'subsection' => true,
		'fields'     => array(
			array(
				'id'       => 'product_sidebar_config',
				'type'     => 'image_select',
				'title'    => esc_html__( 'Single Product Page Sidebar Position', 'amely' ),
				'subtitle' => esc_html__( 'Controls the position of sidebars for the product pages.', 'amely' ),
				'options'  => array(
					'left'  => array(
						'title' => esc_html__( 'Left', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . '/2cl.png',
					),
					'no'    => array(
						'title' => esc_html__( 'Disable', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . '/1c.png',
					),
					'right' => array(
						'title' => esc_html__( 'Right', 'amely' ),
						'img'   => AMELY_ADMIN_IMAGES . '/2cr.png',
					),
				),
				'default'  => 'no',
			),

			array(
				'id'       => 'product_sidebar',
				'type'     => 'select',
				'title'    => esc_html__( 'Single Product Page Sidebar', 'amely' ),
				'subtitle' => esc_html__( 'Choose the sidebar for single product pages.', 'amely' ),
				'data'     => 'sidebars',
				'default'  => 'sidebar-shop',
				'required' => array(
					array( 'product_sidebar_config', '!=', 'no' ),
				),
			),

			array(
				'id'       => 'product_ajax_add_to_cart',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable AJAX add to cart on single product page', 'amely' ),
				'subtitle' => wp_kses_post( 'This option does not work if you turn on <b>\'Redirect to the cart page after successful addition\'</b> in <b>WooCommerce Settings >> Products >> Add to cart behaviour</b>.',
					'amely' ),
				'default'  => true,
			),

			array(
				'id'      => 'show_featured_images',
				'type'    => 'switch',
				'title'   => esc_html__( 'Show only featured images', 'amely' ),
				'default' => false,
			),

			array(
				'id'       => 'product_thumbnails_position',
				'type'     => 'button_set',
				'title'    => esc_html__( 'Thumbnails Position', 'amely' ),
				'options'  => array(
					'left'   => esc_html__( 'Left', 'amely' ),
					'bottom' => esc_html__( 'Bottom', 'amely' ),
				),
				'default'  => 'left',
				'required' => array(
					array( 'show_featured_images', '=', array( false ) ),
				),
			),

			array(
				'id'      => 'product_page_layout',
				'type'    => 'select',
				'title'   => esc_html__( 'Product Page Layout', 'amely' ),
				'options' => array(
					'basic'                => esc_html__( 'Basic', 'amely' ),
					'fullwidth'            => esc_html__( 'Fullwidth', 'amely' ),
					'sticky'               => esc_html__( 'Sticky Details', 'amely' ),
					'sticky-fullwidth'     => esc_html__( 'Sticky Details (Full-width)', 'amely' ),
					'background'           => esc_html__( 'With Background', 'amely' ),
					'background-fullwidth' => esc_html__( 'With Background (Full-width)', 'amely' ),
				),
				'default' => 'basic',
			),

			array(
				'id'          => 'product_bgcolor',
				'type'        => 'color',
				'title'       => esc_html__( 'Background Color', 'amely' ),
				'subtitle'    => esc_html__( 'Pick a background color for the header', 'amely' ),
				'output'      => $amely_selectors['product_bgcolor'],
				'default'     => '#f9f9f9',
				'transparent' => false,
				'required'    => array(
					array( 'product_page_layout', '=', array( 'background', 'background-fullwidth' ) ),
				),
			),

			array(
				'id'       => 'product_zoom_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Enable zoom for product image', 'amely' ),
				'subtitle' => wp_kses( sprintf( __( 'You have to use images larger than the size of the Single Product Image configured  <a href="%s" target="_blank">here</a>. If you use Product Page Layout as full width, you should use images of 1000px or more in width. Otherwise, this function will not work.  Also, this function does not work with External / Affiliate product.',
					'amely' ),
					esc_url(add_query_arg( 'autofocus[section]', 'woocommerce_product_images', admin_url( 'customize.php' ) ))),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'default'  => true,
			),

			array(
				'id'       => 'product_lightbox_button',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show "Zoom image" button', 'amely' ),
				'subtitle' => esc_html__( 'Click to open image in popup and swipe to zoom', 'amely' ),
				'default'  => true,
				'required' => array(
					array( 'product_zoom_on', '=', true ),
				),
			),

			array(
				'id'       => 'product_wishlist_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show "Wishlist" button', 'amely' ),
				'subtitle' => wp_kses( sprintf( __( 'This feature requires <a href="%s" target="_blank">YITH WooCommerce Wishlist</a> plugin.',
					'amely' ),
					esc_url( 'https://wordpress.org/plugins/yith-woocommerce-wishlist/' ) ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'default'  => true,
			),

			array(
				'id'       => 'product_compare_on',
				'type'     => 'switch',
				'title'    => esc_html__( 'Show "Compare" button', 'amely' ),
				'subtitle' => wp_kses( sprintf( __( 'This feature requires <a href="%s" target="_blank">YITH WooCommerce Compare</a> plugin.',
					'amely' ),
					esc_url( 'https://wordpress.org/plugins/yith-woocommerce-compare/' ) ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ),
				'default'  => true,
			),

			array(
				'id'       => 'product_show_share',
				'type'     => 'switch',
				'title'    => esc_html__( 'Social Sharing Box', 'amely' ),
				'subtitle' => esc_html__( 'Turn on to display the social sharing box.', 'amely' ),
				'default'  => true,
			),

			array(
				'id'       => 'product_share_links',
				'type'     => 'checkbox',
				'title'    => esc_html__( 'Share the product on ', 'amely' ),
				'options'  => array(
					'facebook'  => '<i class="fa fa-facebook"></i>&nbsp;&nbsp;' . esc_html__( 'Facebook', 'amely' ),
					'twitter'   => '<i class="fa fa-twitter"></i>&nbsp;&nbsp;' . esc_html__( 'Twitter', 'amely' ),
					'google'    => '<i class="fa fa-google-plus"></i>&nbsp;&nbsp;' . esc_html__( 'Google+',
							'amely' ),
					'pinterest' => '<i class="fa fa-pinterest"></i>&nbsp;&nbsp;' . esc_html__( 'Pinterest',
							'amely' ),
					'email'     => '<i class="fa fa-envelope-o"></i>&nbsp;&nbsp;' . esc_html__( 'Email', 'amely' ),
				),
				'default'  => array(
					'facebook'  => '1',
					'twitter'   => '1',
					'google'    => '1',
					'pinterest' => '1',
					'email'     => '1',
				),
				'required' => array(
					array( 'product_show_share', '=', array( true ) ),
				),
			),

			array(
				'id'       => 'upsells_title',
				'type'     => 'text',
				'title'    => esc_html__( 'Up-Sells title', 'amely' ),
				'subtitle' => esc_html__( 'Up-sells are products which you recommend instead of the currently viewed product.',
					'amely' ),
				'default'  => esc_html__( 'Also looks great with...', 'amely' ),
			),

			array(
				'id'            => 'product_related',
				'type'          => 'slider',
				'title'         => esc_html__( 'Number of Related Products', 'amely' ),
				'subtitle'      => esc_html__( 'Related products is a section on some templates that pulls other products from your store that share the same tags or categories as the current product. Set 0 to hide this section.',
					'amely' ),
				'min'           => 0,
				'max'           => 24,
				'default'       => 8,
				'display_value' => 'label',
			),
		),
	) );
