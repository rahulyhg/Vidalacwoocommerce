<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $source
 * @var $image
 * @var $custom_src
 * @var $img_size
 * @var $external_img_size
 * @var $category
 * @var $product_count_visibility
 * @var $open_new_tab
 * @var $show_arrow
 * @var $color_name
 * @var $color_name_hover
 * @var $color_count
 * @var $hover_style
 * @var $animation
 * @var $el_class
 * @var $css
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Product_Category_Banner
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$css_class = array(
	'tm-shortcode',
	'amely-product-category-banner',
	'hover-' . $hover_style,
	$show_arrow == 'yes' ? 'category-title-arrow' : '',
	'product-count-visible-' . $product_count_visibility,
	$this->getCSSAnimation( $animation ),
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

$img = false;

$a_target = $open_new_tab ? '_blank' : '';

// Get banner image
switch ( $source ) {
	case 'media_library':

		if ( ! $img_size ) {
			$img_size = 'full';
		}

		if ( $image ) {
			$dimensions = vcExtractDimensions( $img_size );
			$hwstring   = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

			$img = array(
				'thumbnail' => '<img ' . $hwstring . ' src="' . wp_get_attachment_image_src( $image,
						$img_size )[0] . '" alt="" />',
				'src'       => wp_get_attachment_image_src( $image, $img_size )[0],
			);
		}

		break;

	case 'external_link':

		$dimensions = vcExtractDimensions( $external_img_size );
		$hwstring   = $dimensions ? image_hwstring( $dimensions[0], $dimensions[1] ) : '';

		$custom_src = $custom_src ? esc_attr( $custom_src ) : $default_src;

		$img = array(
			'thumbnail' => '<img ' . $hwstring . 'src="' . $custom_src . '" alt="" />',
			'src'       => $custom_src,
		);

		break;

	default:
		break;
}

// Get category
$category = get_term_by( 'slug', $category, 'product_cat' );

$css_id = Amely_VC::get_amely_shortcode_id( 'amely-product-category-banner' );
$this->shortcode_css( $css_id );

if ( $category ) :
	?>

	<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">

		<?php echo '' . $img['thumbnail']; ?>

		<div class="banner-content">
			<p class="category-name"><?php echo esc_html( $category->name ); ?></p>

			<?php if ( $product_count_visibility != 'hidden' ) { ?>
				<p class="product-count"><?php echo esc_html( $category->count . ' ' . _n( 'item',
							'items',
							$category->count,
							'amely' ) ); ?></p>
			<?php } ?>
		</div>
		<a class="banner-link"
		   href="<?php echo esc_url( get_term_link( $category, 'product_cat' ) ) ?>"
		   title="<?php echo esc_attr( $category->name ); ?>"
		   target="<?php echo esc_attr( $a_target ); ?>"><?php echo '' . $category->name; ?></a>
	</div>
	<?php
endif;
