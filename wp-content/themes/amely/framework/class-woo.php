<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom functions for WooCommerce
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Woo' ) ) {

	class Amely_Woo {

		/**
		 * The constructor.
		 */
		public function __construct() {
			// Hide default smart compare button
			add_filter( 'filter_wooscp_button_archive',
				function () {
					return '0';
				} );
			add_filter( 'filter_wooscp_button_single',
				function () {
					return '0';
				} );

			// Remove default WooCommerce style
			add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

			/*****************************************************************************************
			 * AJAX Registration
			 *****************************************************************************************/
			// Wishlist AJAX
			add_action( 'wp_ajax_amely_get_wishlist_fragments',
				array(
					$this,
					'get_wishlist_fragments',
				) );
			add_action( 'wp_ajax_nopriv_amely_get_wishlist_fragments',
				array(
					$this,
					'get_wishlist_fragments',
				) );
			add_action( 'wp_ajax_amely_remove_wishlist_item',
				array(
					$this,
					'remove_wishlist_item',
				) );
			add_action( 'wp_ajax_nopriv_amely_remove_wishlist_item',
				array(
					$this,
					'remove_wishlist_item',
				) );
			add_action( 'wp_ajax_amely_undo_remove_wishlist_item',
				array(
					$this,
					'undo_remove_wishlist_item',
				) );
			add_action( 'wp_ajax_nopriv_amely_undo_remove_wishlist_item',
				array(
					$this,
					'undo_remove_wishlist_item',
				) );

			// Mini cart AJAX
			add_filter( 'woocommerce_add_to_cart_fragments',
				array(
					$this,
					'get_cart_fragments',
				),
				10 );
			add_action( 'wp_ajax_amely_remove_cart_item',
				array(
					$this,
					'remove_cart_item',
				) );
			add_action( 'wp_ajax_nopriv_amely_remove_cart_item',
				array(
					$this,
					'remove_cart_item',
				) );
			add_action( 'wp_ajax_amely_undo_remove_cart_item',
				array(
					$this,
					'undo_remove_cart_item',
				) );
			add_action( 'wp_ajax_nopriv_amely_undo_remove_cart_item',
				array(
					$this,
					'undo_remove_cart_item',
				) );

			// Quick view AJAX
			add_action( 'wp_ajax_amely_quick_view',
				array(
					$this,
					'quick_view',
				) );
			add_action( 'wp_ajax_nopriv_amely_quick_view',
				array(
					$this,
					'quick_view',
				) );
			add_action( 'amely_after_page_container',
				array(
					$this,
					'add_quick_view_container',
				) );
			add_action( 'wp_ajax_amely_ajax_add_to_cart',
				array(
					$this,
					'ajax_add_to_cart',
				) );
			add_action( 'wp_ajax_nopriv_amely_ajax_add_to_cart',
				array(
					$this,
					'ajax_add_to_cart',
				) );

			// Enqueue scripts for the quick view
			add_action( 'wp_enqueue_scripts',
				function () {
					wp_enqueue_script( 'wc-add-to-cart' );
					wp_enqueue_script( 'woocommerce' );
					wp_enqueue_script( 'wc-single-product' );
					wp_enqueue_script( 'wc-add-to-cart-variation' );
				} );

			/******************************************************************************************
			 * Shop Page (Product Archive Page)
			 *****************************************************************************************/
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
			remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );

			// Categories Rows
			add_action( 'woocommerce_before_shop_loop', array( $this, 'categories_row' ), 32 );

			// Remove categories in product loop
			remove_filter( 'woocommerce_product_loop_start', 'woocommerce_maybe_show_product_subcategories' );

			// Remove breadcrumb
			remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

			// remove content wrapper
			remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper' );
			remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end' );

			// Change subcategory count HTML
			add_filter( 'woocommerce_subcategory_count_html', array( $this, 'subcategory_count_html', ), 10, 2 );

			// Change thumbnail size for subcategory within loop
			add_filter( 'subcategory_archive_thumbnail_size',
				function () {
					return 'full';
				} );

			add_filter( 'woocommerce_gallery_image_size',
				function () {
					return 'woocommerce_single';
				} );

			/******************************************************************************************
			 * Product Loop Items
			 *
			 * @see woocommerce_template_loop_product_link_open()
			 * @see woocommerce_template_loop_product_link_close()
			 * @see woocommerce_template_loop_add_to_cart()
			 * @see woocommerce_template_loop_product_thumbnail()
			 * @see woocommerce_template_loop_product_title()
			 * @see woocommerce_template_loop_rating()
			 * @see woocommerce_template_loop_price()
			 *****************************************************************************************/
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );

			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', 5 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 15 );

			add_filter( 'woocommerce_loop_add_to_cart_args', array( $this, 'add_to_cart_args' ), 10, 2 );

			// Add hover image
			remove_action( 'woocommerce_before_shop_loop_item_title',
				'woocommerce_template_loop_product_thumbnail',
				10 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
			add_action( 'woocommerce_before_shop_loop_item_title',
				array( $this, 'template_loop_product_thumbnail', ),
				10 );

			// Add link to the product title
			remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );
			add_action( 'woocommerce_shop_loop_item_title', array( $this, 'template_loop_product_title', ), 10 );

			// Swap rating & price
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );
			remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
			add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 5 );

			// Hide default wishlist button
			add_filter( 'yith_wcwl_positions',
				function () {
					return array(
						'add-to-cart' => array(
							'hook'     => '',
							'priority' => 0,
						),
						'thumbnails'  => array(
							'hook'     => '',
							'priority' => 0,
						),
						'summary'     => array(
							'hook'     => '',
							'priority' => 0,
						),
					);
				} );

			// Hide default compare button
			add_filter( 'yith_woocompare_remove_compare_link_by_cat', '__return_true' );

			/******************************************************************************************
			 * Single Product
			 *
			 * @see woocommerce_output_product_data_tabs()
			 * @see woocommerce_upsell_display()
			 * @see woocommerce_output_related_products()
			 *****************************************O************************************************/
			remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_upsell_display', 15 );
			remove_action( 'woocommerce_after_single_product_summary', 'woocommerce_output_related_products', 20 );

			// Swap rating & title
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 5 );
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 5 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_title', 10 );

			// Swap price & excerpt
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 10 );
			add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_price', 15 );

			// Single Navigation
			add_action( 'woocommerce_single_product_summary', array( $this, 'product_single_navigation' ), 6 );

			add_filter( 'woocommerce_review_gravatar_size',
				function () {
					return '70';
				} );

			// Change number of Related & Up sells product
			add_filter( 'woocommerce_output_related_products_args',
				function ( $args ) {

					$args['posts_per_page'] = amely_get_option( 'product_related' );
					$args['columns']        = 4;

					return $args;
				} );

			//Currency loadmore with WPML
			add_filter( 'wcml_multi_currency_ajax_actions',
				array( $this, 'add_action_to_multi_currency_ajax' ),
				10,
				1 );

			/**
			 * Product List Widget
			 */
			add_filter( 'woocommerce_before_widget_product_list',
				function () {
					return '<div class="product_list_widget">';
				} );
			add_filter( 'woocommerce_after_widget_product_list',
				function () {
					return '</div>';
				} );

			/**
			 * Mini cart
			 */
			add_filter( 'woocommerce_is_attribute_in_product_name',
				array( $this, 'is_attribute_in_product_name', ),
				10,
				3 );

			add_filter( 'woocommerce_get_item_data',
				array( $this, 'get_item_data' ),
				10,
				2 );

			add_filter( 'posts_join', array( $this, 'product_search_join' ), 10, 2 );

			add_filter( 'posts_where', array( $this, 'product_search_where' ), 10, 2 );
		}

		/**
		 * Wishlist widget
		 */
		private function wishlist_widget() {

			$products = YITH_WCWL()->get_products( array(
				'is_default' => true,
			) );

			$products = array_reverse( $products );

			$wl_link = YITH_WCWL()->get_wishlist_url();


			$classes = array( 'wishlist_items product_list_widget' );

			if ( get_option( 'yith_wcwl_remove_after_add_to_cart' ) == 'yes' ) {
				$classes[] = 'remove_after_add_to_cart';
			}

			?>
			<p class="widget_wishlist_title"><?php esc_html_e( 'Wishlist', 'amely' ); ?>
				<a href="#" class="close-on-mobile hidden-xl-up">&times;</a>
				<span class="undo">
						<?php esc_html_e( 'Item removed.', 'amely' ) ?>
					<a href="#"><?php esc_html_e( 'Undo', 'amely' ); ?></a>
				</span>
			</p>
			<ul class="<?php echo implode( ' ', $classes ); ?>">
				<li class="wishlist_empty_message empty<?php echo empty( $products ) ? '' : ' hidden'; ?>"><?php esc_html_e( 'No products in the wishlist.',
						'amely' ); ?></li>
				<?php
				if ( ! empty( $products ) ) {
					foreach ( $products as $p ) {

						global $product;

						if ( function_exists( 'wc_get_product' ) ) {
							$product = wc_get_product( $p['prod_id'] );
						} else {
							$product = get_product( $p['prod_id'] );
						}

						if ( ! $product ) {
							continue;
						}

						$product_name  = $product->get_title();
						$thumbnail     = $product->get_image( 'shop_thumbnail' );
						$product_price = $product->get_price_html();
						$remove_url    = add_query_arg( 'remove_from_wishlist', $p['prod_id'], $wl_link );

						?>
						<li class="wishlist_item"
						    data-product_id="<?php echo esc_attr( $p['prod_id'] ); ?>"
						    data-wishlist_id="<?php echo esc_attr( $p['wishlist_id'] ); ?>"
						    data-wishlist_token="<?php echo esc_attr( $p['wishlist_token'] ); ?>">
							<a href="<?php echo esc_url( $remove_url ); ?>" class="remove"
							   title="<?php esc_html_e( 'Remove this product', 'amely' ) ?>">&times;</a>
							<?php if ( ! $product->is_visible() ) { ?>
								<?php echo str_replace( array(
										'http:',
										'https:',
									),
										'',
										$thumbnail ) . '&nbsp;'; ?>
							<?php } else { ?>
								<a href="<?php echo esc_url( $product->get_permalink() ); ?>"
								   class="wishlist_item_product_image">
									<?php echo str_replace( array(
											'http:',
											'https:',
										),
											'',
											$thumbnail ) . '&nbsp;'; ?>
								</a>
							<?php } ?>
							<div class="wishlist_item_right">
								<h5 class="product-title">
									<a href="<?php echo esc_url( $product->get_permalink() ); ?>"><?php echo esc_html( $product_name ); ?></a>
								</h5>
								<?php echo wp_kses_post( $product_price ); ?>
								<?php if ( ! $product->is_in_stock() ) { ?>
									<p class="outofstock"><?php esc_html_e( 'Out of stock', 'amely' ); ?></p>
								<?php } ?>
								<?php if ( $product->is_in_stock() && amely_get_option( 'wishlist_add_to_cart_on' ) ) {
									if ( function_exists( 'woocommerce_template_loop_add_to_cart' ) ) {
										woocommerce_template_loop_add_to_cart();
									} else {
										wc_get_template( 'loop/add-to-cart.php' );
									}
								} ?>
							</div>
						</li>
					<?php }
				} ?>
			</ul>
			<?php

			if ( ! empty( $products ) ) {

				$target = '';

				if ( amely_get_option( 'wishlist_target' ) ) {
					$target = '_blank';
				}
				?>
				<a href="<?php echo esc_url( $wl_link ); ?>"
				   target="<?php echo esc_attr( $target ); ?>"
				   class="button btn-view-wishlist"><?php esc_html_e( 'View Wishlist', 'amely' ); ?></a>
				<?php
			}
		}

		public function get_wishlist_fragments() {

			if ( ! function_exists( 'wc_setcookie' ) || ! class_exists( 'YITH_WCWL' ) ) {
				return;
			}

			$products = YITH_WCWL()->get_products( array(
				'is_default' => true,
			) );

			ob_start();

			$this->wishlist_widget();

			$wl       = ob_get_clean();
			$wl_count = YITH_WCWL()->count_products();

			// Fragments and wishlist are returned
			$data = array(
				'fragments' => array(
					'span.wishlist-count'         => '<span class="wishlist-count">' . $wl_count . '</span>',
					'div.widget_wishlist_content' => '<div class="widget_wishlist_content">' . $wl . '</div>',
					'tm-wishlist'                 => array(
						'count' => $wl_count,
					),
				),
				'wl_hash'   => md5( json_encode( $products ) ),
			);

			wp_send_json( $data );
		}

		public function remove_wishlist_item() {

			if ( ! function_exists( 'wc_setcookie' ) || ! class_exists( 'YITH_WCWL' ) ) {
				return;
			}

			$item = isset( $_POST['item'] ) ? $_POST['item'] : '';

			if ( ! $item ) {
				return;
			}

			YITH_WCWL()->details['remove_from_wishlist'] = $item['remove_from_wishlist'];
			YITH_WCWL()->details['wishlist_id']          = $item['wishlist_id'];

			if ( is_user_logged_in() ) {
				YITH_WCWL()->details['user_id'] = get_current_user_id();
			}

			if ( YITH_WCWL()->remove() ) {
				$this->get_wishlist_fragments();
			} else {
				wp_send_json( array( 'success' => false ) );
			}

			$this->get_wishlist_fragments();
		}

		public function undo_remove_wishlist_item() {
			if ( ! function_exists( 'wc_setcookie' ) || ! class_exists( 'YITH_WCWL' ) ) {
				return;
			}

			$item = isset( $_POST['item'] ) ? $_POST['item'] : '';

			if ( ! $item ) {
				return;
			}

			YITH_WCWL()->details['add_to_wishlist'] = $item['add_to_wishlist'];
			YITH_WCWL()->details['wishlist_id']     = $item['wishlist_id'];

			if ( is_user_logged_in() ) {
				YITH_WCWL()->details['user_id'] = get_current_user_id();
			}

			if ( YITH_WCWL()->add() ) {
				$this->get_wishlist_fragments();
			} else {
				wp_send_json( array( 'success' => false ) );
			}
		}

		public static function get_cart_count() {

			ob_start();

			?>
			<span class="minicart-count"><?php echo WC()->cart->cart_contents_count; ?></span>
			<?php

			return ob_get_clean();
		}

		public static function get_cart_total() {

			ob_start();
			?>

			<span class="minicart-total"><?php echo WC()->cart->get_cart_total(); ?></span>

			<?php

			return ob_get_clean();
		}

		private function get_formated_cart_total( $price, $args = array() ) {

			extract( apply_filters( 'wc_price_args',
				wp_parse_args( $args,
					array(
						'ex_tax_label'       => false,
						'currency'           => '',
						'decimal_separator'  => wc_get_price_decimal_separator(),
						'thousand_separator' => wc_get_price_thousand_separator(),
						'decimals'           => wc_get_price_decimals(),
						'price_format'       => get_woocommerce_price_format(),
					) ) ) );

			$negative = $price < 0;
			$price    = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * - 1 : $price ) );
			$price    = apply_filters( 'formatted_woocommerce_price',
				number_format( $price, $decimals, $decimal_separator, $thousand_separator ),
				$price,
				$decimals,
				$decimal_separator,
				$thousand_separator );

			if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $decimals > 0 ) {
				$price = wc_trim_zeros( $price );
			}

			$formatted_price = ( $negative ? '-' : '' ) . sprintf( $price_format,
					'<span class="woocommerce-Price-currencySymbol">' . get_woocommerce_currency_symbol( $currency ) . '</span>',
					$price );

			return $formatted_price;
		}

		public function get_cart_fragments( $fragments ) {

			$count = $this->get_cart_count();
			$total = $this->get_cart_total();

			$fragments['span.minicart-count'] = $count;
			$fragments['span.minicart-total'] = $total;
			$fragments['tm-minicart']         = array(
				'total' => $this->get_formated_cart_total( WC()->cart->subtotal ),
				'count' => WC()->cart->cart_contents_count,
			);

			return $fragments;

		}

		public function refresh_cart_fragments() {

			$cart_ajax = new WC_AJAX();
			$cart_ajax->get_refreshed_fragments();

			exit();
		}

		public function remove_cart_item() {

			$item = isset( $_POST['item'] ) ? $_POST['item'] : '';

			if ( $item ) {
				WC()->instance()->cart->remove_cart_item( $item );
			}

			$this->refresh_cart_fragments();
		}

		public function undo_remove_cart_item() {

			$item = isset( $_POST['item'] ) ? $_POST['item'] : '';

			if ( $item ) {
				WC()->cart->restore_cart_item( $item );
			}

			$this->refresh_cart_fragments();
		}

		/**
		 * Categories Row
		 */
		public function categories_row() {

			$display_type = woocommerce_get_loop_display_mode();

			// If displaying categories, append to the loop.
			if ( 'subcategories' === $display_type || 'both' === $display_type ) {
				$layout        = amely_get_option( 'categories_layout' );
				$data_carousel = ' data-carousel="' . amely_get_option( 'categories_columns' ) . '"';
				$before        = '<div class="categories-row row';

				if ( $layout == 'carousel' ) {
					$before .= ' categories-carousel"';
					$before .= $data_carousel . '>';
				} else {
					$before .= '">';
				}

				woocommerce_output_product_categories( array(
					'before'    => $before,
					'after'     => '</div>',
					'parent_id' => is_product_category() ? get_queried_object_id() : 0,
				) );
			}
		}

		/**
		 * Product categories menu on the product archive page
		 *
		 * @return string|void
		 */
		public static function product_categories_menu() {

			$args = array(
				'hide_empty'         => 0,
				'menu_order'         => 'asc',
				'show_option_all'    => '',
				'show_option_none'   => '',
				'taxonomy'           => 'product_cat',
				'title_li'           => '',
				'use_desc_for_title' => 1,
			);

			$current_cat = false;

			if ( is_tax( 'product_cat' ) ) {
				$current_cat = get_queried_object();
			}

			// Show children of current category
			if ( $current_cat ) {

				// Direct children are wanted
				$include = get_terms( 'product_cat',
					array(
						'fields'       => 'ids',
						'parent'       => $current_cat->term_id,
						'hierarchical' => true,
						'hide_empty'   => false,
					) );

				$args['include']          = implode( ',', $include );
				$args['current_category'] = ( $current_cat ) ? $current_cat->term_id : '';

				$link = ( $current_cat->parent ) ? get_category_link( $current_cat->parent ) : get_permalink( wc_get_page_id( 'shop' ) );

				if ( empty( $include ) ) { ?>
					<?php if ( is_product_category() || is_product_tag() ) { ?>
						<div class="shop-menu">
							<a href="#" class="show-categories-menu"><?php esc_html_e( 'Categories',
									'amely' ) ?></a>
							<ul class="product-categories-menu">
								<li class="cat-item shop-back-link">
									<a href="<?php echo esc_url( $link ); ?>"><span>&larr;</span><?php esc_html_e( 'Back',
											'amely' ) ?>
									</a>
								</li>
							</ul>
						</div>
						<?php
					}

					return;
				}

			} else {
				$args['child_of']     = 0;
				$args['depth']        = 1;
				$args['hierarchical'] = 1;
			}

			$args = apply_filters( 'amely_product_categories_menu_args', $args );

			include_once( WC()->plugin_path() . '/includes/walkers/class-product-cat-list-walker.php' );

			ob_start();
			?>
			<div class="shop-menu">
				<a href="#" class="show-categories-menu"><?php esc_html_e( 'Categories', 'amely' ) ?></a>
				<ul class="product-categories-menu">
					<?php if ( is_product_category() || is_product_tag() ) { ?>
						<?php $link = ( $current_cat->parent ) ? get_category_link( $current_cat->parent ) : get_permalink( wc_get_page_id( 'shop' ) ); ?>
						<li class="cat-item shop-back-link">
							<a href="<?php echo esc_url( $link ); ?>"><span>&larr;</span><?php esc_html_e( 'Back',
									'amely' ) ?>
							</a>
						</li>
					<?php } ?>
					<?php wp_list_categories( $args ); ?>
				</ul>
			</div>

			<?php

			return ob_get_clean();
		}

		public function subcategory_count_html( $mark_class_count_category_count_mark, $category ) {
			if ( $category->count > 0 ) {
				echo ' <mark class="count">' . $category->count . ' ' . _n( 'item',
						'items',
						$category->count,
						'amely' ) . '</mark>';
			}
		}

		/**
		 * Calculate sale percentage
		 *
		 * @param $product
		 *
		 * @return float|int
		 */
		public static function get_sale_percentage( $product ) {
			$percentage    = 0;
			$regular_price = $product->get_regular_price();
			$sale_price    = $product->get_sale_price();

			if ( $product->get_regular_price() ) {
				$percentage = - round( ( ( $regular_price - $sale_price ) / $regular_price ) * 100 );
			}

			return $percentage . '%';
		}

		public function add_to_cart_args( $args, $product ) {
			$args['attributes']['data-product_name'] = get_the_title( $product->get_id() );

			return $args;
		}

		/**
		 * Add a hover image for product thumbnail within loops
		 *
		 * @see woocommerce_template_loop_product_thumbnail()
		 */
		public function template_loop_product_thumbnail() {

			global $product;

			$id        = $product->get_id();
			$size      = 'woocommerce_thumbnail';
			$gallery   = get_post_meta( $id, '_product_image_gallery', true );
			$hover_img = '';

			$size = apply_filters( 'amely_product_loop_thumbnail_size', $size );

			if ( ! empty( $gallery ) ) {
				$gallery        = explode( ',', $gallery );
				$first_image_id = $gallery[0];
				$hover_img      = wp_get_attachment_image( $first_image_id,
					$size,
					false,
					array( 'class' => 'hover-image' ) );
			}

			$thumb_img = get_the_post_thumbnail( $id, $size, array( 'class' => 'thumb-image' ) );
			if ( ! $thumb_img ) {
				if ( wc_placeholder_img_src() ) {
					$thumb_img = wc_placeholder_img( $size );
				}
			}

			echo '' . $thumb_img;
			echo '' . $hover_img;
		}

		/**
		 * Custom product title instead of default product title
		 *
		 * @see woocommerce_template_loop_product_title()
		 */
		public function template_loop_product_title() {
			echo '<h3 class="product-title"><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></h3>';
		}

		/**
		 * Product short description
		 */
		public function template_loop_product_excerpt() {
			global $post;

			echo '<div class="product-description">';
			echo apply_filters( 'woocommerce_short_description', $post->post_excerpt );
			echo '</div>';
		}

		/**
		 * Wishlist button
		 */
		public static function wishlist_button() {
			if ( class_exists( 'YITH_WCWL' ) && 'yes' == get_option( 'yith_wcwl_enabled' ) && amely_get_option( 'shop_wishlist_on' ) ) {
				echo do_shortcode( '[yith_wcwl_add_to_wishlist]' );
			}
		}

		/**
		 * Quickview button
		 */
		public static function quick_view_button() {

			ob_start();

			global $product;
			$id = $product->get_id();

			if ( amely_get_option( 'shop_quick_view_on' ) && ! wp_is_mobile() ) { ?>
				<div class="quick-view-btn hint--top-right hint-bounce"
				     aria-label="<?php esc_html_e( 'Quick View', 'amely' ); ?>"
				     data-pid="<?php echo esc_attr( $id ) ?>"
				     data-pnonce="<?php echo esc_attr( wp_create_nonce( 'amely_quick_view' ) ); ?>">
					<a href="#" aria-label="<?php esc_html_e( 'Quick View', 'amely' ); ?>" rel="nofollow">
						<?php esc_html_e( 'Quick View', 'amely' ); ?>
					</a>
				</div>
			<?php }

			echo ob_get_clean();
		}

		/**
		 * Compare button
		 */
		public static function compare_button() {

			ob_start();

			global $product;
			$id = $product->get_id();

			$button_text = get_option( 'yith_woocompare_button_text', esc_html__( 'Compare', 'amely' ) );

			if ( function_exists( 'yith_wpml_register_string' ) && function_exists( 'yit_wpml_string_translate' ) ) {
				yit_wpml_register_string( 'Plugins', 'plugin_yit_compare_button_text', $button_text );
				$button_text = yit_wpml_string_translate( 'Plugins', 'plugin_yit_compare_button_text', $button_text );
			}

			if ( ( class_exists( 'WPcleverWooscp' ) || class_exists( 'WooSCP' ) ) && amely_get_option( 'shop_compare_on' ) ) { ?>
				<div class="compare-btn hint--bounce hint--top-left"
				     aria-label="<?php esc_html_e( 'Compare', 'amely' ); ?>">
					<?php echo do_shortcode( '[wooscp id="' . $id . '" type="link"]' ); ?>
				</div>
			<?php } elseif ( class_exists( 'YITH_Woocompare' ) && amely_get_option( 'shop_compare_on' ) && ! wp_is_mobile() ) { ?>
				<div class="compare-btn hint--bounce hint--top-left"
				     aria-label="<?php esc_html_e( 'Compare', 'amely' ); ?>">
					<?php
					printf( '<a href="%s" class="%s" data-product_id="%d" rel="nofollow">%s</a>',
						self::get_compare_add_product_url( $id ),
						'compare',
						$id,
						$button_text );
					?>
				</div>
			<?php }

			echo ob_get_clean();
		}

		/**
		 * Get compare URL
		 */
		private static function get_compare_add_product_url( $product_id ) {

			$action_add = 'yith-woocompare-add-product';

			$url_args = array(
				'action' => $action_add,
				'id'     => $product_id,
			);

			return apply_filters( 'yith_woocompare_add_product_url',
				esc_url_raw( add_query_arg( $url_args ) ),
				$action_add );
		}

		public function quick_view() {

			global $post, $product;

			$post = get_post( $_REQUEST['pid'] );
			setup_postdata( $post );

			$product = wc_get_product( $post->ID );

			ob_start();

			get_template_part( 'woocommerce/quick-view' );

			echo ob_get_clean();

			die();
		}

		public static function get_quickview_image_size() {

			$cropping_width  = max( 1,
				get_option( 'woocommerce_thumbnail_cropping_custom_width', '3' ) );
			$cropping_height = max( 1,
				get_option( 'woocommerce_thumbnail_cropping_custom_height', '4' ) );
			$image_width     = intval( get_option( 'woocommerce_single_image_width', 432 ) ) * .8;
			$image_height    = absint( round( ( $image_width / $cropping_width ) * $cropping_height ) );

			return array(
				apply_filters( 'amely_quickview_image_width', $image_width ),
				apply_filters( 'amely_quickview_image_height', $image_height ),
			);
		}

		public function add_quick_view_container() {
			echo '<div id="woo-quick-view" class="' . ( amely_get_option( 'animated_quick_view_on' ) ? 'animated-quick-view' : '' ) . '"></div>';
		}

		public function ajax_add_to_cart() {

			global $woocommerce;

			$variation_id      = ( isset( $_POST['variation_id'] ) ) ? $_POST['variation_id'] : '';
			$_POST['quantity'] = ( isset( $_POST['quantity'] ) ) ? $_POST['quantity'] : 1;

			$variations = array();

			foreach ( $_POST as $key => $value ) {
				if ( substr( $key, 0, 10 ) == 'attribute_' ) {
					$variations[ $key ] = $value;
				}
			}

			if ( is_array( $_POST['quantity'] ) && ! empty( $_POST['quantity'] ) ) { // grouped product
				$quantity_set = false;

				foreach ( $_POST['quantity'] as $id => $qty ) {

					if ( $qty > 0 ) {

						$quantity_set = true;
						$atc          = $woocommerce->cart->add_to_cart( $id, $qty );

						if ( $atc ) {
							continue;
						} else {
							break;
						}
					}
				}

				if ( ! $quantity_set ) {
					$response            = array( 'result' => 'fail' );
					$response['message'] = esc_html__( 'Please choose the quantity of items you wish to add to your cart.',
						'amely' );
				}

			} else { // simple & variable product
				$atc = $woocommerce->cart->add_to_cart( $_POST['pid'], $_POST['quantity'], $variation_id, $variations );
			}

			if ( $atc ) {
				$this->refresh_cart_fragments();
			} else {

				$sold_indv = get_post_meta( $_POST['pid'], '_sold_individually', true );

				if ( $sold_indv == 'yes' ) {
					$response            = array( 'result' => 'fail' );
					$response['message'] = esc_html__( 'Sorry, that item can only be added once.', 'amely' );
				} else {

					if ( ! is_array( $_POST['quantity'] ) ) {
						$response            = array( 'result' => 'fail' );
						$response['message'] = esc_html__( 'Sorry, something went wrong. Please try again.',
							'amely' );
					}
				}

				$response['post'] = $_POST;

				wp_send_json( $response );
			}
		}

		/**
		 * Get Instagram image by hashtag for product
		 *
		 * @return string|void
		 */
		public static function product_instagram() {

			$hashtag = get_post_meta( Amely_Helper::get_the_ID(), 'amely_product_hashtag', true );

			if ( ! $hashtag ) {
				return;
			}

			ob_start();

			$number = apply_filters( 'amely_product_instagram_number', 8 );
			$col    = apply_filters( 'amely_product_instagram_columns', 4 );
			$class  = Amely_Helper::get_grid_item_class( array(
				'xl' => $col,
				'lg' => 4,
				'md' => 2,
				'sm' => 1,
			) );

			?>
			<div class="product-instagram">
				<div class="container">
					<p><?php printf( wp_kses( __( 'Tag your photos with <a href="%s" target="%s">%s</a> on Instagram.',
							'amely' ),
							'amely-a' ),
							esc_url( 'https://www.instagram.com/explore/tags/' . substr( $hashtag, 1 ) ),
							apply_filters( 'amely_product_instagram_link_target', '__blank' ),
							$hashtag ); ?></p>
					<?php

					$media_array = Amely_Instagram::get_instance()->scrape_instagram( $hashtag, $number );

					if ( is_wp_error( $media_array ) ) { ?>
						<div class="tm-instagram--error">
							<p><?php echo wp_kses_post( $media_array->get_error_message() ); ?></p>
						</div>
					<?php } else { ?>
						<div class="tm-instagram-pics row">
							<?php foreach ( $media_array as $item ) { ?>
								<div class="item <?php echo esc_attr( $class ) ?>">
									<div class="item-info">
										<span><?php esc_html_e( 'View on Instagram', 'amely' ); ?></span>
									</div>
									<img src="<?php echo esc_url( $item['thumbnail'] ) ?>" alt="image"
									     class="item-image"/>
									<?php if ( 'video' == $item['type'] ) { ?>
										<span class="play-button"></span>
									<?php } ?>

									<div class="overlay">
										<a href="<?php echo esc_url( $item['link'] ); ?>"
										   target="<?php echo apply_filters( 'amely_product_instagram_link_target',
											   '_blank' ); ?>"><?php esc_html_e( 'View on Instagram', 'amely' ) ?></a>
									</div>

								</div>
							<?php } ?>
						</div>

					<?php } ?>
				</div>
			</div>
			<?php

			return ob_get_clean();
		}

		/**
		 * Get shop layout
		 *
		 * @return mixed List or Grid
		 */
		public static function get_shop_view_mode() {

			if ( ! isset( $_COOKIE['amely_archive_view_mode'] ) || ! $_COOKIE['amely_archive_view_mode'] ) {
				$layout = amely_get_option( 'shop_view_mode' );
			} else {
				$layout = $_COOKIE['amely_archive_view_mode'];
			}

			return $layout;
		}

		/**
		 * Display variation name
		 * The product must be get by $_product->get_title() instead of $_product->get_name()
		 *
		 * The product in cart will be display like this: http://prntscr.com/fe1ylt
		 * instead of this: http://prntscr.com/fe1yt9
		 *
		 * @param $is_in_name
		 * @param $attribute
		 * @param $name
		 *
		 * @return bool
		 */
		public function is_attribute_in_product_name( $is_in_name, $attribute, $name ) {
			return false;
		}

		/**
		 * Gets and formats a list of cart item data + variations for display on the frontend.
		 *
		 * @param $cart_item
		 *
		 * @return string
		 */
		public static function get_item_data( $item_data, $cart_item ) {

			$isw_settings = get_option( 'isw_settings' );

			if ( class_exists( 'SitePress' ) ) {

				global $sitepress;

				if ( method_exists( $sitepress, 'get_default_language' ) ) {

					$default_language = $sitepress->get_default_language();
					$current_language = $sitepress->get_current_language();

					if ( $default_language != $current_language ) {
						$isw_settings = get_option( 'isw_settings_' . $current_language );
					}
				}
			}

			// Variation values are shown only if they are not found in the title as of 3.0.
			// This is because variation titles display the attributes.
			if ( $cart_item['data']->is_type( 'variation' ) && is_array( $cart_item['variation'] ) ) {
				foreach ( $cart_item['variation'] as $name => $value ) {
					$taxonomy = wc_attribute_taxonomy_name( str_replace( 'attribute_pa_', '', urldecode( $name ) ) );

					if ( taxonomy_exists( $taxonomy ) ) {
						// If this is a term slug, get the term's nice name.
						$term = get_term_by( 'slug', $value, $taxonomy );
						if ( ! is_wp_error( $term ) && $term && $term->name ) {
							$value = $term->name;
						}
						$label = wc_attribute_label( $taxonomy );
					} else {
						continue;
					}

					if ( isset( $isw_settings['isw_attr'] ) && is_array( $isw_settings['isw_attr'] ) && in_array( $taxonomy,
							$isw_settings['isw_attr'] ) ) {

						$isw_attr = $isw_settings['isw_attr'];

						if ( isset( $isw_settings['isw_style'] ) && is_array( $isw_settings['isw_style'] ) ) {
							$isw_style = $isw_settings['isw_style'];
							$swatch    = '';

							for ( $i = 0; $i < count( $isw_style ); $i ++ ) {

								if ( $taxonomy == $isw_attr[ $i ] ) {

									switch ( $isw_style[ $i ] ) {

										case 'isw_color':

											if ( isset( $isw_settings['isw_custom'] ) && is_array( $isw_settings['isw_custom'] ) ) {

												$isw_custom = isset( $isw_settings['isw_custom'][ $i ] ) ? $isw_settings['isw_custom'][ $i ] : '';

												if ( is_array( $isw_custom ) ) {

													foreach ( $isw_custom as $key => $value ) {

														if ( $term->slug == $key ) {
															$swatch_style = 'background-color:' . $value . ';';
														}
													}
												}

												if ( ! empty( $swatch_style ) ) {
													$swatch = '<span class="filter-swatch swatch-color hint--top hint--bounce" aria-label="' . esc_attr( esc_html( $term->name ) ) . '" style="' . $swatch_style . '"></span>';
												}
											}
											break;

										case 'isw_image':

											if ( isset( $isw_settings['isw_custom'] ) && is_array( $isw_settings['isw_custom'] ) ) {

												$isw_custom = isset( $isw_settings['isw_custom'][ $i ] ) ? $isw_settings['isw_custom'][ $i ] : '';

												if ( is_array( $isw_custom ) ) {

													foreach ( $isw_custom as $key => $value ) {

														if ( $term->slug == $key ) {

															$swatch = '<span class="filter-swatch swatch-image hint--top hint--bounce" aria-label="' . esc_attr( esc_html( $term->name ) ) . '"><img src="' . esc_url( $value ) . '" alt="' . esc_attr( $term->slug ) . '"/></span>';
														}
													}
												}
											}
											break;

										case 'isw_html':

											if ( isset( $isw_settings['isw_custom'] ) && is_array( $isw_settings['isw_custom'] ) ) {

												$isw_custom = isset( $isw_settings['isw_custom'][ $i ] ) ? $isw_settings['isw_custom'][ $i ] : '';

												if ( is_array( $isw_custom ) ) {

													foreach ( $isw_custom as $key => $value ) {

														if ( $term->slug == $key ) {

															$swatch = '<span class="filter-swatch swatch-html">' . $value . '</span>';
														}
													}
												}
											}
											break;

										case 'isw_text':
										default:

											if ( isset( $isw_settings['isw_custom'] ) && is_array( $isw_settings['isw_custom'] ) ) {

												$isw_custom = isset( $isw_settings['isw_custom'][ $i ] ) ? $isw_settings['isw_custom'][ $i ] : '';

												if ( is_array( $isw_custom ) ) {

													foreach ( $isw_custom as $key => $value ) {

														if ( $term->slug == $key ) {

															$swatch = '<span class="filter-swatch swatch-text">' . $value . '</span>';
														}
													}
												}
											}
											break;
									}
								}
							}

							for ( $i = 0; $i < count( $item_data ); $i ++ ) {

								if ( sanitize_title( $item_data[ $i ]['key'] ) == sanitize_title( $label ) ) {
									$item_data[ $i ]['id']      = 'isw_item_data';
									$item_data[ $i ]['display'] = $swatch;
								}
							}
						}
					}
				}
			}

			return $item_data;
		}

		/**
		 * Get product by given data source
		 *
		 * @param $data_source
		 * @param $atts array
		 * @param $args array Additional arguments
		 *
		 * @return mixed|WP_Query
		 */
		public static function get_products_by_datasource( $data_source, $atts, $args = array() ) {

			$defaults = array(
				'post_type'           => 'product',
				'status'              => 'published',
				'ignore_sticky_posts' => 1,
				'orderby'             => $atts['orderby'],
				'order'               => $atts['order'],
				'posts_per_page'      => intval( $atts['number'] ) > 0 ? intval( $atts['number'] ) : 1000,
			);

			$args = wp_parse_args( $args, $defaults );

			switch ( $data_source ) {
				case 'filter':
					$tax_array = $atts['tax_array'];
					$tax_query = array();

					foreach ( $tax_array as $key => $value ) {

						$tax_query[] = array(
							'relation' => $value['query_type'],
							array(
								'taxonomy' => $key,
								'field'    => 'slug',
								'terms'    => $value['terms'],
							),
						);
					}

					$args['tax_query'] = array( $tax_query );

					break;
				case 'featured_products':
					if ( version_compare( WC()->version, '3.0.0', '<' ) ) {
						$args['meta_key']   = '_featured';
						$args['meta_value'] = 'yes';
					} else {
						$args['tax_query'] = array(
							array(
								'taxonomy' => 'product_visibility',
								'field'    => 'name',
								'terms'    => array( 'featured' ),
								'operator' => 'IN',
							),
						);
					}
					break;
				case 'sale_products':
					$product_ids_on_sale   = wc_get_product_ids_on_sale();
					$product_ids_on_sale[] = 0;
					$args['post__in']      = $product_ids_on_sale;
					break;
				case 'best_selling_products':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				case 'top_rated_products':
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					$args['order']    = 'DESC';
					break;
				case 'product_attribute':
					$args['tax_query'] = array(
						array(
							'taxonomy' => strstr( $atts['attribute'],
								'pa_' ) ? sanitize_title( $atts['attribute'] ) : 'pa_' . sanitize_title( $atts['attribute'] ),
							'field'    => 'slug',
							'terms'    => array_map( 'sanitize_title', explode( ',', $atts['filter'] ) ),
						),
					);
					break;
				case 'products':
					if ( $atts['product_ids'] != '' ) {
						$args['post__in'] = explode( ',', $atts['product_ids'] );
						$args['orderby']  = ( ! $args['orderby'] || $args['orderby'] == 'none' ) ? 'post__in' : '';
					}
					break;
				case 'categories':
					$args['tax_query'] = array(
						'relation' => 'OR',
						array(
							'taxonomy'         => 'product_cat',
							'field'            => 'slug',
							'terms'            => explode( ',', $atts['product_cat_slugs'] ),
							'include_children' => $atts['include_children'],
						),
					);
					break;
				case 'category':
					$args['tax_query'] = array(
						'relation' => 'OR',
						array(
							'taxonomy'         => 'product_cat',
							'field'            => 'slug',
							'terms'            => $atts['category'],
							'include_children' => $atts['include_children'],
						),
					);
					break;
				case 'recent_products':
				default:
					if ( ! $args['orderby'] || $args['orderby'] == 'menu_order' ) {
						$args['order'] = 'ASC';
					}
					break;
			}

			switch ( $atts['orderby'] ) {
				case 'price':
				case 'price-desc':
					$args['meta_key'] = '_price';
					$args['orderby']  = 'meta_value_num';
					break;
				case 'salse':
					$args['meta_key'] = 'total_sales';
					$args['orderby']  = 'meta_value_num';
					break;
				case 'rating':
					$args['meta_key'] = '_wc_average_rating';
					$args['orderby']  = 'meta_value_num';
					break;
			}

			if ( ! empty( $atts['exclude'] ) ) {
				$args['post__not_in'] = explode( ',', $atts['exclude'] );
			}

			$transient_name = 'amely_wc_loop' . substr( md5( json_encode( $args ) . $data_source ),
					28 ) . WC_Cache_Helper::get_transient_version( 'product_query' );
			$query          = get_transient( $transient_name );

			if ( false === $query || ! is_a( $query, 'WP_Query' ) ) {
				$query = new WP_Query( $args );
				set_transient( $transient_name, $query, DAY_IN_SECONDS * 30 );
			}

			return $query;

		}

		/**
		 * Get base shop page link
		 *
		 * @param bool $keep_query
		 *
		 * @return false|string|void|WP_Error
		 */
		public static function get_shop_page_link( $keep_query = false ) {

			// Base Link decided by current page
			if ( defined( 'SHOP_IS_ON_FRONT' ) ) {
				$link = home_url();
			} elseif ( is_post_type_archive( 'product' ) || is_page( wc_get_page_id( 'shop' ) ) ) {
				$link = get_post_type_archive_link( 'product' );
			} elseif ( is_product_category() ) {
				$link = get_term_link( get_query_var( 'product_cat' ), 'product_cat' );
			} elseif ( is_product_tag() ) {
				$link = get_term_link( get_query_var( 'product_tag' ), 'product_tag' );
			} else {
				$link = get_term_link( get_query_var( 'term' ), get_query_var( 'taxonomy' ) );
			}

			if ( $keep_query ) {

				// Keep query string vars intact
				foreach ( $_GET as $key => $val ) {

					if ( 'orderby' === $key || 'submit' === $key ) {
						continue;
					}

					$link = add_query_arg( $key, $val, $link );
				}
			}

			return $link;
		}

		public static function is_shop() {
			return ( function_exists( 'is_shop' ) && is_shop() ) || ( function_exists( 'is_product_taxonomy' ) && is_product_taxonomy() );
		}

		public function product_single_navigation() {
			echo Amely_Templates::single_navigation();
		}

		function product_search_where( $where, $query ) {
			if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
				return $where;
			}

			global $wpdb;

			$where = preg_replace( "/\(\s*{$wpdb->posts}.post_title\s+LIKE\s*(\'[^\']+\')\s*\)/",
				"({$wpdb->posts}.post_title LIKE $1) OR (iconic_post_meta.meta_key = '_sku' AND iconic_post_meta.meta_value LIKE $1)",
				$where );

			return $where;
		}

		function product_search_join( $join, $query ) {
			if ( ! $query->is_main_query() || is_admin() || ! is_search() || ! is_woocommerce() ) {
				return $join;
			}

			global $wpdb;

			$join .= " LEFT JOIN {$wpdb->postmeta} iconic_post_meta ON {$wpdb->posts}.ID = iconic_post_meta.post_id ";

			return $join;
		}

		public function add_action_to_multi_currency_ajax( $ajax_actions ) {
			$ajax_actions[] = 'amely_ajax_load_more';

			return $ajax_actions;
		}
	}

	new Amely_Woo();
}
