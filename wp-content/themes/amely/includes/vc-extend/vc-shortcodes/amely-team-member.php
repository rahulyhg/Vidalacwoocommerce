<?php

/**
 * ThemeMove Team Member Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Team_Member extends WPBakeryShortCode {

	public function getSocialLinks( $atts ) {
		$social_links     = preg_split( '/\s+/', $atts['social_links'] );
		$social_links_arr = array();

		foreach ( $social_links as $social ) {
			$pieces = explode( '|', $social );
			if ( count( $pieces ) == 2 ) {
				$key                      = $pieces[0];
				$link                     = $pieces[1];
				$social_links_arr[ $key ] = $link;
			}
		}

		return $social_links_arr;
	}

}

// Mapping shortcode.
vc_map( array(
	'name'     => esc_html__( 'Team Member', 'amely' ),
	'base'     => 'amely_team_member',
	'icon'     => 'amely-element-icon-team-member',
	'category' => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'params'   => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Image', 'amely' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select an image from media library.', 'amely' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Name', 'amely' ),
			'param_name'  => 'name',
			'admin_label' => true,
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Role', 'amely' ),
			'param_name'  => 'role',
			'description' => esc_html__( 'Add a role. E.g. CEO of ThemeMove', 'amely' ),
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Biography', 'amely' ),
			'param_name' => 'biography',
		),
		Amely_VC::get_param( 'el_class' ),
		array(
			'group'      => esc_html__( 'Social', 'amely' ),
			'type'       => 'checkbox',
			'param_name' => 'link_new_page',
			'value'      => array( esc_html__( 'Open links in new tab', 'amely' ) => 'yes' ),
		),
		array(
			'group'      => esc_html__( 'Social', 'amely' ),
			'type'       => 'social_links',
			'heading'    => esc_html__( 'Social links', 'amely' ),
			'param_name' => 'social_links',
		),
		Amely_VC::get_param( 'css' ),
	),
) );
