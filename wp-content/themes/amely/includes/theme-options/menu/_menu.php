<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title' => esc_html__( 'Navigation', 'amely' ),
	'id'    => 'panel_nav',
	'icon'  => 'fa fa-bars',
) );

require_once AMELY_OPTIONS_DIR . DS . 'menu' . DS . 'site_menu.php';
require_once AMELY_OPTIONS_DIR . DS . 'menu' . DS . 'mobile_menu.php';
