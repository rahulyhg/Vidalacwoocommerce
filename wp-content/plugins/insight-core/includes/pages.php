<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
add_action( 'admin_menu', 'insight_core_admin_menu' );
function insight_core_admin_menu() {
	add_menu_page(
		'Insight Core',
		'Insight Core',
		'manage_options',
		'insight-core',
		'insight_core_welcome',
		INSIGHT_CORE_PATH . '/assets/images/icon.png',
		6
	);
	add_submenu_page( 'insight-core', 'Welcome', 'Welcome', 'manage_options', 'insight-core' );
	add_submenu_page( 'insight-core', 'Customize', 'Customize', 'edit_theme_options', 'customize.php', null, null, 61 );
	add_submenu_page( 'insight-core', 'Update', 'Update', 'manage_options', 'insight-core-update', 'insight_core_update' );
	add_submenu_page( 'insight-core', 'System', 'System', 'manage_options', 'insight-core-system', 'insight_core_system' );
	add_submenu_page( 'insight-core', 'Child Theme', 'Child Theme', 'manage_options', 'insight-core-child', 'insight_core_child' );
}

function insight_core_welcome() {
	include_once( INSIGHT_CORE_INC_DIR . '/pages-welcome.php' );
}

function insight_core_update() {
	include_once( INSIGHT_CORE_INC_DIR . '/pages-update.php' );
}

function insight_core_system() {
	include_once( INSIGHT_CORE_INC_DIR . '/pages-system.php' );
}

function insight_core_child() {
	include_once( INSIGHT_CORE_INC_DIR . '/pages-child.php' );
}