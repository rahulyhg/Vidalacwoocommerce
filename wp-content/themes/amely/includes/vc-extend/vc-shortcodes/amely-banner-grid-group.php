<?php
class WPBakeryShortCode_Amely_Banner_Grid_Group extends WPBakeryShortCodesContainer {

}

vc_map( array(
	'name'                    => esc_html__( 'Banner Grid Group', 'amely' ),
	'description'             => esc_html__( 'Arrange multiple banners per row with unusual structure.', 'amely' ),
	'base'                    => 'amely_banner_grid_group',
	'icon'                    => 'amely-element-icon-banner-grid-group',
	'category'                => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'js_view'                 => 'VcColumnView',
	'content_element'         => true,
	'show_settings_on_create' => false,
	'as_parent'               => array( 'only' => 'amely_banner, amely_banner2, amely_banner3, amely_product_category_banner, rev_slider, rev_slider_vc' ),
	'params'                  => array(

		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	),
) );
