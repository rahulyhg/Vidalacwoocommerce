<?php

/**
 * Class Amely_Chosen
 *
 * @package Amely
 */

/* Example
array(
  'type'       => 'chosen',
  'heading'    => esc_html__( 'Categories', 'amely' ),
  'param_name' => 'ajax',
	'options'     => array(
		'multiple'  => true, // multiple or not
		'type'      => 'taxonomy', // taxonomy or post_type
		'get'       => 'product_cat', // term or post type name, split by comma
		'field'     => 'slug', // slug or id
		'values'    => array( // Using key 'values' will disable an AJAX requests on autocomplete input and also any filter for suggestions
			array( 'label' => 'Abrams', 'value' => 1 ),
			array( 'label' => 'Brama', 'value' => 2 ),
			array( 'label' => 'Dron', 'value' => 3 ),
			array( 'label' => 'Akelloam', 'value' => 4 ),
		)
	),
  ),
*/

if ( ! class_exists( 'Amely_Chosen' ) ) {

	class Amely_Chosen {

		public function __construct() {

			if ( class_exists( 'WpbakeryShortcodeParams' ) ) {
				WpbakeryShortcodeParams::addField( 'chosen', array( $this, 'render' ) );
			}

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );
		}

		public function admin_scripts() {
			wp_enqueue_style( 'amely-chosen', AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-chosen/chosen.min.css' );
			wp_enqueue_script( 'amely-chosen', AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-chosen/chosen.jquery.min.js', array( 'jquery' ), AMELY_THEME_VERSION, true );
		}

		public function render( $settings, $value ) {

			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$options    = isset( $settings['options'] ) ? $settings['options'] : array();
			$values     = isset( $options['values'] ) ? $options['values'] : array();
			$multiple   = isset( $options['multiple'] ) ? $options['multiple'] : true;
			$type       = isset( $options['type'] ) ? $options['type'] : 'post_type';
			$get        = isset( $options['get'] ) ? $options['get'] : 'post';
			$field      = isset( $options['field'] ) ? $options['field'] : 'id';
			$limit      = isset( $options['limit'] ) ? $options['limit'] : - 1;
			$items      = array();

			if ( empty( $values ) ) {

				if ( $type == 'post_type' ) {

					$params = array(
						'posts_per_page'      => $limit,
						'post_type'           => explode( ',', $get ),
						'ignore_sticky_posts' => 1,
					);

					$loop = new WP_Query( $params );
					if ( $loop->have_posts() ) {
						while ( $loop->have_posts() ) {
							$loop->the_post();
							$items[] = array(
								'id'   => get_the_ID(),
								'name' => get_the_title(),
							);
						}
					}

					wp_reset_postdata();

				} elseif ( $type == 'taxonomy' ) {

					$terms = get_terms( array(
						'taxonomy'   => $get,
						'hide_empty' => false,
					) );
				}
			} else {

				foreach ( $values as $val ) {

					$items[] = array(
						'id'   => $val['value'],
						'name' => $val['label'],
					);
				}
			}

			$id = uniqid( 'chosen-' );

			$output = '<div class="amely-chosen">';
			$output .= '<input name="' . $param_name . '" class="wpb_vc_param_value ' . $param_name . ' amely_chosen_items_' . $param_name .
			           '" id="amely-chosen-items" type="hidden" value="' . $value . '" />';
			$output .= '<select name="' . $param_name . '"' . ' id="' . $id . '" class="wpb_vc_param_value wpb-select ' .
			           $param_name . ' ' . $settings['type'] . '_field"' . ( $multiple ? ' multiple="multiple"' : '' ) . ' data-class="amely_chosen_items_' . $param_name . '">';

			$values = explode( ',', $value );

			if ( $type == 'post_type' ) {

				foreach ( $items as $item ) {

					$selected = '';
					if ( is_array( $values ) && in_array( $item['id'], $values ) ) {
						$selected = 'selected';
					}

					$output .= '<option value="' . $item['id'] . '" ' . $selected . '>';
					$output .= $item['name'];
					$output .= '</option>';
				}

			} elseif ( $type == 'taxonomy' ) {

				foreach ( $terms as $term ) {

					$selected = '';

					if ( is_array( $values ) && ( ( $field == 'id' && in_array( $term->term_id, $values ) ) || ( $field == 'slug' && in_array( $term->slug, $values ) ) ) ) {
						$selected = 'selected';
					}

					$output .= '<option value="' . ( $field == 'id' ? $term->term_id : $term->slug ) . '" ' . $selected . '>';
					$output .= $term->name . ' (' . $term->count . ')';
					$output .= '</option>';

				}
			}

			$output .= '</select>';
			$output .= '</div>';
			$output .= '<script type="text/javascript">jQuery(document).ready(function() {' .
			           'jQuery("#' . $id . '").chosen();' .
			           'jQuery("#' . $id . '").on(\'change\', function(){' .
			           'var element_target="." + jQuery(this).attr(\'data-class\');' .
			           'jQuery(element_target).val(jQuery(this).val())' .
			           '});' .
			           '});</script>';

			return $output;
		}
	}

	new Amely_Chosen();
}
