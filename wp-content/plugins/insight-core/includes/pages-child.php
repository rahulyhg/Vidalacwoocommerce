<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
InsightCore::update_option_count( 'insight_core_view_system' );
?>
<div class="wrap insight-core-wrap">
	<?php
	include_once( INSIGHT_CORE_INC_DIR . '/pages-header.php' );
	?>
	<div class="insight-core-body">
		<div class="box blue box-child-why">
			<div class="box-header">
				<span class="icon"><i class="pe-7s-leaf"></i></span> Why use a Child Theme?
			</div>
			<div class="box-body">
				There are a few reasons why you would want to use a child theme:
				<ul>
					<li>If you modify a theme directly and it is updated, then your modifications may be lost. By using
						a child theme you will ensure that your modifications are preserved.
					</li>
					<li>Using a child theme can speed up development time.</li>
					<li>Using a child theme is a great way to learn about WordPress theme development.</li>
				</ul>
				Read more about the Child Theme: <a href="https://codex.wordpress.org/Child_Themes" target="_blank">https://codex.wordpress.org/Child_Themes</a>
			</div>
		</div>
		<div class="box green box-child-download">
			<div class="box-header">
				<span class="icon"><i class="pe-7s-bottom-arrow"></i></span> Download Child Theme
			</div>
			<div class="box-body">
				<?php if ( isset( InsightCore::$info['child'] ) ) { ?>
					<a class="btn" href="<?php echo esc_url( InsightCore::$info['child'] ); ?>">Download</a>
				<?php } else { ?>
					Please contact us to get the Child Theme. Submit your ticket <a
						href="<?php echo esc_url( InsightCore::$info['support'] ); ?>" target="_blank">here</a>.
				<?php } ?>
			</div>
		</div>
	</div>
	<?php
	include_once( INSIGHT_CORE_INC_DIR . '/pages-footer.php' );
	?>
</div>