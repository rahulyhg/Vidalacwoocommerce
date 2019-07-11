<?php

/**
 * Amely Image Carousel
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Image_Carousel extends WPBakeryShortCode {

	public function shortcode_css( $css_id ) {

		$atts   = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );
		$css_id = '#' . $css_id;
		$css    = '';

		$effect  = $atts['effect'];
		$opacity = $atts['opacity'];
		$scale   = $atts['scale'];
		$overlay = $atts['overlay'];

		switch ( $effect ) {
			case 'opacity':
				$css .= $css_id . ' .tm-carousel-item img{opacity:' . $opacity . '}';
				$css .= $css_id . ' .tm-carousel-item:hover img{opacity:1}';
				break;
			case 'zoom':
				$css .= $css_id . ' .tm-carousel-item img{ -ms-transform: scale(1);-webkit-transform: scale(1);transform: scale(1);}';
				$css .= $css_id . ' .tm-carousel-item:hover img{ -ms-transform: scale(' . $scale . ');-webkit-transform: scale(' . $scale . ');transform: scale(' . $scale . ');}';
				break;
			case 'overlay':
				$css .= $css_id . '.link-no .tm-carousel-item:before,' . $css_id . ' .tm-carousel-item a:before{background-color:' . $overlay . '}';
				break;
			default:
				break;
		}

		global $amely_shortcode_css;
		$amely_shortcode_css .= $css;
	}
}

vc_map( array(
	'name'        => esc_html__( 'Image Carousel', 'amely' ),
	'base'        => 'amely_image_carousel',
	'icon'        => 'amely-element-icon-image-carousel',
	'description' => esc_html__( 'Animated carousel with images', 'amely' ),
	'category'    => sprintf( esc_html__( 'by % s', 'amely' ), AMELY_THEME_NAME ),
	'params'      => array(
		array(
			'type'        => 'attach_images',
			'heading'     => esc_html__( 'Images', 'amely' ),
			'param_name'  => 'images',
			'value'       => '',
			'description' => esc_html__( 'Select images from media library . ', 'amely' ),
			'save_always' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Carousel image size', 'amely' ),
			'param_name'  => 'img_size',
			'value'       => 'full',
			'description' => esc_html__( 'Enter image size . Example: "thumbnail", "medium", "large", "full" or other sizes defined by current theme . Alternatively enter image size in pixels: 200x100( Width x Height). Leave empty to use "thumbnail" size . ', 'amely' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'On click action', 'amely' ),
			'param_name'  => 'onclick',
			'value'       => array(
				esc_html__( 'None', 'amely' )              => 'link_no',
				esc_html__( 'Open lightbox', 'amely' )     => 'link_image',
				esc_html__( 'Open custom links', 'amely' ) => 'custom_link',
			),
			'description' => esc_html__( 'Select action for click event. ', 'amely' ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Custom link target', 'amely' ),
			'param_name'  => 'custom_links_target',
			'description' => esc_html__( 'Select how to open custom links . ', 'amely' ),
			'dependency'  => array(
				'element' => 'onclick',
				'value'   => array( 'custom_link' ),
			),
			'value'       => vc_target_param_list(),
		),

		array(
			'type'        => 'exploded_textarea_safe',
			'heading'     => esc_html__( 'Custom links', 'amely' ),
			'param_name'  => 'custom_links',
			'description' => esc_html__( 'Enter links for each slide( Note: divide links with linebreaks( Enter ).', 'amely' ),
			'dependency'  => array(
				'element' => 'onclick',
				'value'   => array( 'custom_link' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Number of images to show', 'amely' ),
			'param_name' => 'number_of_images_to_show',
			'value'      => array(
				1,
				2,
				3,
				4,
				5,
				6,
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable carousel loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autolay', 'amely' ) => 'yes' ),
		),
		array(
			'type'       => 'number',
			'param_name' => 'auto_play_speed',
			'heading'    => esc_html__( 'Auto play speed', 'amely' ),
			'value'      => 5,
			'max'        => 10,
			'min'        => 3,
			'step'       => 0.5,
			'suffix'     => 'seconds',
			'dependency' => array(
				'element' => 'auto_play',
				'value'   => 'yes',
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'nav_type',
			'heading'    => esc_html__( 'Navigation type', 'amely' ),
			'value'      => array(
				esc_html__( 'Arrows', 'amely' ) => 'arrows',
				esc_html__( 'Dots', 'amely' )   => 'dots',
				__( 'Arrows & Dots', 'amely' )  => 'both',
				esc_html__( 'None', 'amely' )   => '',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'show_title',
			'value'      => array( esc_html__( 'Show title of images', 'amely' ) => 'yes' ),
		),
		Amely_VC::get_param( 'el_class' ),
		array(
			'group'       => esc_html__( 'Hover effect', 'amely' ),
			'type'        => 'dropdown',
			'param_name'  => 'effect',
			'heading'     => esc_html__( 'Image hover effect', 'amely' ),
			'description' => esc_html__( 'Select an effect when mouse over the images . ', 'amely' ),
			'value'       => array(
				esc_html__( 'Opacity', 'amely' ) => 'opacity',
				esc_html__( 'Zoom', 'amely' )    => 'zoom',
				esc_html__( 'Overlay', 'amely' ) => 'overlay',
			),
		),
		array(
			'group'      => esc_html__( 'Hover effect', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Opacity value from', 'amely' ),
			'param_name' => 'opacity',
			'value'      => 0.6,
			'min'        => 0,
			'max'        => 1,
			'step'       => 0.1,
			'suffix'     => 'to 1',
			'dependency' => array(
				'element' => 'effect',
				'value'   => array( 'opacity' ),
			),
		),
		array(
			'group'      => esc_html__( 'Hover effect', 'amely' ),
			'type'       => 'number',
			'heading'    => esc_html__( 'Zoom scale', 'amely' ),
			'param_name' => 'scale',
			'max'        => 5,
			'min'        => 0.1,
			'value'      => 1.1,
			'step'       => 0.1,
			'dependency' => array(
				'element' => 'effect',
				'value'   => array( 'zoom' ),
			),
		),
		array(
			'group'      => esc_html__( 'Hover effect', 'amely' ),
			'type'       => 'colorpicker',
			'heading'    => esc_html__( 'Overlay color', 'amely' ),
			'param_name' => 'overlay',
			'value'      => 'rgba( 255, 255, 255, 0.6 )',
			'dependency' => array(
				'element' => 'effect',
				'value'   => array( 'overlay' ),
			),
		),
		Amely_VC::get_param( 'css' ),
	),
) );
