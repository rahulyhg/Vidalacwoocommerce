<?php
/**
 * Single Product Share
 *
 * Sharing plugins can hook into here or you can add your own code directly.
 *
 * @author        WooThemes
 * @package       WooCommerce/Templates
 * @version       3.5.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$product_show_share  = amely_get_option( 'product_show_share' );
$product_share_links = amely_get_option( 'product_share_links' );

if ( ! is_array( $product_share_links ) ) {
	return;
}

$no_share_links = true;
foreach ( $product_share_links as $link ) {
	if ( $link ) {
		$no_share_links = false;
	}
}

?>

<?php if ( $product_show_share && ! $no_share_links ) { ?>
	<table class="product-share">
		<tr>
			<td class="label"><?php echo esc_html__( 'Share on:', 'amely' ); ?></td>
			<td class="value">
				<ul class="list-inline share-list">
					<?php do_action( 'amely_before_product_share' ); ?>
					<?php if ( $product_share_links['facebook'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;"
							   title="<?php esc_attr_e( 'Facebook', 'amely' ) ?>">
								<i class="fa fa-facebook"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( $product_share_links['twitter'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://twitter.com/home?status=Check%20out%20this%20article:%20<?php echo rawurlencode( the_title( '', '', false ) ); ?>%20-%20<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;"
							   title="<?php esc_attr_e( 'Twitter', 'amely' ) ?>">
								<i class="fa fa-twitter"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( $product_share_links['google'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="https://plus.google.com/share?url=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;"
							   title="<?php esc_attr_e( 'Google+', 'amely' ) ?>">
								<i class="fa fa-google-plus"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( $product_share_links['pinterest'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>"
							   onclick="window.open(this.href, '', 'menubar=no,toolbar=no,resizable=no,scrollbars=no,height=455,width=600'); return false;"
							   title="<?php esc_attr_e( 'Pinterest', 'amely' ) ?>">
								<i class="fa fa-pinterest"></i>
							</a>
						</li>
					<?php } ?>
					<?php if ( $product_share_links['email'] ) { ?>
						<li class="list-inline-item share-list__item">
							<a href="mailto:?subject=I%20wanted%20you%20to%20see%20this%20site&amp;body=<?php the_permalink(); ?>&amp"
							   title="<?php esc_attr_e( 'Email', 'amely' ) ?>">
								<i class="fa fa-envelope-o"></i>
							</a>
						</li>
					<?php } ?>
					<?php do_action( 'amely_after_product_share' ); ?>
				</ul>
			</td>
		</tr>
	</table>
<?php } ?>

<?php do_action( 'woocommerce_share' ); // Sharing plugins can hook into here ?>
