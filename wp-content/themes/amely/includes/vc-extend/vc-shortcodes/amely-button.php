<?php

/**
 * Amely Button Shortcode.
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Button extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;

		$style = $atts['style'] ? $atts['style'] : '';

		$font_color          = $atts['font_color'] ? $atts['font_color'] : 'transparent';
		$button_bg_color     = $atts['button_bg_color'] ? $atts['button_bg_color'] : 'transparent';
		$button_border_color = $atts['button_border_color'] ? $atts['button_border_color'] : 'transparent';

		$font_color_hover          = $atts['font_color_hover'] ? $atts['font_color_hover'] : 'transparent';
		$button_bg_color_hover     = $atts['button_bg_color_hover'] ? $atts['button_bg_color_hover'] : 'transparent';
		$button_border_color_hover = $atts['button_border_color_hover'] ? $atts['button_border_color_hover'] : 'transparent';

		$font_size = $atts['font_size'] . 'px';

		$css = '';

		if ( $style == 'custom' ) {
			$css .= $cssID . '{color:' . $font_color . ';background-color:' . $button_bg_color . ';border-color:' . $button_border_color . ';font-size:' . $font_size . ';}';
			$css .= $cssID . ':hover{color:' . $font_color_hover . ';background-color:' . $button_bg_color_hover . ';border-color:' . $button_border_color_hover . ';}';
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

$params = array_merge(
// General
	array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Style', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'style',
			'value'       => array(
				esc_html__( 'Default', 'amely' )     => '',
				esc_html__( 'Alternative', 'amely' ) => 'alt',
				esc_html__( 'Custom', 'amely' )      => 'custom',
			),
			'description' => esc_html__( 'Select button style.', 'amely' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Size', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'size',
			'value'       => array(
				esc_html__( 'Small', 'amely' )       => 'small',
				esc_html__( 'Medium', 'amely' )      => 'medium',
				esc_html__( 'Large', 'amely' )       => 'large',
				esc_html__( 'Extra large', 'amely' ) => 'xlarge',
			),
			'std'         => 'medium',
			'description' => esc_html__( 'Select button size.', 'amely' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Text', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'text',
			'description' => esc_html__( 'Enter text on the button.', 'amely' ),
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'URL (Link)', 'amely' ),
			'param_name'  => 'link',
			'description' => esc_html__( 'Enter button link', 'amely' ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Font size', 'amely' ),
			'param_name' => 'font_size',
			'value'      => 14,
			'min'        => 10,
			'suffix'     => 'px',
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'add_icon',
			'value'      => array( esc_html__( 'Add icon?', 'amely' ) => 'yes' ),
		),
	),
	// Animation class
	array(
		Amely_VC::get_param( 'animation' ),
	),
	// Extra class
	array(
		Amely_VC::get_param( 'el_class' ),
	),
	// Icon.
	Amely_VC::icon_libraries( array( 'element' => 'add_icon', 'not_empty' => true ) ),
	// Icon position.
	array(
		array(
			'group'       => esc_html__( 'Icon', 'amely' ),
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon position', 'amely' ),
			'value'       => array(
				esc_html__( 'Left', 'amely' )  => 'left',
				esc_html__( 'Right', 'amely' ) => 'right',
			),
			'param_name'  => 'icon_pos',
			'description' => esc_html__( 'Select icon library.', 'amely' ),
			'dependency'  => array( 'element' => 'add_icon', 'not_empty' => true ),
		),
	),
	// Color.
	array(
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background color', 'amely' ),
			'param_name' => 'button_bg_color',
			'value'      => amely_get_option( 'secondary_color' ),
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background color (on hover)', 'amely' ),
			'param_name' => 'button_bg_color_hover',
			'value'      => amely_get_option( 'primary_color' ),
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text color', 'amely' ),
			'param_name' => 'font_color',
			'value'      => '#fff',
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text color (on hover)', 'amely' ),
			'param_name' => 'font_color_hover',
			'value'      => '#fff',
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border color', 'amely' ),
			'param_name' => 'button_border_color',
			'value'      => amely_get_option( 'secondary_color' ),
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border color (on hover)', 'amely' ),
			'param_name' => 'button_border_color_hover',
			'value'      => amely_get_option( 'primary_color' ),
			'dependency' => array(
				'element' => 'style',
				'value'   => 'custom',
			),
		),
	),

	array(
		// Css box,
		Amely_VC::get_param( 'css' ),
	)
);

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Button', 'amely' ),
	'base'        => 'amely_button',
	'icon'        => 'amely-element-icon-button',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Eye catching button', 'amely' ),
	'js_view'     => 'VcIconElementView_Backend',
	'params'      => $params,
) );
