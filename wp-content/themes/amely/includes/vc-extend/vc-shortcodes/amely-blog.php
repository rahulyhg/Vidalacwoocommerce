<?php

/**
 * Amely Blog Shortcode
 *
 * @version 1.0
 * @package Amely
 */
class WPBakeryShortCode_Amely_Blog extends WPBakeryShortCode {

	public $query = '';
	public $num_pages = 0;
	public $paged;
	public $offset = 0;

	public function __construct( $settings ) {
		parent::__construct( $settings );
		add_filter( 'amely_blog_image_size', array( $this, 'get_image_size' ) );
	}

	public function get_image_size() {
		$atts = vc_map_get_attributes( $this->getShortcode(), $this->getAtts() );

		return ( $atts['view'] == 'grid' || $atts['view'] == 'carousel' ) ? 'amely-post-grid' : 'amely-single-thumb';
	}

	public function get_query( $atts ) {

		$total_posts    = intval( $atts['total_posts'] ) > 0 ? intval( $atts['total_posts'] ) : 1000;
		$posts_per_page = intval( $atts['posts_per_page'] ) > 0 ? intval( $atts['posts_per_page'] ) : 5;

		if ( $total_posts > 0 && $posts_per_page > 0 && $posts_per_page > $total_posts ) {
			$posts_per_page = $total_posts;
		}

		if ( get_query_var( 'paged' ) ) {
			$this->paged = get_query_var( 'paged' );
		} else if ( get_query_var( 'page' ) ) {
			$this->paged = get_query_var( 'page' );
		} else {
			$this->paged = 1;
		}

		$orderby = $atts['orderby'];
		$order   = $atts['order'];

		$cat_slugs = $atts['cat_slugs'];
		$tag_slugs = $atts['tag_slugs'];

		$offset = $posts_per_page * ( $this->paged - 1 );
		$args   = array(
			'post_type'      => 'post',
			'offset'         => $offset,
			'post_count'     => $total_posts,
			'posts_per_page' => $posts_per_page,
			'orderby'        => $orderby,
			'order'          => $order,
		);

		if ( $cat_slugs ) {
			$args['category_name'] = $cat_slugs;
		}

		if ( $tag_slugs ) {
			$args['tag'] = $tag_slugs;
		}

		$this->query = new WP_Query( $args );

		$this->num_pages = intval( $atts['total_posts'] ) != - 1 ? ceil( $total_posts / $posts_per_page ) : $this->query->max_num_pages;
	}

	/***
	 * Display navigation to next/previous set of posts when applicable.
	 *
	 * @return array|string
	 */
	public function get_paging_nav() {
		global $wp_rewrite;

		// Don't print empty markup if there's only one page.
		if ( $this->num_pages < 2 ) {
			return '';
		}

		$pagenum_link = wp_kses_post( get_pagenum_link() );
		$query_args   = array();
		$url_parts    = explode( '?', $pagenum_link );

		if ( isset( $url_parts[1] ) ) {
			wp_parse_str( $url_parts[1], $query_args );
		}

		$pagenum_link = esc_url( remove_query_arg( array_keys( $query_args ), $pagenum_link ) );
		$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

		$format = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
		$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%',
			'paged' ) : '?paged=%#%';

		// Set up paginated links.
		$links = paginate_links( array(
			'base'      => $pagenum_link,
			'format'    => $format,
			'total'     => $this->num_pages,
			'current'   => $this->paged,
			'add_args'  => array_map( 'urlencode', $query_args ),
			'prev_text' => '<i class="fa fa-angle-left"></i>',
			'next_text' => '<i class="fa fa-angle-right"></i>',
			'type'      => 'list',
			'end_size'  => 3,
			'mid_size'  => 3,
		) );

		if ( ! $links ) {
			return '';
		}

		return $links;
	}
}

// Mapping shortcode.
vc_map( array(
	'name'        => esc_html__( 'Blog', 'amely' ),
	'base'        => 'amely_blog',
	'icon'        => 'amely-element-icon-blog',
	'category'    => sprintf( esc_html__( 'by %s', 'amely' ), AMELY_THEME_NAME ),
	'description' => esc_html__( 'Show posts in a grid or carousel', 'amely' ),
	'params'      => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'View mode', 'amely' ),
			'description' => esc_html__( 'Select a template to display post', 'amely' ),
			'param_name'  => 'view',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Grid', 'amely' )     => 'grid',
				esc_html__( 'Carousel', 'amely' ) => 'carousel',
				esc_html__( 'Masonry', 'amely' )  => 'masonry',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Alignment', 'amely' ),
			'param_name' => 'grid_align',
			'value'      => array(
				esc_html__( 'Left', 'amely' )   => 'text-xs-left',
				esc_html__( 'Center', 'amely' ) => 'text-xs-center',
				esc_html__( 'Right', 'amely' )  => 'text-xs-right',
			),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'loop',
			'value'      => array( esc_html__( 'Enable loop mode', 'amely' ) => 'yes' ),
			'std'        => 'yes',
			'dependency' => array( 'element' => 'view', 'value' => array( 'carousel' ) ),
		),
		array(
			'type'       => 'checkbox',
			'param_name' => 'auto_play',
			'value'      => array( esc_html__( 'Enable carousel autoplay', 'amely' ) => 'yes' ),
			'dependency' => array(
				'element' => 'view',
				'value'   => array( 'carousel' ),
			),
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
			'dependency' => array(
				'element' => 'view',
				'value'   => array( 'carousel' ),
			),
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Total Posts', 'amely' ),
			'param_name'  => 'total_posts',
			'value'       => - 1,
			'max'         => 1000,
			'min'         => - 1,
			'step'        => 1,
			'description' => esc_html__( 'Set max limit for items in grid or enter -1 to show all (limited to 1000)',
				'amely' ),
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Posts per page', 'amely' ),
			'param_name'  => 'posts_per_page',
			'value'       => 10,
			'min'         => 1,
			'step'        => 1,
			'description' => esc_html__( 'Number of items to show per page', 'amely' ),
			'dependency'  => array(
				'element'            => 'view',
				'value_not_equal_to' => array( 'carousel' ),
			),
		),
		array(
			'type'       => 'dropdown',
			'param_name' => 'pagination_type',
			'heading'    => esc_html__( 'Pagination type', 'amely' ),
			'value'      => array(
				esc_html__( 'Default', 'amely' )          => 'default',
				esc_html__( 'Load More Button', 'amely' ) => 'more-btn',
				esc_html__( 'Infinite Scroll', 'amely' )  => 'infinite',
			),
			'dependency' => array(
				'element'            => 'view',
				'value_not_equal_to' => array( 'carousel' ),
			),
		),
		Amely_VC::get_param( 'columns' ),
		Amely_VC::get_param( 'el_class' ),
		Amely_VC::get_param( 'order', esc_html__( 'Data Settings', 'amely' ) ),
		Amely_VC::get_param( 'order_way', esc_html__( 'Data Settings', 'amely' ) ),
		array(
			'group'       => esc_html__( 'Data Settings', 'amely' ),
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Filter by', 'amely' ),
			'param_name'  => 'filter',
			'admin_label' => true,
			'description' => esc_html__( 'Select filter source.', 'amely' ),
			'value'       => array(
				esc_html__( 'Categories', 'amely' ) => 'category',
				esc_html__( 'Tags', 'amely' )       => 'tag',
			),
		),
		array(
			'group'      => esc_html__( 'Data Settings', 'amely' ),
			'type'       => 'chosen',
			'heading'    => esc_html__( 'Select Categories', 'amely' ),
			'param_name' => 'cat_slugs',
			'options'    => array(
				'type'  => 'taxonomy',
				'get'   => 'category',
				'field' => 'slug',
			),
			'dependency' => array( 'element' => 'filter', 'value' => 'category' ),
		),
		array(
			'group'      => esc_html__( 'Data Settings', 'amely' ),
			'type'       => 'chosen',
			'heading'    => esc_html__( 'Select Tags', 'amely' ),
			'param_name' => 'tag_slugs',
			'options'    => array(
				'type'  => 'taxonomy',
				'get'   => 'post_tag',
				'field' => 'slug',
			),
			'dependency' => array( 'element' => 'filter', 'value' => 'tag' ),
		),
		Amely_VC::get_param( 'css' ),
	),
) );
