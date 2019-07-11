<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

add_thickbox();

if ( ! current_user_can( 'update_themes' ) ) {
	wp_die( __( 'Sorry, you are not allowed to update this site.', 'insight-core' ) );
}

InsightCore::update_option_count( 'insight_core_view_update' );

?>
<div class="wrap insight-core-wrap">
	<?php
	include_once( INSIGHT_CORE_INC_DIR . '/pages-header.php' );
	?>
	<div class="insight-core-body">
		<div class="box theme-overlay">
			<div class="box-header">
				<span class="icon gray"><i class="pe-7s-ribbon"></i></span>
				Update
			</div>
			<div class="box-body">
				<?php
				if ( InsightCore::check_valid_update() ) {
					printf( __(
						'There is a new version of %1$s available. <a href="%2$s" %3$s>View version %4$s details</a> or <a href="%5$s" %6$s>update now</a>.',
						'insight-core'
					),
						INSIGHT_CORE_THEME_NAME,
						esc_url( add_query_arg( 'action', 'insight_core_get_changelogs', admin_url( 'admin-ajax.php' ) ) ),
						sprintf( 'class="thickbox" aria-label="%s"',
							esc_attr( sprintf( __( 'View %1$s version %2$s details' ), INSIGHT_CORE_THEME_NAME, $last_update->response[ INSIGHT_CORE_THEME_SLUG ]['new_version'] ) )
						),
						$last_update->response[ INSIGHT_CORE_THEME_SLUG ]['new_version'],
						wp_nonce_url( self_admin_url( 'update.php?action=upgrade-theme&theme=' ) . INSIGHT_CORE_THEME_SLUG, 'upgrade-theme_' . INSIGHT_CORE_THEME_SLUG ),
						sprintf( 'id="update-theme" aria-label="%s"',
							esc_attr( sprintf( __( 'Update %s now' ), INSIGHT_CORE_THEME_NAME ) )
						) );
				} else {
					printf( __(
						'There is a new version of %1$s available. <strong>Please enter your purchase code to update the theme.</strong>',
						'insight-core'
					),
						INSIGHT_CORE_THEME_NAME
					);
				}
				?>
			</div>
		</div>
		<div class="box">
			<div class="box-header">
				<span class="icon gray"><i class="pe-7s-ribbon"></i></span>
				Patcher for <?php echo INSIGHT_CORE_THEME_NAME . ' ' . INSIGHT_CORE_THEME_VERSION; ?>
			</div>
			<div class="box-body">
				<?php
				$patchers = InsightCore::get_patcher();
				//get patcher for only current version
				if ( is_array( $patchers ) && isset( $patchers[ INSIGHT_CORE_THEME_VERSION ] ) ) {
				$patchers_reverse = array_reverse( $patchers[ INSIGHT_CORE_THEME_VERSION ], true );
				?>
				<table class="wp-list-table widefat striped changelogs">
					<thead>
					<tr>
						<th>ID</th>
						<th>Time</th>
						<th>Description</th>
						<th>Action</th>
					</tr>
					</thead>
					<tbody>
					<?php
					$patchers_status = (array) get_option( 'insight_core_patcher' );
					$i               = 0;
					foreach ( $patchers_reverse as $key => $val ) {
						echo '<tr>';
						echo '<td>#' . $key . '</td>';
						echo '<td>' . $val['time'] . '</td>';
						echo '<td>' . $val['desc'] . '</td>';

						if ( InsightCore::check_valid_update() ) {

							if ( in_array( $key, $patchers_status ) ) {
								echo '<td>Done</td>';
								$patchers_done = false;
								$i             = 0;
							} else {
								if ( $i != 0 ) {
									echo '<td>Please apply previous patch first</td>';
								} else {
									echo '<td id="patcher' . $key . '"><a class="insight-core-patcher" rel="' . $key . '" href="#">Apply</a></td>';
								}
								$i ++;
							}

						} else {
							echo '<td><strong>Please enter your purchase code to update the theme.</strong></td>';
						}
						echo '</tr>';
					}
					echo '</tbody></table>';
					} else {
						echo 'Have no patcher for this version.';
					}
					?>
			</div>
		</div>
	</div>
	<?php
	include_once( INSIGHT_CORE_INC_DIR . '/pages-footer.php' );
	?>
</div>