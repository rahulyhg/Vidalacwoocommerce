<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'            => esc_html__( 'Style', 'amely' ),
	'id'               => 'panel_style',
	'customizer_width' => '400px',
	'icon'             => 'fa fa-paint-brush',
) );

require_once AMELY_OPTIONS_DIR . DS . 'style' . DS . 'style_typo.php';
require_once AMELY_OPTIONS_DIR . DS . 'style' . DS . 'style_colors.php';
require_once AMELY_OPTIONS_DIR . DS . 'style' . DS . 'style_tag.php';
