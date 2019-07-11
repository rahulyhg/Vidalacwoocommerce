<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper functions
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Mailchimp' ) ) {

	class Amely_Mailchimp {

		private $api_key = "";
		private $datacenter = "";
		private $api_version = "";
		private $api_endpoint = "";
		private $format = "";
		private $verify_ssl = false;
		private $user_agent = "";
		private $debug = false;

		function __construct() {
			$api_key       = Amely_Helper::get_option( 'mailchimp_api_key' );
			$this->api_key = $api_key;
			if ( strlen( substr( strrchr( $api_key, '-' ), 1 ) ) ) {
				$this->datacenter = substr( strrchr( $api_key, '-' ), 1 );
			} else {
				$this->datacenter = "us1";
			}
			$this->api_version  = "2.0";
			$this->api_endpoint = "https://" . $this->datacenter . ".api.mailchimp.com/" . $this->api_version . "/";
			$this->format       = "json";
			$this->verify_ssl   = false;
			$this->user_agent   = "ThemeMove-Mailing/1.0";

			add_action( 'wp_ajax_nopriv_amely_ajax_subscribe',
				array(
					&$this,
					'subscribe_to_list',
				) );
			add_action( 'wp_ajax_amely_ajax_subscribe',
				array(
					&$this,
					'subscribe_to_list',
				) );
		}

		/**
		 *
		 *    Runs API query
		 *
		 * @param $query - string - endpoint and parameters. like "lists/subscribe"
		 * @param $data  - array - the data which'll be posted. must NOT be json decoded!
		 * @param $data  - array - optional - curl query timeout in seconds
		 *
		 * @return array - API response
		 */
		private function rest( $query, $data = array(), $timeout = 10 ) {
			if ( ! function_exists( 'curl_init' ) ) {
				$result = array(
					'status' => true,
					'name'   => 'curl_package_disabled',
				);

				return $result;
			}

			$url = $this->api_endpoint . $query . "." . $this->format;

			$data['apikey'] = $this->api_key;

			$header[] = "Content-type: application/json";

			$ch = curl_init();
			curl_setopt( $ch, CURLOPT_URL, $url );

			$jsondata = json_encode( $data );
			curl_setopt( $ch, CURLOPT_POSTFIELDS, $jsondata );
			curl_setopt( $ch, CURLOPT_POST, true );
			curl_setopt( $ch, CURLOPT_HTTPHEADER, $header );
			curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, $this->verify_ssl );
			curl_setopt( $ch, CURLOPT_TIMEOUT, $timeout );
			curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $ch, CURLOPT_HEADER, false );
			curl_setopt( $ch, CURLOPT_USERAGENT, $this->user_agent );

			$result = curl_exec( $ch );

			if ( $this->debug ) {
				echo "<pre>result:<br>";
				print_r( json_decode( $result, true ) );
				echo "<br>curlinfo:<br>";
				print_r( curl_getinfo( $ch ) );
				echo "</pre>";
			}

			curl_close( $ch );

			return json_decode( $result, true );
		}

		/**
		 *
		 *    Subscribes the email address to the given list
		 *
		 * @param    $email   - string
		 * @param    $list_id - string - sth like "6edd80a499"
		 * @param    $optin   - boolean - optional
		 *
		 * @return array
		 */
		public function subscribe( $email, $list_id, $optin = true ) {
			$data = array(
				"id"           => $list_id,
				"email"        => array(
					"email" => $email,
				),
				"merge_vars"   => array(
					"FNAME" => "",
					"LNAME" => "",
				),
				"double_optin" => $optin,
				"send_welcome" => $optin,
			);

			return $this->rest( "lists/subscribe", $data, 20 );
		}

		/**
		 *
		 *    Unsubscribes the email address to the given list
		 *
		 * @param    $email   - string
		 * @param    $list_id - string - sth like "6edd80a499"
		 * @param    $optout  - boolean - optional
		 *
		 * @return    $result - array
		 */
		public function unsubscribe( $email, $list_id, $optout = false ) {
			$data = array(
				"id"           => $list_id,
				"email"        => array(
					"email" => $email,
				),
				"send_goodbye" => $optout,
				"send_notify"  => $optout,
			);

			return $this->rest( "lists/unsubscribe", $data );
		}

		/**
		 *
		 *    Lists lists o_O
		 *
		 * @param string $list_id - string - sth like "6edd80a499"
		 *
		 * @return array $result
		 */
		public function get_lists( $list_id = "" ) {
			$data = array(
				"filters" => array(
					"list_id" => $list_id,
				),
			);

			return $this->rest( "lists/list", $data, 20 );
		}

		public function get_lists_for_dropdown_vc() {

			$lists    = $this->get_lists();
			$lists_vc = array( esc_html__( 'Select a list', 'amely' ) => '' );

			if ( ! $lists ) {
				return;
			}

			if ( isset($lists['data']) && is_array( $lists['data'] ) ) {
				foreach ( $lists['data'] as $list ) {
					$lists_vc[ $list['name'] ] = $list['id'];
				}
			}

			return $lists_vc;
		}

		public function subscribe_to_list() {

			$email   = stripslashes( $_POST['email'] );
			$list_id = stripslashes( $_POST['list_id'] );
			$optin   = stripslashes( $_POST['optin'] );

			$result = $this->subscribe( $email, $list_id, $optin );

			if ( empty( $result['status'] ) == false ) {
				switch ( $result['name'] ) {
					case 'Invalid_ApiKey':
						echo json_encode( array(
							'action_status' => false,
							'message'       => $result['error'],
						) );
						break;
					case 'List_DoesNotExist':
						echo json_encode( array(
							'action_status' => false,
							'message'       => $result['error'],
						) );
						break;
					case 'ValidationError':
						echo json_encode( array(
							'action_status' => false,
							'message'       => esc_html__( 'Oops! Enter a valid Email address', 'amely' ),
						) );
						break;

					case 'List_AlreadySubscribed':
						echo json_encode( array(
							'action_status' => false,
							'message'       => esc_html__( 'This email already subscribed to the list.', 'amely' ),
						) );
						break;

					case 'curl_package_disabled':
						echo json_encode( array(
							'action_status' => false,
							'message'       => esc_html__( 'Curl is disabled. Please enable curl in server php.ini settings.',
								'amely' ),
						) );
						break;
				}
			} elseif ( isset( $result['email'] ) ) {
				echo json_encode( array(
					'action_status' => true,
					'message'       => $result['email'] . esc_html__( ' has been subscribed.', 'amely' ),
				) );
			}
			wp_die();
		}
	}
}
