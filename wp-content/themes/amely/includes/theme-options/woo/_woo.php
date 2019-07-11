<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title' => esc_html__( 'Shop', 'amely' ),
	'id'    => 'panel_woo',
	'icon'  => 'fa fa-shopping-basket'
) );

require_once AMELY_OPTIONS_DIR . DS . 'woo' . DS . 'woo_general.php';
require_once AMELY_OPTIONS_DIR . DS . 'woo' . DS . 'woo_shop.php';
require_once AMELY_OPTIONS_DIR . DS . 'woo' . DS . 'woo_product.php';
