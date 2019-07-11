<?php

/**
 * Amely Google Maps Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Gmaps extends WPBakeryShortCode {

	public function convertAttributesToNewMarker( $atts ) {
		if ( isset( $atts['markers'] ) && strlen( $atts['markers'] ) > 0 ) {
			$markers = vc_param_group_parse_atts( $atts['markers'] );

			if ( ! is_array( $markers ) ) {
				$temp         = explode( ',', $atts['markers'] );
				$paramMarkers = array();

				foreach ( $temp as $marker ) {
					$data = explode( '|', $marker );

					$newMarker            = array();
					$newMarker['address'] = isset( $data[0] ) ? $data[0] : '';
					$newMarker['icon']    = isset( $data[1] ) ? $data[1] : '';
					$newMarker['info']    = isset( $data[2] ) ? $data[2] : '';

					$paramMarkers[] = $newMarker;
				}

				$atts['markers'] = urlencode( json_encode( $paramMarkers ) );

			}

			return $atts;
		}
	}
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Google Maps', 'amely' ),
	'base'        => 'amely_gmaps',
	'icon'        => 'amely-element-icon-gmaps',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Map block', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Height', 'amely' ),
			'param_name'  => 'map_height',
			'value'       => '500',
			'description' => esc_html__( 'Enter map height (in pixels or %)', 'amely' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Width', 'amely' ),
			'param_name'  => 'map_width',
			'value'       => '100%',
			'description' => esc_html__( 'Enter map width (in pixels or %)', 'amely' ),
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Zoom level', 'amely' ),
			'param_name'  => 'zoom_lvl',
			'value'       => 16,
			'max'         => 17,
			'min'         => 0,
			'description' => esc_html__( 'Map zoom level', 'amely' ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'scroll_whell',
			'value'      => array(
				esc_html__( 'Enable mouse scroll wheel zoom', 'amely' ) => 'yes',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Map type', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'map_type',
			'description' => esc_html__( 'Choose a map type', 'amely' ),
			'value'       => array(
				'Roadmap'   => 'ROADMAP',
				'Satellite' => 'SATELLITE',
				'Hybrid'    => 'HYBRID',
				'Terrain'   => 'TERRAIN',
			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Map style', 'amely' ),
			'admin_label' => true,
			'param_name'  => 'map_style',
			'description' => esc_html__( 'Choose a map style. This approach changes the style of the Roadmap types (base imagery in terrain and satellite views is not affected, but roads, labels, etc. respect styling rules)', 'amely' ),
			'value'       => array(
				'Default'          => 'default',
				'Grayscale'        => 'style1',
				'Subtle Grayscale' => 'style2',
				'Apple Maps-esque' => 'style3',
				'Pale Dawn'        => 'style4',
				'Muted Blue'       => 'style5',
				'Paper'            => 'style6',
				'Light Dream'      => 'style7',
				'Retro'            => 'style8',
				'Avocado World'    => 'style9',
				'Facebook'         => 'style10',
				'Custom'           => 'custom',
			),
		),
		array(
			'type'        => 'textarea_raw_html',
			'heading'     => esc_html__( 'Map style snippet', 'amely' ),
			'param_name'  => 'map_style_snippet',
			'description' => sprintf( wp_kses( __( 'To get the style snippet, visit <a href="%s" target="_blank">Sanzzymaps</a> or <a href="%s" target="_blank">Mapstylr</a>.', 'amely' ),
				array(
					'a' => array(
						'href'   => array(),
						'target' => array(),
					)
				) ), esc_url( 'https://sanzzymaps.com/' ), esc_url( 'http://www.mapstylr.com/' )
			),
			'dependency'  => array(
				'element' => 'map_style',
				'value'   => 'custom',
			),
		),
		array(
			'group'       => esc_html__( 'Markers', 'amely' ),
			'type'        => 'param_group',
			'heading'     => esc_html__( 'Markers', 'amely' ),
			'param_name'  => 'markers',
			'description' => esc_html__( 'You can add multiple markers to the map', 'amely' ),
			'value'       => urlencode( json_encode( array(
				array(
					'address' => '40.7590615,-73.969231',
				),
			) ) ),
			'params'      => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Address or Coordinate', 'amely' ),
					'param_name'  => 'address',
					'admin_label' => true,
					'description' => sprintf( wp_kses( __( 'Enter address or coordinate. Find coordinates using the name and/or address of the place using <a href="%s" target="_blank">this simple tool here.</a>', 'amely' ),
						array(
							'a' => array(
								'href'   => array(),
								'target' => array(),
							)
						) ), esc_url( 'http://universimmedia.pagesperso-orange.fr/geo/loc.htm' )
					),
				),
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Marker icon', 'amely' ),
					'param_name'  => 'icon',
					'description' => esc_html__( 'Choose a image for marker address', 'amely' ),
				),
				array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Marker Information', 'amely' ),
					'param_name'  => 'info',
					'description' => esc_html__( 'Content for info window', 'amely' ),
				),
			),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Extra class name', 'amely' ),
			'param_name'  => 'el_class',
			'description' => esc_html__( 'If you want to use multiple Google Maps in one page, please add a class name for them.', 'amely' ),
		),
		Amely_VC::get_param( 'css' ),
	),
) );
