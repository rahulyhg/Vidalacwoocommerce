<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}
?>
<div class="insight-core-header">
	<h1><?php echo sprintf( esc_html__( 'Welcome to %s', 'insight-core' ), INSIGHT_CORE_THEME_NAME . ' ' . INSIGHT_CORE_THEME_VERSION ); ?></h1>
	<div class="about-text">
		<?php echo esc_html( InsightCore::$info['desc'] ); ?>
		<br/><a target="_blank" href="<?php echo esc_url( InsightCore::$info['support'] ); ?>">Need support?</a> |
		<a href="<?php echo esc_url( admin_url( "admin.php?page=insight-core-update" ) ); ?>">Check Update</a>
	</div>
	<div class="badge">
		<img src="<?php echo esc_url( InsightCore::$info['icon'] ); ?>"/>
	</div>
</div>