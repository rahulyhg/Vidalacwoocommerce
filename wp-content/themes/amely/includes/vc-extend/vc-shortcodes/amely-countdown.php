<?php

/**
 * Amely Countdown Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Countdown extends WPBakeryShortCode {

	/**
	 * Defines fields names for google_fonts, font_container and etc
	 *
	 * @var array
	 */
	protected $fields = array(
		'digit_google_fonts' => 'digit_google_fonts',
		'unit_google_fonts'  => 'unit_google_fonts',
		'el_class'           => 'el_class',
		'css'                => 'css',
	);

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
	 * Get param value by providing key
	 *
	 * @param $key
	 *
	 * @return array|bool
	 */
	protected function getParamData( $key ) {
		return WPBMap::getParam( $this->shortcode, $this->getField( $key ) );
	}

	/**
	 * Parses shortcode attributes and set defaults based on vc_map function relative to shortcode and fields names
	 *
	 * @param $atts
	 * @param $is_unit_text
	 *
	 * @since 4.3
	 * @return array
	 */
	public function getAttributes( $atts, $is_unit_text = false ) {
		/**
		 * Shortcode attributes
		 *
		 * @var $digit_google_fonts
		 * @var $unit_google_fonts
		 * @var $el_class
		 * @var $css
		 */
		$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
		extract( $atts );

		/**
		 * Get default values from VC_MAP.
		 **/
		if ( ! $is_unit_text ) {
			$google_fonts_field = $this->getParamData( 'digit_google_fonts' );
		} else {
			$google_fonts_field = $this->getParamData( 'unit_google_fonts' );
		}

		$el_class                    = $this->getExtraClass( $el_class );
		$google_fonts_obj            = new Vc_Google_Fonts();
		$google_fonts_field_settings = isset( $google_fonts_field['settings'], $google_fonts_field['settings']['fields'] ) ? $google_fonts_field['settings']['fields'] : array();

		if ( ! $is_unit_text ) {
			$google_fonts_data = strlen( $digit_google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings,
				$digit_google_fonts ) : '';
		} else {
			$google_fonts_data = strlen( $unit_google_fonts ) > 0 ? $google_fonts_obj->_vc_google_fonts_parse_attributes( $google_fonts_field_settings,
				$unit_google_fonts ) : '';
		}

		$results = array(
			'google_fonts' => $digit_google_fonts,
			'el_class'     => $el_class,
			'css'          => $css,
		);

		if ( ! $is_unit_text ) {
			$results['google_fonts_data'] = $google_fonts_data;
		} else {
			$results['unit_google_fonts_data'] = $google_fonts_data;
		}

		return $results;
	}

	/**
	 * Parses google_fonts_data and font_container_data to get needed css styles to markup
	 *
	 * @param      $el_class
	 * @param      $css
	 * @param      $google_fonts_data
	 * @param      $atts
	 * @param bool $is_unit_text
	 *
	 * @return array
	 */
	public function getStyles( $el_class, $css, $google_fonts_data, $atts, $is_unit_text = false ) {
		$styles = array();

		if ( ( ! isset( $atts['use_theme_fonts'] ) || 'yes' !== $atts['use_theme_fonts'] || $is_unit_text ) && ! empty( $google_fonts_data ) && isset( $google_fonts_data['values'], $google_fonts_data['values']['font_family'], $google_fonts_data['values']['font_style'] ) ) {
			$google_fonts_family = explode( ':', $google_fonts_data['values']['font_family'] );
			$styles[]            = 'font-family:' . $google_fonts_family[0];
			$google_fonts_styles = explode( ':', $google_fonts_data['values']['font_style'] );
			$styles[]            = 'font-weight:' . $google_fonts_styles[1];
			$styles[]            = 'font-style:' . $google_fonts_styles[2];
		}

		$results = array(
			'styles' => $styles,
		);

		if ( isset( $atts['time_zone'] ) && 'user' == $atts['time_zone'] ) {
			$el_class .= ' user-timezone';
		}

		if ( ! $is_unit_text ) {

			$css_class = array(
				'tm-shortcode',
				'amely-countdown',
				$el_class,
				vc_shortcode_custom_css_class( $css ),
			);

			$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
				implode( ' ', $css_class ),
				$this->settings['base'],
				$atts );

			$results['css_class'] = trim( preg_replace( '/\s+/', ' ', $css_class ) );
		}

		return $results;
	}

	public function get_string_translation( $singular = true ) {
		$atts = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );

		$str_second_singular = isset( $atts['str_second_singular'] ) ? $atts['str_second_singular'] : '';
		$str_second_plural   = isset( $atts['str_second_plural'] ) ? $atts['str_second_plural'] : '';
		$str_minute_singular = isset( $atts['str_minute_singular'] ) ? $atts['str_minute_singular'] : '';
		$str_minute_plural   = isset( $atts['str_minute_plural'] ) ? $atts['str_minute_plural'] : '';
		$str_hour_singular   = isset( $atts['str_hour_singular'] ) ? $atts['str_hour_singular'] : '';
		$str_hour_plural     = isset( $atts['str_hour_plural'] ) ? $atts['str_hour_plural'] : '';
		$str_day_singular    = isset( $atts['str_day_singular'] ) ? $atts['str_day_singular'] : '';
		$str_day_plural      = isset( $atts['str_day_plural'] ) ? $atts['str_day_plural'] : '';
		$str_week_singular   = isset( $atts['str_week_singular'] ) ? $atts['str_week_singular'] : '';
		$str_week_plural     = isset( $atts['str_week_plural'] ) ? $atts['str_week_plural'] : '';
		$str_month_singular  = isset( $atts['str_month_singular'] ) ? $atts['str_month_singular'] : '';
		$str_month_plural    = isset( $atts['str_month_plural'] ) ? $atts['str_month_plural'] : '';
		$str_year_singular   = isset( $atts['str_year_singular'] ) ? $atts['str_year_singular'] : '';
		$str_year_plural     = isset( $atts['str_year_plural'] ) ? $atts['str_year_plural'] : '';

		$str = '';

		if ( $singular ) {
			$str .= $str_year_singular . ',' . $str_month_singular . ',' . $str_week_singular . ',' . $str_day_singular . ',' . $str_hour_singular . ',' . $str_minute_singular . ',' . $str_second_singular;
		} else {
			$str .= $str_year_plural . ',' . $str_month_plural . ',' . $str_week_plural . ',' . $str_day_plural . ',' . $str_hour_plural . ',' . $str_minute_plural . ',' . $str_second_plural;
		}

		return $str;
	}

	public function get_countdown_format() {
		$atts = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );

		$count_frmt = 'DHMS';

		if ( isset( $atts['countdown_opts'] ) && ! empty( $atts['countdown_opts'] ) ) {
			$countdown_opt = explode( ',', $atts['countdown_opts'] );

			if ( is_array( $countdown_opt ) ) {
				$count_frmt = '';

				foreach ( $countdown_opt as $opt ) {
					if ( $opt == 'syear' ) {
						$count_frmt .= 'Y';
					}
					if ( $opt == 'smonth' ) {
						$count_frmt .= 'O';
					}
					if ( $opt == 'sweek' ) {
						$count_frmt .= 'W';
					}
					if ( $opt == 'sday' ) {
						$count_frmt .= 'D';
					}
					if ( $opt == 'shr' ) {
						$count_frmt .= 'H';
					}
					if ( $opt == 'smin' ) {
						$count_frmt .= 'M';
					}
					if ( $opt == 'ssec' ) {
						$count_frmt .= 'S';
					}
				}
			}
		}

		return $count_frmt;
	}

	public function shortcode_css( $css_id ) {
		$atts   = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$css_id = '#' . $css_id;

		// Get digit text style
		extract( $this->getAttributes( $atts ) );
		extract( $this->getStyles( $el_class, $css, $google_fonts_data, $atts ) );

		if ( ! empty( $styles ) && $atts['use_theme_fonts_unit'] !== 'yes' ) {
			$style = esc_attr( implode( ';', $styles ) );
		} else {
			$style = '';
		}

		// Get unit text style.
		extract( $this->getAttributes( $atts, true ) );
		extract( $this->getStyles( $el_class, $css, $unit_google_fonts_data, $atts, true ) );

		if ( ! empty( $styles ) ) {
			$unit_text_style = esc_attr( implode( ';', $styles ) );
		} else {
			$unit_text_style = '';
		}

		$section_bg_color = $atts['section_bg_color'];
		$section_bd_color = $atts['section_bd_color'];

		$digit_color = $atts['digit_color'];

		$digit_font_size   = $atts['digit_font_size'];
		$digit_line_height = $atts['digit_line_height'];

		$unit_color       = $atts['unit_color'];
		$unit_font_size   = $atts['unit_font_size'];
		$unit_line_height = $atts['unit_line_height'];

		$css = '';

		$countdown_section = $css_id . ' .countdown-section';

		if ( $section_bg_color || $section_bd_color ) {

			$css .= $countdown_section . '{';

			if ( $section_bg_color ) {
				$css .= 'background-color:' . $section_bg_color . ';';
			}

			if ( $section_bd_color ) {
				$css .= 'border-color:' . $section_bd_color . ';';
			}

			$css .= '}';
		}

		$countdown_amount = $css_id . ' .countdown-amount';
		$css              .= $countdown_amount . '{' . 'color:' . $digit_color . ';';

		$css .= $style . '}';

		$css .= $countdown_amount . '{' . 'font-size:' . $digit_font_size . 'px;' . 'line-height:' . $digit_line_height . 'px;}';


		$countdown_period = $css_id . ' .countdown-period';
		$css              .= $css_id . ' .countdown-period {' . 'color:' . $unit_color . ';' . $unit_text_style . '}';

		$css .= $countdown_period . '{' . 'font-size:' . $unit_font_size . 'px;' . 'line-height:' . $unit_line_height . 'px;}';

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

vc_map( array(
	'name'        => esc_html__( 'Countdown', 'amely' ),
	'base'        => 'amely_countdown',
	'icon'        => 'amely-element-icon-countdown',
	'description' => esc_html__( 'Countdown timer', 'amely' ),
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'      => array(
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Background color', 'amely' ),
			'param_name' => 'section_bg_color',
			'value'      => '#fff',
		),
		array(
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Border color', 'amely' ),
			'param_name' => 'section_bd_color',
			'value'      => '#eee',
		),
		array(
			'type'        => 'datetimepicker',
			'heading'     => esc_html__( 'Target time for Countdown', 'amely' ),
			'param_name'  => 'datetime',
			'admin_label' => true,
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Countdown timer depends on', 'amely' ),
			'param_name' => 'time_zone',
			'value'      => array(
				esc_html__( 'WordPress Defined Timezone', 'amely' ) => 'wp',
				__( 'User\'s System Timezone', 'amely' )            => 'user',
			),
		),
		array(
			'type'       => 'checkbox',
			'heading'    => esc_html__( 'Select time units to display in countdown timer', 'amely' ),
			'param_name' => 'countdown_opts',
			'value'      => array(
				esc_html__( 'Years', 'amely' )   => 'syear',
				esc_html__( 'Months', 'amely' )  => 'smonth',
				esc_html__( 'Weeks', 'amely' )   => 'sweek',
				esc_html__( 'Days', 'amely' )    => 'sday',
				esc_html__( 'Hours', 'amely' )   => 'shr',
				esc_html__( 'Minutes', 'amely' ) => 'smin',
				esc_html__( 'Seconds', 'amely' ) => 'ssec',
			),
		),
		Amely_VC::get_param( 'el_class' ),
		// Digit.
		array(
			'group'      => esc_html__( 'Digit', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text color', 'amely' ),
			'param_name' => 'digit_color',
			'value'      => '#202020',
		),
		array(
			'group'      => esc_html__( 'Digit', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Font size', 'amely' ),
			'param_name' => 'digit_font_size',
			'min'        => 10,
			'suffix'     => 'px',
			'value'      => 48,
		),
		array(
			'group'      => esc_html__( 'Digit', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Line height', 'amely' ),
			'param_name' => 'digit_line_height',
			'min'        => 10,
			'suffix'     => 'px',
			'value'      => 42,
		),
		array(
			'group'       => esc_html__( 'Digit', 'amely' ),
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Use theme default font family?', 'amely' ),
			'param_name'  => 'use_theme_fonts',
			'value'       => array( esc_html__( 'Yes', 'amely' ) => 'yes' ),
			'description' => esc_html__( 'Use font family from the theme.', 'amely' ),
			'std'         => 'yes',
		),
		array(
			'group'      => esc_html__( 'Digit', 'amely' ),
			'type'       => 'google_fonts',
			'param_name' => 'digit_google_fonts',
			'value'      => 'font_family:' . rawurlencode( 'Source Sans Pro:200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900,900italic' ) . '|font_style:' . rawurlencode( '700 bold regular:700:normal' ),
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
		// Unit.
		array(
			'group'      => esc_html__( 'Unit', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Text color', 'amely' ),
			'param_name' => 'unit_color',
			'value'      => '#202020',
		),
		array(
			'group'      => esc_html__( 'Unit', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Font size', 'amely' ),
			'param_name' => 'unit_font_size',
			'min'        => 10,
			'suffix'     => 'px',
			'value'      => 16,
		),
		array(
			'group'      => esc_html__( 'Unit', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Line height', 'amely' ),
			'param_name' => 'unit_line_height',
			'min'        => 10,
			'suffix'     => 'px',
			'value'      => 16,
		),
		array(
			'group'       => esc_html__( 'Unit', 'amely' ),
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Use theme default font family?', 'amely' ),
			'param_name'  => 'use_theme_fonts_unit',
			'value'       => array( esc_html__( 'Yes', 'amely' ) => 'yes' ),
			'description' => esc_html__( 'Use font family from the theme.', 'amely' ),
			'std'         => 'yes',
		),
		array(
			'group'      => esc_html__( 'Unit', 'amely' ),
			'type'       => 'google_fonts',
			'param_name' => 'unit_google_fonts',
			'value'      => 'font_family:' . rawurlencode( 'Source Sans Pro:200,200italic,300,300italic,regular,italic,600,600italic,700,700italic,900,900italic' ) . '|font_style:' . rawurlencode( '600 bold regular:600:normal' ),
			'settings'   => array(
				'fields' => array(
					'font_family_description' => esc_html__( 'Select font family.', 'amely' ),
					'font_style_description'  => esc_html__( 'Select font styling.', 'amely' ),
				),
			),
			'dependency' => array(
				'element'            => 'use_theme_fonts_unit',
				'value_not_equal_to' => 'yes',
			),
		),
		// String translation.
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Second (Singular)', 'amely' ),
			'param_name' => 'str_second_singular',
			'value'      => esc_html__( 'Second', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Seconds (Plural)', 'amely' ),
			'param_name' => 'str_second_plural',
			'value'      => esc_html__( 'Seconds', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Minute (Singular)', 'amely' ),
			'param_name' => 'str_minute_singular',
			'value'      => esc_html__( 'Minute', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Minutes (Plural)', 'amely' ),
			'param_name' => 'str_minute_plural',
			'value'      => esc_html__( 'Minutes', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Hour (Singular)', 'amely' ),
			'param_name' => 'str_hour_singular',
			'value'      => esc_html__( 'Hour', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Hours (Plural)', 'amely' ),
			'param_name' => 'str_hour_plural',
			'value'      => esc_html__( 'Hours', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Day (Singular)', 'amely' ),
			'param_name' => 'str_day_singular',
			'value'      => esc_html__( 'Day', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Days (Plural)', 'amely' ),
			'param_name' => 'str_day_plural',
			'value'      => esc_html__( 'Days', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Week (Singular)', 'amely' ),
			'param_name' => 'str_week_singular',
			'value'      => esc_html__( 'Week', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Weeks (Plural)', 'amely' ),
			'param_name' => 'str_week_plural',
			'value'      => esc_html__( 'Weeks', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Month (Singular)', 'amely' ),
			'param_name' => 'str_month_singular',
			'value'      => esc_html__( 'Month', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Months (Plural)', 'amely' ),
			'param_name' => 'str_month_plural',
			'value'      => esc_html__( 'Months', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Year (Singular)', 'amely' ),
			'param_name' => 'str_year_singular',
			'value'      => esc_html__( 'Year', 'amely' ),
		),
		array(
			'group'      => esc_html__( 'String Translation', 'amely' ),
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Years (Plural)', 'amely' ),
			'param_name' => 'str_year_plural',
			'value'      => esc_html__( 'Years', 'amely' ),
		),
		Amely_VC::get_param( 'css' ),
	),
) );
