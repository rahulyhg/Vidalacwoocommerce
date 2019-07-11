<?php

/**
 * Instagram
 *
 * @package   InsightFramework
 */
if ( ! class_exists( 'Amely_Instagram' ) ) {

	class Amely_Instagram {

		const CLIENT_ID = 'd5d0868a929d453281a9f5dfb324d510';
		const CLINE_SECRET = 'ddc3dbc54b2e478a9e1feb54376cc49e';
		const ACCESS_TOKEN = '2102623126.d5d0868.e18524f9c81d49c3992f3ee0ce3e41ee';

		//    !!! IMPORTANT: DO NOT CHANGE THESE URL!!!!
		const INSTAGRAM_API_URL = 'https://api.instagram.com/v1';
		const FIND_USER_URL = self::INSTAGRAM_API_URL;

		public static function get_instance() {
			static $instance;
			$class = __CLASS__;

			if ( ! $instance instanceof $class ) {
				$instance = new $class;
			}

			return $instance;
		}

		public static function scrape_instagram( $username, $number, $square = true ) {

			$username   = trim( strtolower( $username ) );
			$by_hashtag = substr( $username, 0, 1 ) == '#';

			if ( false === ( $instagram = get_transient( 'instagram-media-2' . sanitize_title_with_dashes( $username . '-' . $square ) ) ) ) {

				$request_param = $by_hashtag ? 'explore/tags/' . substr( $username, 1 ) : $username;

				$remote = wp_remote_get( sprintf( 'https://instagram.com/%s', $request_param ) );

				if ( is_wp_error( $remote ) ) {
					return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'amely' ) );
				}

				if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
					return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'amely' ) );
				}
				$shards     = explode( 'window._sharedData = ', $remote['body'] );
				$insta_json = explode( ';</script>', $shards[1] );
				$insta_arr  = json_decode( $insta_json[0], true );

				if ( ! $insta_arr ) {
					return new WP_Error( 'bad_json', esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
				}

				if ( isset( $insta_arr['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'] ) ) {
					$media_arr = $insta_arr['entry_data']['ProfilePage'][0]['graphql']['user']['edge_owner_to_timeline_media']['edges'];
				} elseif ( $by_hashtag && isset( $insta_arr['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) && count( $insta_arr['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'] ) ) {
					$media_arr = $insta_arr['entry_data']['TagPage'][0]['graphql']['hashtag']['edge_hashtag_to_media']['edges'];
				} else {
					return new WP_Error( 'bad_json_2', esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
				}

				if ( ! is_array( $media_arr ) ) {
					return new WP_Error( 'bad_array', esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
				}

				$instagram = array();
				$index     = 0;

				foreach ( $media_arr as $media ) {

					if ( $index == $number ) {
						break;
					}

					$node      = $media['node'];
					$image_src = ( $square ) ? 'thumbnail_src' : 'display_url';
					$type      = ( $node['is_video'] == true ) ? 'video' : 'image';

					$instagram[] = array(
						'description' => isset( $node['edge_media_to_caption']['edges'][0]['node']['text'] ) ? $node['edge_media_to_caption']['edges'][0]['node']['text'] : '',
						'link'        => '//instagram.com/p/' . $node['shortcode'],
						'time'        => $node['taken_at_timestamp'],
						'comments'    => self::roundNumber( $node['edge_media_to_comment']['count'] ),
						'likes'       => self::roundNumber( $node['edge_liked_by']['count'] ),
						'thumbnail'   => preg_replace( '/^https?\:/i', '', $node[ $image_src ] ),
						'type'        => $type,
					);

					$index ++;
				}

				// do not set an empty transient - should help catch private or empty accounts
				if ( ! empty( $instagram ) ) {
					$instagram = insight_core_base_encode( serialize( $instagram ) );
					set_transient( 'instagram-media-' . sanitize_title_with_dashes( $username . '-' . $square ),
						$instagram,
						apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
				}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( insight_core_base_decode( $instagram ) );

				return $instagram;

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'amely' ) );

			}
		}

		/**
		 * Generate rounded number
		 * Example: 11200 --> 11K
		 *
		 * @param $number
		 *
		 * @return string
		 */
		public static function roundNumber( $number ) {
			if ( $number > 999 && $number <= 999999 ) {
				$result = floor( $number / 1000 ) . ' K';
			} elseif ( $number > 999999 ) {
				$result = floor( $number / 1000000 ) . ' M';
			} else {
				$result = $number;
			}

			return $result;
		}

		/**
		 * Get media via OAuth 2 (use for future if scrape_instagram can't be used
		 * Alway return square media
		 *
		 * @param $username
		 * @param $number_items
		 *
		 * @return array|WP_Error
		 */
		public static function oauth_instagram( $username, $number_items ) {

			$username = trim( strtolower( $username ) );

			if ( false === ( $instagram = get_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username ) ) ) ) {
				// find user by name
				$user_remote = wp_remote_get( sprintf( self::INSTAGRAM_API_URL . '/users/search/?q=%s&access_token=%s&count=1',
					$username,
					self::ACCESS_TOKEN ) );

				if ( true === self::isValidRemote( $user_remote ) ) {

					if ( ! empty( $user_remote['body'] ) ) {
						$user_arr = json_decode( $user_remote['body'], true );

						if ( ! $user_arr ) {
							return new WP_Error( 'bad_json',
								esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
						}

						// get user ID.
						if ( isset( $user_arr['data'][0]['id'] ) ) {
							$userID = $user_arr['data'][0]['id'];

							// Get the most recent media published by a user.
							if ( ! empty( $userID ) ) {
								$insta_remote = wp_remote_get( sprintf( self::INSTAGRAM_API_URL . '/users/%s/media/recent/?access_token=%s&count=%s',
									$userID,
									self::ACCESS_TOKEN,
									$number_items ) );
								if ( true === self::isValidRemote( $insta_remote ) ) {
									$insta_arr = json_decode( $insta_remote['body'], true );

									if ( ! $insta_arr ) {
										return new WP_Error( 'bad_json_2',
											esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
									}

									$media_arr = $insta_arr['data'];

									if ( ! is_array( $media_arr ) ) {
										return new WP_Error( 'bad_array',
											esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
									}

									$instagram = self::get_media_old_method( $username, $media_arr );

									// do not set an empty transient - should help catch private or empty accounts
									if ( ! empty( $instagram ) ) {
										$instagram = insight_core_base_encode( serialize( $instagram ) );
										set_transient( 'instagram-media-new-' . sanitize_title_with_dashes( $username ),
											$instagram,
											apply_filters( 'null_instagram_cache_time', HOUR_IN_SECONDS * 2 ) );
									}
								}
							}
						} else {
							return new WP_Error( 'bad_json_4',
								esc_html__( 'Instagram has returned invalid data.', 'amely' ) );
						}
					}
				}
			}

			if ( ! empty( $instagram ) ) {

				$instagram = unserialize( insight_core_base_encode( $instagram ) );

				return $instagram;

			} else {

				return new WP_Error( 'no_images', esc_html__( 'Instagram did not return any images.', 'amely' ) );

			}
		}

		/**
		 * Check Remote
		 *
		 * @param $remote
		 *
		 * @return bool|WP_Error
		 */
		public static function isValidRemote( $remote ) {
			if ( is_wp_error( $remote ) ) {
				return new WP_Error( 'site_down', esc_html__( 'Unable to communicate with Instagram.', 'amely' ) );
			}

			if ( 200 != wp_remote_retrieve_response_code( $remote ) ) {
				return new WP_Error( 'invalid_response', esc_html__( 'Instagram did not return a 200.', 'amely' ) );
			}

			return true;
		}
	}
}
