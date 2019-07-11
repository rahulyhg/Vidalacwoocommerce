<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Amely
 */

$sidebar = Amely_Helper::get_active_sidebar();

if ( ! $sidebar ) {
	return;
}

?>
<aside id="secondary" class="sidebar col-xs-12 col-md-4 col-lg-3 <?php echo esc_attr( $sidebar['class'] ); ?>"
       itemscope="itemscope" itemtype="http://schema.org/WPSideBar">
	<div class="widget-area">

		<?php
		dynamic_sidebar( $sidebar['sidebar'] );
		?>

	</div>
</aside>
