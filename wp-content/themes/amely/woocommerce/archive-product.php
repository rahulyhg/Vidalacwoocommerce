<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
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
 * @version       3.4.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

get_header( 'shop' );

// Sidebar config
$page_wrap_class = $content_class = '';
$sidebar_config  = amely_get_option( 'shop_sidebar_config' );
$full_width_shop = amely_get_option( 'full_width_shop' );
$column_switcher = amely_get_option( 'column_switcher' );
$breadcrumbs_on  = amely_get_option( 'breadcrumbs' );
$shop_filters    = amely_get_option( 'shop_filters' );
$always_open_shop_filters    = amely_get_option( 'always_open_shop_filters' );

if ( $sidebar_config == 'left' ) {
	$page_wrap_class = 'has-sidebar-left row';
	$content_class   = ( $full_width_shop ) ? 'col-xs-12 col-md-8 col-lg-10' : 'col-xs-12 col-md-8 col-lg-9';
} elseif ( $sidebar_config == 'right' ) {
	$page_wrap_class = 'has-sidebar-right row';
	$content_class   = ( $full_width_shop ) ? 'col-xs-12 col-md-8 col-lg-10' : 'col-xs-12 col-md-8 col-lg-9';
} else {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

$sidebar = Amely_Helper::get_active_sidebar( true );

if ( ! $sidebar ) {
	$page_wrap_class = 'has-no-sidebars row';
	$content_class   = 'col-xs-12';
}

?>

<div class="container<?php echo $full_width_shop ? ' wide' : ''; ?>">
	<div class="inner-page-wrap <?php echo esc_attr( $page_wrap_class ); ?>  <?php echo $always_open_shop_filters ? ' always_display_filters' : ''; ?>">
		<div id="main" class="site-content <?php echo esc_attr( $content_class ); ?>" role="main">
			<?php
			/**
			 * woocommerce_before_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
			 * @hooked woocommerce_breadcrumb - 20
			 * @hooked WC_Structured_Data::generate_website_data() - 30
			 */
			do_action( 'woocommerce_before_main_content' );
			?>

			<?php
			/**
			 * woocommerce_archive_description hook.
			 *
			 * @hooked woocommerce_taxonomy_archive_description - 10
			 * @hooked woocommerce_product_archive_description - 10
			 */
			do_action( 'woocommerce_archive_description' );

			if ( have_posts() ) : ?>

				<div class="shop-loop-head row">
					<div class="shop-display col-xl-7 col-lg-6">
						<?php woocommerce_result_count(); ?>
					</div>
					<div class="shop-filter col-xl-5 col-lg-6">

						<?php

						if ( ! $shop_filters ) :
							woocommerce_catalog_ordering();
						endif;

						if ( $column_switcher ) :

							$columns = apply_filters( 'amely_shop_products_columns',
								array(
									'xs' => 1,
									'sm' => 2,
									'md' => 3,
									'lg' => 3,
									'xl' => get_option( 'woocommerce_catalog_columns', 5 ),
								) );

							?>
							<div class="col-switcher"
							     data-cols="<?php echo esc_attr( json_encode( $columns ) ); ?>"><?php esc_html_e( 'See:',
									'amely' ); ?>
								<a href="#" data-col="2">2</a>
								<a href="#" data-col="3">3</a>
								<a href="#" data-col="4">4</a>
								<a href="#" data-col="5">5</a>
								<a href="#" data-col="6">6</a>
							</div><!-- .col-switcher -->
						<?php endif; ?>

						<?php if ( $shop_filters ) : ?>
							<div class="amely-filter-buttons">
								<a href="#" class="open-filters"><?php esc_html_e( 'Filters', 'amely' ); ?></a>
							</div><!-- .amely-filter-buttons -->
						<?php endif; ?>
					</div>
				</div><!--.shop-loop-head -->

				<?php if ( $shop_filters ) : ?>
					<div class="filters-area">
						<div class="filters-inner-area row">
							<?php dynamic_sidebar( 'filters-area' ); ?>
						</div><!-- .filters-inner-area -->
					</div><!--.filters-area-->

					<div
						class="active-filters"><?php the_widget( 'WC_Widget_Layered_Nav_Filters' ); ?></div><!--.active-filters-->
				<?php endif; ?>

				<?php

				/**
				 * Hook: woocommerce_before_shop_loop.
				 *
				 * @hooked wc_print_notices - 10
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );

				woocommerce_product_loop_start();

				if ( 'subcategories' !== woocommerce_get_loop_display_mode() ) {

					if ( wc_get_loop_prop( 'total' ) ) {
						while ( have_posts() ) {
							the_post();
							/**
							 * Hook: woocommerce_shop_loop.
							 *
							 * @hooked WC_Structured_Data::generate_product_data() - 10
							 */
							do_action( 'woocommerce_shop_loop' );

							wc_get_template_part( 'content', 'product' );
						}

					}
				}

				woocommerce_product_loop_end();

				/**
				 * Hook: woocommerce_after_shop_loop.
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
				?>

			<?php else: ?>

				<?php
				/**
				 * woocommerce_no_products_found hook.
				 *
				 * @hooked wc_no_products_found - 10
				 */
				do_action( 'woocommerce_no_products_found' );
				?>

			<?php endif; ?>

			<?php
			/**
			 * woocommerce_after_main_content hook.
			 *
			 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
			 */
			do_action( 'woocommerce_after_main_content' );
			?>
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

<?php get_footer( 'shop' ); ?>
