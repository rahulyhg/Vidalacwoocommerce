<?php

/**
 * ThemeMove Banner Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Banner2 extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;
		$css   = '';

		$buttons = vc_param_group_parse_atts( $atts['buttons'] );

		foreach ( (array) $buttons as $index => $button ) {

			if ( $button ) {

				$index ++;

				if ( isset( $button['button_style'] ) && $button['button_style'] == 'link' ) {
					$css .= $cssID . ' .banner-button-' . $index . '{color:' . $button['button_color'] . '}';
					$css .= $cssID . ' .banner-button-' . $index . ':after{background-color:' . $button['button_color'] . '}';
					$css .= $cssID . ':hover .banner-button-' . $index . '{color:' . $button['button_color_hover'] . '}';
					$css .= $cssID . ':hover .banner-button-' . $index . ':after{background-color:' . $button['button_color_hover'] . '}';

				}

				if ( isset( $button['button_style'] ) && $button['button_style'] == 'custom' ) {
					$css .= $cssID . ' .banner-button-' . $index . '{';
					$css .= 'color:' . $button['button_color'] . ';';
					$css .= 'background-color:' . $button['button_bg_color'] . ';';
					$css .= 'border-color:' . $button['button_border_color'] . ';';
					$css .= '}';

					$css .= $cssID . ' .banner-button-' . $index . ':hover{';
					$css .= 'color:' . $button['button_color_hover'] . ';';
					$css .= 'background-color:' . $button['button_bg_color_hover'] . ';';
					$css .= 'border-color:' . $button['button_border_color_hover'] . ';';
					$css .= '}';
				}
			}
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= Amely_Helper::text2line( $css );
	}

	/**
	 *
	 * Custom title in backend, show image instead of icon
	 *
	 * @param $param
	 * @param $value
	 *
	 * @return string
	 */
	public function singleParamHtmlHolder( $param, $value ) {

		$output = '';

		$param_name = isset( $param['param_name'] ) ? $param['param_name'] : '';
		$type       = isset( $param['type'] ) ? $param['type'] : '';
		$class      = isset( $param['class'] ) ? $param['class'] : '';

		if ( 'attach_image' === $param['type'] && 'image' === $param_name ) {
			$output .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
			$element_icon = $this->settings( 'icon' );
			$img          = wpb_getImageBySize( array(
				'attach_id'  => (int) preg_replace( '/[^\d]/', '', $value ),
				'thumb_size' => 'thumbnail',
				'class'      => 'attachment-thumbnail vc_general vc_element-icon tm-element-icon-none',
			) );
			$this->setSettings( 'logo',
				( $img ? $img['thumbnail'] : '<img width="150" height="150" src="' . vc_asset_url( 'vc/blank.gif' ) . '" class="attachment-thumbnail vc_general vc_element-icon amely-element-icon-banner"  data-name="' . $param_name . '" alt="" title="" style="display: none;" />' ) . '<span class="no_image_image vc_element-icon' . ( ! empty( $element_icon ) ? ' ' . $element_icon : '' ) . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '" /><a href="#" class="column_edit_trigger' . ( $img && ! empty( $img['p_img_large'][0] ) ? ' image-exists' : '' ) . '">' . esc_html__( 'Add image',
					'amely' ) . '</a>' );
			$output .= $this->outputCustomTitle( $this->settings['name'] );
		} elseif ( ! empty( $param['holder'] ) ) {
			if ( 'input' === $param['holder'] ) {
				$output .= '<' . $param['holder'] . ' readonly="true" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '">';
			} elseif ( in_array( $param['holder'],
				array(
					'img',
					'iframe',
				) ) ) {
				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" src="' . $value . '">';
			} elseif ( 'hidden' !== $param['holder'] ) {
				$output .= '<' . $param['holder'] . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '">' . $value . '</' . $param['holder'] . '>';
			}
		}

		if ( ! empty( $param['admin_label'] ) && true === $param['admin_label'] ) {
			$output .= '<span class="vc_admin_label admin_label_' . $param['param_name'] . ( empty( $value ) ? ' hidden-label' : '' ) . '"><label>' . $param['heading'] . '</label>: ' . $value . '</span>';
		}

		return $output;
	}

	protected function outputTitle( $title ) {
		return '';
	}

	protected function outputCustomTitle( $title ) {
		return '<h4 class="wpb_element_title">' . $title . ' ' . $this->settings( 'logo' ) . '</h4>';
	}
}

vc_map( array(
	'name'        => esc_html__( 'Banner2', 'amely' ),
	'description' => esc_html__( 'Simple banner that supports multiple buttons', 'amely' ),
	'base'        => 'amely_banner2',
	'icon'        => 'amely-element-icon-banner2',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'      => array(

		// General
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Image Source', 'amely' ),
			'param_name'  => 'source',
			'value'       => array(
				esc_html__( 'Media library', 'amely' ) => 'media_library',
				esc_html__( 'External link', 'amely' ) => 'external_link',
			),
			'std'         => 'media_library',
			'description' => esc_html__( 'Select image source.', 'amely' ),
		),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Banner Image', 'amely' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select an image from media library.', 'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => 'media_library',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'External Link', 'amely' ),
			'param_name'  => 'custom_src',
			'description' => esc_html__( 'Select external link.', 'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => 'external_link',
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image Size (Optional)', 'amely' ),
			'param_name'  => 'img_size',
			'value'       => 'full',
			'description' => esc_html__( 'Enter image size (Example: "thumbnail", "medium", "large", "full" or other sizes defined by theme). Alternatively enter size in pixels (Example: 200x100 (Width x Height)).',
				'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => array( 'media_library' ),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Image Size (Optional)', 'amely' ),
			'param_name'  => 'external_img_size',
			'value'       => '',
			'description' => esc_html__( 'Enter image size in pixels. Example: 200x100 (Width x Height).',
				'amely' ),
			'dependency'  => array(
				'element' => 'source',
				'value'   => 'external_link',
			),
		),

		Amely_VC::get_param( 'el_class' ),

		// Button
		array(
			'group'       => esc_html__( 'Buttons', 'amely' ),
			'heading'     => esc_html__( 'Buttons', 'amely' ),
			'description' => esc_html__( 'Enter link and label for buttons.', 'amely' ),
			'type'        => 'param_group',
			'param_name'  => 'buttons',
			'params'      => array(
				array(
					'heading'     => esc_html__( 'Button Text', 'amely' ),
					'type'        => 'textfield',
					'param_name'  => 'text',
					'admin_label' => true,
				),
				array(
					'heading'    => esc_html__( 'Button Link', 'amely' ),
					'type'       => 'vc_link',
					'param_name' => 'link',
				),
				array(
					'group'       => esc_html__( 'Buttons', 'amely' ),
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Button Style', 'amely' ),
					'param_name'  => 'button_style',
					'admin_label' => true,
					'value'       => array(
						esc_html__( 'Default', 'amely' )     => '',
						esc_html__( 'Alternative', 'amely' ) => 'alt',
						esc_html__( 'Link', 'amely' )        => 'link',
						esc_html__( 'Custom', 'amely' )      => 'custom',
					),
					'description' => esc_html__( 'Select button style.', 'amely' ),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Text Color', 'amely' ),
					'param_name' => 'button_color',
					'value'      => '#fff',
					'dependency' => array(
						'element' => 'button_style',
						'value'   => array( 'custom', 'link' ),
					),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Text Color (on hover)', 'amely' ),
					'param_name' => 'button_color_hover',
					'value'      => '#fff',
					'dependency' => array(
						'element' => 'button_style',
						'value'   => array( 'custom', 'link' ),
					),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Background Color', 'amely' ),
					'param_name' => 'button_bg_color',
					'value'      => amely_get_option( 'secondary_color' ),
					'dependency' => array(
						'element' => 'button_style',
						'value'   => 'custom',
					),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Background Color (on hover)', 'amely' ),
					'param_name' => 'button_bg_color_hover',
					'value'      => amely_get_option( 'primary_color' ),
					'dependency' => array(
						'element' => 'button_style',
						'value'   => 'custom',
					),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Border Color', 'amely' ),
					'param_name' => 'button_border_color',
					'value'      => amely_get_option( 'secondary_color' ),
					'dependency' => array(
						'element' => 'button_style',
						'value'   => 'custom',
					),
				),
				array(
					'group'      => esc_html__( 'Buttons', 'amely' ),
					'type'       => 'colorpicker',
					'heading'    => esc_html__( 'Border Color (on hover)', 'amely' ),
					'param_name' => 'button_border_color_hover',
					'value'      => amely_get_option( 'primary_color' ),
					'dependency' => array(
						'element' => 'button_style',
						'value'   => 'custom',
					),
				),
			),
		),

		// Animation
		array(
			'group'       => esc_html__( 'Animation', 'amely' ),
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Banner Hover Effect', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'hover_style',
			'value'       => array(
				esc_html__( 'none', 'amely' )          => '',
				esc_html__( 'Zoom in', 'amely' )       => 'zoom-in',
				esc_html__( 'Blur', 'amely' )          => 'blur',
				esc_html__( 'Gray scale', 'amely' )    => 'grayscale',
				esc_html__( 'White Overlay', 'amely' ) => 'white-overlay',
				esc_html__( 'Black Overlay', 'amely' ) => 'black-overlay',
			),
			'std'         => 'zoom-in',
			'description' => esc_html__( 'Select animation style for banner when mouse over. Note: Some styles only work in modern browsers',
				'amely' ),
		),
		array(
			'group'      => esc_html__( 'Animation', 'amely' ),
			'type'       => 'animation_style',
			'heading'    => esc_html__( 'Banner Animation', 'amely' ),
			'param_name' => 'animation',
			'settings'   => array(
				'type' => array( 'in', 'other' ),
			),
		),

		Amely_VC::get_param( 'css' ),

	),
) );
