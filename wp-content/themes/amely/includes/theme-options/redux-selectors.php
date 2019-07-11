<?php

define( 'PRIMARY_COLOR', '#c61932' );
define( 'SECONDARY_COLOR', '#333333' );
define( 'TERTIARY_COLOR', '#ffffff' );

/**
 * Get CSS selectors for Redux ouput
 */
if ( ! function_exists( ' amely_get_selectors ' ) ) {
	function amely_get_selectors() {
		return apply_filters( 'amely_get_selectors',
			array(
				'primary_color' => array(
					'color' => Amely_Helper::text2line( '.text-hightlight,
					.post-tags .tagcloud a:hover, 
					.widget_tag_cloud .tagcloud a:hover, 
					.widget_product_tag_cloud .tagcloud a:hover,
					.select2-container--default .select2-results__option--highlighted[aria-selected],
					#woo-quick-view .quickview-loading span:before,
					.isw-swatches .isw-swatch--isw_text .isw-term:not(.isw-disabled):hover,
					.product-style-hover--info .add-to-cart-btn,
					.product-style-hover--info .add-to-cart-btn,
					.error404 .area-404__content-heading .button:hover,
					.isw-swatches .isw-swatch--isw_text .isw-term.isw-selected,
					.footer-vc strong,
					.social-amely ul.social-links i:hover,
					.readmore-button:hover,
					.vc_tta-accordion.vc_tta-style-amely.vc_tta-style-amely .vc_tta-panel-title > a:hover,
					.vc_tta-accordion.vc_tta-style-amely.vc_tta-style-amely .vc_active .vc_tta-panel-title > a,
					.amely-social i:hover, .tm-instagram .user-name:hover,
					.shop-filter .amely-filter-buttons .open-filters.opened,
					.widget_layered_nav_filters ul li > a .woocommerce-Price-amount,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-stock-status span.wishlist-in-stock:before,
					.woocommerce table.shop_table tr.order-total .amount,
					.widget_layered_nav_filters ul li > a .woocommerce-Price-amount,
					.woocommerce table.shop_table tr.order-total .amount,
					.woocommerce-checkout .showlogin:hover, .woocommerce-checkout .showcoupon:hover,
					.woocommerce-account .woocommerce-LostPassword.lost_password a,
					.woocommerce-account .woocommerce-MyAccount-content table.order_details tfoot tr:last-of-type td .woocommerce-Price-amount,
					table.woocommerce-table--order-details tfoot tr:last-of-type td .woocommerce-Price-amount' ),

					'background-color' => Amely_Helper::text2line( '.widget_shopping_cart .button:hover, .widget_shopping_cart .button:focus,
					button.alt, input[type="submit"].alt, input[type="button"].alt, a.button.alt, .tm-button.button.alt,
					button.alt-button, input[type="submit"].alt-button, input[type="button"].alt-button, a.button.alt-button, .tm-button.button.alt,
					button:hover, input[type="submit"]:hover, input[type="button"]:hover, a.button:hover, .tm-button.button:hover,
					button:focus, input[type="submit"]:focus, input[type="button"]:focus, a.button:focus, .tm-button.button:focus,
					.woocommerce .order-again .button,
					.page-header__prev-item:hover > a, .page-header__next-item:hover > a,
					.product-categories-menu .cat-item a:after,
					.woocommerce .order-again .button:hover,
					.woocommerce .order-again .button,
					.amely-mailchimp .title:after,
					.amely-products-widget .product-buttons > div a:hover,
					.categories-icon-list > [class*=\'col-\']:hover,
					.wb-allview-formcnt .wb-allview-lettercnt .wb-wb-allview-letters:hover,
					.wb-allview-formcnt .wb-allview-lettercnt .wb-wb-allview-letters:focus,
					.wb-bx-controls.wb-bx-has-controls-direction .wb-bx-prev:hover,
					.wb-bx-controls.wb-bx-has-controls-direction .wb-bx-next:hover,
					.wpb-js-composer .vc_tta-tabs.vc_tta-style-amely.vc_tta-style-amely .vc_tta-tab > a:after,
					.wpb-js-composer .vc_tta-tabs.vc_tta-style-amely.vc_tta-style-amely .vc_tta-panel .vc_tta-panel-title > a:after,
					.wb-bx-wrapper.wb-carousel-amely .wb-bx-pager.wb-bx-default-pager .wb-bx-pager-item a:hover,
					.wb-bx-wrapper.wb-carousel-amely .wb-bx-pager.wb-bx-default-pager .wb-bx-pager-item a.active,
					.site-footer .mc4wp-form button[type="submit"]:hover,
					.woocommerce .widget_layered_nav.yith-woocommerce-ajax-product-filter ul.yith-wcan-label li a:hover,
					.tp-caption.rs-hover-ready.hover-line:after,
					.error404 .area-404__content-heading .button:hover:after,
					.text-product360-decription-2:before,
					.woocommerce.single-product .product .summary form.variations_form .isw-swatch--isw_text .isw-term:hover, 
					.woocommerce.single-product .product .summary form.variations_form .isw-swatch--isw_text .isw-term:focus, 
					.woocommerce.single-product .product .summary form.variations_form .isw-swatch--isw_text .isw-term.isw-selected,
					.woocommerce.single-product .product .summary .single_add_to_cart_button:hover,
					.widget_tm_layered_nav ul.show-labels-on li.no-swatch:hover a, 
					.widget_tm_layered_nav ul.show-labels-on li.no-swatch.chosen a, 
					.widget_tm_layered_nav ul.show-labels-on li.swatch-text:hover a, 
					.widget_tm_layered_nav ul.show-labels-on li.swatch-text.chosen a,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button:hover,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button:focus,
					.woocommerce-checkout .showlogin:hover:after, 
					.woocommerce-checkout .showcoupon:hover:after,
					.woocommerce-checkout form.checkout_coupon input[type="submit"]:hover,
					.mabel-siwc-img-wrapper .mb-siwc-tag:hover, .mabel-siwc-img-wrapper .mb-siwc-tag.active,
					.header-tools.layout-only-mini-cart .header-minicart a.toggle .minicart-count' ),

					'border-color' => Amely_Helper::text2line( 'button.alt, input[type="submit"].alt, input[type="button"].alt, a.button.alt, .tm-button.button.alt,
					button.alt-button, input[type="submit"].alt-button, input[type="button"].alt-button, a.button.alt-button, .tm-button.button.alt,
					button:hover, input[type="submit"]:hover, input[type="button"]:hover, a.button:hover, .tm-button.button:hover,
					button:focus, input[type="submit"]:focus, input[type="button"]:focus, a.button:focus, .tm-button.button:focus,
					.page-header__prev-item:hover > a, .page-header__next-item:hover > a,
					.widget_shopping_cart .button:hover, .widget_shopping_cart .button:focus,
					.woocommerce .order-again .button:hover,
					a.show-categories-menu,
					.wb-allview-formcnt .wb-allview-lettercnt .wb-wb-allview-letters:hover,
					.wb-allview-formcnt .wb-allview-lettercnt .wb-wb-allview-letters:focus,
				    .tm-products-widget .slick-arrow.small:focus,
				    .amely-products-widget .slick-arrow.small:focus,
				    .site-footer .mc4wp-form button[type="submit"]:hover,
				    .ajax-results-wrapper .suggestion-title ins,
				    .ajax-results-wrapper .suggestion-sku ins,
					.woocommerce.single-product .product .summary .single_add_to_cart_button:hover,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button:hover,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button:focus' ),

				),

				'secondary_color' => array(
					'color' => Amely_Helper::text2line( '.ajax-results-wrapper .suggestion-sku, 
					.ajax-results-wrapper .suggestion-price,
					.wpb-js-composer .vc_tta-tabs.vc_tta-style-amely.vc_tta-style-amely .vc_tta-tab.vc_active > a' ),

					'background-color' => Amely_Helper::text2line( '.widget_shopping_cart .button.checkout:hover,
					.slick-dots li.slick-active button,
					.slick-dots button:hover,
					.widget_shopping_cart .button.checkout:focus,
					button.alt:hover, input[type="submit"].alt:hover, input[type="button"].alt:hover, a.button.alt:hover, .tm-button.button.alt:hover,
					button.alt:focus, input[type="submit"].alt:focus, input[type="button"].alt:focus, a.button.alt:focus, .tm-button.button.alt:focus,
					button.alt-button:hover, input[type="submit"].alt-button:hover, input[type="button"].alt-button:hover, a.button.alt-button:hover,
					button.alt-button:focus, input[type="submit"].alt-button:focus, input[type="button"].alt-button:focus, a.button.alt-button:focus,
					button, input[type="submit"], input[type="button"], a.button, .tm-button.button,
					.wb-bx-wrapper.wb-carousel-amely .wb-bx-pager.wb-bx-default-pager .wb-bx-pager-item a,
					.woocommerce.single-product .product .summary .single_add_to_cart_button,
					.woocommerce.single-product .product .summary .compare-btn:hover a,
					.woocommerce.single-product .product .summary .compare-btn:focus a,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button' ),

					'border-color' => Amely_Helper::text2line( '.widget_shopping_cart .button.checkout:hover,
					.widget_shopping_cart .button.checkout:focus,
					button.alt:hover, input[type="submit"].alt:hover, input[type="button"].alt:hover, a.button.alt:hover, .tm-button.button.alt:hover,
					button.alt:focus, input[type="submit"].alt:focus, input[type="button"].alt:focus, a.button.alt:focus, .tm-button.button.alt:focus,
					button.alt-button:hover, input[type="submit"].alt-button:hover, input[type="button"].alt-button:hover, a.button.alt-button:hover,
					button.alt-button:focus, input[type="submit"].alt-button:focus, input[type="button"].alt-button:focus, a.button.alt-button:focus,
					button, input[type="submit"], input[type="button"], a.button, .tm-button.button,
					.woocommerce.single-product .product .summary .single_add_to_cart_button,
					.woocommerce.single-product .product .summary .compare-btn:hover a,
					.woocommerce.single-product .product .summary .compare-btn:focus a,
					#yith-wcwl-form table.shop_table.wishlist_table td.product-add-to-cart .button' ),
				),

				'tertiary_color' => array(),

				'primary_font'   => array( 'body' ),
				'secondary_font' => array( 'font-family' => '.secondary-font, .tm-icon-box.secondary-font .title,.tm-icon-box.secondary-font a' ),
				'tertiary_font'  => array( 'font-family' => '.tertiary-font, .tm-icon-box.tertiary-font .title,.tm-icon-box.tertiary-font a' ),

				'heading_font' => array( 'h1,h2,h3,h4,h5,h6,h1 a,h2 a,h3 a,h4 a,h5 a, h6 a', ),

				'link_color'              => array(
					'color' => Amely_Helper::text2line( 'a,
					.site-header .header-search.search-open a.toggle,
					.cookie-buttons a.cookie-btn,
					.header-wishlist .add-to-cart-btn .button' ),
				),
				'link_hover_color'        => array(
					'color'            => Amely_Helper::text2line( 'a:hover, a:focus,
					.site-mobile-menu .menu-show-all > a,
					.topbar .switcher .nice-select:hover .current,
					.topbar .switcher .nice-select:hover:after,
					.topbar .switcher .nice-select .option:hover,
					.cookie-wrapper a,
					.shop-loop-head .switcher.active,
					.shop-loop-head .switcher:hover,
					.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a,
					.yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a,
					.woocommerce.single-product .product .summary .product-meta-buttons > div a:hover,
					.woocommerce.single-product .product .summary table.product_meta td.value a:hover,
					.woocommerce.single-product .product .summary table.product-share td.value a:hover,
					.category-grid-item:hover .product-category-content .category-link a,
					.category-grid-item:hover .product-category-content .category-link:after,
					.amely-product-widget .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistaddedbrowse a:before,
					.amely-product-widget .yith-wcwl-add-to-wishlist .yith-wcwl-wishlistexistsbrowse a:before' ),
					'background-color' => Amely_Helper::text2line( '.cookie-buttons a:hover' ),
					'border-color'     => Amely_Helper::text2line( '.widget_calendar tbody td a:hover' ),
				),

				// Top bar
				'topbar_color'            => array(
					'color'            => '.topbar',
					'background-color' => Amely_Helper::text2line( '.topbar.topbar-divider--dotted .social-links li:after,
						.topbar.topbar-divider--dotted .topbar-menu .menu > li.menu-item:after,
						.topbar.topbar-divider--dotted .switcher-menu:after,
						.topbar.topbar-divider--dotted .switcher .nice-select:after,
						.topbar.topbar-divider--dotted .switcher .menu > li:after' ),
				),
				'topbar_link_color'       => array( 'color' => '.topbar a' ),
				'topbar_link_color_hover' => array( 'color' => '.topbar a:hover' ),
				'topbar_bgcolor'          => array( 'background-color' => '.topbar' ),
				'topbar_bdcolor'          => array( 'border-color' => '.topbar' ),

				'header_bgcolor'               => array( 'background-color' => '.site-header, .header-overlap .sticky-header, .header-overlap .site-header.site-header:hover' ),
				'header_bdcolor'               => array( 'border-color' => '.site-header' ),

				// Page title
				'page_title_text_color'        => array(
					'color' => Amely_Helper::text2line( '.page-title h1, .page-title a' ),
				),
				'page_subtitle_color'          => array( 'color' => '.page-title .page-subtitle' ),
				'page_title_bg_color'          => array( 'background-color' => '.page-title' ),
				'page_title_overlay_color'     => array( 'background-color' => '.page-title:before' ),
				'page_title_bg_image'          => array( 'background-image' => '.page-title' ),

				// Breadcrumbs
				'breadcrumbs_text_color'       => array( 'color' => '.site-breadcrumbs' ),
				'breadcrumbs_seperator_color'  => array( 'color' => '.site-breadcrumbs ul li:after' ),
				'breadcrumbs_link_color'       => array( 'color' => '.site-breadcrumbs .insight_core_breadcrumb a' ),
				'breadcrumbs_link_color_hover' => array( 'color' => '.site-breadcrumbs .insight_core_breadcrumb a:hover' ),

				// search
				'search_color'                 => array(
					'color' => Amely_Helper::text2line( '.header-search a.toggle,
						.site-header.sticky-header .header-search a.toggle,
						.header-overlap .site-header:hover .header-search a.toggle' ),
				),

				// my account color
				'header_login_icon_color'      => array(
					'color' => Amely_Helper::text2line( '.header-tools .header-login a,
						.site-header.sticky-header .header-tools .header-login a,
						.header-overlap .site-header:hover .header-tools .header-login a' ),
				),

				// wishlist
				'wishlist_icon_color'          => array(
					'color' => Amely_Helper::text2line( '.header-wishlist a.toggle,
						.site-header.sticky-header .header-wishlist a.toggle,
						.header-overlap .site-header:hover .header-wishlist a.toggle' ),
				),
				'wishlist_count_color'         => array(
					'color' => Amely_Helper::text2line( '.header-wishlist a.toggle .wishlist-count,
					.site-header.sticky-header .header-wishlist a.toggle .wishlist-count,
					.header-overlap .site-header:hover .header-wishlist a.toggle .wishlist-count' ),
				),
				'wishlist_count_bg_color'      => array(
					'background-color' => Amely_Helper::text2line( '.header-wishlist a.toggle .wishlist-count,
						.site-header.sticky-header .header-wishlist a.toggle .wishlist-count,
						.header-overlap .site-header:hover .header-wishlist a.toggle .wishlist-count' ),
				),

				// Mini cart
				'minicart_icon_color'          => array(
					'color' => Amely_Helper::text2line( '.header-minicart a.toggle,
					.header-tools.layout-only-mini-cart .header-minicart a.toggle,
					.site-header.sticky-header .header-minicart a.toggle,
					.header-overlap .site-header:hover .header-minicart a.toggle' ),
				),
				'minicart_count_color'         => array(
					'color' => Amely_Helper::text2line( '.header-minicart a.toggle .minicart-count,
				.header-tools.layout-only-mini-cart .header-minicart a.toggle .minicart-count,
				.site-header.sticky-header .header-minicart a.toggle .minicart-count,
				.header-overlap .site-header:hover .header-minicart a.toggle .minicart-count' ),
				),
				'minicart_count_bg_color'      => array(
					'background-color' => Amely_Helper::text2line( '.header-minicart a.toggle .minicart-count,
				.site-header.sticky-header .header-minicart a.toggle .minicart-count,
				.header-overlap .site-header:hover .header-minicart a.toggle .minicart-count' ),
				),

				//Offcanvas
				'offcanvas_button_color'       => array(
					'color' => Amely_Helper::text2line( '.offcanvas-btn .ti-menu,
				.site-header.sticky-header .offcanvas-btn .ti-menu,
				.header-overlap .site-header:hover .offcanvas-btn .ti-menu' ),
				),

				//'' => array(),

				// Menu
				'site_menu_font'               => array( '.site-menu .menu > ul > li > a, .site-menu .menu > li > a' ),
				'site_menu_items_color'        => array(
					'color' => Amely_Helper::text2line( '.site-menu .menu > ul > li > a,
					 .site-menu .menu > li > a,
					 .site-header.sticky-header .site-menu .menu > ul > li > a, 
					 .site-header.sticky-header .site-menu .menu > li > a,
					 .header-overlap .site-header:hover .site-menu .menu > ul > li > a,
					 .header-overlap .site-header:hover .site-menu .menu > li > a' ),
				),
				'site_menu_subitems_color'     => array(
					'color' => Amely_Helper::text2line( '.site-menu .menu > ul > li .children a, 
					.site-menu .menu > li .sub-menu a, 
					.site-header.sticky-header .site-menu .menu > ul > li .children a,
					.site-header.sticky-header .site-menu .menu > li .sub-menu a' ),
				),
				'site_menu_bgcolor'            => array( 'background-color' => '.site-header .site-menu-wrap' ),
				'site_menu_bdcolor'            => array( 'border-color' => '.site-header .site-menu-wrap' ),

				// Mobile menu
				'mobile_menu_button_color'     => array(
					'stroke' => Amely_Helper::text2line( '.site-header.sticky-header .mobile-menu-btn path,.mobile-menu-btn path,
				.header-overlap .site-header:hover .mobile-menu-btn path,.mobile-menu-btn path' ),
				),

				// Menu item tag
				'hot_tag_color'                => array( 'color' => '.menu-item-tag.menu-item-tag--hot' ),
				'hot_tag_bgcolor'              => array(
					'background-color'   => '.menu-item-tag.menu-item-tag--hot, .product-badges .hot',
					'border-top-color'   => '.site-menu .menu-item-tag.menu-item-tag--hot:after',
					'border-right-color' => '.site-mobile-menu .menu-item-tag--hot:after',
				),
				'hot_tag_bgcolor_hover'        => array(
					'background-color'   => '.menu-item:hover .menu-item-tag.menu-item-tag--hot, .product-badges:hover .hot',
					'border-top-color'   => '.site-menu .menu-item:hover .menu-item-tag.menu-item-tag--hot:after',
					'border-right-color' => '.site-mobile-menu .menu-item:hover .menu-item-tag--hot:after',
				),
				'new_tag_color'                => array( 'color' => '.menu-item-tag.menu-item-tag--new' ),
				'new_tag_bgcolor'              => array(
					'background-color'   => '.menu-item-tag.menu-item-tag--new, .product-badges .new',
					'border-top-color'   => '.site-menu .menu-item-tag.menu-item-tag--new:after',
					'border-right-color' => '.site-mobile-menu .menu-item-tag--new:after',
				),
				'new_tag_bgcolor_hover'        => array(
					'background-color'   => '.menu-item:hover .menu-item-tag.menu-item-tag--new, .product-badges:hover .new',
					'border-top-color'   => '.site-menu .menu-item:hover .menu-item-tag.menu-item-tag--new:after',
					'border-right-color' => '.site-mobile-menu .menu-item:hover .menu-item:hover .menu-item-tag--new:after',
				),
				'sale_tag_color'               => array( 'color' => '.menu-item-tag.menu-item-tag--sale, .product-badges .onsale' ),
				'sale_tag_bgcolor'             => array(
					'background-color'   => '.menu-item-tag.menu-item-tag--sale, .product-badges .onsale',
					'border-top-color'   => '.site-menu .menu-item-tag.menu-item-tag--sale:after',
					'border-right-color' => '.site-mobile-menu .menu-item-tag--sale:after',
				),
				'sale_tag_bgcolor_hover'       => array(
					'background-color'   => '.menu-item:hover .menu-item-tag.menu-item-tag--sale, .product-badges:hover .onsale',
					'border-top-color'   => '.site-menu .menu-item:hover .menu-item-tag.menu-item-tag--sale:after',
					'border-right-color' => '.site-mobile-menu .menu-item:hover .menu-item-tag--sale:after',
				),

				'footer_bgcolor'      => array( 'background-color' => '.site-footer' ),
				'footer_color'        => array( 'color' => '.site-footer, .site-footer a' ),
				'footer_accent_color' => array( 'color' => '.site-footer .widget-title, .site-footer a:hover, .site-footer .entry-title a, .widget-title:after' ),

				'footer_copyright_bgcolor'       => array( 'background-color' => '.site-footer .site-copyright' ),
				'footer_copyright_color'         => array( 'color' => '.site-footer .site-copyright' ),
				'footer_copyright_link_color'    => array( 'color' => '.site-footer .site-copyright a' ),

				// Product buttons color
				'product_buttons_bg_color'       => array( 'background-color' => '.product-loop .product-buttons.product-buttons--custom > div' ),
				'product_buttons_hover_bg_color' => array( 'background-color' => '.product-loop .product-buttons.product-buttons--custom > div:hover' ),
				'product_buttons_bd_color'       => array(
					'border-color' => Amely_Helper::text2line( '.product-loop .product-buttons.product-buttons--custom .quick-view-btn, 
					.product-loop .product-buttons.product-buttons--custom .compare-btn' ),
				),
				'product_buttons_hover_bd_color' => array(
					'border-color' => Amely_Helper::text2line( '.product-loop .product-buttons.product-buttons--custom .quick-view-btn:hover, 
					.product-loop .product-buttons.product-buttons--custom .compare-btn:hover' ),
				),
				'product_buttons_color'          => array( 'color' => '.product-loop .product-buttons.product-buttons--custom a' ),
				'product_buttons_hover_color'    => array( 'color' => '.product-loop .product-buttons.product-buttons--custom > div:hover a' ),

				// Product background color
				'product_bgcolor'                => array( 'background-color' => '.single-product .background-wrapper' ),
			) );
	}
}

$amely_selectors = amely_get_selectors();
