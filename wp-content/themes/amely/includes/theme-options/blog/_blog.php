<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title' => esc_html__( 'Blog', 'amely' ),
	'id'    => 'panel_blog',
	'icon'  => 'fa fa-pencil'
) );

require_once AMELY_OPTIONS_DIR . DS . 'blog' . DS . 'blog_general.php';
require_once AMELY_OPTIONS_DIR . DS . 'blog' . DS . 'blog_archive.php';
require_once AMELY_OPTIONS_DIR . DS . 'blog' . DS . 'blog_single.php';
