<?php

/**
 * Amely Icon Box Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Icon_Box extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts   = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$css_id = '#' . $css_id;

		$icon_font_size = $atts['icon_font_size'];
		$icon_color     = $atts['icon_color'] ? $atts['icon_color'] : 'transparent';
		$icon_bgcolor   = $atts['icon_bgcolor'] ? $atts['icon_bgcolor'] : 'transparent';

		$title_font_size  = $atts['title_font_size'];
		$title_font_color = $atts['title_font_color'] ? $atts['title_font_color'] : 'transparent';

		$content_font_size  = $atts['content_font_size'];
		$content_font_color = $atts['content_font_color'] ? $atts['content_font_color'] : 'transparent';

		$link_color = $atts['link_color'] ? $atts['link_color'] : 'transparent';

		$with_bg  = $atts['with_bg'];
		$bg_shape = $atts['bg_shape'];

		$css = '';

		$icon = $css_id . ' i,' . $css_id . ' span';
		$css .= $icon . '{color: ' . $icon_color . ';';

		if ( 'yes' == $with_bg ) {
			if ( $bg_shape == 'square' || $bg_shape == 'circle' || $bg_shape == 'rounded' ) {
				$css .= 'background-color:' . $icon_bgcolor . ';';
			} else {
				$css .= 'border-color:' . $icon_bgcolor . ';';
			}
		}

		if ( is_numeric( $icon_font_size ) ) {
			$css .= 'font-size:' . $icon_font_size . 'px;}';
		}

		$title = $css_id . ' .title, ' . $css_id . ' .title > a';
		$css .= $title . '{color:' . $title_font_color . ';';

		if ( is_numeric( $title_font_size ) ) {
			$css .= 'font-size:' . $title_font_size . 'px;}';
		}

		$description = $css_id . ' .description,' . $css_id . ' .description em';
		$css .= $description . '{color:' . $content_font_color . ';';

		if ( is_numeric( $content_font_size ) ) {
			$css .= 'font-size:' . $content_font_size . 'px;}';
		}

		$css .= $css_id . ' a{color:' . $link_color . ';}';

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

$params = array_merge(
// General
	array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'amely' ),
			'param_name'  => 'style',
			'value'       => array(
				esc_html__( 'Left', 'amely' )   => 'left',
				esc_html__( 'Center', 'amely' ) => 'center',
				esc_html__( 'Right', 'amely' )  => 'right',
			),
			'description' => esc_html__( 'Select icon box style', 'amely' ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Vertical Alignment', 'amely' ),
			'param_name' => 'v_align',
			'value'      => array(
				esc_html__( 'Top', 'amely' )    => 'top',
				esc_html__( 'Middle', 'amely' ) => 'middle',
				esc_html__( 'Bottom', 'amely' ) => 'bottom',
			),
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Title', 'amely' ),
			'param_name'  => 'title',
			'admin_label' => true,
			'value'       => esc_html__( 'This is icon box title', 'amely' ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Title font size', 'amely' ),
			'param_name' => 'title_font_size',
			'value'      => 20,
			'min'        => 10,
			'suffix'     => 'px',
		),
		array(
			'type'       => 'textarea_html',
			'heading'    => esc_html__( 'Description', 'amely' ),
			'param_name' => 'content',
			'value'      => wp_kses_post( __( '<p>This is the description of icon box element</p>', 'amely' ) ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Description font size', 'amely' ),
			'param_name' => 'content_font_size',
			'value'      => 15,
			'min'        => 10,
			'suffix'     => 'px',
		),
		array(
			'type'        => 'vc_link',
			'heading'     => esc_html__( 'URL (Link)', 'amely' ),
			'param_name'  => 'link',
			'description' => esc_html__( 'Add link to icon box', 'amely' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'use_link_title',
			'value'      => array( esc_html__( 'Use link in title', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'use_text',
			'value'      => array( esc_html__( 'Use text instead of icon', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Text', 'amely' ),
			'param_name' => 'text',
			'dependency' => array(
				'element' => 'use_text',
				'value'   => 'yes',
			),
		),
	),
	// Extra class.
	array(
		Amely_VC::get_param( 'el_class' ),
	),
	// Icon.
	Amely_VC::icon_libraries( array( 'element' => 'use_text', 'value_not_equal_to' => 'yes' ) ),
	// Icon font-size.
	array(
		array(
			'group'      => esc_html__( 'Icon', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Font size', 'amely' ),
			'param_name' => 'icon_font_size',
			'value'      => 40,
			'min'        => 10,
			'suffix'     => 'px',
		),
	),
	array(
		array(
			'group'      => esc_html__( 'Icon', 'amely' ),
			'type'       => 'checkbox',
			'param_name' => 'with_bg',
			'value'      => array( esc_html__( 'Icon with background', 'amely' ) => 'yes' ),
		),
		array(
			'group'      => esc_html__( 'Icon', 'amely' ),
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Background shape', 'amely' ),
			'param_name' => 'bg_shape',
			'value'      => array(
				esc_html__( 'Square', 'amely' )          => 'square',
				esc_html__( 'Circle', 'amely' )          => 'circle',
				esc_html__( 'Rounded', 'amely' )         => 'rounded',
				esc_html__( 'Outline Square', 'amely' )  => 'outline-square',
				esc_html__( 'Outline Circle', 'amely' )  => 'outline-circle',
				esc_html__( 'Outline Rounded', 'amely' ) => 'outline-rounded',
			),
			'dependency' => array(
				'element' => 'with_bg',
				'value'   => 'yes',
			),
		),
	),
	// Color.
	array(
		array(
			'group'       => esc_html__( 'Color', 'amely' ),
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Title font color', 'amely' ),
			'param_name'  => 'title_font_color',
			'value'       => '#222222',
			'description' => esc_html__( 'Select title font color', 'amely' ),
		),
		array(
			'group'       => esc_html__( 'Color', 'amely' ),
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Description font color', 'amely' ),
			'param_name'  => 'content_font_color',
			'value'       => '#878787',
			'description' => esc_html__( 'Select description font color', 'amely' ),
		),
		array(
			'group'       => esc_html__( 'Color', 'amely' ),
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Link color', 'amely' ),
			'param_name'  => 'link_color',
			'value'       => '#878787',
			'description' => esc_html__( 'Select link color', 'amely' ),
		),
		array(
			'group'       => esc_html__( 'Color', 'amely' ),
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Icon color', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'icon_color',
			'value'       => amely_get_option( 'primary_color' ),
			'description' => esc_html__( 'Select icon color', 'amely' ),
		),
		array(
			'group'       => esc_html__( 'Color', 'amely' ),
			'type'        => 'colorpicker',
			'heading'     => esc_html__( 'Icon background color', 'amely' ),
			'param_name'  => 'icon_bgcolor',
			'value'       => amely_get_option( 'primary_color' ),
			'description' => esc_html__( 'Select icon background color', 'amely' ),
			'dependency'  => array(
				'element' => 'with_bg',
				'value'   => 'yes',
			),
		),
	),
	// Css box,
	array(
		Amely_VC::get_param( 'css' ),
	)
);

vc_map( array(
	'name'        => esc_html__( 'Icon Box', 'amely' ),
	'base'        => 'amely_icon_box',
	'icon'        => 'amely-element-icon-icon-box',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Eye catching icons from libraries', 'amely' ),
	'js_view'     => 'VcIconElementView_Backend',
	'params'      => $params,
) );
