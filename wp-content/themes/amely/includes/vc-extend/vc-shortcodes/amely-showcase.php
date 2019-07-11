<?php

/**
 * Amely Product Grid Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Showcase extends WPBakeryShortCode {

	public function __construct( $settings ) {
		parent::__construct( $settings );
		add_filter( 'amely_product_loop_thumbnail_size', array( $this, 'image_size' ) );
	}

	public function image_size() {

		$atts = $this->getAtts();

		if ( empty( $atts['img_size'] ) ) {
			$atts['img_size'] = 'woocommerce_thumbnail';
		}

		return isset( $atts['img_size'] ) ? Amely_Helper::convert_image_size( $atts['img_size'] ) : 'woocommerce_thumbnail';
	}
}

// Mapping shortcode.
vc_map( array(
	'name'     => esc_html__( 'Showcase', 'amely' ),
	'base'     => 'amely_showcase',
	'icon'     => 'amely-element-icon-showcase',
	'category' => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Use for one page scroll', 'amely' ),
	'params'   => array(
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'amely' ),
			'param_name'  => 'title',
			'description' => esc_html__( 'Display title vertical', 'amely' ),
		),
		array(
			'type'       => 'chosen',
			'heading'    => esc_html__( 'Product', 'amely' ),
			'param_name' => 'product_slugs',
			'options'    => array(
				'multiple' => false, // multiple or not
				'type'     => 'post_type', // taxonomy or post_type
				'get'      => 'product', // term or post type name, split by comma
				'field'    => 'slug', // slug or id
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_number',
			'value'      => array( esc_html__( 'Show number', 'amely' ) => 'yes' ),
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Number', 'amely' ),
			'param_name'  => 'number',
			'value'       => 1,
			'description' => esc_html__( 'Show sequence number', 'amely' ),
			'dependency'  => array(
				'element' => 'show_number',
				'value'   => 'yes',
			),
		),
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
			'heading'     => esc_html__( 'Image Product', 'amely' ),
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
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Align Image', 'amely' ),
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Align Right', 'amely' ) => 'right',
				esc_html__( 'Align Left', 'amely' )  => 'left',
			),
			'std'        => 'right',
		),

		Amely_VC::get_param( 'animation' ),
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'css' ),
	),
) );

