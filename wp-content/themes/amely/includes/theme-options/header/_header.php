<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title' => esc_html__( 'Header', 'amely' ),
	'id'    => 'panel_header',
	'icon'  => 'el el-credit-card',
) );

require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_layout.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_left_column.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_right_column.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_appearance.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_topbar.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_search.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_wishlist.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'header_cart.php';
require_once AMELY_OPTIONS_DIR . DS . 'header' . DS . 'offcanvas_button.php';
