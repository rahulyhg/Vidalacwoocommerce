<?php
/**
 * The template for displaying product content within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @author  WooThemes
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

// Ensure visibility.
if ( empty( $product ) || ! $product->is_visible() ) {
	return;
}

$classes = array(
	'product',
	'product-loop',
);

// Add 'new' class
$timestamp = strtotime( get_the_time( 'Y-m-d', $post->ID ) );
$newdays   = apply_filters( 'amely_shop_new_days', amely_get_option( 'shop_new_days' ) );
$is_new    = time() - $timestamp < 60 * 60 * 24 * $newdays;

if ( $is_new ) {
	$classes[] = 'new';
}

$classes[] = Amely_Helper::get_grid_item_class( apply_filters( 'amely_shop_products_columns',
	array(
		'xs' => 1,
		'sm' => 2,
		'md' => 3,
		'lg' => 4,
		'xl' => intval( get_option( 'woocommerce_catalog_columns', 5 ) ),
	) ) );

$other_classes = apply_filters( 'amely_shop_products_classes', '' );
$classes[]     = $other_classes;

$buttons_class   = array(
	'product-buttons product-buttons--' . apply_filters( 'amely_product_buttons_scheme',
		amely_get_option( 'product_buttons_scheme' ) ),
);
$buttons_class[] = wp_is_mobile() ? 'mobile' : '';

?>
<div <?php post_class( $classes ); ?>>
	<?php woocommerce_show_product_loop_sale_flash(); ?>
	<div class="product-thumb">
		<?php

		Amely_Woo::wishlist_button();

		/**
		 * woocommerce_before_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_link_open - 5
		 * @hooked woocommerce_template_loop_product_thumbnail - 10
		 * @hooked woocommerce_template_loop_product_link_close - 15
		 */
		do_action( 'woocommerce_before_shop_loop_item_title' );
		?>
		<div
			class="<?php echo implode( ' ', $buttons_class ); ?>">

			<?php
			Amely_Woo::quick_view_button();
			woocommerce_template_loop_add_to_cart();
			Amely_Woo::compare_button();
			?>

		</div>
	</div>

	<div class="product-info">

		<?php

		/**
		 * woocommerce_shop_loop_item_title hook.
		 *
		 * @hooked woocommerce_template_loop_product_title - 10
		 */
		do_action( 'woocommerce_shop_loop_item_title' );
		?>

		<div class="wrap-price">
			<?php
			/**
			 * woocommerce_after_shop_loop_item_title hook.
			 *
			 * @hooked woocommerce_template_loop_rating - 5
			 * @hooked woocommerce_template_loop_price - 10
			 */
			do_action( 'woocommerce_after_shop_loop_item_title' );
			?>
		</div>

		<?php woocommerce_template_loop_rating(); ?>
	</div>
</div>

