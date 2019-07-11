<?php
/**
 * The template for displaying product category thumbnails within loops
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-product_cat.php.
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
 * @version 2.6.1
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $woocommerce_loop;
$classes = array( 'category-grid-item' );

$categories_columns = amely_get_option( 'categories_columns' );

$classes[] = Amely_Helper::get_grid_item_class( apply_filters( 'amely_shop_categories_columns', array(
	'xl' => $categories_columns,
	'lg' => $categories_columns == 1 ? 1 : 3,
	'md' => $categories_columns == 1 ? 1 : 2,
	'sm' => 1,
) ) );

?>
<div <?php wc_product_cat_class( $classes, $category ); ?>>

	<div class="product-category-thumbnail">
		<?php

		/**
		 * woocommerce_before_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_open - 10
		 */
		do_action( 'woocommerce_before_subcategory', $category );
		/**
		 * woocommerce_before_subcategory_title hook.
		 *
		 * @hooked woocommerce_subcategory_thumbnail - 10
		 */
		do_action( 'woocommerce_before_subcategory_title', $category );

		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category ); ?>

	</div>

	<div class="product-category-content">

		<h2 class="woocommerce-loop-category__title">

			<a href="<?php echo get_term_link( $category, 'product_cat' ) ?>"><?php echo $category->name; ?></a>

			<?php
			if ( $category->count > 0 ) {
				echo apply_filters( 'woocommerce_subcategory_count_html', ' <mark class="count">(' . $category->count . ')</mark>', $category );
			}
			?>
		</h2>

		<?php

		/**
		 * woocommerce_after_subcategory_title hook.
		 */
		do_action( 'woocommerce_after_subcategory_title', $category );

		/**
		 * woocommerce_after_subcategory hook.
		 *
		 * @hooked woocommerce_template_loop_category_link_close - 10
		 */
		do_action( 'woocommerce_after_subcategory', $category ); ?>
	</div>
</div>
