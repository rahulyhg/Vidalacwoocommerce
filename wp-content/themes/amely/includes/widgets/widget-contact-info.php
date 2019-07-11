<?php
/**
 * Contact Information Widget
 * Add contact information to the footer
 *
 */

if ( ! class_exists( 'Amely_Contact_Info_Widget' ) ) {
	add_action( 'widgets_init', 'load_amely_contact_info_widget' );

	function load_amely_contact_info_widget() {
		register_widget( 'Amely_Contact_Info_Widget', 1 );
	}

	/**
	 * Contact Information Widget by ThemeMove
	 */
	class Amely_Contact_Info_Widget extends WPH_Widget {

		/**
		 * Register widget with WordPress.
		 */
		function __construct() {

			// Configure widget array
			$args = array(
				'slug'        => 'tm_contact_info',
				// Widget Backend label
				'label'       => '&#x1f4e7; &nbsp;' . esc_html__( 'AMELY Contact Information', 'amely' ),
				// Widget Backend Description
				'description' => esc_html__( 'Display contact information on footer. Developed by ThemeMove.', 'amely' ),
			);

			// Configure the widget fields
			$args['fields'] = array(

				array(
					'name'   => esc_html__( 'Title', 'amely' ),
					'id'     => 'title',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Logo URL', 'amely' ),
					'id'     => 'image_src',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Description', 'amely' ),
					'id'     => 'description',
					'type'   => 'textarea',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Address 1', 'amely' ),
					'id'     => 'address1',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Address 2', 'amely' ),
					'id'     => 'address2',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Address 3', 'amely' ),
					'id'     => 'address3',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr'
				),

				array(
					'name'   => esc_html__( 'Phone', 'amely' ),
					'id'     => 'phone',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr',
					'desc'   => esc_html__( 'You can add multiple phone numbers, separate by comma. E.g. (1234) 567 890, +1 468 398', 'amely' )
				),

				array(
					'name'   => esc_html__( 'Email', 'amely' ),
					'id'     => 'email',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr',
					'desc'   => esc_html__( 'You can add multiple email addresses, separate by comma. E.g. tech@example.com, support@gmail.com', 'amely' )
				),

				array(
					'name'   => esc_html__( 'Websites', 'amely' ),
					'id'     => 'web',
					'type'   => 'text',
					'class'  => 'widefat',
					'std'    => '',
					'filter' => 'strip_tags|esc_attr',
					'desc'   => esc_html__( 'You can add multiple websites, separate by comma. Eg: http://example.com, https://myname.com', 'amely' )
				),

				array(
					'name' => esc_html__( 'Show social links', 'amely' ),
					'id'   => 'show_social_links',
					'type' => 'checkbox',
				),
			);

			// create widget
			$this->create_widget( $args );
		}

		function widget( $args, $instance ) {

			$title             = isset( $instance['title'] ) ? $instance['title'] : '';
			$img_src           = isset( $instance['image_src'] ) ? $instance['image_src'] : '';
			$description       = isset( $instance['description'] ) ? $instance['description'] : '';
			$address1          = isset( $instance['address1'] ) ? $instance['address1'] : '';
			$address2          = isset( $instance['address2'] ) ? $instance['address2'] : '';
			$address3          = isset( $instance['address3'] ) ? $instance['address3'] : '';
			$phone             = isset( $instance['phone'] ) ? $instance['phone'] : '';
			$email             = isset( $instance['email'] ) ? $instance['email'] : '';
			$web               = isset( $instance['web'] ) ? $instance['web'] : '';
			$show_social_links = isset( $instance['show_social_links'] ) ? $instance['show_social_links'] : '';

			echo '' . $args['before_widget'];

			$output = $title ? $args['before_title'] . $title . $args['after_title'] : '';

			$output .= '<div class="contact-info">';

			if ( $img_src ) {
				$output .= '<img class="contact-info__logo" src="' . esc_attr( $img_src ) . '" alt="" />';
			}

			if ( $description ) {
				$output .= '<p class="description">';
				$output .= '<span>' . $description . '</span>';
				$output .= '</p>';
			}

			if ( $address1 ) {
				$output .= '<p class="address1">';
				$output .= '<i class="fa fa-map-marker"></i>';
				$output .= '<span>' . $address1 . '</span>';
				$output .= '</p>';
			}

			if ( $address2 ) {
				$output .= '<p class="address2">';
				$output .= '<i class="fa fa-map-marker"></i>';
				$output .= '<span>' . $address2 . '</span>';
				$output .= '</p>';
			}
			if ( $address3 ) {
				$output .= '<p class="address3">';
				$output .= '<i class="fa fa-map-marker"></i>';
				$output .= '<span>' . $address3 . '</span>';
				$output .= '</p>';
			}

			if ( isset( $phone ) && $phone ) {

				$phones = explode( ',', $phone );

				foreach ( $phones as $p ) {
					$p = trim( $p );
					$output .= '<p class="phone">';
					$output .= '<i class="fa fa-phone"></i>';
					$output .= '<a href="tel:' . preg_replace( '/\D/', '', $p ) . '">' . $p . '</a>';
					$output .= '</p>';

				}
			}

			if ( isset( $email ) && $email ) {

				$emails = explode( ',', $email );

				foreach ( $emails as $e ) {
					$e = trim( $e );
					$output .= '<p class="email">';
					$output .= '<i class="fa fa-envelope-o"></i>';
					$output .= '<a href="mailto:' . $e . '">' . $e . '</a>';
					$output .= '</p>';
				}
			}

			if ( isset( $web ) && $web ) {

				$webs = explode( ',', $web );

				foreach ( $webs as $w ) {
					$output .= '<p class="web">';
					$output .= '<i class="fa fa-anchor"></i>';
					$output .= '<a href="' . ( $w ) . '">' . $w . '</a>';
					$output .= '</p>';
				}
			}


			$output .= '</div>';

			echo '' . $output;
			if ( $show_social_links ) {
				echo Amely_Templates::social_links();
			}

			echo '' . $args['after_widget'];
		}
	}
}
