<?php

/**
 * ThemeMove Product Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Product extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;
		$css   = '';

		$style_hover        = $atts['style_hover'] ? $atts['style_hover'] : '';
		$background_overlay        = $atts['background_overlay'] ? $atts['background_overlay'] : '';
		$text_color        = $atts['text_color'] ? $atts['text_color'] : '';

		if ( $style_hover == 'display_info' ) {
			$css .= $cssID . ':hover .background-overlay { background-color :' . $background_overlay .';}';
			$css .= $cssID . ' .product-title { color :' . $text_color .';}';
			$css .= $cssID . ' .product-price { color :' . $text_color .';}';
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= Amely_Helper::text2line( $css );
	}
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Amely Product', 'amely' ),
	'description' => esc_html__( 'Display single product banner', 'amely' ),
	'base'        => 'amely_product',
	'icon'        => 'amely-element-icon-product',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'      => array(

		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Images', 'amely' ),
			'description' => esc_html__( 'Upload a product image', 'amely' ),
			'param_name'  => 'image',
			'value'       => '',
		),

		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Top text', 'amely' ),
			'param_name' => 'top_text',
		),

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Product name', 'amely' ),
			'param_name'  => 'title',
			'admin_label' => true,
		),

		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Product price', 'amely' ),
			'param_name'  => 'price',
			'description' => esc_html__( 'Enter product price. Only allow number.', 'amely' ),
		),

		array(
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Product URL', 'amely' ),
			'param_name' => 'link',
		),

		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style hover', 'amely' ),
			'param_name'  => 'style_hover',
			'value'       => array(
				esc_html__( 'Display button when hover', 'amely' )       => 'display_button',
				esc_html__( 'Display info product when hover', 'amely' ) => 'display_info',
			),
			'description' => esc_html__( 'Display style when hover.Remember add link text button and URL before.',
				'amely' ),
		),

		// Color
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background Overlay', 'amely' ),
			'param_name' => 'background_overlay',
			'std' => '#1C4486',
			'dependency' => array(
				'element' => 'style_hover',
				'value'   => 'display_info',
			),
		),

		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text Color', 'amely' ),
			'param_name' => 'text_color',
			'std' => '#ffffff',
			'dependency' => array(
				'element' => 'style_hover',
				'value'   => 'display_info',
			),
		),

		AMELY_VC::get_param( 'animation' ),
		AMELY_VC::get_param( 'el_class' ),
		AMELY_VC::get_param( 'css' ),
	),
) );
