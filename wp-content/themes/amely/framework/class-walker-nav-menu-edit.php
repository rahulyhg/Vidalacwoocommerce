<?php

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Amely_Walker_Nav_Menu_Edit' ) ) {
	/**
	 * Copied from Walker_Nav_Menu_Edit class in core
	 *
	 * Create HTML list of nav menu input items.
	 *
	 * @package WordPress
	 * @since   3.0.0
	 * @uses    Walker_Nav_Menu
	 */
	class Amely_Walker_Nav_Menu_Edit extends Walker_Nav_Menu {

		public function __construct() {

			if ( 'nav-menus' == get_current_screen()->id ) {
				add_action( 'admin_enqueue_scripts', array( $this, 'setup_admin_scripts' ) );
			}
		}

		public function setup_admin_scripts() {
			wp_enqueue_style( 'wp-color-picker' );
			wp_add_inline_style( 'wp-color-picker', '' );//fix on WP 4.9
			wp_enqueue_script( 'rgba-picker-js',
				AMELY_THEME_URI . '/assets/admin/js/rgba-picker.min.js',
				array( 'wp-color-picker' ) );
		}

		/**
		 * Starts the list before the elements are added.
		 *
		 * @see   Walker_Nav_Menu::start_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args Not used.
		 */
		public function start_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * Ends the list of after the elements are added.
		 *
		 * @see   Walker_Nav_Menu::end_lvl()
		 *
		 * @since 3.0.0
		 *
		 * @param string $output Passed by reference.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args Not used.
		 */
		public function end_lvl( &$output, $depth = 0, $args = array() ) {
		}

		/**
		 * Start the element output.
		 *
		 * @see   Walker_Nav_Menu::start_el()
		 * @since 3.0.0
		 *
		 * @global int $_wp_nav_menu_max_depth
		 *
		 * @param string $output Passed by reference. Used to append additional content.
		 * @param object $item Menu item data object.
		 * @param int $depth Depth of menu item. Used for padding.
		 * @param array $args Not used.
		 * @param int $id Not used.
		 */
		public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
			global $_wp_nav_menu_max_depth;
			$_wp_nav_menu_max_depth = $depth > $_wp_nav_menu_max_depth ? $depth : $_wp_nav_menu_max_depth;

			$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';

			ob_start();
			$item_id      = esc_attr( $item->ID );
			$removed_args = array(
				'action',
				'customlink-tab',
				'edit-menu-item',
				'menu-item',
				'page-tab',
				'_wpnonce',
			);

			$original_title = '';
			if ( 'taxonomy' == $item->type ) {
				$original_title = get_term_field( 'name', $item->object_id, $item->object, 'raw' );
				if ( is_wp_error( $original_title ) ) {
					$original_title = false;
				}
			} elseif ( 'post_type' == $item->type ) {
				$original_object = get_post( $item->object_id );
				$original_title  = $original_object->post_title;
			} elseif ( 'post_type_archive' == $item->type ) {
				$original_object = get_post_type_object( $item->object );
				if ( $original_object ) {
					$original_title = $original_object->labels->archives;
				}
			}

			$classes = array(
				'menu-item menu-item-depth-' . $depth,
				'menu-item-' . esc_attr( $item->object ),
				'menu-item-edit-' . ( ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? 'active' : 'inactive' ),
			);

			$title = $item->title;

			if ( ! empty( $item->_invalid ) ) {
				$classes[] = 'menu-item-invalid';
				/* translators: %s: title of menu item which is invalid */
				$title = sprintf( __( '%s (Invalid)', 'amely' ), $item->title );
			} elseif ( isset( $item->post_status ) && 'draft' == $item->post_status ) {
				$classes[] = 'pending';
				/* translators: %s: title of menu item in draft status */
				$title = sprintf( __( '%s (Pending)', 'amely' ), $item->title );
			}

			$title = ( ! isset( $item->label ) || '' == $item->label ) ? $title : $item->label;

			$submenu_text = '';
			if ( 0 == $depth ) {
				$submenu_text = 'style="display: none;"';
			}

			?>
			<li id="menu-item-<?php echo esc_attr( $item_id ); ?>" class="<?php echo implode( ' ', $classes ); ?>">
			<div class="menu-item-bar">
				<div class="menu-item-handle">
				<span class="item-title"><span class="menu-item-title"><?php echo esc_html( $title ); ?></span> <span
						class="is-submenu" <?php echo esc_attr( $item_id ); ?>><?php esc_html_e( 'sub item',
							'amely' ); ?></span></span>
					<span class="item-controls">
                        <span class="item-type"><?php echo esc_html( $item->type_label ); ?></span>
                        <span class="item-order hide-if-js">
                            <a href="<?php
                            echo wp_nonce_url( add_query_arg( array(
	                            'action'    => 'move-up-menu-item',
	                            'menu-item' => $item_id,
                            ),
	                            remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ),
	                            'move-menu_item' );
                            ?>" class="item-move-up"
                               aria-label="<?php esc_attr_e( 'Move up', 'amely' ) ?>">&#8593;</a>
                            |
                            <a href="<?php
                            echo wp_nonce_url( add_query_arg( array(
	                            'action'    => 'move-down-menu-item',
	                            'menu-item' => $item_id,
                            ),
	                            remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ),
	                            'move-menu_item' );
                            ?>" class="item-move-down"
                               aria-label="<?php esc_attr_e( 'Move down', 'amely' ) ?>">&#8595;</a>
                        </span>
                        <a class="item-edit" id="edit-<?php echo esc_attr( $item_id ); ?>" href="<?php
                        echo ( isset( $_GET['edit-menu-item'] ) && $item_id == $_GET['edit-menu-item'] ) ? admin_url( 'nav-menus.php' ) : add_query_arg( 'edit-menu-item',
	                        $item_id,
	                        remove_query_arg( $removed_args,
		                        admin_url( 'nav-menus.php#menu-item-settings-' . $item_id ) ) );
                        ?>"
                           aria-label="<?php esc_attr_e( 'Edit menu item', 'amely' ); ?>"><?php esc_html_e( 'Edit',
		                        'amely' ); ?></a>
                    </span>
				</div>
			</div>

			<div class="menu-item-settings wp-clearfix" id="menu-item-settings-<?php echo esc_attr( $item_id ); ?>">
				<?php if ( 'custom' == $item->type ) : ?>
					<p class="field-url description description-wide">
						<label for="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>">
							<?php esc_html_e( 'URL', 'amely' ); ?><br/>
							<input type="text" id="edit-menu-item-url-<?php echo esc_attr( $item_id ); ?>"
							       class="widefat code edit-menu-item-url"
							       name="menu-item-url[<?php echo esc_attr( $item_id ); ?>]"
							       value="<?php echo esc_attr( $item->url ); ?>"/>
						</label>
					</p>
				<?php endif; ?>
				<p class="description description-wide">
					<label for="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Navigation Label', 'amely' ); ?><br/>
						<input type="text" id="edit-menu-item-title-<?php echo esc_attr( $item_id ); ?>"
						       class="widefat edit-menu-item-title"
						       name="menu-item-title[<?php echo esc_attr( $item_id ); ?>]"
						       value="<?php echo esc_attr( $item->title ); ?>"/>
					</label>
				</p>
				<p class="field-title-attribute field-attr-title description description-wide">
					<label for="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Title Attribute', 'amely' ); ?><br/>
						<input type="text" id="edit-menu-item-attr-title-<?php echo esc_attr( $item_id ); ?>"
						       class="widefat edit-menu-item-attr-title"
						       name="menu-item-attr-title[<?php echo esc_attr( $item_id ); ?>]"
						       value="<?php echo esc_attr( $item->post_excerpt ); ?>"/>
					</label>
				</p>
				<p class="field-link-target description">
					<label for="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>">
						<input type="checkbox" id="edit-menu-item-target-<?php echo esc_attr( $item_id ); ?>"
						       value="_blank"
						       name="menu-item-target[<?php echo esc_attr( $item_id ); ?>]"<?php checked( $item->target,
							'_blank' ); ?> />
						<?php esc_html_e( 'Open link in a new tab', 'amely' ); ?>
					</label>
				</p>
				<p class="field-css-classes description description-thin">
					<label for="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'CSS Classes (optional)', 'amely' ); ?><br/>
						<input type="text" id="edit-menu-item-classes-<?php echo esc_attr( $item_id ); ?>"
						       class="widefat code edit-menu-item-classes"
						       name="menu-item-classes[<?php echo esc_attr( $item_id ); ?>]"
						       value="<?php echo esc_attr( implode( ' ', $item->classes ) ); ?>"/>
					</label>
				</p>
				<p class="field-xfn description description-thin">
					<label for="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Link Relationship (XFN)', 'amely' ); ?><br/>
						<input type="text" id="edit-menu-item-xfn-<?php echo esc_attr( $item_id ); ?>"
						       class="widefat code edit-menu-item-xfn"
						       name="menu-item-xfn[<?php echo esc_attr( $item_id ); ?>]"
						       value="<?php echo esc_attr( $item->xfn ); ?>"/>
					</label>
				</p>
				<p class="field-description description description-wide">
					<label for="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>">
						<?php esc_html_e( 'Description', 'amely' ); ?><br/>
						<textarea id="edit-menu-item-description-<?php echo esc_attr( $item_id ); ?>"
						          class="widefat edit-menu-item-description" rows="3" cols="20"
						          name="menu-item-description[<?php echo esc_attr( $item_id ); ?>]"><?php echo esc_html( $item->description ); // textarea_escaped ?></textarea>
						<span
							class="description"><?php esc_html_e( 'The description will be displayed in the menu if the current theme supports it.',
								'amely' ); ?></span>
					</label>
				</p>

				<?php
				// This is the added section
				do_action( 'wp_nav_menu_item_custom_fields', $item_id, $item, $depth, $args );
				// end added section
				?>

				<p class="field-move hide-if-no-js description description-wide">
					<label>
						<span><?php esc_html_e( 'Move', 'amely' ); ?></span>
						<a href="#" class="menus-move menus-move-up"
						   data-dir="up"><?php esc_html_e( 'Up one', 'amely' ); ?></a>
						<a href="#" class="menus-move menus-move-down"
						   data-dir="down"><?php esc_html_e( 'Down one', 'amely' ); ?></a>
						<a href="#" class="menus-move menus-move-left" data-dir="left"></a>
						<a href="#" class="menus-move menus-move-right" data-dir="right"></a>
						<a href="#" class="menus-move menus-move-top"
						   data-dir="top"><?php esc_html_e( 'To the top', 'amely' ); ?></a>
					</label>
				</p>

				<div class="menu-item-actions description-wide submitbox">
					<?php if ( 'custom' != $item->type && $original_title !== false ) : ?>
						<p class="link-to-original">
							<?php printf( __( 'Original: %s', 'amely' ),
								'<a href="' . esc_attr( $item->url ) . '">' . esc_html( $original_title ) . '</a>' ); ?>
						</p>
					<?php endif; ?>
					<a class="item-delete submitdelete deletion" id="delete-<?php echo esc_attr( $item_id ); ?>"
					   href="<?php
					   echo wp_nonce_url( add_query_arg( array(
						   'action'    => 'delete-menu-item',
						   'menu-item' => $item_id,
					   ),
						   remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ),
						   'delete-menu_item_' . $item_id ); ?>"><?php esc_html_e( 'Remove', 'amely' ); ?></a>
					<span class="meta-sep"> | </span> <a
						class="item-cancel submitcancel" id="cancel-<?php echo esc_attr( $item_id ); ?>"
						href="<?php echo esc_url( add_query_arg( array(
							'edit-menu-item' => $item_id,
							'cancel'         => time(),
						),
							remove_query_arg( $removed_args, admin_url( 'nav-menus.php' ) ) ) );
						?>#menu-item-settings-<?php echo esc_attr( $item_id ); ?>"><?php esc_html_e( 'Cancel',
							'amely' ); ?></a>
				</div>

				<input class="menu-item-data-db-id" type="hidden"
				       name="menu-item-db-id[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item_id ); ?>"/>
				<input class="menu-item-data-object-id" type="hidden"
				       name="menu-item-object-id[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->object_id ); ?>"/>
				<input class="menu-item-data-object" type="hidden"
				       name="menu-item-object[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->object ); ?>"/>
				<input class="menu-item-data-parent-id" type="hidden"
				       name="menu-item-parent-id[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->menu_item_parent ); ?>"/>
				<input class="menu-item-data-position" type="hidden"
				       name="menu-item-position[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->menu_order ); ?>"/>
				<input class="menu-item-data-type" type="hidden"
				       name="menu-item-type[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->type ); ?>"/>
			</div><!-- .menu-item-settings-->
			<ul class="menu-item-transport"></ul>
			<?php
			$output .= ob_get_clean();
		}
	}

	// add custom field
	add_action( 'wp_nav_menu_item_custom_fields', 'amely_nav_menu_item_custom_fields', 9, 4 );
	function amely_nav_menu_item_custom_fields( $item_id, $item, $depth, $args ) { ?>

		<?php if ( $item->object !== 'ic_mega_menu' ) { ?>

		<strong style="float:left;width: 392px;background-color: #ededed;padding: 10px;margin: 30px 0 10px -10px;">
			<?php esc_attr_e( 'Custom Fields (from theme)', 'amely' ); ?>
		</strong>

		<p class="description description-wide" style="margin-top:10px;">
			<strong><?php esc_html_e( 'Item Tag (Optional)', 'amely' ) ?></strong></p>

		<p class="field-tag_type description description-wide">
			<label for="menu_item_tag_type-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Tag Type', 'amely' ); ?><br/>
				<select id="menu_item_tag_type-<?php echo esc_attr( $item_id ); ?>"
				        class="widefat edit-menu-item-tag_type"
				        name="menu-item-tag_type[<?php echo esc_attr( $item_id ); ?>]">
					<option
						value="" <?php selected( '', $item->tag_type ) ?>><?php esc_html_e( '-- Select label type --',
							'amely' ) ?></option>
					<option
						value="hot" <?php selected( 'hot', $item->tag_type ) ?>><?php esc_html_e( 'Hot',
							'amely' ) ?></option>
					<option
						value="new" <?php selected( 'new', $item->tag_type ) ?>><?php esc_html_e( 'New',
							'amely' ) ?></option>
					<option
						value="sale" <?php selected( 'sale', $item->tag_type ) ?>><?php esc_html_e( 'Sale',
							'amely' ) ?></option>
					<option
						value="custom" <?php selected( 'custom', $item->tag_type ) ?>><?php esc_html_e( 'Custom',
							'amely' ) ?></option>
				</select>
			</label>
			<span class="description">
	                    <?php echo sprintf( wp_kses( __( 'You can change the colors for menu item tags <strong><a href="%s" target="_blank">here</a></strong>',
		                    'amely' ),
		                    array(
			                    'strong' => array(),
			                    'a'      => array(
				                    'href'   => array(),
				                    'target' => array(),
			                    ),
		                    ) ),
		                    esc_url( add_query_arg( array(
			                    'page' => 'amely_options',
			                    'tab'  => '18',
		                    ),
			                    admin_url() ) ) ); ?></span>
		</p>

		<p class="description description-wide custom-colors"
		   style="margin-top:10px;<?php echo( 'custom' != $item->tag_type ? 'display:none;' : '' ); ?>">
			<strong><?php esc_html_e( 'Normal State Colors', 'amely' ) ?></strong></p>

		<p class="description description-wide custom-colors"<?php echo( 'custom' != $item->tag_type ? ' style="display:none;"' : '' ); ?>>
			<span class="display:block;"><?php esc_html_e( 'Text Color: ', 'amely' ) ?></span>
			<input type="text" id="menu_item_tag_color-<?php echo esc_attr( $item_id ); ?>" data-alpha="true"
			       class="tm-color-picker" name="menu-item-tag_color[<?php echo esc_attr( $item_id ); ?>]"
			       value="<?php echo esc_attr( $item->tag_color ); ?>"/>
		</p>

		<p class="description description-wide custom-colors"<?php echo( 'custom' != $item->tag_type ? ' style="display:none;"' : '' ); ?>>
			<span class="display:block;"><?php esc_html_e( 'Background Color: ', 'amely' ) ?></span>
			<input type="text" id="menu_item_tag_bgcolor-<?php echo esc_attr( $item_id ); ?>" data-alpha="true"
			       class="tm-color-picker" name="menu-item-tag_bgcolor[<?php echo esc_attr( $item_id ); ?>]"
			       value="<?php echo esc_attr( $item->tag_bgcolor ); ?>"/>
		</p>

		<p class="description description-wide custom-colors"<?php echo( 'custom' != $item->tag_type ? ' style="display:none;"' : '' ); ?>
		   style="margin-top:10px;<?php 'custom' != $item->tag_type ? 'display:none;' : ''; ?>">
			<strong><?php esc_html_e( 'Hover State Colors', 'amely' ) ?></strong></p>

		<p class="description description-wide custom-colors"<?php echo( 'custom' != $item->tag_type ? ' style="display:none;"' : '' ); ?>>
			<span class="display:block;"><?php esc_html_e( 'Text Color: ', 'amely' ) ?></span>
			<input type="text" id="menu_item_tag_color_hover-<?php echo esc_attr( $item_id ); ?>"
			       data-alpha="true"
			       class="tm-color-picker" name="menu-item-tag_color_hover[<?php echo esc_attr( $item_id ); ?>]"
			       value="<?php echo esc_attr( $item->tag_color_hover ); ?>"/>
		</p>

		<p class="description description-wide custom-colors"<?php echo( 'custom' != $item->tag_type ? ' style="display:none;"' : '' ); ?>>
			<span class="display:block;"><?php esc_html_e( 'Background Color: ', 'amely' ) ?></span>
			<input type="text" id="menu_item_tag_bgcolor_hover-<?php echo esc_attr( $item_id ); ?>"
			       data-alpha="true"
			       class="tm-color-picker" name="menu-item-tag_bgcolor_hover[<?php echo esc_attr( $item_id ); ?>]"
			       value="<?php echo esc_attr( $item->tag_bgcolor_hover ); ?>"/>
		</p>

		<p class="field-tag description description-wide"
		   style="margin-bottom: 10px;<?php echo( 'custom' != $item->tag_type ? ' display:none;' : '' ); ?>">
			<label for="menu_item_tag-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Tag Text', 'amely' ); ?><br/>
				<input type="text" id="menu_item_tag-<?php echo esc_attr( $item_id ); ?>"
				       class="widefat edit-menu-item-tag" name="menu-item-tag[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->tag ); ?>"/>
			</label>
			<span
				class="description"><?php esc_html_e( 'If you leave it empty, text will be put in by default from Tag Type.',
					'amely' ); ?></span>
		</p>

		<p class="field-icon-classes description description-wide">
			<label for="menu_item_icon_classes-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Icon Classes (optional)', 'amely' ); ?><br/>
				<input type="text"
				       id="menu_item_icon_classes-<?php echo esc_attr( $item_id ); ?>"
				       class="widefat code edit-menu-item-icon-classes"
				       name="menu-item-icon-classes[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->icon_classes ); ?>">
			</label>
			<span
				class="description">
				<?php echo wp_kses( sprintf( __( 'Our theme supports <a target="_blank" href="%s">FontAwesome</a>, <a target="_blank" href="%s">Pe Icon 7 Stroke</a>, <a target="_blank" href="%s">Themify Icons</a>, <a target="_blank" href="%s">Ion Icons</a>. Please select and copy icon\'s class, then paste it here.',
					'amely' ),
					'http://fontawesome.io/cheatsheet/',
					'http://themes-pixeden.com/font-demos/7-stroke/',
					'https://themify.me/themify-icons',
					'http://ionicons.com/' ),
					array(
						'a' => array(
							'href'   => array(),
							'target' => array(),
						),
					) ) ?></span>
		</p>


		<p class="description description-wide">
			<label for="menu_item_layout-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Mega Menu Layout', 'amely' ); ?><br>
				<select id="menu_item_layout-<?php echo esc_attr( $item_id ); ?>" class="widefat"
				        name="menu-item-layout[<?php echo esc_attr( $item_id ); ?>]">
					<option
						value="default" <?php selected( $item->layout,
						'default',
						true ); ?>><?php esc_html_e( 'Default', 'amely' ); ?></option>
					<option
						value="full-width" <?php selected( $item->layout,
						'full-width',
						true ); ?>><?php esc_html_e( 'Full width', 'amely' ); ?></option>
					<option
						value="custom" <?php selected( $item->layout, 'custom', true ); ?>><?php esc_html_e( 'Custom',
							'amely' ); ?></option>
				</select>
			</label>
			<span class="description"><?php esc_html_e( 'Select the mega menu layout', 'amely' ); ?></span>
		</p>
		<p class="description description-thin custom-width"<?php echo( 'custom' != $item->layout ? ' style="display:none;"' : '' ); ?>>
			<label for="menu_item_width-<?php echo esc_attr( $item_id ); ?>">
				<?php esc_html_e( 'Mega Menu width', 'amely' ); ?><br>
				<input type="number" id="menu_item_width-<?php echo esc_attr( $item_id ); ?>" class="widefat"
				       name="menu-item-width[<?php echo esc_attr( $item_id ); ?>]"
				       value="<?php echo esc_attr( $item->width ); ?>">
			</label>
		</p>
	<?php
	}

	?>
		<script type='text/javascript'>
			jQuery( document ).ready( function( $ ) {
				$( '.tm-color-picker' ).wpColorPicker();

				$( '#menu_item_tag_type-<?php echo esc_attr( $item_id ); ?>' ).on( 'change', function() {
					var value = $( this ).val();

					if ( value ) {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .field-tag' ).show();
					} else {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .field-tag' ).hide();
					}

					if ( 'custom' == value ) {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .custom-colors' ).show();
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .wp-color-result' ).show();
					} else {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .custom-colors' ).hide();
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .wp-color-result' ).hide();
					}
				} );

				$( '#menu_item_layout-<?php echo esc_attr( $item_id ); ?>' ).on( 'change', function() {

					var value = $( this ).val();

					if ( 'custom' == value ) {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .custom-width' ).show();
					} else {
						$( '#menu-item-settings-<?php echo esc_attr( $item_id ); ?> .custom-width' ).hide();
					}
				} );
			} );
		</script>
		<?php
	}

	/*
	 * Saves new field to postmeta for navigation
	 */
	add_action( 'wp_update_nav_menu_item', 'amely_nav_update', 10, 3 );
	function amely_nav_update( $menu_id, $menu_item_db_id, $args ) {

		if ( isset ( $_REQUEST['menu-item-tag'] ) && is_array( $_REQUEST['menu-item-tag'] ) && isset( $_REQUEST['menu-item-tag'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id, '_menu_item_tag', $_REQUEST['menu-item-tag'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_type'] ) && is_array( $_REQUEST['menu-item-tag_type'] ) && isset( $_REQUEST['menu-item-tag_type'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_type',
				$_REQUEST['menu-item-tag_type'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-icon-classes'] ) && is_array( $_REQUEST['menu-item-icon-classes'] ) && isset( $_REQUEST['menu-item-icon-classes'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_icon_classes',
				$_REQUEST['menu-item-icon-classes'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-alt-colors'] ) && is_array( $_REQUEST['menu-item-alt-colors'] ) && isset( $_REQUEST['menu-item-alt-colors'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_alt_colors',
				$_REQUEST['menu-item-alt-colors'][ $menu_item_db_id ] );
		} else {
			delete_post_meta( $menu_item_db_id, '_menu_item_alt_colors' );
		}

		if ( isset ( $_REQUEST['menu-item-tag_color'] ) && is_array( $_REQUEST['menu-item-tag_color'] ) && isset( $_REQUEST['menu-item-tag_color'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_color',
				$_REQUEST['menu-item-tag_color'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_bgcolor'] ) && is_array( $_REQUEST['menu-item-tag_bgcolor'] ) && isset( $_REQUEST['menu-item-tag_bgcolor'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_bgcolor',
				$_REQUEST['menu-item-tag_bgcolor'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_bdcolor'] ) && is_array( $_REQUEST['menu-item-tag_bdcolor'] ) && isset( $_REQUEST['menu-item-tag_bdcolor'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_bdcolor',
				$_REQUEST['menu-item-tag_bdcolor'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_color_hover'] ) && is_array( $_REQUEST['menu-item-tag_color_hover'] ) && isset( $_REQUEST['menu-item-tag_color_hover'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_color_hover',
				$_REQUEST['menu-item-tag_color_hover'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_bgcolor_hover'] ) && is_array( $_REQUEST['menu-item-tag_bgcolor_hover'] ) && isset( $_REQUEST['menu-item-tag_bgcolor_hover'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_bgcolor_hover',
				$_REQUEST['menu-item-tag_bgcolor_hover'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-tag_bdcolor_hover'] ) && is_array( $_REQUEST['menu-item-tag_bdcolor_hover'] ) && isset( $_REQUEST['menu-item-tag_bdcolor_hover'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_tag_bdcolor_hover',
				$_REQUEST['menu-item-tag_bdcolor_hover'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-layout'] ) && is_array( $_REQUEST['menu-item-layout'] ) && isset( $_REQUEST['menu-item-layout'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id,
				'_menu_item_layout',
				$_REQUEST['menu-item-layout'][ $menu_item_db_id ] );
		}

		if ( isset ( $_REQUEST['menu-item-width'] ) && is_array( $_REQUEST['menu-item-width'] ) && isset( $_REQUEST['menu-item-width'][ $menu_item_db_id ] ) ) {
			update_post_meta( $menu_item_db_id, '_menu_item_width', $_REQUEST['menu-item-width'][ $menu_item_db_id ] );
		}
	}

	/*
	 * Adds value of new field to $item object that will be passed to     Amely_Walker_Nav_Menu_Edit
	 */
	add_filter( 'wp_setup_nav_menu_item', 'amely_nav_item' );
	function amely_nav_item( $menu_item ) {
		$menu_item->tag               = get_post_meta( $menu_item->ID, '_menu_item_tag', true );
		$menu_item->tag_type          = get_post_meta( $menu_item->ID, '_menu_item_tag_type', true );
		$menu_item->icon_classes      = get_post_meta( $menu_item->ID, '_menu_item_icon_classes', true );
		$menu_item->alt_colors        = get_post_meta( $menu_item->ID, '_menu_item_alt_colors', true );
		$menu_item->tag_color         = get_post_meta( $menu_item->ID, '_menu_item_tag_color', true );
		$menu_item->tag_bgcolor       = get_post_meta( $menu_item->ID, '_menu_item_tag_bgcolor', true );
		$menu_item->tag_bdcolor       = get_post_meta( $menu_item->ID, '_menu_item_tag_bdcolor', true );
		$menu_item->tag_color_hover   = get_post_meta( $menu_item->ID, '_menu_item_tag_color_hover', true );
		$menu_item->tag_bgcolor_hover = get_post_meta( $menu_item->ID, '_menu_item_tag_bgcolor_hover', true );
		$menu_item->tag_bdcolor_hover = get_post_meta( $menu_item->ID, '_menu_item_tag_bdcolor_hover', true );
		$menu_item->layout            = get_post_meta( $menu_item->ID, '_menu_item_layout', true );
		$menu_item->width             = get_post_meta( $menu_item->ID, '_menu_item_width', true );

		return $menu_item;
	}

	add_filter( 'wp_edit_nav_menu_walker', 'amely_nav_edit_walker', 10, 2 );
	function amely_nav_edit_walker( $walker, $menu_id ) {
		return 'Amely_Walker_Nav_Menu_Edit';
	}
}
