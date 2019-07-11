<?php
/**
 * Woocommerce Compare page
 *
 * @author  Your Inspiration Themes
 * @package YITH Woocommerce Compare
 * @version 1.1.4
 */

// remove the style of woocommerce
if ( defined( 'WOOCOMMERCE_USE_CSS' ) && WOOCOMMERCE_USE_CSS ) {
	wp_dequeue_style( 'woocommerce_frontend_styles' );
}

$is_iframe = (bool) ( isset( $_REQUEST['iframe'] ) && $_REQUEST['iframe'] );

wp_enqueue_script( 'jquery-fixedheadertable', YITH_WOOCOMPARE_ASSETS_URL . '/js/jquery.dataTables.min.js', array( 'jquery' ), '1.3', true );
wp_enqueue_script( 'jquery-fixedcolumns', YITH_WOOCOMPARE_ASSETS_URL . '/js/FixedColumns.min.js', array(
	'jquery',
	'jquery-fixedheadertable',
), '1.3', true );

$widths = array();
foreach ( $products as $product ) {
	$widths[] = '{ "sWidth": "205px", resizeable:true }';
}

$table_text = get_option( 'yith_woocompare_table_text' );
yit_wpml_register_string( 'Plugins', 'plugin_yit_compare_table_text', $table_text );
$localized_table_text = yit_wpml_string_translate( 'Plugins', 'plugin_yit_compare_table_text', $table_text );

$body_font     = amely_get_option( 'primary_font' );
$primary_color = amely_get_option( 'primary_color' );

$enable_add_to_cart = false;
$parts              = parse_url( $_SERVER['HTTP_REFERER'] );

$catalog_enable = null;
if ( isset( $parts['query'] ) ) {
	parse_str( $parts['query'], $query );

	if ( isset( $query['catalog'] ) ) {
		$catalog_enable = $query['catalog'];
	} else {
		$catalog_enable = false;
	}
}

if ( ! amely_get_option( 'catalog_mode_on' ) && is_null( $catalog_enable ) ) {
	$enable_add_to_cart = true;
} elseif ( ! is_null( $catalog_enable ) && $catalog_enable != 'true' ) {
	$enable_add_to_cart = true;
}

?>

<!DOCTYPE html>
<html <?php language_attributes() ?>>

<!-- START HEAD -->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta name="viewport" content="width=device-width"/>
	<?php add_filter( 'wp_title', function() {
		return esc_html__( 'Product Comparison', 'amely' );
	} ); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11"/>

	<link rel="stylesheet"
	      href="http://fonts.googleapis.com/css?family=<?php echo rawurlencode( $body_font['font-family'] ); ?>:300,400,500,600,700,800,900"/>
	<link rel="stylesheet" href="<?php echo esc_url( $this->stylesheet_url() ); ?>" type="text/css"/>
	<link rel="stylesheet" href="<?php echo YITH_WOOCOMPARE_URL ?>assets/css/colorbox.css"/>
	<link rel="stylesheet" href="<?php echo YITH_WOOCOMPARE_URL ?>assets/css/jquery.dataTables.css"/>
	<link rel="stylesheet" href="<?php echo AMELY_THEME_URI; ?>/assets/libs/font-awesome/css/font-awesome.min.css"
	      type="text/css" media="all">
	<link rel="stylesheet"
	      href="<?php echo AMELY_THEME_URI; ?>/assets/libs/pixeden-stroke-7-icon/css/pe-icon-7-stroke.min.css"
	      type="text/css" media="all">

	<?php
	wp_head();
	?>

	<style type="text/css">

		body {
			font-family: '<?php echo esc_attr($body_font['font-family']);?>';
			font-weight: <?php echo esc_attr($body_font['font-weight']);?>;
			font-size: 15px;
			line-height: 1.5;
		}

		h1.title {
			text-transform: none;
			font-weight: 400;
			font-size: 20px;
			background-color: #fff;
			color: #333333;
			border-bottom: 1px solid #eee;
		}

		table.compare-list th {
			padding: 15px 25px;
			font-weight: 400;
			text-transform: none;
			font-size: 18px;
			background-color: #f7f7f7;
		}

		table.compare-list td {
			background-color: #fff;
			padding: 15px 25px;
		}

		table.compare-list .remove td a {
			color: #999;
			font-weight: 500;
			font-size: 12px;
			letter-spacing: .1em;
			text-transform: uppercase;
			-webkit-transition: all .3s ease-in-out;
			-moz-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;
		}

		table.compare-list .remove td a:before {
			font-family: 'Pe-icon-7-stroke';
			content: '\e680';
			font-size: 20px;
			margin-right: 5px;
			vertical-align: -5px;
		}

		table.compare-list .remove td a:hover {
			color: #f00;
		}

		table.compare-list td img {
			max-width: 100%;
			background: none;
			border: none;
			margin-bottom: 0;
			padding: 0;
		}

		table.compare-list tr.title td {
			text-transform: none;
			font-size: 15px;
			font-weight: 400;
			padding-bottom: 0;
		}

		table.compare-list tr.title td a {
			font-size: 15px;
			text-decoration: none;
			-webkit-transition: all .3s ease-in-out;
			-moz-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;
			color: #ababab;
		}

		table.compare-list tr.description td {
			text-align: left;
		}

		table.compare-list tr.price td {
			text-decoration: none;
			font-size: 14px;
			font-weight: 700;
			color: #333333;
		}

		table.compare-list tr.price td ins {
			text-decoration: none;
		}

		table.compare-list tr.price td del {
			color: #999;
			font-size: .875em;
			font-weight: 400;
			margin-right: 5px;
		}

		table.compare-list .add-to-cart td a {
			display: block;
			position: relative;
			font-size: 14px;
			font-weight: 500;
			line-height: inherit;
			letter-spacing: .1em;
			background-color: transparent !important;
			color: <?php echo esc_html(amely_get_option('link_hover_color'))?>;
			margin: 0;
			padding: 0;
			-webkit-transition: all .3s ease-in-out;
			-moz-transition: all .3s ease-in-out;
			transition: all .3s ease-in-out;
		}

		table.compare-list .add-to-cart td a.loading {
			font-size: 0;
		}

		table.compare-list .add-to-cart td a.loading:before {
			content: url(<?php echo AMELY_THEME_URI . '/assets/images/loading.svg';?>);
			position: absolute;
			top: -10px;
			left: 50%;
			line-height: 0;
			width: 0;

			-webkit-transform: translateX(-50%);
			-moz-transform: translateX(-50%);
			transform: translateX(-50%);
		}

		table.compare-list .add-to-cart td a.added:before {
			font-family: 'FontAwesome';
			color: <?php echo esc_html(amely_get_option('link_hover_color'))?>;
			content: '\f00c';
			font-size: 14px;
			margin-right: 10px;
		}

		table.compare-list .add-to-cart td a:hover {
			color: <?php echo esc_html(amely_get_option('link_hover_color'))?>;
		}

		table.compare-list .add-to-cart td a:focus {
			outline: none;
		}

		table.compare-list .description td {
			color: #ababab;
		}

		table.compare-list .stock td {
			font-size: 14px;
			font-weight: 400;
			text-transform: none;
		}

		table.compare-list .stock td span {
			coloe: #ababab;
		}

		table.compare-list .stock td span:before {
			content: '\f120';
			font-family: 'Ionicons';
			margin-right: 5px;
		}

		table.compare-list .stock td span.out-of-stock:before {
			content: '\f100';
			color: #ababab;
		}

	</style>
</head>
<!-- END HEAD -->

<?php global $product; ?>

<!-- START BODY -->
<body <?php body_class( 'woocommerce' ) ?>>

<h1 class="title">
	<?php echo esc_html( $localized_table_text ); ?>
	<?php if ( ! $is_iframe ) : ?><a class="close"
	                                 href="#"><?php esc_html_e( 'Close window [X]', 'amely' ) ?></a><?php endif; ?>
</h1>

<?php do_action( 'yith_woocompare_before_main_table' ); ?>

<table class="compare-list" cellpadding="0" cellspacing="0"<?php if ( empty( $products ) )
	echo ' style="width:100%"' ?>>
	<thead>
	<tr>
		<th>&nbsp;</th>
		<?php foreach ( $products as $product_id => $product ) : ?>
			<td></td>
		<?php endforeach; ?>
	</tr>
	</thead>
	<tfoot>
	<tr>
		<th>&nbsp;</th>
		<?php foreach ( $products as $product_id => $product ) : ?>
			<td></td>
		<?php endforeach; ?>
	</tr>
	</tfoot>
	<tbody>

	<?php if ( empty( $products ) ) : ?>

		<tr class="no-products">
			<td><?php esc_html_e( 'No products added in the compare table.', 'amely' ) ?></td>
		</tr>

	<?php else : ?>
		<tr class="remove">
			<th>&nbsp;</th>
			<?php foreach ( $products as $product_id => $product ) :
				$product_class = ' product_' . $product_id; ?>
				<td class="<?php echo esc_attr( $product_class ); ?>">
					<a href="<?php echo add_query_arg( 'redirect', 'view', $this->remove_product_url( $product_id ) ) ?>"
					   data-product_id="<?php echo esc_attr( $product_id ); ?>"><?php esc_html_e( 'Remove', 'amely' ) ?>
				</td>
			<?php endforeach ?>
		</tr>

		<?php foreach ( $fields as $field => $name ) : ?>

			<tr class="<?php echo esc_attr( $field ); ?>">

				<th>
					<?php echo esc_html( $name ); ?>
					<?php if ( $field == 'image' ) {
						echo '<div class="fixed-th"></div>';
					} ?>
				</th>

				<?php foreach ( $products as $product_id => $product ) :
					$product_class = ' product_' . $product_id; ?>
					<td class="<?php echo esc_attr( $product_class ); ?>"><?php
						switch ( $field ) {

							case 'image':
								echo '<div class="image-wrap">' . wp_get_attachment_image( $product->fields[ $field ], apply_filters( 'amely_compare_image_size', 'yith-woocompare-image' ) ) . '</div>';
								break;

							case 'price':
								$price_html = $product->get_price_html();
								echo( $price_html );
								break;

							case 'add-to-cart':
								if ( $enable_add_to_cart ) {
									woocommerce_template_loop_add_to_cart();
								}
								break;

							case 'title':
								echo '<a href="' . get_permalink( $product_id ) . '">' . $product->fields['title'] . '</a>';
								break;

							default:
								echo empty( $product->fields[ $field ] ) ? '&nbsp;' : $product->fields[ $field ];
								break;
						}
						?>
					</td>
				<?php endforeach ?>

			</tr>

		<?php endforeach; ?>

		<?php if ( $repeat_price == 'yes' && isset( $fields['price'] ) ) : ?>
			<tr class="price repeated">
				<th><?php echo esc_html( $fields['price'] ); ?></th>

				<?php foreach ( $products as $product_id => $product ) :
					$product_class = ' product_' . $product_id; ?>
					<td class="<?php echo esc_attr( $product_class ); ?>">
						<?php
						$price_html = $product->get_price_html();
						echo( $price_html );
						?>
					</td>
				<?php endforeach; ?>

			</tr>
		<?php endif; ?>

		<?php if ( $repeat_add_to_cart == 'yes' && isset( $fields['add-to-cart'] ) && $enable_add_to_cart ) : ?>
			<tr class="add-to-cart repeated">
				<th><?php echo esc_html( $fields['add-to-cart'] ); ?></th>

				<?php foreach ( $products as $product_id => $product ) :
					$product_class = ' product_' . $product_id; ?>
					<td class="<?php echo esc_attr( $product_class ); ?>"><?php woocommerce_template_loop_add_to_cart(); ?></td>
				<?php endforeach; ?>

			</tr>
		<?php endif; ?>

	<?php endif; ?>

	</tbody>
</table>

<?php do_action( 'yith_woocompare_after_main_table' ); ?>

<?php if ( wp_script_is( 'responsive-theme', 'enqueued' ) ) wp_dequeue_script( 'responsive-theme' ) ?><?php if ( wp_script_is( 'responsive-theme', 'enqueued' ) ) wp_dequeue_script( 'responsive-theme' ) ?>
<?php do_action( 'wp_print_footer_scripts' ); ?>

<script type="text/javascript">

	jQuery( document ).ready( function( $ ) {
		<?php if ( $is_iframe ) : ?>$( 'a' ).attr( 'target', '_parent' );<?php endif; ?>

		var oTable;
		$( 'body' ).on( 'yith_woocompare_render_table', function() {
			if ( $( window ).width() > 767 ) {
				oTable = $( 'table.compare-list' ).dataTable( {
					"sScrollX": "100%",
					"bScrollInfinite": true,
					"bScrollCollapse": true,
					"bPaginate": false,
					"bSort": false,
					"bInfo": false,
					"bFilter": false,
					"bAutoWidth": false
				} );

				new FixedColumns( oTable );
				$( '<table class="compare-list" />' ).insertAfter( $( 'h1' ) ).hide();
			}

		} ).trigger( 'yith_woocompare_render_table' );


		var redirect_to_cart = false;
		// close colorbox if redirect to cart is active after add to cart
		$( 'body' ).on( 'adding_to_cart', function( $thisbutton, data ) {
			if ( wc_add_to_cart_params.cart_redirect_after_add == 'yes' ) {
				wc_add_to_cart_params.cart_redirect_after_add = 'no';
				redirect_to_cart = true;
			}
		} );

		// remove add to cart button after added
		$( 'body' ).on( 'added_to_cart', function( ev, fragments, cart_hash, button ) {

			if ( redirect_to_cart == true ) {
				// redirect
				parent.window.location = wc_add_to_cart_params.cart_url;
				return;
			}

			$( 'a.added_to_cart' ).remove();

			<?php if ( $is_iframe ) : ?>
			$( 'a' ).attr( 'target', '_parent' );

			// Replace fragments
			if ( fragments ) {
				$.each( fragments, function( key, value ) {
					$( key, window.parent.document ).replaceWith( value );
				} );
			}
			<?php endif; ?>
		} );

		$( window ).on( 'yith_woocompare_product_removed', function() {
			if ( $( window ).width() > 767 ) {
				oTable.fnDestroy( true );
			}
			$( 'body' ).trigger( 'yith_woocompare_render_table' );
		} );

	} );

</script>

</body>
</html>
