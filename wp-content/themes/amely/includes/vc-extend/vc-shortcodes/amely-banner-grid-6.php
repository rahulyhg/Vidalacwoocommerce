<?php

/**
 * ThemeMove Banner Grid 5 Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Banner_Grid_6 extends WPBakeryShortCodesContainer {

}

// Banner Grid 6
vc_map( array(
	'name'                    => esc_html__( 'Banner Grid 6', 'amely' ),
	'description'             => esc_html__( 'Group maximum 6 banners into 3 columns', 'amely' ),
	'base'                    => 'amely_banner_grid_6',
	'icon'                    => 'amely-element-icon-banner-grid-6',
	'category'                => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'js_view'                 => 'VcColumnView',
	'content_element'         => true,
	'show_settings_on_create' => false,
	'as_parent'               => array( 'only' => 'amely_banner,amely_banner2,amely_banner3,amely_product_category_banner, rev_slider, rev_slider_vc' ),
	'params'                  => array(
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	),
) );
