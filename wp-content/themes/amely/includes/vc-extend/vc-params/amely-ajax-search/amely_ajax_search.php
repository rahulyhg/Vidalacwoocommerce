<?php
/**
 * Class Amely_Ajax_Search
 *
 * @package Amely
 *
 */

/* Example
array(
  'type'       => 'ajax-search',
  'heading'    => esc_html__( 'Categories', 'amely' ),
  'param_name' => 'ajax',
	'options'     => array(
		'type'  => 'taxonomy', // taxonomy or post_type
		'get'   => 'product_cat', // term or post type name, split by comma
		'field' => 'slug', // slug or id
	),
  ),
*/
if ( ! class_exists( 'Amely_Ajax_Search' ) ) {

	class Amely_Ajax_Search {

		public function __construct() {

			if ( class_exists( 'WpbakeryShortcodeParams' ) ) {
				WpbakeryShortcodeParams::addField( 'ajax-search', array( $this, 'render' ) );
			}

			add_action( 'admin_enqueue_scripts', array( $this, 'admin_scripts' ) );

			// VC ajax search
			add_action( 'wp_ajax_vc_ajax_search', array( $this, 'ajax_search' ) );
			add_action( 'wp_ajax_nopriv_vc_ajax_search', array( $this, 'ajax_search' ) );
			add_filter( 'posts_where', array( $this, 'title_like_posts_where' ), 10, 2 );
		}

		function ajax_search() {

			$q        = isset( $_GET['q'] ) ? $_GET['q'] : '';
			$type     = urldecode( isset( $_GET['type'] ) ? $_GET['type'] : 'post_type' );
			$get      = urldecode( isset( $_GET['get'] ) ? $_GET['get'] : 'post' );
			$field    = urldecode( isset( $_GET['field'] ) ? $_GET['field'] : 'id' );
			$values   = explode( ',', $get );
			$post_arr = array();

			if ( $type == 'post_type' ) {
				$params = array(
					'post_title_like'     => $q,
					'posts_per_page'      => 10,
					'post_type'           => $values,
					'ignore_sticky_posts' => 1,
				);

				$loop = new WP_Query( $params );
				if ( $loop->have_posts() ) {
					while ( $loop->have_posts() ) {
						$loop->the_post();
						$post_arr[] = array(
							'id'   => get_the_ID(),
							'name' => get_the_title(),
						);
					}
				}

				wp_reset_postdata();

			} elseif ( $type == 'taxonomy' ) {

				global $wpdb;
				$cat_id          = (int) $q;
				$q               = trim( $q );
				$post_meta_infos = $wpdb->get_results( $wpdb->prepare( "SELECT a.term_id AS id, b.name as name, b.slug AS slug
						FROM {$wpdb->term_taxonomy} AS a
						INNER JOIN {$wpdb->terms} AS b ON b.term_id = a.term_id
						WHERE a.taxonomy = '{$get}' AND (a.term_id = '%d' OR b.slug LIKE '%%%s%%' OR b.name LIKE '%%%s%%' )", $cat_id > 0 ? $cat_id : - 1, stripslashes( $q ), stripslashes( $q ) ), ARRAY_A );

				$result = array();
				if ( is_array( $post_meta_infos ) && ! empty( $post_meta_infos ) ) {
					foreach ( $post_meta_infos as $value ) {
						$data         = array();
						$data['id']   = ( $field == 'slug' ) ? $value['slug'] : $value['id'];
						$data['name'] = esc_html__( 'Id', 'amely' ) . ': ' . $value['id'] . ( ( strlen( $value['name'] ) > 0 ) ? ' - ' . esc_html__( 'Name', 'amely' ) . ': ' . $value['name'] : '' ) . ( ( strlen( $value['slug'] ) > 0 ) ? ' - ' . esc_html__( 'Slug', 'amely' ) . ': ' . $value['slug'] : '' );
						$result[]     = $data;
					}
				}
			}

			wp_send_json( $result );
		}

		public function title_like_posts_where( $where, $wp_query ) {
			global $wpdb;
			if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
				$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
			}

			return $where;
		}

		public function admin_scripts() {
			wp_enqueue_style( 'amely-ajax-search', AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-ajax-search/token-input.css' );
			wp_enqueue_script( 'amely-ajax-search', AMELY_THEME_URI . '/includes/vc-extend/vc-params/amely-ajax-search/jquery.tokeninput.min.js', array( 'jquery' ), AMELY_THEME_VERSION, true );
		}

		public function render( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$options    = isset( $settings['options'] ) ? $settings['options'] : array();
			$type       = isset( $options['type'] ) ? $options['type'] : 'post_type';
			$get        = isset( $options['get'] ) ? $options['get'] : 'post';
			$field      = isset( $options['field'] ) ? $options['field'] : 'id';
			$ajax_limit = isset( $options['ajax_limit'] ) ? $options['ajax_limit'] : 10;

			$id = uniqid( 'tokeninput-' );

			$pre_populate = '';
			if ( $value != '' ) {
				$value_items = explode( ',', $value );
				if ( $type == 'post_type' ) {
					foreach ( $value_items as $value_item ) {
						$value_item_info = get_post( trim( $value_item ) );
						$pre_populate .= '{id: ' . $value_item_info->ID . ', name: "' . $value_item_info->post_title . '"},';
					}
				} elseif ( $type == 'taxonomy' ) {
					foreach ( $value_items as $value_item ) {
						$value_item_info = get_term_by( $field, trim( $value_item ), $get );
						$pre_populate .= '{id: "' . trim( $value_item ) . '", name: "ID: ' . $value_item->term_id . ( ( strlen( $value_item_info->name ) > 0 ) ? ' - ' . esc_html__( 'Name', 'amely' ) . ': ' . $value_item_info->name : '' ) . ( strlen( $value_item_info->slug ) > 0 ? ' - ' . esc_html__( 'Slug', 'amely' ) . ': ' . $value_item_info->slug : '' ) . '"},';
					}
				}
			}

			$output = '<div class="tokeninput">';
			$output .= '<input id="' . $id . '" name="' . $param_name . '" value="' . $value . '" type="text" class="wpb_vc_param_value" />';
			$output .= '</div>';
			$output .= '<script>jQuery("#' . $id . '").tokenInput("' . esc_js( admin_url( 'admin-ajax.php' ) ) . '?action=vc_ajax_search&type=' . urlencode( $type ) . '&get=' . urlencode( $get ) . '&field=' . urlencode( $field ) . '", {
                prePopulate: [' . $pre_populate . '], resultsLimit: ' . $ajax_limit . ', excludeCurrent: true } );</script>';

			return $output;
		}
	}

	new Amely_Ajax_Search();
}
