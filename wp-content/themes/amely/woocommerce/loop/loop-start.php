<?php
/**
 * Product Loop Start
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/loop-start.php.
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
 * @version       3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$classes = array( 'products row' );

if ( amely_get_option( 'shop_ajax_on' ) ) {
	$classes[] = 'ajax-products';
}

if ( ( is_shop() || is_product_category() || is_product_tag() || is_product_taxonomy() ) && ! is_singular( 'product' ) && ! is_search() ) {
	$classes[] = 'grid';
}

// fix for price filter ajax
$min_price = isset( $_GET['min_price'] ) ? esc_attr( $_GET['min_price'] ) : '';
$max_price = isset( $_GET['max_price'] ) ? esc_attr( $_GET['max_price'] ) : '';

?>
<div class="<?php echo implode( ' ', $classes ) ?>" data-min_price="<?php echo esc_attr( $min_price ); ?>"
     data-max_price="<?php echo esc_attr( $max_price ); ?>">
