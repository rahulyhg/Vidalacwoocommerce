<?php
/**
 * Shortcode attributes
 *
 * @var $atts
 * @var $style
 * @var $v_align
 * @var $title
 * @var $title_font_size
 * @var $title_font_color
 * @var $content
 * @var $content_font_size
 * @var $content_font_color
 * @var $link
 * @var $use_link_title
 * @var $link_color
 * @var $use_text
 * @var $text
 * @var $el_class
 * @var $type
 * @var $icon_fontawesome
 * @var $icon_openiconic
 * @var $icon_typicons
 * @var $icon_entypo
 * @var $icon_linecons
 * @var $icon_pe7stroke
 * @var $icon_font_size
 * @var $with_bg
 * @var $bg_shape
 * @var $icon_color
 * @var $icon_bgcolor
 * @var $css
 * @var $css_id
 * Shortcode class
 * @var $this WPBakeryShortCode_Amely_Icon_Box
 */

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$el_class = $this->getExtraClass( $el_class );

$css_class = array(
	'tm-shortcode',
	'amely-icon-box',
	$v_align,
	$style,
	$el_class,
	vc_shortcode_custom_css_class( $css ),
);

$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG,
	implode( ' ', $css_class ),
	$this->settings['base'],
	$atts );

// Enqueue needed icon font.
vc_icon_element_fonts_enqueue( $type );
$iconClass = isset( ${"icon_" . $type} ) ? esc_attr( ${"icon_" . $type} ) : 'fa fa-adjust';

if ( ! empty( $link ) && "||" !== $link && "|||" !== $link ) {
	$link      = vc_build_link( $link );
	$link_text = '<a href="' . esc_attr( $link['url'] ) . '"' . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' ) . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' ) . 'rel="' . $link['rel'] . '">' . ( $link['title'] ? $link['title'] : '' ) . '</a>';
}

$css_id        = uniqid( 'tm-icon-box-' );
$shortcode_css = $this->shortcode_css( $css_id );

if ( empty( $title ) && empty( $content ) ) {
	$css_class .= ' only-icon';
}

?>
<div class="<?php echo esc_attr( trim( $css_class ) ); ?>" id="<?php echo esc_attr( $css_id ); ?>">

	<?php if ( 'left' == $style || 'center' == $style ) { ?>

		<div
			class="tm-icon-box__icon<?php echo esc_attr( $with_bg ? ' with-bg' : '' ); ?><?php echo esc_attr( $with_bg ? ' ' . $bg_shape : '' ); ?>">
			<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
			<a href="<?php echo esc_attr( $link['url'] ); ?>" target="<?php echo esc_html( $link['target'] ); ?>"
			   rel="<?php echo esc_attr( $link['rel'] ); ?>"
			   title="<?php echo esc_html( $title ); ?>">
				<?php } ?>
				<?php if ( 'yes' == $use_text ) { ?>
					<span><?php echo '' . $text; ?></span>
				<?php } else { ?>
					<i class="<?php echo esc_attr( $iconClass ); ?>"></i>
				<?php } ?>
				<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
			</a>
		<?php } ?>
		</div>

	<?php } ?>

	<?php if ( $title || $content ) { ?>
		<div class="tm-icon-box__content">
			<?php if ( $title ) { ?>
				<h3 class="title">
					<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
					<a href="<?php echo esc_attr( $link['url'] ); ?>"
					   target="<?php echo esc_html( $link['target'] ); ?>" rel="<?php echo esc_attr( $link['rel'] ); ?>"
					   title="<?php echo esc_attr( $title ); ?>">
						<?php
						$title = ( $link['title'] ? $link['title'] : $title );
						} ?>
						<?php echo '' . $title; ?>
						<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
					</a>
				<?php } ?>
				</h3>
			<?php } ?>
			<?php if ( $content ) { ?>
				<div class="description"><?php echo do_shortcode( $content ); ?></div>
			<?php } ?>
			<?php if ( 'yes' != $use_link_title && isset( $link_text ) && $link_text ) { ?>
				<p class="subtext"><?php echo '' . $link_text; ?></p>
			<?php } ?>
		</div>
	<?php } ?>

	<?php if ( 'right' == $style ) { ?>

		<div
			class="tm-icon-box__icon<?php echo esc_attr( $with_bg ? ' with-bg' : '' ); ?><?php echo esc_attr( $with_bg ? ' ' . $bg_shape : '' ); ?>">
			<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
			<a href="<?php echo esc_attr( $link['url'] ); ?>" target="<?php echo esc_html( $link['target'] ); ?>"
			   rel="<?php echo esc_attr( $link['rel'] ); ?>"
			   title="<?php echo esc_html( $title ); ?>">
				<?php } ?>
				<?php if ( 'yes' == $use_text ) { ?>
					<spans><?php echo '' . $text; ?></spans>
				<?php } else { ?>
					<i class="<?php echo esc_attr( $iconClass ); ?>"></i>
				<?php } ?>
				<?php if ( 'yes' == $use_link_title && ! empty( $link ) && "||" !== $link && "|||" !== $link ) { ?>
			</a>
		<?php } ?>
		</div>

	<?php } ?>
</div>
