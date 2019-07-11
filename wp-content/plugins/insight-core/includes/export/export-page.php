<div class="wrap insight-core-wrap">
	<?php
	InsightCore::update_option_count( 'insight_core_view_export' );
	include_once( INSIGHT_CORE_INC_DIR . '/pages-header.php' );
	?>
	<div class="insight-core-body">
		<div class="box">
			<div class="box-header">
				<span class="icon"><i class="pe-7s-magic-wand"></i></span>
				Export
			</div>
			<div class="box-body">
				<table class="table">
					<tbody>
					<tr valign="middle">
						<td>
							Content
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="content"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export"
								       class="btn"/>
							</form>
						</td>
					</tr>
					<tr valign="middle">
						<td>
							Sidebars
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="sidebars"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export"
								       class="btn"/>
							</form>
						</td>
					</tr>
					<tr valign="middle">
						<td>
							Widgets
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="widgets"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export"
								       class="btn"/>
							</form>
						</td>
					</tr>
					<tr valign="middle">
						<td>
							Menus
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="menus"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export"
								       class="btn"/>
							</form>
						</td>
					</tr>
					<tr valign="middle">
						<td>
							Page Options
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="page_options"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export" class="btn"/>
							</form>
						</td>
					</tr>
					<tr valign="middle">
						<td>
							Customizer Options
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="customizer_options"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export" class="btn"/>
							</form>
						</td>
					</tr>
					<?php if ( class_exists( 'WooCommerce' ) ) { ?>
						<tr valign="middle">
							<td>
								WooCommerce
							</td>
							<td>
								<form method="post" action="">
									<input type="hidden" name="export_option" value="woocommerce"/>
									<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
									       name="export"
									       class="btn"/>
								</form>
							</td>
						</tr>
					<?php } ?>
					<?php if ( class_exists( 'WooCommerce' ) && class_exists( 'Insight_Attribute_Swatches' ) ) { ?>
						<tr valign="middle">
							<td>
								Insight Attribute Swatches
							</td>
							<td>
								<form method="post" action="">
									<input type="hidden" name="export_option" value="isw"/>
									<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
									       name="export"
									       class="btn"/>
								</form>
							</td>
						</tr>
					<?php } ?>
					<?php if ( class_exists( 'Essential_Grid' ) ) { ?>
						<!--form method="post" action="">
							<input type="hidden" name="export_option" value="essential_grid"/>
							<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
							       name="export" class="btn"/>
						</form-->
					<?php } ?>
					<td>
						Revolution Slider
					</td>
					<td>
						<form method="post" action="">
							<input type="hidden" name="export_option" value="rev_sliders"/>
							<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
							       name="export" class="btn"/>
						</form>
					</td>
					<tr valign="middle">
						<td>
							Media Package
						</td>
						<td>
							<form method="post" action="">
								<input type="hidden" name="export_option" value="media_package"/>
								<input type="text" name="demo" value="insightcore01"/>
								<input type="submit" value="<?php echo esc_html__( 'Export', 'insight-core' ); ?>"
								       name="export" class="btn"/>
							</form>
						</td>
					</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
	<?php
	include_once( INSIGHT_CORE_INC_DIR . '/pages-footer.php' );
	?>
</div>