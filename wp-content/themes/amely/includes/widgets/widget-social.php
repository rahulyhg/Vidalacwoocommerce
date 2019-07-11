<?php
/**
 * Social Widget
 */
if ( ! class_exists( 'Amely_Social_Widget' ) ) {

	add_action( 'widgets_init', 'load_amely_widget' );

	function load_amely_widget() {
		register_widget( 'Amely_Social_Widget' );
	}

	/**
	 * Widget by amely
	 *
	 * @property mixed data
	 */
	class Amely_Social_Widget extends WP_Widget {

		private $social_networks = array();
		private $social_links = array();

		private function parse_social_links( $array ) {

			foreach ( $this->social_networks as $key => $val ) {
				if ( isset( $array[ $key ] ) ) {
					$this->social_links[ $key ] = $array[ $key ];
				}
			}
		}

		/*
         * Register widget with WordPress
         */
		function __construct() {
			parent::__construct( 'tm_social',
				'&#x1f534; &nbsp;' . esc_html__( 'AMELY Social', 'amely' ),
				array( 'description' => esc_html__( 'Display your social networks.', 'amely' ) ) );

			$this->social_networks = Amely_Helper::social_icons( false );
		}

		function widget( $args, $instance ) {

			$tooltip         = amely_get_option( 'tooltip' );
			$open_in_new_tab = amely_get_option( 'social_open_in_new_tab' );

			extract( $args );

			echo $args['before_widget'];

			$output = '<h3 class="widget-title">' . $instance['title'] . '</h3>';

			if ( $instance['source'] == 'default' ) {
				$output .= Amely_Templates::social_links();
			} else {

				$this->parse_social_links( $instance );

				if ( ! empty( $this->social_links ) ) {

					$li_classes = array();
					$labels     = Amely_Helper::social_icons( false );

					$output .= '<ul class="social-links">';

					if ( $tooltip ) {
						$li_classes[] = 'hint--top hint--bounce';
					}

					foreach ( $this->social_links as $key => $link ) {

						if ( $link != '' ) {

							if ( 'envelope-o' == $key ) {
								$link = 'mailto:' . $link;
							}

							$output .= '<li class="' . implode( ' ',
									$li_classes ) . '" aria-label="' . esc_attr( $labels[ $key ] ) . '">';
							$output .= '<a href="' . esc_url( $link ) . '" target="' . ( $open_in_new_tab ? '_blank' : '_self' ) . '">';
							$output .= '<i class="fa fa-' . esc_attr( $key ) . '" aria-hidden="true"></i>';
							$output .= '</a>';
							$output .= '</li>';
						}
					}

					$output .= '</ul>';
				}
			}

			echo $output;

			echo $args['after_widget'];
		}

		function update( $new_instance, $old_instance ) {
			$instance           = $old_instance;
			$instance['title']  = strip_tags( $new_instance['title'] );
			$instance['source'] = strip_tags( $new_instance['source'] );

			foreach ( $this->social_networks as $key => $val ) {
				$instance[ $key ] = strip_tags( $new_instance[ $key ] );
			}

			return $instance;
		}

		function form( $instance ) {

			// Set up default settings
			$default = array(
				'title'  => '',
				'source' => 'default',
			);

			foreach ( $this->social_networks as $key => $social ) {
				$default[ $key ] = '';
			}

			$instance = wp_parse_args( (array) $instance, $default );

			?>
			<p>
				<label for="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"><?php esc_html_e( 'Title',
						'amely' ); ?></label>
				<input type="text" class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'title' ) ); ?>"
				       name="<?php echo esc_attr( $this->get_field_name( 'title' ) ); ?>"
				       value="<?php echo esc_attr( $instance['title'] ); ?>"/>
			</p>
			<p>
				<label
					for="<?php echo esc_attr( $this->get_field_id( 'source' ) ); ?>"><?php esc_html_e( 'Select Social Source',
						'amely' ); ?></label>
				<select class="widefat"
				        name="<?php echo esc_attr( $this->get_field_name( 'source' ) ); ?>"
				        id="<?php echo esc_attr( $this->get_field_id( 'source' ) ); ?>">
					<option value="default" <?php selected( $instance['source'], 'default', true ); ?>>
						<?php esc_html_e( 'Default (from Theme Options >> Social)', 'amely' ) ?>
					</option>
					<option value="custom" <?php selected( $instance['source'], 'custom', true ); ?>>
						<?php esc_html_e( 'Custom', 'amely' ) ?>
					</option>
				</select>
			</p>
			<p class="help"><?php echo wp_kses( sprintf( __( 'If you choose default, please edit social networks in <a href="%s" target="_blank">Theme Options >> Social</a>',
					'amely' ),
					'?page=amely_options&tab=28' ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) );
				?></p>
			<div class="tm-social-links" data-social-links="true">
				<p>
					<label><?php esc_html_e( 'Social links', 'amely' ); ?></label>
				</p>
				<div class="tm-social-links-inner">
					<table class="tm-table tm-social-links-table widefat">
						<tr>
							<th><strong><?php esc_html_e( 'Social Network', 'amely' ); ?></strong></th>
							<th><strong><?php esc_html_e( 'Link', 'amely' ); ?></strong></th>
						</tr>
						<?php
						foreach ( $this->social_networks as $key => $social ) {
							?>
							<tr>
								<td class="tm-social tm-social--<?php echo esc_attr( $key ); ?>">
									<span><i
											class="fa fa-<?php echo esc_attr( $key ) ?>"></i><?php echo $social; ?></span>
								</td>
								<td>
									<input type="text" name="<?php echo esc_attr( $this->get_field_name( $key ) ) ?>"
									       id="<?php echo esc_attr( $this->get_field_id( $key ) ); ?>"
									       value="<?php echo esc_attr( $instance[ $key ] ); ?>">
								</td>
							</tr>
							<?php
						}
						?>
					</table>
				</div>
			</div>
			<script type='text/javascript'>

				jQuery( document ).ready( function( $ ) {

					var $select = $( '#<?php echo esc_attr( $this->get_field_id( 'source' ) ); ?>' ),
						$socialLinks = $( '.tm-social-links' ),
						source = $select.val();

					if ( source == 'custom' ) {
						$socialLinks.show();
					} else {
						$socialLinks.hide();
					}

					$select.on( 'change', function() {

						var value = $( this ).val();

						if ( value == 'custom' ) {
							$socialLinks.show();
						} else {
							$socialLinks.hide();
						}
					} );
				} );
			</script>
			<?php
		}
	} // end class
} // end if
