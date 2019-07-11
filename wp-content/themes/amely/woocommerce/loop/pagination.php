<?php
/**
 * Pagination - Show numbered pagination for catalog pages
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/pagination.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see           https://docs.woocommerce.com/document/template-structure/
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.3.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$total   = isset( $total ) ? $total : wc_get_loop_prop( 'total_pages' );
$current = isset( $current ) ? $current : wc_get_loop_prop( 'current_page' );
$base    = isset( $base ) ? $base : esc_url_raw( str_replace( 999999999,
	'%#%',
	remove_query_arg( 'add-to-cart', get_pagenum_link( 999999999, false ) ) ) );
$format  = isset( $format ) ? $format : '';

if ( $total <= 1 ) {
	return;
}

$pagination = amely_get_option( 'shop_pagination' );

if ( $pagination == 'default' ) :

	?>
	<nav class="woocommerce-pagination">
		<?php
		echo paginate_links( apply_filters( 'woocommerce_pagination_args',
			array(
				'base'      => $base,
				'format'    => $format,
				'add_args'  => false,
				'current'   => max( 1, $current ),
				'total'     => $total,
				'prev_text' => esc_html__( 'Prev', 'amely' ),
				'next_text' => esc_html__( 'Next', 'amely' ),
				'type'      => 'list',
				'end_size'  => 3,
				'mid_size'  => 3,
			) ) );
		?>
	</nav>
<?php else :

	$orderby = get_option( 'woocommerce_default_catalog_orderby' );
	$order   = 'DESC';

	if ($orderby == 'price') {
		$order = 'ASC';
	}

	$load_more_atts = array(
		'container'      => '.products.ajax-products',
		'post_type'      => 'product',
		'paged'          => 1,
		'posts_per_page' => apply_filters( 'amely_ajax_products_per_page',
			intval( get_option( 'woocommerce_catalog_columns', 4 ) ) * get_option( 'woocommerce_catalog_rows', 3 ) ),
		'columns'        => intval( get_option( 'woocommerce_catalog_columns',4 ) ),
		'orderby'        => $orderby,
		'order'          => $order
	);

	if ( is_product_category() ) {
		$load_more_atts['data_source'] = 'category';
		$load_more_atts['category']    = get_query_var( 'product_cat' );
	}

	if ( $_chosen_attributes = WC_Query::get_layered_nav_chosen_attributes() ) {
		$load_more_atts['data_source'] = 'filter';
		$load_more_atts['tax_array']   = $_chosen_attributes;
	}

	?>
	<div class="amely-loadmore-wrap woocommerce-pagination"
	     data-atts="<?php echo esc_attr( json_encode( $load_more_atts ) ); ?>">
		<a href="#"
		   class=" amely-loadmore-btn load-on-<?php echo ( $pagination == 'more-btn' ) ? 'click' : 'scroll'; ?>"><?php esc_html_e( 'Load More ...',
				'amely' ); ?></a>
	</div>
<?php endif; ?>
