<?php

if ( ! class_exists( 'Amely_Social_Links' ) ) {
	/**
	 * Class Amely_Social_Links
	 *
	 * @package Amely
	 */
	class Amely_Social_Links {

		private $value = '';

		private $social_networks = array();

		public function __construct() {

			$this->social_networks = Amely_Helper::social_icons();

			WpbakeryShortcodeParams::addField( 'social_links', array(
				$this,
				'render',
			), AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-social-links/amely_social_links.js' );
		}

		/**
		 * @return array
		 */
		private function getData() {
			$data     = preg_split( '/\s+/', $this->value );
			$data_arr = array();

			foreach ( $data as $d ) {
				$pieces = explode( '|', $d );
				if ( count( $pieces ) == 2 ) {
					$key              = $pieces[0];
					$link             = $pieces[1];
					$data_arr[ $key ] = $link;
				}
			}

			return $data_arr;
		}

		private function getLink( $key ) {
			$link_arr = $this->getData();
			foreach ( $link_arr as $key1 => $link ) {
				if ( $key == $key1 ) {
					return $link;
				}
			}

			return '';
		}

		/**
		 * Render HTML
		 *
		 * @param $settings
		 * @param $value
		 *
		 * @return string
		 */
		public function render( $settings, $value ) {

			$this->value = $value;

			$html = '';
			$html .= '<div class="tm-social_links" data-social-links="true">
              <input name="' . esc_attr( $settings['param_name'] ) . '" class="wpb_vc_param_value ' . esc_attr( $settings['param_name'] ) . ' ' . esc_attr( $settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $value ) . '"/>
             <table class="vc_table tm-table tm-social-links-table">
              <tr data-social="">
                <th>' . esc_html__( 'Social Network', 'amely' ) . '</th>
                <th>' . esc_html__( 'Link', 'amely' ) . '</th>
              </tr>
            ';
			foreach ( $this->social_networks as $key => $social ) {
				$html .= '
            <tr data-social="' . $key . '">
                <td class="tm-social tm-social--' . $key . '">
                    <label><span><i class="fa fa-' . $key . '"></i>&nbsp;' . $social . '</span></label>
                </td>
                <td>
                    <input type="text" name="' . $key . '" class="social_links_field" value="' . $this->getLink( $key ) . '' . '">
                </td>
            </tr>';
			}

			$html .= '</table></div>';

			return $html;
		}
	}

	new Amely_Social_Links();
}
