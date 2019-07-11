<?php

/**
 * Amely Space shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Space extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts   = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$css    = '';
		$css_id = '#' . $css_id;

		$unit      = ( isset( $atts['unit'] ) && $atts['unit'] ) ? $atts['unit'] : 'px';
		$height    = ( isset( $atts['height'] ) && $atts['height'] ) ? $atts['height'] : 0;
		$height_lg = ( isset( $atts['height_lg'] ) && $atts['height_lg'] ) ? intval( $atts['height_lg'] ) : 0;
		$height_md = ( isset( $atts['height_md'] ) && $atts['height_md'] ) ? intval( $atts['height_md'] ) : 0;
		$height_sm = ( isset( $atts['height_sm'] ) && $atts['height_sm'] ) ? intval( $atts['height_sm'] ) : 0;
		$height_xs = ( isset( $atts['height_xs'] ) && $atts['height_xs'] ) ? intval( $atts['height_xs'] ) : 0;

		$css .= $css_id . '{height:' . $height . $unit . '}';

		$css .= '@media (max-width:1199px){' . $css_id . '{height:' . $height_lg . $unit . '}}';
		$css .= '@media (max-width:991px){' . $css_id . '{height:' . $height_md . $unit . '}}';
		$css .= '@media (max-width:767px){' . $css_id . '{height:' . $height_sm . $unit . '}}';
		$css .= '@media (max-width:543px){' . $css_id . '{height:' . $height_xs . $unit . '}}';

		$css = Amely_Helper::text2line( $css );

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

vc_map(
	array(
		'name'        => esc_html__( 'Responsive Empty Space', 'amely' ),
		'base'        => 'amely_space',
		'icon'        => 'amely-element-icon-space',
		'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
		'description' => esc_html__( 'Responsive blank space width custom height', 'amely' ),
		'params'      => array(
			array(
				'type'        => 'dropdown',
				'heading'     => esc_html__( 'Units', 'amely' ),
				'param_name'  => 'units',
				'admin_label' => true,
				'std'         => 'px',
				'value'       => array(
					esc_html__( 'px', 'amely' )  => 'px',
					esc_html__( 'em', 'amely' )  => 'em',
					esc_html__( 'rem', 'amely' ) => 'rem',
					esc_html__( 'ex', 'amely' )  => 'ex',
					esc_html__( 'cm', 'amely' )  => 'cm',
					esc_html__( 'mm', 'amely' )  => 'mm',
					esc_html__( 'in', 'amely' )  => 'in',
					esc_html__( 'pt', 'amely' )  => 'pt',
					esc_html__( 'pc', 'amely' )  => 'pc',
				),
			),
			array(
				'type'        => 'number',
				'heading'     => esc_html__( 'Height', 'amely' ),
				'description' => esc_html__( 'Extra large devices (large desktops)', 'amely' ),
				'admin_label' => true,
				'param_name'  => 'height',
			),
			array(
				'type'        => 'number',
				'heading'     => esc_html__( 'Large Devices Height', 'amely' ),
				'description' => esc_html__( 'Large devices (desktops, less than 1200px)', 'amely' ),
				'param_name'  => 'height_lg',
			),
			array(
				'type'        => 'number',
				'heading'     => esc_html__( 'Medium Devices Height', 'amely' ),
				'description' => esc_html__( 'Tablets, screen resolutions less than 992px', 'amely' ),
				'param_name'  => 'height_md',
			),
			array(
				'type'        => 'number',
				'heading'     => esc_html__( 'Small Devices Height', 'amely' ),
				'description' => esc_html__( 'Landscape phones, screen resolutions less than 768px.', 'amely' ),
				'param_name'  => 'height_sm',
			),
			array(
				'type'        => 'number',
				'heading'     => esc_html__( 'Extra Small Devices Height', 'amely' ),
				'description' => esc_html__( 'Portrait phones,screen resolutions less than 576px.', 'amely' ),
				'param_name'  => 'height_xs',
			),
			array(
				'type'        => 'textfield',
				'heading'     => esc_html__( 'Element ID', 'amely' ),
				'description' => sprintf( __( 'Enter element ID (Note: make sure it is unique and valid according to <a href="%s" target="_blank">w3c specification</a>).', 'amely' ), 'https://www.w3schools.com/tags/att_global_id.asp' ),
				'admin_label' => true,
				'param_name'  => 'id',
			),
			Amely_VC::get_param( 'el_class' ),
		)
	)
);
