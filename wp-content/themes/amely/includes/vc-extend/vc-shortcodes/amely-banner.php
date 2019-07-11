<?php

/**
 * ThemeMove Banner Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Banner extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts  = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$cssID = '#' . $css_id;
		$css   = '';

		$color_desc = $atts['color_desc'] ? $atts['color_desc'] : SECONDARY_COLOR;

		$button_style        = $atts['button_style'] ? $atts['button_style'] : '';
		$button_color        = $atts['button_color'] ? $atts['button_color'] : '#ffffff';
		$button_bg_color     = $atts['button_bg_color'] ? $atts['button_bg_color'] : SECONDARY_COLOR;
		$button_border_color = $atts['button_border_color'] ? $atts['button_border_color'] : SECONDARY_COLOR;

		$button_color_hover        = $atts['button_color_hover'] ? $atts['button_color_hover'] : '#ffffff';
		$button_bg_color_hover     = $atts['button_bg_color_hover'] ? $atts['button_bg_color_hover'] : PRIMARY_COLOR;
		$button_border_color_hover = $atts['button_border_color_hover'] ? $atts['button_border_color_hover'] : PRIMARY_COLOR;

		$css .= $cssID . ' .banner-desc{color:' . $color_desc . '}';
		if ( $button_style == 'link' ) {
			$css .= $cssID . ' .banner-button{color:' . $button_color . ';}';
			$css .= $cssID . ' .banner-button:after{background-color:' . $button_color . ';}';
			$css .= $cssID . ':hover .banner-button{color:' . $button_color_hover . ';}';
			$css .= $cssID . ':hover .banner-button:after{background-color:' . $button_bg_color_hover . ';}';
		}

		if ( $button_style == 'custom' ) {
			$css .= $cssID . ' .banner-button{color:' . $button_color . ';background-color:' . $button_bg_color . ';border-color:' . $button_border_color . ';}';
			$css .= $cssID . ':hover .banner-button{color:' . $button_color_hover . ';background-color:' . $button_bg_color_hover . ';border-color:' . $button_border_color_hover . ';}';
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= Amely_Helper::text2line( $css );
	}

	/**
	 * Defines fields names for google_fonts, font_container and etc
	 *
	 * @since 4.4
	 * @var array
	 */
	protected $fields = array(
		'google_fonts' => 'google_fonts',
		'el_class'     => 'el_class',
		'css'          => 'css',
		'text'         => 'text',
	);

	/**
	 * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
	 *
	 * @param $atts
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getAttributes( $atts, $line = 'first' ) {
		/**
		 * Shortcode attributes
		 *
		 * @var $google_fonts_1
		 * @var $google_fonts_2
		 * @var $el_class
		 * @var $css
		 */
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		extract( $atts );

		/**
		 * Get default values from VC_MAP.
		 **/
		$google_fonts_field = $this->getParamData( 'google_fonts' );

		$el_class                    = $this->getExtraClass( $el_class );
		$google_fonts_obj            = new Vc_Google_Fonts();
		$google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();

		$google_fonts_data = strlen( $google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings,
			$google_fonts ) : '';

		return array(
			'google_fonts_data' => $google_fonts_data,
			'google_fonts'      => $google_fonts,
			'el_class'          => $el_class,
			'css'               => $css,
		);
	}

	/**
	 * Get param value by providing key
	 *
	 * @param $key
	 *
	 * @since 4.4
	 * @return array|bool
	 */
	protected function getParamData( $key ) {
		return WPBMap::getParam( $this->shortcode, $this->getField( $key ) );
	}

	/**
	 * Used to get field name in vc_map function for google_fonts, font_container and etc..
	 *
	 * @param $key
	 *
	 * @since 4.4
	 * @return bool
	 */
	protected function getField( $key ) {
		return isset( $this->fields[ $key ] ) ? $this->fields[ $key ] : false;
	}

	/**
	 * Parses google_fonts_data to get needed css styles to markup
	 *
	 * @param $el_class
	 * @param $css
	 * @param $google_fonts_data
	 * @param $atts
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getStyles( $el_class, $css, $google_fonts_data, $atts ) {
		$styles = array();

		if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
			$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
			$styles[]            = 'font-family:' . $google_fonts_family[0];
			$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
			if ( is_array( $google_fonts_styles ) ) {
				$styles[] = 'font-weight:' . $google_fonts_styles[1];
				$styles[] = 'font-style:' . $google_fonts_styles[2];
			}

		}

		if ( isset( $atts['font_size'] ) ) {
			$styles[] = 'font-size:' . $atts['font_size'] . 'px;';
		}

		if ( isset( $atts['line_height'] ) ) {
			$styles[] = 'line-height:' . $atts['line_height'];
		}

		if ( isset( $atts['color_content'] ) && $atts['color_content'] ) {
			$styles[] = 'color:' . $atts['color_content'];
		}

		$css_class = array(
			'tm-shortcode',
			'amely-banner',
			'hover-' . $atts['hover_style'],
			'text-position-' . $atts['text_position'],
			'button-visible-' . $atts['button_visibility'],
			$this->getCSSAnimation( $atts['animation'] ),
			$el_class,
			vc_shortcode_custom_css_class( $css ),
		);

		$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
			implode( ' ', $css_class ),
			$this->settings['base'],
			$atts );

		return array(
			'css_class' => trim( preg_replace( '/\s+/', ' ', $css_class ) ),
			'styles'    => $styles,
		);
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
			$output       .= '<input type="hidden" class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . '" name="' . $param_name . '" value="' . $value . '" />';
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
	'name'        => esc_html__( 'Banner', 'amely' ),
	'description' => esc_html__( 'Banner image for promotion', 'amely' ),
	'base'        => 'amely_banner',
	'icon'        => 'amely-element-icon-banner',
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
		array(
			'heading'    => esc_html__( 'Banner Link', 'amely' ),
			'type'       => 'vc_link',
			'param_name' => 'link',
		),
		array(
			'heading'     => esc_html__( 'Banner Description', 'amely' ),
			'description' => esc_html__( 'A short text display before the banner text', 'amely' ),
			'type'        => 'textfield',
			'param_name'  => 'desc',
		),
		array(
			'heading'     => esc_html__( 'Banner Text', 'amely' ),
			'description' => esc_html__( 'Enter the banner text', 'amely' ),
			'type'        => 'textarea_html',
			'param_name'  => 'content',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Text Position', 'amely' ),
			'description' => esc_html__( 'Select the text position for content.', 'amely' ),
			'param_name'  => 'text_position',
			'value'       => array(
				esc_html__( 'Left', 'amely' )   => 'left',
				esc_html__( 'Center', 'amely' ) => 'center',
				esc_html__( 'Right', 'amely' )  => 'right',
			),
			'std'         => 'center',
		),
		Amely_VC::get_param( 'el_class' ),

		// Font
		array(
			'group'      => esc_html__( 'Font', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Font size', 'amely' ),
			'param_name' => 'font_size',
			'value'      => 24,
			'min'        => 16,
			'max'        => 50,
			'step'       => 1,
			'suffix'     => 'px',
		),
		array(
			'group'      => esc_html__( 'Font', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Line height', 'amely' ),
			'param_name' => 'line_height',
			'value'      => '36px',
		),
		array(
			'group'      => esc_html__( 'Font', 'amely' ),
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Use theme default font family?', 'amely' ),
			'param_name' => 'use_theme_fonts',
			'value'      => array( esc_html__( 'Yes', 'amely' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'group'      => esc_html__( 'Font', 'amely' ),
			'type'       => 'google_fonts',
			'param_name' => 'google_fonts',
			'value'      => 'font_family:' . rawurlencode( 'Poppins:300,regular,500,600,700' ) . '|font_style:' . rawurlencode( '300,regular,500,600,700' ),
			'settings'   => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select font family.', 'amely' ),
					'font_style_description'  => esc_html__( 'Select font styling.', 'amely' ),
				),
			),
			'dependency' => array(
				'element'            => 'use_theme_fonts',
				'value_not_equal_to' => 'yes',
			),
		),

		// Button
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'heading'     => esc_html__( 'Button Text', 'amely' ),
			'description' => esc_html__( 'Enter button text', 'amely' ),
			'type'        => 'textfield',
			'param_name'  => 'button_text',
		),
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'heading'     => esc_html__( 'Button Visibility', 'amely' ),
			'description' => esc_html__( 'Select button visibility', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'button_visibility',
			'value'       => array(
				esc_html__( 'Always visible', 'amely' ) => 'always',
				esc_html__( 'When hover', 'amely' )     => 'hover',
				esc_html__( 'Hidden', 'amely' )         => 'hidden',
			),
		),
		array(
			'group'       => esc_html__( 'Button', 'amely' ),
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Button Style', 'amely' ),
			'param_name'  => 'button_style',
			'value'       => array(
				esc_html__( 'Default', 'amely' )     => '',
				esc_html__( 'Alternative', 'amely' ) => 'alt',
				esc_html__( 'Link', 'amely' )        => 'link',
				esc_html__( 'Custom', 'amely' )      => 'custom',
			),
			'description' => esc_html__( 'Select button style.', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'Button', 'amely' ),
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
			'group'      => esc_html__( 'Button', 'amely' ),
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
			'group'      => esc_html__( 'Button', 'amely' ),
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
			'group'      => esc_html__( 'Button', 'amely' ),
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
			'group'      => esc_html__( 'Button', 'amely' ),
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
			'group'      => esc_html__( 'Button', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border Color (on hover)', 'amely' ),
			'param_name' => 'button_border_color_hover',
			'value'      => amely_get_option( 'primary_color' ),
			'dependency' => array(
				'element' => 'button_style',
				'value'   => 'custom',
			),
		),

		// Color
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Description Color', 'amely' ),
			'param_name' => 'color_desc',
			'value'      => '#333333',
		),
		array(
			'group'      => esc_html__( 'Color', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Banner Text Color', 'amely' ),
			'param_name' => 'color_content',
			'value'      => '#333333',
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
