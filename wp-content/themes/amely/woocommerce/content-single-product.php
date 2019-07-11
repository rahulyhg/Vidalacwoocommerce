<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/content-single-product.php.
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
 * @version       3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>

<?php

if ( post_password_required() ) {
	echo get_the_password_form();

	return;
}

/**
 * Get sidebar config
 */

$page_wrap_class = $content_class = '';
$sidebar_config  = amely_get_option( 'product_sidebar_config' );

if ( $sidebar_config == 'left' ) {
	$page_wrap_class = 'has-sidebar-left row';
	$content_class   = 'col-xs-12 col-md-8 col-lg-9';
} elseif ( $sidebar_config == 'right' ) {
	$page_wrap_class = 'has-sidebar-right row';
	$content_class   = 'col-xs-12 col-md-8 col-lg-9';
} else {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

$sidebar = Amely_Helper::get_active_sidebar( true );

if ( ! $sidebar ) {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

// Show only featured images
$show_only_featured_images = get_post_meta( Amely_Helper::get_the_ID(), 'amely_show_featured_images', true );

if ( $show_only_featured_images == 'default' || ! $show_only_featured_images ) {
	$show_only_featured_images = amely_get_option( 'show_featured_images' );
}

// Product page layout
$product_page_layout = get_post_meta( Amely_Helper::get_the_ID(), 'amely_product_page_layout', true );
$product_bgcolor     = get_post_meta( Amely_Helper::get_the_ID(), 'amely_product_bgcolor', true );

if ( $product_page_layout == 'default' || ! $product_page_layout ) {
	$product_page_layout = amely_get_option( 'product_page_layout' );
}

if ( $product_page_layout != 'sticky-fullwidth' ) {
	$product_class = 'product-layout-' . $product_page_layout;
} else {
	$product_class = 'product-layout-sticky product-layout-fullwidth';
}

if ( get_post_meta( Amely_Helper::get_the_ID(), 'amely_page_title_on', true ) == 'on' ) {
	$product_class .= ' product-title-hide';
}

$container_classes = array( 'container' );

if ( strpos( $product_page_layout, 'fullwidth' ) > - 1 ) {
	$container_classes[] = 'wide';
}

$summary_classes = array( 'col-lg-6', 'summary', 'entry-summary' );

if ( amely_get_option( 'product_ajax_add_to_cart' ) ) {
	$summary_classes[] = 'ajax-add-to-cart';
}

if ( amely_get_option( 'single_nav_on' ) ) {
	$summary_classes[] = 'single-nav-on';
}

global $product;

if ( $product->is_type( 'variable' ) ) {
	add_action( 'woocommerce_after_single_variation', array( 'Amely_Woo', 'compare_button' ) );
} else {
	add_action( 'woocommerce_after_add_to_cart_button', array( 'Amely_Woo', 'compare_button' ) );
}

?>

<div id="product-<?php the_ID(); ?>" <?php post_class( $product_class ); ?>>
	<?php if ( strpos( $product_page_layout, 'background' ) > - 1 ) {
		echo '<div class="background-wrapper" style="background-color:' . esc_attr( $product_bgcolor ) . '">';
	} ?>
	<div class="<?php echo implode( ' ', $container_classes ); ?>">
		<div class="<?php echo esc_attr( $page_wrap_class ); ?>">
			<div class="<?php echo esc_attr( $content_class ); ?>">
				<?php

				/**
				 * woocommerce_before_single_product hook.
				 *
				 * @hooked wc_print_notices - 10
				 */
				do_action( 'woocommerce_before_single_product' );
				?>
				<div
					class="row<?php if ( $product_page_layout == 'sticky' || $product_page_layout == 'sticky-fullwidth' ) {
						echo ' sticky-row';
					} ?>">
					<div class="col-lg-6 product-images">
						<?php
						/**
						 * woocommerce_before_single_product_summary hook.
						 *
						 * @hooked woocommerce_show_product_sale_flash - 10
						 * @hooked woocommerce_show_product_images - 20
						 */
						do_action( 'woocommerce_before_single_product_summary' );
						?>
					</div>

					<div
						class="<?php echo implode( ' ', $summary_classes ); ?>">

						<?php
						/**
						 * woocommerce_single_product_summary hook.
						 *
						 * @hooked woocommerce_template_single_title - 5
						 * @hooked woocommerce_template_single_rating - 10
						 * @hooked woocommerce_template_single_price - 10
						 * @hooked woocommerce_template_single_excerpt - 20
						 * @hooked woocommerce_template_single_add_to_cart - 30
						 * @hooked woocommerce_template_single_meta - 40
						 * @hooked woocommerce_template_single_sharing - 50
						 */
						do_action( 'woocommerce_single_product_summary' );
						?>

					</div><!-- .summary -->
				</div>
			</div>
			<?php
			/**
			 * woocommerce_sidebar hook.
			 *
			 * @hooked woocommerce_get_sidebar - 10
			 */
			do_action( 'woocommerce_sidebar' );
			?>
		</div>
	</div>
	<?php if ( strpos( $product_page_layout, 'background' ) > - 1 ) {
		echo '</div>';
	} ?>
	<?php woocommerce_upsell_display(); ?>
	<div class="product-tabs-wrapper">
		<?php
		/**
		 * woocommerce_after_single_product_summary hook.
		 *
		 * @hooked woocommerce_output_product_data_tabs - 10
		 */
		do_action( 'woocommerce_after_single_product_summary' );
		?>
	</div>
	<div class="container">
		<?php

		if ( ! get_post_meta( Amely_Helper::get_the_ID(), 'amely_hide_related_products', true ) == 'on') {
			woocommerce_output_related_products();
		}
		?>
	</div>
	<?php echo Amely_Woo::product_instagram(); ?>
	<meta itemprop="url" content="<?php the_permalink(); ?>"/>
</div><!-- #product-<?php the_ID(); ?> -->

<?php do_action( 'woocommerce_after_single_product' ); ?>
