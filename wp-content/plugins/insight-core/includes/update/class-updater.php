<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Update theme
 *
 * @since     1.0
 * @package   TM_TwentyFramework
 */
if ( ! class_exists( 'InsightCore_Updater' ) ) {

	class InsightCore_Updater {

		public function __construct() {

			add_filter( 'pre_set_site_transient_update_themes', array( $this, 'check_for_update' ) );
		}

		public function check_for_update( $transient ) {

			if ( empty( $transient->checked ) ) {
				return $transient;
			}

			$update = InsightCore::check_theme_update();

			if ( $update ) {
				$response = array(
					'url'         => esc_url( add_query_arg( 'action', 'insight_core_get_changelogs', admin_url( 'admin-ajax.php' ) ) ),
					'new_version' => $update['new_version'],
				);

				$transient->response[ INSIGHT_CORE_THEME_SLUG ] = $response;

				// If the purchase code is valide, user can get the update package
				if ( InsightCore::check_valid_update() ) {
					$transient->response[ INSIGHT_CORE_THEME_SLUG ]['package'] = $update['package'];
				} else {
					unset( $transient->response[ INSIGHT_CORE_THEME_SLUG ]['package'] );
				}

			}

			return $transient;
		}
	}

	new InsightCore_Updater();
}