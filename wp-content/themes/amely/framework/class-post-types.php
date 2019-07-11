<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 *
 * Custom Post Type
 *
 * @package Amely
 */

if ( ! class_exists( 'Amely_Post_Types' ) ) {

	class Amely_Post_Types {

		public function __construct() {
			add_action( 'init', array( $this, 'init' ), 9 );
			add_action( 'init', array( $this, 'register_taxonomies' ), 1 );
		}

		public function init() {
			add_filter( 'insight_posttypes', array( $this, 'register_post_types' ) );
			add_filter( 'manage_testimonials_posts_columns', array( $this, 'testimonials_edit_columns' ), 10, 1 );
		}

		public function register_post_types() {

			$post_types = array();

			// Testimonial
			$post_types['testimonials'] = array(
				'labels'            => array(
					'name'               => esc_html__( 'Testimonials', 'amely' ),
					'singular_name'      => esc_html__( 'Testimonial', 'amely' ),
					'add_new'            => esc_html__( 'Add New', 'amely' ),
					'add_new_item'       => esc_html__( 'Add New Testimonial', 'amely' ),
					'edit_item'          => esc_html__( 'Edit Testimonial', 'amely' ),
					'new_item'           => esc_html__( 'New Testimonial', 'amely' ),
					'view_item'          => esc_html__( 'View Testimonial', 'amely' ),
					'search_items'       => esc_html__( 'Search Testimonials', 'amely' ),
					'not_found'          => esc_html__( 'No testimonials have been added yet', 'amely' ),
					'not_found_in_trash' => esc_html__( 'Nothing found in Trash', 'amely' ),
					'parent_item_colon'  => '',
				),
				'public'            => false,
				'has_archive'       => false,
				'show_ui'           => true,
				'show_in_menu'      => true,
				'show_in_nav_menus' => false,
				'menu_icon'         => 'dashicons-format-quote',
				'rewrite'           => false,
				'supports'          => array(
					'title',
					'editor',
					'custom-fields',
					'excerpt',
					'revisions',
				),
			);

			return $post_types;
		}

		public function register_taxonomies() {

			register_taxonomy( 'testimonials-category',
				'testimonials',
				array(
					'labels'            => esc_html__( 'Testimonial Categories', 'amely' ),
					'hierarchical'      => true, // Like categories.
					'public'            => false,
					'show_ui'           => true,
					'show_admin_column' => true,
					'show_in_nav_menus' => false,
					'rewrite'           => false,
					'query_var'         => true,
				) );
		}

		public function testimonials_edit_columns( $columns ) {
			$columns = array(
				'cb'                             => '<input type="checkbox" />',
				'title'                          => esc_html__( 'Testimonial', 'amely' ),
				'taxonomy-testimonials-category' => esc_html__( 'Categories', 'amely' ),
			);

			return $columns;
		}

	}

	new Amely_Post_Types();
}
