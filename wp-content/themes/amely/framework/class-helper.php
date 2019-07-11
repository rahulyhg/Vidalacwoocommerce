<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper functions
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Helper' ) ) {

	class Amely_Helper {

		public static $theme_config;

		public function __construct() {
			add_action( 'wp_ajax_amely_ajax_search', array( $this, 'ajax_search' ) );
			add_action( 'wp_ajax_nopriv_amely_ajax_search', array( $this, 'ajax_search' ) );
			add_filter( 'posts_where', array( $this, 'title_like_posts_where' ), 10, 2 );

			add_action( 'wp_ajax_amely_ajax_load_more', array( $this, 'ajax_load_more' ) );
			add_action( 'wp_ajax_nopriv_amely_ajax_load_more', array( $this, 'ajax_load_more' ) );

			add_filter( 'wp_kses_allowed_html', array( $this, 'wp_kses_allowed_html' ), 2, 99 );
		}

		/**
		 * Get option from Redux Framework
		 *
		 * @since 1.0
		 *
		 * @param string $option
		 *
		 * @return mixed
		 */
		public static function get_option( $option = '' ) {

			global $amely_options;

			return isset( $amely_options[ $option ] ) ? $amely_options[ $option ] : '';
		}

		/**
		 * Get all menus
		 *
		 * @param $vc
		 * @param $allow_empty
		 *
		 * @return array|int|WP_Error
		 */
		public static function get_all_menus( $allow_empty = false, $vc = false ) {

			$args = array(
				'hide_empty' => true,
				'fields'     => 'id=>name',
				'slug'       => '',
			);

			$menus = get_terms( 'nav_menu', $args );

			if ( $allow_empty ) {
				$menus = array( esc_html__( '-- Select a menu --', 'amely' ) => '' );
			}

			if ( $vc ) {

				foreach ( $menus as $menu ) {

					$menus[ $menu->name ] = $menu->slug;
				}
			}

			return $menus;
		}

		/**
		 * Get sidebars
		 *
		 * @param bool $default_option
		 * @param bool $disable_option
		 *
		 * @return array
		 */
		public static function get_registered_sidebars( $default_option = false, $disable_option = false ) {

			global $wp_registered_sidebars;

			$sidebars = array();

			if ( $default_option ) {
				$sidebars['default'] = esc_html__( 'Default', 'amely' );
			}

			if ( $disable_option ) {
				$sidebars['no'] = esc_html__( 'Disable', 'amely' );
			}

			foreach ( $wp_registered_sidebars as $sidebar ) {
				$sidebars[ $sidebar['id'] ] = $sidebar['name'];
			}

			return $sidebars;
		}

		/**
		 * Get list page layout
		 *
		 * @return array
		 */
		public static function get_list_page_layout() {
			return array(
				'fullwidth'       => AMELY_FRAMEWORK_URI . '/assets/images/1c.png',
				'content-sidebar' => AMELY_FRAMEWORK_URI . '/assets/images/2cr.png',
				'sidebar-content' => AMELY_FRAMEWORK_URI . '/assets/images/2cl.png',
			);
		}

		/**
		 * Get theme setup
		 *
		 * @param string $setting
		 *
		 * @return mixed
		 */
		public static function get_config( $setting = '' ) {

			global $wp_filesystem;

			require_once( ABSPATH . '/wp-admin/includes/file.php' );
			WP_Filesystem();

			$path = AMELY_THEME_DIR . DS . 'assets' . DS . 'json' . DS . 'config.json';

			if ( file_exists( $path ) && empty( self::$theme_config ) ) {
				$json               = $wp_filesystem->get_contents( $path );
				self::$theme_config = json_decode( $json, true );
			}

			return self::$theme_config [ $setting ];

		}

		/**
		 * Returns an array of all the social icons
		 *
		 * @param bool $custom
		 * @param bool $colors
		 *
		 * @return array
		 */
		public static function social_icons( $custom = true, $colors = false ) {

			$networks = array(
				'amazon'         => array( 'label' => 'Amazon', 'color' => '#ff9900' ),
				'500px'          => array( 'label' => '500px', 'color' => '#222222' ),
				'behance'        => array( 'label' => 'Behance', 'color' => '#00a1d1' ),
				'bitbucket'      => array( 'label' => 'Bitbucket', 'color' => '#1c4f83' ),
				'codepen'        => array( 'label' => 'Codepen', 'color' => '#000000' ),
				'deviantart'     => array( 'label' => 'Deviantart', 'color' => '#4dc47d' ),
				'digg'           => array( 'label' => 'Digg', 'color' => '#000000' ),
				'dribbble'       => array( 'label' => 'Dribbble', 'color' => '#ea4c89' ),
				'dropbox'        => array( 'label' => 'Dropbox', 'color' => '#007ee5' ),
				'envelope-o'     => array(
					'label' => esc_html__( 'Email Address', 'amely' ),
					'color' => '#000000',
				),
				'facebook'       => array( 'label' => 'Facebook', 'color' => '#3b5998' ),
				'flickr'         => array( 'label' => 'Flickr', 'color' => '#0063dc' ),
				'foursquare'     => array( 'label' => 'Foursquare', 'color' => '#2d5be3' ),
				'github'         => array( 'label' => 'Github', 'color' => '#222222' ),
				'google-plus'    => array( 'label' => 'Google+', 'color' => '#dc4e41' ),
				'instagram'      => array( 'label' => 'Instagram', 'color' => '#3d6997' ),
				'linkedin'       => array( 'label' => 'LinkedIn', 'color' => '#0077b5' ),
				'odnoklassniki'  => array( 'label' => 'Odnoklassniki', 'color' => '#f78200' ),
				'pinterest'      => array( 'label' => 'Pinterest', 'color' => '#bd081c' ),
				'qq'             => array( 'label' => 'QQ', 'color' => '#000000' ),
				'rss'            => array( 'label' => 'RSS', 'color' => '#f26522' ),
				'reddit'         => array( 'label' => 'Reddit', 'color' => '#ff4500' ),
				'skype'          => array( 'label' => 'Skype', 'color' => '#00aff0' ),
				'slack'          => array( 'label' => 'Slack', 'color' => '#776ebd' ),
				'snapchat-ghost' => array( 'label' => 'Snapchat', 'color' => '#fffc00' ),
				'soundcloud'     => array( 'label' => 'Soundcloud', 'color' => '#ff8800' ),
				'spotify'        => array( 'label' => 'Spotify', 'color' => '#2ebd59' ),
				'stack-exchange' => array( 'label' => 'Stack Exchange', 'color' => '#2ebd59' ),
				'stack-overflow' => array( 'label' => 'Stack Overflow', 'color' => '#125099' ),
				'stumbleupon'    => array( 'label' => 'StumbleUpon', 'color' => '#ed4a10' ),
				'telegram'       => array( 'label' => 'Telegram', 'color' => '#0088cc' ),
				'tripadvisor'    => array( 'label' => 'Tripadvisor', 'color' => '#178a29' ),
				'tumblr'         => array( 'label' => 'Tumblr', 'color' => '#35465c' ),
				'twitch'         => array( 'label' => 'Twitch', 'color' => '#64429d' ),
				'twitter'        => array( 'label' => 'Twitter', 'color' => '#55acee' ),
				'vimeo'          => array( 'label' => 'Vimeo', 'color' => '#1ab7ea' ),
				'vine'           => array( 'label' => 'Vine', 'color' => '#00a577' ),
				'vk'             => array( 'label' => 'VK', 'color' => '#45668e' ),
				'weibo'          => array( 'label' => 'Weibo', 'color' => '#d72822' ),
				'xing'           => array( 'label' => 'Xing', 'color' => '#026466' ),
				'yahoo'          => array( 'label' => 'Yahoo', 'color' => '#410093' ),
				'yelp'           => array( 'label' => 'Yelp', 'color' => '#af0606' ),
				'youtube-play'   => array( 'label' => 'Youtube', 'color' => '#cd201f' ),
			);

			if ( $custom ) {
				$networks['custom'] = array( 'label' => esc_attr__( 'Custom', 'amely' ), 'color' => '' );
			}

			if ( ! $colors ) {
				$simple_networks = array();
				foreach ( $networks as $id => $args ) {
					$simple_networks[ $id ] = $args['label'];
				}
				$networks = $simple_networks;
			}

			return $networks;
		}

		/**
		 * Get page IDs from template
		 *
		 * @param $name
		 *
		 * @return array
		 */
		public static function get_pages_ids_from_template( $name ) {

			$pages = get_pages( array(
				'meta_key'   => '_wp_page_template',
				'meta_value' => $name . '.php',
			) );

			$return = array();

			foreach ( $pages as $page ) {
				$return[] = $page->ID;
			}

			return $return;
		}

		/**
		 * Convert text to 1 line
		 *
		 * @param $str
		 *
		 * @return string
		 */
		public static function text2line( $str ) {
			return trim( preg_replace( "/[\r\v\n\t]*/", '', $str ) );
		}

		public static function get_the_ID() {
			global $post;

			$page_id = 0;

			$page_for_posts = get_option( 'page_for_posts' );
			$page_for_shop  = get_option( 'woocommerce_shop_page_id' );

			if ( isset( $post->ID ) ) {
				$page_id = $post->ID;
			}

			if ( isset( $post->ID ) && ( is_singular( 'page' ) || is_singular( 'post' ) ) ) {
				$page_id = $post->ID;
			} else if ( is_home() || is_singular( 'post' ) || is_search() || is_tag() || is_category() || is_date() || is_author() ) {
				$page_id = $page_for_posts;
			}

			if ( class_exists( 'WooCommerce' ) && function_exists( 'is_shop' ) ) {
				if ( is_shop() || is_product_category() || is_product_tag() ) {
					$page_id = $page_for_shop;
				}
			}

			return $page_id;
		}

		public static function get_the_title() {

			$title = '';

			$post_id = self::get_the_ID();

			if ( is_front_page() && ! is_singular( 'page' ) ) {
				$title = esc_html__( 'Our Blog', 'amely' );
			} elseif ( is_home() && ! is_singular( 'page' ) ) {
				$title = get_the_title( get_option( 'page_for_posts', true ) );
			}

			// Search page
			if ( is_search() ) {

				global $wp_query;

				$title = apply_filters( 'amely_page_title',
					'<span id="search-results-count">' . $wp_query->found_posts . '</span> ' . _n( 'Search Result Found',
						'Search Results Found',
						$wp_query->found_posts,
						'amely' ) );
			}

			// Post Archive
			if ( is_tag() || is_category() || is_date() || is_author() ) {

				// Author.
				if ( is_author() ) {
					$title = get_the_archive_title();
				} elseif ( is_post_type_archive() ) {
					// Post Type archive title.
					$title = post_type_archive_title( '', false );
				} elseif ( is_day() ) {
					// Daily archive title.
					$title = sprintf( esc_html__( 'Daily Archives: %s', 'amely' ), get_the_date() );
				} elseif ( is_month() ) {
					// Monthly archive title.
					$title = sprintf( esc_html__( 'Monthly Archives: %s', 'amely' ),
						get_the_date( esc_html_x( 'F Y', 'Page title monthly archives date format', 'amely' ) ) );
				} elseif ( is_year() ) {
					// Yearly archive title.
					$title = sprintf( esc_html__( 'Yearly Archives: %s', 'amely' ),
						get_the_date( esc_html_x( 'Y', 'Page title yearly archives date format', 'amely' ) ) );
				} else {
					// Categories/Tags/Other.

					// Get term title.
					$title = single_term_title( '', false );

					// Fix for plugins that are archives but use pages.
					if ( ! $title ) {
						$title = get_the_title( $post_id );
					}
				}
			}

			// 404 Page
			if ( is_404() ) {

				$title = esc_html__( '404: Page Not Found', 'amely' );

			}

			// Anything else with a post_id defined.
			if ( $post_id ) {

				if ( is_singular( 'post' ) ) {
					$title = get_post_meta( $post_id,
						'amely_post_title_on_top',
						true ) ? get_the_title( $post_id ) : esc_html__( 'Our Blog', 'amely' );
				} elseif ( is_singular( 'product' ) ) {
					$title = get_post_meta( $post_id,
						'amely_product_title_on_top',
						true ) ? get_the_title( $post_id ) : woocommerce_page_title( false );
				} else {
					$title = get_the_title( $post_id );
				}

				// Custom meta title.
				if ( $custom_title = get_post_meta( $post_id, 'amely_custom_page_title', true ) ) {
					$title = $custom_title;
				}
			}

			if ( class_exists( 'WooCommerce' ) && ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) ) {

				if ( apply_filters( 'woocommerce_show_page_title', true ) && ! is_product() ) {

					$title = woocommerce_page_title( false );

					// Custom meta title for shop page
					if ( is_shop() && $custom_title = get_post_meta( $post_id, 'amely_custom_page_title', true ) ) {
						$title = $custom_title;
					}

					if ( wc_get_page_id( 'shop' ) < 0 ) {
						$title = esc_html__( 'Shop', 'amely' );
					}
				}
			}

			return apply_filters( 'amely_page_title', $title );;
		}

		/**
		 * Get the current locale.
		 *
		 * @since   1.0.0
		 * @return  string $locale
		 */
		public static function get_locale() {

			$locale = get_locale();

			if ( preg_match( '#^[a-z]{2}\-[A-Z]{2}$#', $locale ) ) {
				$locale = str_replace( '-', '_', $locale );
			} else if ( preg_match( '#^[a-z]{2}$#', $locale ) ) {
				$locale .= '_' . mb_strtoupper( $locale, 'UTF-8' );
			}

			if ( empty( $locale ) ) {
				$locale = 'en_US';
			}

			return $locale;

		}

		public static function get_grid_item_class( $number_of_cols ) {

			$total_cols = 12;
			$classes    = array();

			if ( ! is_array( $number_of_cols ) && is_numeric( $number_of_cols ) && $number_of_cols > 0 ) {

				if ( 0 == $total_cols % $cols ) {
					$width     = $total_cols / $cols;
					$classes[] = 'col-md-' . $width;
				} else {
					if ( 5 == $cols ) {
						$classes[] = 'col-md-is-5';
					}
				}
			} else {

				foreach ( $number_of_cols as $media_query => $cols ) {

					$cols = intval( $cols );

					if ( $cols == 0 ) {
						$cols = 1;
					}

					if ( 0 == $total_cols % $cols ) {
						$width     = $total_cols / $cols;
						$classes[] = 'col-' . $media_query . '-' . $width;
					} else {
						if ( 5 == $cols ) {
							$classes[] = 'col-' . $media_query . '-is-5';
						}
					}
				}
			}

			return join( ' ', $classes );
		}

		/**
		 * GET CUSTOM POST TYPE TAXONOMY LIST.
		 *
		 * @param        $category_name
		 * @param int $filter
		 * @param string $category_child
		 * @param bool $frontend_display
		 *
		 * @return array|void
		 */
		public static function get_category_list( $category_name, $filter = 0, $category_child = '', $frontend_display = false ) {

			if ( ! $frontend_display && ! is_admin() ) {
				return;
			}

			if ( $category_name == 'product-category' ) {
				$category_name = 'product_cat';
			}

			if ( ! $filter ) {

				$get_category  = get_categories( array( 'taxonomy' => $category_name, 'hide_empty' => 0 ) );
				$category_list = array( '0' => 'All' );

				foreach ( $get_category as $category ) {
					if ( isset( $category->slug ) ) {
						$category_list[] = $category->slug;
					}
				}

				return $category_list;

			} else if ( $category_child != '' && $category_child != 'All' ) {

				$childcategory = get_term_by( 'slug', $category_child, $category_name );
				$get_category  = get_categories( array(
					'taxonomy' => $category_name,
					'child_of' => $childcategory->term_id,
				) );
				$category_list = array( '0' => 'All' );

				foreach ( $get_category as $category ) {
					if ( isset( $category->cat_name ) ) {
						$category_list[] = $category->slug;
					}
				}

				return $category_list;

			} else {

				$get_category  = get_categories( array( 'taxonomy' => $category_name, 'hide_empty' => 0 ) );
				$category_list = array( '0' => 'All' );

				foreach ( $get_category as $category ) {
					if ( isset( $category->cat_name ) ) {
						$category_list[] = $category->cat_name;
					}
				}

				return $category_list;
			}
		}

		/**
		 * AJAX SEARCH
		 */
		public function ajax_search() {

			if ( ! empty( $_REQUEST['query'] ) ) {

				$query          = stripslashes( $_REQUEST['query'] );
				$post_type      = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : amely_get_option( 'search_post_type' );
				$posts_per_page = isset( $_REQUEST['limit'] ) ? $_REQUEST['limit'] : amely_get_option( 'search_limit' );
				$product_cat    = isset( $_REQUEST['product_cat'] ) ? $_REQUEST['product_cat'] : '0';
				$cat            = isset( $_REQUEST['cat'] ) ? $_REQUEST['cat'] : '0';
				$search_by      = amely_get_option( 'search_by' );
				$thumb_size     = apply_filters( 'amely_search_thumb_size', 'amely-search-thumb' );

				$args = array(
					'post_type'           => $post_type,
					'post_status'         => 'publish',
					'ignore_sticky_posts' => 1,
					'posts_per_page'      => $posts_per_page,
					'orderby'             => 'title',
					'order'               => 'ASC',
					'tax_query'           => array(
						'relation' => 'AND',
					),
				);

				if ( class_exists( 'WooCommerce' ) ) {

					global $woocommerce;

					$ordering_args = $woocommerce->query->get_catalog_ordering_args( 'title', 'asc' );

					$args['orderby'] = $ordering_args['orderby'];
					$args['order']   = $ordering_args['order'];
				}

				if ( $post_type == 'product' ) {

					if ( version_compare( WC()->version, '3.0.0', '<' ) ) {
						$args['meta_query'] = array(
							array(
								'key'     => '_visibility',
								'value'   => array( 'search', 'visible' ),
								'compare' => 'IN',
							),
						);
					} else {
						$product_visibility_term_ids = wc_get_product_visibility_term_ids();

						$args['meta_query'][] = array(
							'taxonomy' => 'product_visibility',
							'field'    => 'term_taxonomy_id',
							'terms'    => $product_visibility_term_ids['exclude-from-search'],
							'operator' => 'NOT IN',
						);
					}

					$args['suppress_filters'] = false;

					if ( $product_cat != '0' ) {

						$args['tax_query'][] = array(
							'taxonomy' => 'product_cat',
							'field'    => 'slug',
							'terms'    => $_REQUEST['product_cat'],
						);
					}

					if ( $search_by == 'title' ) {

						$args['post_title_like'] = $query;

					} elseif ( $search_by == 'sku' ) {

						$search_ids = $this->search_by_sku( $query );

						if ( ! empty( $search_ids ) ) {
							$args['post__in'] = $search_ids;
						} else {
							$suggestions = array(
								'suggestions' => array(
									array(
										'id'    => - 1,
										'value' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with different keywords',
											'amely' ),
										'url'   => '',
									),
								),
							);

							wp_send_json( $suggestions );
						}
					} else { // both title & SKU

						$search_ids = $this->search_by_sku( $query );

						// If SKU is not found, find by title
						if ( empty( $search_ids ) ) {
							$args['post_title_like'] = $query;
						} else {
							$args['post__in'] = $search_ids;
						}
					}
				}

				if ( $post_type == 'post' ) {

					if ( $cat != '0' ) {
						$args['category_name'] = $_REQUEST['cat'];
					}
				}

				$posts       = new WP_Query( $args );
				$suggestions = array();

				if ( $posts->have_posts() ) {

					$wptexturize = remove_filter( 'the_title', 'wptexturize' );

					while ( $posts->have_posts() ) {

						global $post;

						$posts->the_post();

						if ( $post_type == 'product' ) {

							$product = wc_get_product( $post );

							$suggestions[] = array(
								'id'        => $product->get_id(),
								'value'     => strip_tags( $product->get_title() ),
								'url'       => $product->get_permalink(),
								'thumbnail' => $product->get_image( 'shop_thumbnail' ),
								'price'     => $product->get_price_html(),
								'sku'       => $product->get_sku(),
								'excerpt'   => $post->post_excerpt,
							);
						}

						if ( $post_type == 'post' ) {

							$date = get_the_date( '', $post );

							if ( ! $date ) {
								$date = get_the_modified_date( '', $post );
							}

							$suggestions[] = array(
								'id'        => get_the_ID(),
								'value'     => get_the_title(),
								'url'       => get_permalink( $post ),
								'date'      => $date,
								'thumbnail' => get_the_post_thumbnail( $post->ID, $thumb_size ),
								'excerpt'   => $post->post_excerpt,
							);

						}
					}

					if ( $wptexturize ) {
						add_filter( 'the_title', 'wptexturize' );
					}

					// add view all link
					$query_str = '?s=' . $query . '&post_type=' . $post_type;

					if ( $product_cat != '0' ) {
						$query_str .= '&product_cat=' . $product_cat;
					}

					if ( $cat != '0' ) {
						$query_str .= '&category_name=' . $cat;
					}

					if ( intval( $posts->found_posts ) > $posts_per_page ) {

						$suggestions[] = array(
							'id'     => - 2,
							'value'  => esc_html__( 'View All', 'amely' ),
							'url'    => esc_url( home_url( '/' ) ) . $query_str,
							'target' => apply_filters( 'amely_search_view_all_target', '_blank' ),
						);
					}

					wp_reset_postdata();

				} else {
					$suggestions[] = array(
						'id'    => - 1,
						'value' => esc_html__( 'Sorry, but nothing matched your search terms. Please try again with different keywords',
							'amely' ),
						'url'   => '',
					);
				}

				$suggestions = array(
					'suggestions' => $suggestions,
				);

				wp_send_json( $suggestions );
			}

		}

		public function title_like_posts_where( $where, $wp_query ) {
			global $wpdb;
			if ( $post_title_like = $wp_query->get( 'post_title_like' ) ) {
				$where .= ' AND ' . $wpdb->posts . '.post_title LIKE \'%' . esc_sql( $wpdb->esc_like( $post_title_like ) ) . '%\'';
			}

			return $where;
		}

		public function search_by_sku( $sku ) {

			global $wpdb;

			// search for variations with a matching sku and return the parent.
			$sku_to_parent_id = $wpdb->get_col( $wpdb->prepare( "SELECT p.post_parent as post_id FROM {$wpdb->posts} as p join {$wpdb->postmeta} pm on p.ID = pm.post_id and pm.meta_key='_sku' and pm.meta_value LIKE '%%%s%%' where p.post_parent <> 0 group by p.post_parent",
				sanitize_text_field( $sku ) ) );

			//Search for a regular product that matches the sku.
			$sku_to_id = $wpdb->get_col( $wpdb->prepare( "SELECT post_id FROM {$wpdb->postmeta} WHERE meta_key='_sku' AND meta_value LIKE '%%%s%%';",
				wc_clean( $sku ) ) );

			return array_merge( $sku_to_id, $sku_to_parent_id );

		}

		/**
		 * AJAX LOAD MORE
		 */
		public function ajax_load_more() {

			$post_type = isset( $_REQUEST['post_type'] ) ? $_REQUEST['post_type'] : 'post';

			$args = array(
				'post_type'           => $post_type,
				'post_status'         => 'publish',
				'ignore_sticky_posts' => 1,
				'offset'              => $_REQUEST['offset'],
				'posts_per_page'      => $_REQUEST['posts_per_page'],
				'orderby'             => isset( $_REQUEST['orderby'] ) ? $_REQUEST['orderby'] : 'date',
				'order'               => isset( $_REQUEST['order'] ) ? $_REQUEST['order'] : 'DESC',
				'post__not_in'        => $_REQUEST['exclude'],
			);

			if ( isset( $_REQUEST['exclude'] ) ) {
				unset( $args['offset'] );
			}

			if ( $post_type == 'post' ) {

				$filter = isset( $_REQUEST['filter'] ) ? $_REQUEST['filter'] : '';

				switch ( $filter ) {
					case 'category';
						if ( isset( $_REQUEST['cat_slugs'] ) ) {
							$args['category_name'] = $_REQUEST['cat_slugs'];
						}
						break;
					case 'tag';
						if ( isset( $_REQUEST['tag_slugs'] ) ) {
							$args['tag'] = $_REQUEST['tag_slugs'];
						}
						break;

				}

				$shortcode_post_class = isset( $_POST['columns'] ) ? 'col-lg-' . Amely_VC::calculate_column_width( $_POST['columns'] ) : 'col-lg-3';
				$shortcode_post_class .= ' post adding-item';

				$view = $_REQUEST['view'];

				$query = new WP_Query( $args );
			}

			if ( $post_type == 'product' ) {

				$data_source = isset( $_REQUEST['data_source'] ) ? $_REQUEST['data_source'] : '';

				$atts = array();

				if ( $data_source == 'filter' ) {
					$atts['tax_array'] = isset( $_REQUEST['tax_array'] ) ? $_REQUEST['tax_array'] : '';
				}

				if ( $data_source == 'product_attribute' ) {
					$atts['attribute'] = isset( $_REQUEST['attribute'] ) ? $_REQUEST['attribute'] : '';
					$atts['filter']    = isset( $_REQUEST['filter'] ) ? $_REQUEST['filter'] : '';
				}

				if ( $data_source == 'categories' ) {
					$atts['product_cat_slugs'] = isset( $_REQUEST['product_cat_slugs'] ) ? $_REQUEST['product_cat_slugs'] : '';
					$atts['include_children']  = isset( $_REQUEST['include_children'] ) ? $_REQUEST['include_children'] : true;
				}

				if ( $data_source == 'category' ) {
					$atts['category']         = isset( $_REQUEST['category'] ) ? $_REQUEST['category'] : '';
					$atts['include_children'] = isset( $_REQUEST['include_children'] ) ? $_REQUEST['include_children'] : true;
				}

				$query = Amely_Woo::get_products_by_datasource( $data_source, $atts, $args );

				add_filter( 'amely_shop_products_columns',
					function() {

						return array(
							'xs' => 1,
							'sm' => 2,
							'md' => 3,
							'lg' => 3,
							'xl' => isset( $_REQUEST['columns'] ) ? $_REQUEST['columns'] : 4,
						);
					} );

				add_filter( 'amely_shop_products_classes',
					function() {
						return 'adding-item';
					} );
			}

			ob_start();

			if ( $query->have_posts() ) {

				while ( $query->have_posts() ) {

					$query->the_post();

					if ( $post_type == 'post' ) {

						add_filter( 'amely_blog_image_size',
							function() {
								return ( $view == 'grid' ) ? 'amely-post-grid' : 'amely-single-thumb';
							} );
						include( locate_template( 'components/post/content.php' ) );
					} ?>

					<?php if ( $post_type == 'product' ) {
						wc_get_template_part( 'content', 'product' );
					}
				}

				wp_reset_postdata();
			}

			$data = ob_get_clean();

			wp_send_json( $data );
		}

		/**
		 * Convert image size in pixels to array
		 * Eg, 200x100 => array (200, 100)
		 *
		 * If image size is string, don't need to convert
		 *
		 * @param $size
		 *
		 * @return array|false
		 */
		public static function convert_image_size( $size ) {

			global $_wp_additional_image_sizes;

			if ( is_string( $size ) && ( ( ! empty( $_wp_additional_image_sizes[ $size ] ) && is_array( $_wp_additional_image_sizes[ $size ] ) ) || in_array( $size,
						array(
							'thumbnail',
							'thumb',
							'medium',
							'large',
							'full',
						) ) )
			) {
				return $size;
			} else {
				if ( is_string( $size ) ) {
					preg_match_all( '/\d+/', $size, $thumb_matches );
					if ( isset( $thumb_matches[0] ) ) {
						$size  = array();
						$count = count( $thumb_matches[0] );
						if ( $count > 1 ) {
							$size[] = $thumb_matches[0][0]; // width
							$size[] = $thumb_matches[0][1]; // height
						} elseif ( 1 === $count ) { // square image
							$size[] = $thumb_matches[0][0]; // width
							$size[] = $thumb_matches[0][0]; // height
						} else {
							$size = false;
						}
					}
				}
				if ( is_array( $size ) ) {
					return $size;
				}
			}

			return '';
		}

		/**
		 * Get size information for all currently-registered image sizes.
		 *
		 * @global $_wp_additional_image_sizes
		 * @uses   get_intermediate_image_sizes()
		 * @return array $sizes Data for all currently-registered image sizes.
		 */
		public static function get_image_sizes() {

			global $_wp_additional_image_sizes;

			$sizes = array();

			foreach ( get_intermediate_image_sizes() as $_size ) {
				if ( in_array( $_size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
					$sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
					$sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
					$sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
				} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
					$sizes[ $_size ] = array(
						'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
						'height' => $_wp_additional_image_sizes[ $_size ]['height'],
						'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
					);
				}
			}

			return $sizes;
		}

		/**
		 * Get size information for a specific image size.
		 *
		 * @uses   get_image_sizes()
		 *
		 * @param  string $size The image size for which to retrieve data.
		 *
		 * @return bool|array $size Size data about an image size or false if the size doesn't exist.
		 */
		public static function get_image_size( $size ) {

			$sizes = self::get_image_sizes();

			if ( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			}

			return false;
		}

		/**
		 * Get the width of a specific image size.
		 *
		 * @uses   get_image_size()
		 *
		 * @param  string $size The image size for which to retrieve data.
		 *
		 * @return bool|string $size Width of an image size or false if the size doesn't exist.
		 */
		public static function get_image_width( $size ) {

			if ( ! $size = self::get_image_size( $size ) ) {
				return false;
			}

			if ( isset( $size['width'] ) ) {
				return $size['width'];
			}

			return false;
		}

		/**
		 * Get the height of a specific image size.
		 *
		 * @uses   get_image_size()
		 *
		 * @param  string $size The image size for which to retrieve data.
		 *
		 * @return bool|string $size Height of an image size or false if the size doesn't exist.
		 */
		public static function get_image_height( $size ) {

			if ( ! $size = self::get_image_size( $size ) ) {
				return false;
			}

			if ( isset( $size['height'] ) ) {
				return $size['height'];
			}

			return false;
		}

		/**
		 * Get active sidebar for page
		 *
		 * @var $shop
		 * @return array|bool false if no sidebar or sidebar is not activated,
		 */
		public static function get_active_sidebar( $shop = false ) {

			$sidebar_class = $sidebar_config = '';
			$page_id       = Amely_Helper::get_the_ID();

			// DEFAULT SIDEBAR CONFIG - Page.
			$default_sidebar_config = amely_get_option( 'page_sidebar_config' );
			$sidebar                = get_post_meta( $page_id, 'amely_page_custom_sidebar', true );

			// DEFAULT SIDEBAR CONFIG - Blog.
			if ( is_archive() || is_author() || is_category() || is_home() ) {
				$default_sidebar_config = amely_get_option( 'archive_sidebar_config' );
				$sidebar                = amely_get_option( 'archive_sidebar' );
			}

			// For search page
			if ( is_search() ) {
				$default_sidebar_config = amely_get_option( 'search_sidebar_config' );
				$sidebar                = amely_get_option( 'search_sidebar' );
			}

			// DEFAULT SIDEBAR CONFIG - Single Post.
			if ( is_singular( 'post' ) ) {
				$sidebar_config = get_post_meta( $page_id, 'amely_post_sidebar_config', true );
				$sidebar        = get_post_meta( $page_id, 'amely_post_custom_sidebar', true );

				if ( $sidebar_config == 'default' ) {
					$sidebar_config = amely_get_option( 'post_sidebar_config' );
					$sidebar        = amely_get_option( 'post_sidebar' );
				}
			}

			if ( ! $sidebar ) {
				$sidebar = 'sidebar';
			}

			// WooCommerce
			if ( $shop ) {

				// shop page
				if ( ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && ! is_singular( 'product' ) && ! is_search() ) {
					$sidebar_config = amely_get_option( 'shop_sidebar_config' );
					$sidebar        = amely_get_option( 'shop_sidebar' );
				}

				if ( ! is_product() ) {
 					$title = woocommerce_page_title( false );
 				}

				// In single product page
				if ( is_product() ) {
					$sidebar_config = get_post_meta( $page_id, 'amely_product_sidebar_config', true );
					$sidebar        = get_post_meta( $page_id, 'amely_product_custom_sidebar', true );

					if ( $sidebar_config == 'default' ) {
						$sidebar_config = amely_get_option( 'product_sidebar_config' );
						$sidebar        = amely_get_option( 'product_sidebar' );
					}
				}

				if ( ! $sidebar ) {
					$sidebar = 'sidebar-shop';
				}

			}

			// DEFAULTS.
			if ( ! $sidebar_config ) {
				$sidebar_config = $default_sidebar_config;
			}

			if ( $sidebar_config == 'left' ) {
				$sidebar_class .= 'flex-md-first';
			}

			if ( $sidebar_config == 'no' || ! is_active_sidebar( $sidebar ) ) {
				return false;
			}

			return array(
				'class'   => $sidebar_class,
				'sidebar' => $sidebar,
			);

		}

		/**
		 * Get CSS class for widget in shop area. Based on the number of widgets
		 *
		 * @param string $sidebar_id
		 *
		 * @return mixed|void
		 */
		public static function get_widget_column_class( $sidebar_id = 'filters-area' ) {

			global $_wp_sidebars_widgets;

			if ( empty( $_wp_sidebars_widgets ) ) :
				$_wp_sidebars_widgets = get_option( 'sidebars_widgets', array() );
			endif;

			$sidebars_widgets_count = $_wp_sidebars_widgets;

			if ( isset( $sidebars_widgets_count[ $sidebar_id ] ) || $sidebar_id == 'filters-area' ) {
				$count          = ( isset( $sidebars_widgets_count[ $sidebar_id ] ) ) ? count( $sidebars_widgets_count[ $sidebar_id ] ) : 0;
				$widget_count   = apply_filters( 'widgets_count_' . $sidebar_id, $count );
				$widget_classes = 'widget-count-' . $widget_count;
				$widget_classes .= ' ' . self::get_grid_item_class( array(
						'xs' => 1,
						'sm' => 2,
						'md' => 2,
						'lg' => $widget_count,
					) );

				return apply_filters( 'widget_class_' . $sidebar_id, $widget_classes );
			}
		}

		/**
		 * Convert hexadec color string to rgb(a) string
		 *
		 * @param  $color
		 * @param  $opacity
		 *
		 * @return string
		 */

		public static function hex2rgba( $color, $opacity = 0 ) {

			$default = 'rgba(0,0,0,0)';

			//Return default if no color provided
			if ( empty( $color ) ) {
				return $default;
			}

			//Sanitize $color if "#" is provided
			if ( $color[0] == '#' ) {
				$color = substr( $color, 1 );
			}

			//Check if color has 6 or 3 characters and get values
			if ( strlen( $color ) == 6 ) {
				$hex = array( $color[0] . $color[1], $color[2] . $color[3], $color[4] . $color[5] );
			} elseif ( strlen( $color ) == 3 ) {
				$hex = array( $color[0] . $color[0], $color[1] . $color[1], $color[2] . $color[2] );
			} else {
				return $default;
			}

			//Convert hexadec to rgb
			$rgb = array_map( 'hexdec', $hex );

			if ( abs( $opacity ) > 1 ) {
				$opacity = 1.0;
			}
			$output = 'rgba(' . implode( ",", $rgb ) . ',' . $opacity . ')';

			//Return rgb(a) color string
			return $output;
		}

		function wp_kses_allowed_html( $allowedtags, $context ) {

			switch ( $context ) {
				case 'amely-widget':
					$allowedtags = array(
						'h3'   => array(
							'id'    => array(),
							'class' => array(),
						),
						'div'  => array(
							'id'    => array(),
							'class' => array(),
						),
						'span' => array(
							'id'    => array(),
							'class' => array(),
						),
						'a'    => array(
							'id'     => array(),
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
							'title'  => array(),
						),
						'img'  => array(
							'src'   => array(),
							'alt'   => array(),
							'id'    => array(),
							'class' => array(),
						),
					);
					break;
				case 'amely-breadcrumbs':
					$allowedtags = array(
						'ul' => array(
							'class' => array(),
						),
						'li' => array(
							'class' => array(),
						),
						'a'  => array(
							'id'     => array(),
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
							'title'  => array(),
						),
					);
					break;
				case 'amely-title':
					$allowedtags = array(
						'h1'     => array(
							'id'    => array(),
							'class' => array(),
						),
						'h2'     => array(
							'id'    => array(),
							'class' => array(),
						),
						'h3'     => array(
							'id'    => array(),
							'class' => array(),
						),
						'a'      => array(
							'id'     => array(),
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
							'title'  => array(),
						),
						'span'   => array(
							'id'    => array(),
							'class' => array(),
						),
						'strong' => array(),
					);

					break;
				case 'amely-price':
					$allowedtags = array(
						'span' => array(
							'id'    => array(),
							'class' => array(),
						),
						'ins'  => array(),
						'del'  => array(),
					);

					break;
				case 'amely-span':
					$allowedtags = array(
						'span' => array( 'id' => array(), 'class' => array() ),
					);
					break;
				case 'amely-i':
					$allowedtags = array(
						'i' => array( 'id' => array(), 'class' => array() ),
					);
					break;
				case 'amely-a':
					$allowedtags = array(
						'a' => array(
							'id'     => array(),
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
							'title'  => array(),
						),
					);
					break;
				case 'amely-time':
					$allowedtags = array(
						'time' => array(
							'class'    => array(),
							'datetime' => array(),
						)
					);
					break;
				case 'amely-heading':
					$allowedtags = array(
						'h1'     => array( 'id' => array(), 'class' => array() ),
						'h2'     => array( 'id' => array(), 'class' => array() ),
						'h3'     => array( 'id' => array(), 'class' => array() ),
						'h4'     => array( 'id' => array(), 'class' => array() ),
						'h5'     => array( 'id' => array(), 'class' => array() ),
						'h6'     => array( 'id' => array(), 'class' => array() ),
						'p'      => array( 'id' => array(), 'class' => array() ),
						'div'    => array( 'id' => array(), 'class' => array() ),
						'span'   => array( 'id' => array(), 'class' => array() ),
						'a'      => array(
							'id'     => array(),
							'class'  => array(),
							'href'   => array(),
							'target' => array(),
							'rel'    => array(),
							'title'  => array(),
						),
						'strong' => array(),
					);
					break;
				case 'amely-default':
				default:
					global $allowedposttags;
					$allowedtags = $allowedposttags;
					break;
			}

			return $allowedtags;
		}
	}

	new Amely_Helper();
}
