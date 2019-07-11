<?php
/**
 * The template for displaying product widget entries
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-widget-product.php.
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

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product; ?>

<div class="product product-in-widget">

	<?php do_action( 'woocommerce_widget_product_item_start', $args ); ?>

	<div class="product-thumb">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"
		   title="<?php echo esc_attr( $product->get_title() ); ?>" class="product-title">
			<?php

			if ( isset( $img_size ) && ! empty( $img_size ) ) {
				echo( $product->get_image( $img_size ) );
			} else {
				echo( $product->get_image() );
			}
			?>
		</a>
	</div>
	<div class="product-info">
		<a href="<?php echo esc_url( get_permalink( $product->get_id() ) ); ?>"
		   title="<?php echo esc_attr( $product->get_title() ); ?>" class="product-title">
			<?php echo( $product->get_title() ); ?>
		</a>
		<div class="product-price">
			<?php echo( $product->get_price_html() ); ?>
		</div>
		<?php if ( ! empty( $show_rating ) ) : ?>
			<?php echo wc_get_rating_html( $product->get_average_rating() ); ?>
		<?php endif; ?>
		<?php if ( isset( $show_buttons ) && ! empty( $show_buttons ) ) : ?>
			<div class="product-buttons">
				<?php
				Amely_Woo::wishlist_button();
				woocommerce_template_loop_add_to_cart();
				Amely_Woo::compare_button();
				?>
			</div>
		<?php endif; ?>
	</div>

	<?php do_action( 'woocommerce_widget_product_item_end', $args ); ?>

</div>
