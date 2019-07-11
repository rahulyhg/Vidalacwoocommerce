<?php

Redux::setSection( Amely_Redux::$opt_name, array(
	'title'      => esc_html__( 'Blog Archive', 'amely' ),
	'id'         => 'section_blog_archive',
	'subsection' => true,
	'fields'     => array(

		array(
			'id'       => 'archive_sidebar_config',
			'type'     => 'image_select',
			'title'    => esc_html__( 'Archive Sidebar Position', 'amely' ),
			'subtitle' => esc_html__( 'Controls the position of sidebars for the archive pages.', 'amely' ),
			'options'  => array(
				'left'  => array(
					'title' => esc_html__( 'Left', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . '2cl.png',
				),
				'no'    => array(
					'title' => esc_html__( 'Disable', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . '1c.png',
				),
				'right' => array(
					'title' => esc_html__( 'Right', 'amely' ),
					'img'   => AMELY_ADMIN_IMAGES . DS . '2cr.png',
				),
			),
			'default'  => 'right',
		),

		array(
			'id'       => 'archive_sidebar',
			'type'     => 'select',
			'title'    => esc_html__( 'Archive Sidebar', 'amely' ),
			'subtitle' => esc_html__( 'Choose the sidebar for archive pages.', 'amely' ),
			'data'     => 'sidebars',
			'default'  => 'sidebar',
			'required' => array(
				array( 'archive_sidebar_config', '!=', 'no' ),
			),
		),

		array(
			'id'       => 'archive_display_type',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Archive Display Type', 'amely' ),
			'subtitle' => esc_html__( 'Select the display type.', 'amely' ),
			'options'  => array(
				'standard' => esc_html__( 'Standard', 'amely' ),
				'grid'     => esc_html__( 'Grid', 'amely' ),
				'masonry'  => esc_html__( 'Masonry', 'amely' ),
			),
			'default'  => 'standard',
		),

		array(
			'id'       => 'archive_content_output',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Archive Content Output', 'amely' ),
			'subtitle' => esc_html__( 'Select if you\'d like to output the content or excerpt on archive pages.', 'amely' ),
			'options'  => array(
				'excerpt' => esc_html__( 'Excerpt', 'amely' ),
				'content' => esc_html__( 'Content', 'amely' ),
			),
			'default'  => 'excerpt',
		),

		array(
			'id'                => 'excerpt_length',
			'type'              => 'text',
			'title'             => esc_html__( 'Excerpt Length', 'amely' ),
			'subtitle'          => sprintf( esc_html__( 'Controls the number of words of the post excerpt (from 0 to %s words)', 'amely' ), apply_filters( 'amely_max_excerpt_length', 500 ) ),
			'default'           => 30,
			'display_value'     => 'label',
			'validate_callback' => 'amely_validate_excerpt_callback',
			'required'          => array(
				'archive_content_output',
				'=',
				'excerpt',
			),
		),

		array(
			'id'       => 'archive_pagination',
			'type'     => 'button_set',
			'title'    => esc_html__( 'Pagination Type', 'amely' ),
			'subtitle' => esc_html__( 'Select pagination type', 'amely' ),
			'options'  => array(
				'default'  => esc_html__( 'Default', 'amely' ),
				'more-btn' => esc_html__( 'Load More Button', 'amely' ),
				'infinite' => esc_html__( 'Infinite Scroll', 'amely' ),
			),
			'default'  => 'default'
		),

	),
) );

if ( ! function_exists( 'amely_validate_excerpt_callback' ) ) {
	function amely_validate_excerpt_callback( $field, $value, $existing_value ) {
		$error = false;

		if ( ! is_numeric( $value ) ) {

			$error = true;

			$value        = $existing_value;
			$field['msg'] = esc_html__( 'You must provide a numerical value for this option.', 'amely' );

		} elseif ( $value < 0 || $value > apply_filters( 'amely_max_excerpt_length', 500 ) ) {

			$error = true;

			$value        = $existing_value;
			$field['msg'] = sprintf( esc_html__( 'The excerpt length must be from 0 to %s words.', 'amely' ), apply_filters( 'amely_max_excerpt_length', 500 ) );
		}

		$return['value'] = $value;

		if ( $error ) {
			$return['error'] = $field;
		}

		return $return;
	}
}

