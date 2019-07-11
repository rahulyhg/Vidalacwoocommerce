<?php
/**
 * Widget sort by
 *
 */
if ( ! class_exists( 'Amely_Widget_Sorting' ) ) {

	add_action( 'widgets_init', 'load_amely_sorting_widget' );

	function load_amely_sorting_widget() {
		register_widget( 'Amely_Widget_Sorting', 1 );
	}

	class Amely_Widget_Sorting extends WPH_Widget {

		function __construct() {

			// Configure widget array
			$args = array(
				'slug'        => 'tm_sorting',
				// Widget Backend label
				'label'       => '&#x1f503; &nbsp;' . esc_html__( 'AMELY WooCommerce Sort by', 'amely' ),
				// Widget Backend Description
				'description' => esc_html__( 'Sort products by name, price, popularity etc.', 'amely' ),
			);

			// Configure the widget fields

			// fields array
			$args['fields'] = array(
				array(
					'id'   => 'title',
					'type' => 'text',
					'std'  => esc_html__( 'Sort by', 'amely' ),
					'name' => esc_html__( 'Title', 'amely' ),
				),
			);

			// create widget
			$this->create_widget( $args );
		}

		function widget( $args, $instance ) {

			if ( ! woocommerce_products_will_display() ) {
				return;
			}

			$orderby                 = isset( $_GET['orderby'] ) ? wc_clean( $_GET['orderby'] ) : apply_filters( 'woocommerce_default_catalog_orderby',
				get_option( 'woocommerce_default_catalog_orderby' ) );
			$show_default_orderby    = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby',
					get_option( 'woocommerce_default_catalog_orderby' ) );
			$catalog_orderby_options = apply_filters( 'woocommerce_catalog_orderby',
				array(
					'menu_order' => esc_html__( 'Default', 'amely' ),
					'popularity' => esc_html__( 'Popularity', 'amely' ),
					'rating'     => esc_html__( 'Average rating', 'amely' ),
					'date'       => esc_html__( 'Newness', 'amely' ),
					'price'      => esc_html__( 'Price: low to high', 'amely' ),
					'price-desc' => esc_html__( 'Price: high to low', 'amely' ),
				) );

			if ( wc_get_loop_prop( 'is_search' ) ) {
				$catalog_orderby_options = array_merge( array( 'relevance' => esc_html__( 'Relevance', 'amely' ) ),
					$catalog_orderby_options );
				unset( $catalog_orderby_options['menu_order'] );
				if ( 'menu_order' === $orderby ) {
					$orderby = 'relevance';
				}
			}

			if ( ! $show_default_orderby ) {
				unset( $catalog_orderby_options['menu_order'] );
			}

			if ( get_option( 'woocommerce_enable_review_rating' ) === 'no' ) {
				unset( $catalog_orderby_options['rating'] );
			}

			echo $args['before_widget'];

			if ( $title = apply_filters( 'widget_title',
				empty( $instance['title'] ) ? '' : $instance['title'],
				$instance )
			) {
				echo $args['before_title'] . $title . $args['after_title'];
			}

			wc_get_template( 'loop/orderby.php',
				array(
					'catalog_orderby_options' => $catalog_orderby_options,
					'orderby'                 => $orderby,
					'show_default_orderby'    => $show_default_orderby,
					'list'                    => true,
				) );

			echo $args['after_widget'];
		}
	}
}
