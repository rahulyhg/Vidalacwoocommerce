<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * @package   Amely_Framework
 */

if ( class_exists( 'Walker_Nav_Menu' ) && ! class_exists( 'Amely_Walker_Nav_Menu' ) ) {

	class Amely_Walker_Nav_Menu extends Walker_Nav_Menu {

		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			/**
			 * Filter the arguments for a single nav menu item.
			 */
			$classes   = empty( $item->classes ) ? array() : (array) $item->classes;
			$classes[] = 'menu-item-' . $item->ID;

			$children = get_posts( array(
				'post_type'   => 'nav_menu_item',
				'nopaging'    => true,
				'numberposts' => 1,
				'meta_key'    => '_menu_item_menu_item_parent',
				'meta_value'  => $item->ID,
			) );

			foreach ( $children as $child ) {
				$obj = get_post_meta( $child->ID, '_menu_item_object' );

				if ( $obj[0] == 'ic_mega_menu' ) {

					$classes[] = 'mega-menu-' . ( ! empty( $item->layout ) ? $item->layout : 'default' );
					$classes[] = apply_filters( 'insight_core_mega_menu_css_class', 'mega-menu', $item, $args, $depth );
				}
			}

			// Check alternative color
			if ( ! empty( $item->alt_colors ) && $item->alt_colors == 'on' ) {
				$classes[] = 'alt-color';
			}

			/**
			 * Filter the CSS class(es) applied to a menu item's list item element.
			 *
			 */
			$class_names = join( ' ',
				apply_filters( 'nav_menu_css_class', array_filter( $classes ), $item, $args, $depth ) );
			$class_names = $class_names ? ' class="' . esc_attr( $class_names ) . '"' : '';

			/**
			 * Filter the ID applied to a menu item's list item element.
			 */
			$id = apply_filters( 'nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args, $depth );
			$id = $id ? ' id="' . esc_attr( $id ) . '"' : '';
			$output .= $indent . '<li' . $id . $class_names . '>';

			/**
			 * Filter the HTML attributes applied to a menu item's anchor element.
			 */
			$atts           = array();
			$atts['title']  = ! empty( $item->attr_title ) ? $item->attr_title : '';
			$atts['target'] = ! empty( $item->target ) ? $item->target : '';
			$atts['rel']    = ! empty( $item->xfn ) ? $item->xfn : '';
			$atts['href']   = ! empty( $item->url ) ? $item->url : '';
			$atts           = apply_filters( 'nav_menu_link_attributes', $atts, $item, $args, $depth );
			$attributes     = '';
			foreach ( $atts as $attr => $value ) {
				if ( ! empty( $value ) ) {
					$value = ( 'href' === $attr ) ? esc_url( $value ) : esc_attr( $value );
					$attributes .= ' ' . $attr . '="' . $value . '"';
				}
			}

			/**  Filter a menu item's title  **/
			$item_output = $args->before;
			$item_output .= '<a' . $attributes . '>';
			$item_output .= $args->link_before;

			if ( $item->icon_classes ) {
				$item_output .= '<i class="menu-item-icon ' . ( strpos( $item->icon_classes,
						'fa' ) > - 1 ? 'fa ' : '' ) . $item->icon_classes . '"></i>';
			}

			$item_output .= apply_filters( 'the_title', $item->title, $item->ID );

			if ( $item->tag_type ) {
				$item_output .= '<span class="menu-item-tag menu-item-tag--' . $item->tag_type . '">';
				$item_output .= ( $item->tag ? $item->tag : $item->tag_type );
				$item_output .= '</span>';
			}

			$item_output .= $args->link_after;
			$item_output .= '</a>';
			$item_output .= $args->after;

			$css = $this->get_css( $item );

			if ( $css ) {
				$js_output = '';
				$js_output .= 'if ( _amelyInlineStyle !== null ) {';
				$js_output .= '_amelyInlineStyle.textContent+=\'' . Amely_Helper::text2line( $css ) . '\';';
				$js_output .= '}';
				wp_add_inline_script( 'amely-main-js', Amely_Helper::text2line( $js_output ) );
			}

			if ( $item->object == 'ic_mega_menu' ) {
				$menu_post               = get_post( $item->object_id );
				$mega_menu_content_class = apply_filters( 'insight_core_mega_menu_content_css_class',
					'mega-menu-content container',
					$item,
					$args,
					$depth );
				$output .= '<div class="' . esc_attr( $mega_menu_content_class ) . '">' . do_shortcode( $menu_post->post_content ) . '</div>';
			} else {
				$output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
			}
		}

		public function get_css( $item ) {

			$css = '';

			if ( isset( $item->tag_type ) && $item->tag_type ) {

				if ( ( isset( $item->tag_color ) && $item->tag_color ) || ( isset( $item->tag_bgcolor ) && $item->tag_bgcolor ) ) {

					$css .= '.menu-item-' . $item->ID . ' .menu-item-tag--custom{';

					if ( isset( $item->tag_color ) && $item->tag_color ) {
						$css .= 'color:' . $item->tag_color . ';';
					}

					if ( isset( $item->tag_bgcolor ) && $item->tag_bgcolor ) {
						$css .= 'background-color:' . $item->tag_bgcolor . ';';
					}

					$css .= ' }';

					if ( isset( $item->tag_bgcolor ) && $item->tag_bgcolor ) {
						$css .= '.site-menu .menu-item-' . $item->ID . ' .menu-item-tag--custom:after{';
						$css .= 'border-top-color:' . $item->tag_bgcolor . ';';
						$css .= ' }';
						$css .= '.site-mobile-menu .menu-item-' . $item->ID . ' .menu-item-tag--custom:after{';
						$css .= 'border-right-color:' . $item->tag_bgcolor . ';';
						$css .= ' }';
					}

				}

				if ( ( isset( $item->tag_color_hover ) && $item->tag_color_hover ) || ( isset( $item->tag_bgcolor_hover ) && $item->tag_bgcolor_hover ) ) {

					$css .= '.menu-item-' . $item->ID . ':hover .menu-item-tag--custom{';

					if ( isset( $item->tag_color_hover ) && $item->tag_color_hover ) {
						$css .= 'color:' . $item->tag_color_hover . ';';
					}

					if ( isset( $item->tag_bgcolor_hover ) && $item->tag_bgcolor_hover ) {
						$css .= 'background-color:' . $item->tag_bgcolor_hover . ';';
					}

					$css .= ' }';

					if ( isset( $item->tag_bgcolor_hover ) && $item->tag_bgcolor_hover ) {
						$css .= '.site-menu .menu-item-' . $item->ID . ':hover .menu-item-tag--custom:after{';
						$css .= 'border-top-color:' . $item->tag_bgcolor_hover . ';';
						$css .= ' }';
						$css .= '.site-mobile-menu .menu-item-' . $item->ID . ':hover .menu-item-tag--custom:after{';
						$css .= 'border-right-color:' . $item->tag_bgcolor_hover . ';';
						$css .= ' }';
					}
				}
			}

			if ( ! empty( $item->layout ) && $item->layout == 'custom' && ! empty( $item->width ) ) {
				$css .= '.menu-item-' . $item->ID . ' > .sub-menu {';
				$css .= 'width: ' . $item->width . 'px !important; ';
				$css .= '}';
			}

			return $css;
		}
	}

	add_filter( 'insight_core_bmw_nav_args', 'amely_add_extra_params_to_insightcore_bmw' );
	function amely_add_extra_params_to_insightcore_bmw( $args ) {
		$args['walker'] = new Amely_Walker_Nav_Menu;

		return $args;
	}
}
