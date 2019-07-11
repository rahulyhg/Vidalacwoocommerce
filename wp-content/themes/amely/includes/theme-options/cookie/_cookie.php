<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'  => esc_html__( 'Cookie Notice', 'amely' ),
	'id'     => 'panel_cookie',
	'icon'   => 'fa fa-sticky-note-o',
	'fields' => array(
		array(
			'id'       => 'cookie_on',
			'type'     => 'switch',
			'title'    => esc_html__( 'Enable Cookie Notice', 'amely' ),
			'subtitle' => esc_html__( 'Cookie Notice allows you to elegantly inform users that your site uses cookies and to comply with the EU cookie law regulations. Turn on this option and user will see info box at the bottom of the page that your web-site is using cookies.', 'amely' ),
			'default'  => true,
		),
		array(
			'id'       => 'cookie_expires',
			'type'     => 'select',
			'title'    => esc_html__( 'Cookie expiry', 'amely' ),
			'subtitle' => esc_html__( 'The ammount of time that cookie should be stored for', 'amely' ),
			'options'  => array(
				1       => esc_html__( '1 day', 'amely' ),
				7       => esc_html__( '1 week', 'amely' ),
				30      => esc_html__( '1 month', 'amely' ),
				90      => esc_html__( '3 months', 'amely' ),
				180     => esc_html__( '6 months', 'amely' ),
				365     => esc_html__( '1 year', 'amely' ),
				3650000 => esc_html__( 'Infinity', 'amely' ),
			),
			'default'  => 30
		),
		array(
			'id'       => 'cookie_message',
			'type'     => 'editor',
			'title'    => esc_html__( 'Message', 'amely' ),
			'subtitle' => esc_html__( 'Place here some information about cookies usage that will be shown in the notice', 'amely' ),
			'default'  => esc_html__( 'We use cookies to ensure that we give you the best experience on our website. If you continue to use this site we will assume that you are happy with it.', 'amely' ),
		),
		array(
			'id'       => 'cookie_policy_page',
			'type'     => 'select',
			'title'    => esc_html__( 'Page with details', 'amely' ),
			'subtitle' => esc_html__( 'Choose page that will contain detailed information about your Privacy Policy', 'amely' ),
			'data'     => 'pages',
		),
	),
) );
