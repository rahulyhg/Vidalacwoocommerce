<?php

/**
 * Social Links Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Social extends WPBakeryShortCode {

	public function getSocialLinks( $atts ) {
		$social_links     = preg_split( '/\s+/', $atts['social_links'] );
		$social_links_arr = array();

		foreach ( $social_links as $social ) {
			$pieces = explode( '|', $social );
			if ( count( $pieces ) == 2 ) {
				$key                      = $pieces[0];
				$link                     = ( $key == 'envelope-o' ) ? 'mailto:' . $pieces[1] : $pieces[1];
				$social_links_arr[ $key ] = $link;
			}
		}

		return $social_links_arr;
	}

	public function shortcode_css( $css_id ) {

		$atts   = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$css    = '';
		$css_id = '#' . $css_id;

		if ( is_rtl() ) {
			$css .= $css_id . ' li{margin: 0 ' . intval( $atts['spacing'] ) . 'px;}';
		} else {
			$css .= $css_id . ' li{margin: 0 ' . intval( $atts['spacing'] ) . 'px;}';
		}

		$css .= $css_id . ' li,' . $css_id . ' i' . '{font-size:' . $atts['icon_font_size'] . 'px}';
		$css .= $css_id . ' i{color:' . $atts['icon_color'];
		$css .= ';background-color:' . $atts['icon_bgcolor'];
		$css .= '}';

		$css .= $css_id . ' li:hover i{color:' . $atts['icon_color_hover'];
		$css .= ';background-color:' . $atts['icon_bgcolor_hover'];
		$css .= '}';

		$css = Amely_Helper::text2line( $css );

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

vc_map( array(
	'name'     => esc_html__( 'Social Links', 'amely' ),
	'base'     => 'amely_social',
	'icon'     => 'amely-element-icon-social-links',
	'category' => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'   => array(
		array(
			'type'       => 'number',
			'param_name' => 'icon_font_size',
			'heading'    => esc_html__( 'Icon font size', 'amely' ),
			'value'      => 24,
			'min'        => 10,
			'max'        => 50,
			'step'       => 1,
			'suffix'     => 'px',
		),
		array(
			'type'       => 'number',
			'param_name' => 'spacing',
			'heading'    => esc_html__( 'Spacing', 'amely' ),
			'value'      => 10,
			'min'        => 0,
			'max'        => 50,
			'step'       => 1,
			'suffix'     => 'px',
		),
		array(
			'type'        => 'dropdown',
			'param_name'  => 'icon_shape',
			'heading'     => esc_html__( 'Icon background shape', 'amely' ),
			'value'       => array(
				esc_html__( 'None', 'amely' )   => 'none',
				esc_html__( 'Circle', 'amely' ) => 'circle',
				esc_html__( 'Square', 'amely' ) => 'square',
			),
			'std'         => 'circle',
			'description' => esc_html__( 'Select background shape and style for icons', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'Social', 'amely' ),
			'type'       => 'dropdown',
			'param_name' => 'source',
			'heading'    => esc_html__( 'Select Social Link', 'amely' ),
			'value'      => array(
				esc_html__( 'Default (From Theme Options)', 'amely' ) => 'default',
				esc_html__( 'Custom', 'amely' )                       => 'custom',
			),
			'std'        => 'default',
		),
		array(
			'group'      => esc_html__( 'Social', 'amely' ),
			'type'       => 'social_links',
			'heading'    => esc_html__( 'Social links', 'amely' ),
			'param_name' => 'social_links',
			'dependency' => array(
				'element' => 'source',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'param_name' => 'icon_color',
			'heading'    => esc_html__( 'Icon color', 'amely' ),
			'value'      => '##999999',
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'param_name' => 'icon_color_hover',
			'heading'    => esc_html__( 'Icon color on hover', 'amely' ),
			'value'      => '#333333',
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'param_name' => 'icon_bgcolor',
			'heading'    => esc_html__( 'Icon background color', 'amely' ),
			'value'      => '#ffffff',
			'dependency' => array(
				'element'            => 'icon_shape',
				'value_not_equal_to' => 'none',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'param_name' => 'icon_bgcolor_hover',
			'heading'    => esc_html__( 'Icon background color on hover', 'amely' ),
			'value'      => '#ffffff',
			'dependency' => array(
				'element'            => 'icon_shape',
				'value_not_equal_to' => 'none',
			),
		),
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	),
) );
