<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title' => esc_html__( 'Custom Code', 'amely' ),
	'id'    => 'panel_custom',
	'icon'  => 'fa fa-code'
) );

require_once AMELY_OPTIONS_DIR . DS . 'custom' . DS . 'custom_css.php';
require_once AMELY_OPTIONS_DIR . DS . 'custom' . DS . 'custom_js.php';

