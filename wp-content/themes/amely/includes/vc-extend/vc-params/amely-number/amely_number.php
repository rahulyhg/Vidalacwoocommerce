<?php
/**
 * Class Amely_Number
 *
 * @package Amely
 */

/*
 * Example
    array(
        'type'       => 'number',
        'heading'    => esc_html__( 'Number field', 'amely' ),
        'param_name' => 'number_field',
        'value'      => 100,
        'min'        => 10,
        'max'        => 100,
        'step'       => 1,
        'suffix'     => 'px',
    ),
*/
if ( ! class_exists( 'Amely_Number' ) ) {

	class Amely_Number {

		public function __construct() {

			if ( class_exists( 'WpbakeryShortcodeParams' ) ) {
				WpbakeryShortcodeParams::addField( 'number', array(
					$this,
					'render',
				), AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-number/amely_number.js' );
			}
		}

		public function render( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$min        = isset( $settings['min'] ) ? $settings['min'] : '';
			$max        = isset( $settings['max'] ) ? $settings['max'] : '';
			$step       = isset( $settings['step'] ) ? $settings['step'] : '';
			$suffix     = isset( $settings['suffix'] ) ? $settings['suffix'] : '';

			$output = '<div class="tm_number">';
			$output .= '<input type="button" value="-" class="minus" />';
			$output .= '<input type="number" min="' . esc_attr( $min ) . '"' . ' max="' . esc_attr( $max ) . '"' . ' step="' . esc_attr( $step ) . '"' . ' class="wpb_vc_param_value ' . esc_attr( $param_name ) . '"' . ' name="' . esc_attr( $param_name ) . '"' . ' value="' . esc_attr( $value ) . '" />';
			$output .= '<input type="button" value="+" class="plus" />' . '<span>' . $suffix . '</span>';
			$output .= '</div>';

			return $output;
		}
	}

	new Amely_Number();
}
