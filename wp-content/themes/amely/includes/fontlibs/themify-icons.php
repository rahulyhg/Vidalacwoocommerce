<?php
/* Loads Themify Icons Font. */

// Enqueue CSS
wp_enqueue_style( 'font-themify-icons', AMELY_THEME_URI . '/assets/libs/themify-icons/css/themify-icons.css' );

add_filter( 'vc_iconpicker-type-themifyicons', 'vc_iconpicker_type_themifyicons' );

/**
 * Themify icons
 *
 * @param $icons - taken from filter - vc_map param field settings['source'] provided icons (default empty array).
 *               If array categorized it will auto-enable category dropdown
 *
 * @since 4.4
 * @return array - of icons for iconpicker, can be categorized, or not.
 */
function vc_iconpicker_type_themifyicons( $icons ) {
	$themify_icons = array(
		array( 'ti-arrow-up' => 'arrow-up' ),
		array( 'ti-arrow-right' => 'arrow-right' ),
		array( 'ti-arrow-left' => 'arrow-left' ),
		array( 'ti-arrow-down' => 'arrow-down' ),
		array( 'ti-arrows-vertical' => 'arrows-vertical' ),
		array( 'ti-arrows-horizontal' => 'arrows-horizontal' ),
		array( 'ti-angle-up' => 'angle-up' ),
		array( 'ti-angle-right' => 'angle-right' ),
		array( 'ti-angle-left' => 'angle-left' ),
		array( 'ti-angle-down' => 'angle-down' ),
		array( 'ti-angle-double-up' => 'angle-double-up' ),
		array( 'ti-angle-double-right' => 'angle-double-right' ),
		array( 'ti-angle-double-left' => 'angle-double-left' ),
		array( 'ti-fullscreen' => 'fullscreen' ),
		array( 'ti-arrow-top-right' => 'arrow-top-right' ),
		array( 'ti-arrow-top-left' => 'arrow-top-left' ),
		array( 'ti-arrow-circle-up' => 'arrow-circle-up' ),
		array( 'ti-arrow-circle-right' => 'arrow-circle-right' ),
		array( 'ti-arrow-circle-left' => 'arrow-circle-left' ),
		array( 'ti-arrow-circle-down' => 'arrow-circle-down' ),
		array( 'ti-arrows-corner' => 'arrows-corner' ),
		array( 'ti-split-v' => 'split-v' ),
		array( 'ti-split-v-alt' => 'split-v-alt' ),
		array( 'ti-split-h' => 'split-h' ),
		array( 'ti-hand-point-up' => 'hand-point-up' ),
		array( 'ti-hand-point-right' => 'hand-point-right' ),
		array( 'ti-hand-point-left' => 'hand-point-left' ),
		array( 'ti-hand-point-down' => 'hand-point-down' ),
		array( 'ti-back-right' => 'back-right' ),
		array( 'ti-back-left' => 'back-left' ),
		array( 'ti-exchange-vertical' => 'exchange-vertical' ),
		array( 'ti-wand' => 'wand' ),
		array( 'ti-save' => 'save' ),
		array( 'ti-save-alt' => 'save-alt' ),
		array( 'ti-direction' => 'direction' ),
		array( 'ti-direction-alt' => 'direction-alt' ),
		array( 'ti-user' => 'user' ),
		array( 'ti-link' => 'link' ),
		array( 'ti-unlink' => 'unlink' ),
		array( 'ti-trash' => 'trash' ),
		array( 'ti-target' => 'target' ),
		array( 'ti-tag' => 'tag' ),
		array( 'ti-desktop' => 'desktop' ),
		array( 'ti-tablet' => 'tablet' ),
		array( 'ti-mobile' => 'mobile' ),
		array( 'ti-email' => 'email' ),
		array( 'ti-star' => 'star' ),
		array( 'ti-spray' => 'spray' ),
		array( 'ti-signal' => 'signal' ),
		array( 'ti-shopping-cart' => 'shopping-cart' ),
		array( 'ti-shopping-cart-full' => 'shopping-cart-full' ),
		array( 'ti-settings' => 'settings' ),
		array( 'ti-search' => 'search' ),
		array( 'ti-zoom-in' => 'zoom-in' ),
		array( 'ti-zoom-out' => 'zoom-out' ),
		array( 'ti-cut' => 'cut' ),
		array( 'ti-ruler' => 'ruler' ),
		array( 'ti-ruler-alt-2' => 'ruler-alt-2' ),
		array( 'ti-ruler-pencil' => 'ruler-pencil' ),
		array( 'ti-ruler-alt' => 'ruler-alt' ),
		array( 'ti-bookmark' => 'bookmark' ),
		array( 'ti-bookmark-alt' => 'bookmark-alt' ),
		array( 'ti-reload' => 'reload' ),
		array( 'ti-plus' => 'plus' ),
		array( 'ti-minus' => 'minus' ),
		array( 'ti-close' => 'close' ),
		array( 'ti-pin' => 'pin' ),
		array( 'ti-pencil' => 'pencil' ),
		array( 'ti-pencil-alt' => 'pencil-alt' ),
		array( 'ti-paint-roller' => 'paint-roller' ),
		array( 'ti-paint-bucket' => 'paint-bucket' ),
		array( 'ti-na' => 'na' ),
		array( 'ti-medall' => 'medall' ),
		array( 'ti-medall-alt' => 'medall-alt' ),
		array( 'ti-marker' => 'marker' ),
		array( 'ti-marker-alt' => 'marker-alt' ),
		array( 'ti-lock' => 'lock' ),
		array( 'ti-unlock' => 'unlock' ),
		array( 'ti-location-arrow' => 'location-arrow' ),
		array( 'ti-layout' => 'layout' ),
		array( 'ti-layers' => 'layers' ),
		array( 'ti-layers-alt' => 'layers-alt' ),
		array( 'ti-key' => 'key' ),
		array( 'ti-image' => 'image' ),
		array( 'ti-heart' => 'heart' ),
		array( 'ti-heart-broken' => 'heart-broken' ),
		array( 'ti-hand-stop' => 'hand-stop' ),
		array( 'ti-hand-open' => 'hand-open' ),
		array( 'ti-hand-drag' => 'hand-drag' ),
		array( 'ti-flag' => 'flag' ),
		array( 'ti-flag-alt' => 'flag-alt' ),
		array( 'ti-flag-alt-2' => 'flag-alt-2' ),
		array( 'ti-eye' => 'eye' ),
		array( 'ti-import' => 'import' ),
		array( 'ti-export' => 'export' ),
		array( 'ti-cup' => 'cup' ),
		array( 'ti-crown' => 'crown' ),
		array( 'ti-comments' => 'comments' ),
		array( 'ti-comment' => 'comment' ),
		array( 'ti-comment-alt' => 'comment-alt' ),
		array( 'ti-thought' => 'thought' ),
		array( 'ti-clip' => 'clip' ),
		array( 'ti-check' => 'check' ),
		array( 'ti-check-box' => 'check-box' ),
		array( 'ti-camera' => 'camera' ),
		array( 'ti-announcement' => 'announcement' ),
		array( 'ti-brush' => 'brush' ),
		array( 'ti-brush-alt' => 'brush-alt' ),
		array( 'ti-palette' => 'palette' ),
		array( 'ti-briefcase' => 'briefcase' ),
		array( 'ti-bolt' => 'bolt' ),
		array( 'ti-bolt-alt' => 'bolt-alt' ),
		array( 'ti-blackboard' => 'blackboard' ),
		array( 'ti-bag' => 'bag' ),
		array( 'ti-world' => 'world' ),
		array( 'ti-wheelchair' => 'wheelchair' ),
		array( 'ti-car' => 'car' ),
		array( 'ti-truck' => 'truck' ),
		array( 'ti-timer' => 'timer' ),
		array( 'ti-ticket' => 'ticket' ),
		array( 'ti-thumb-up' => 'thumb-up' ),
		array( 'ti-thumb-down' => 'thumb-down' ),
		array( 'ti-stats-up' => 'stats-up' ),
		array( 'ti-stats-down' => 'stats-down' ),
		array( 'ti-shine' => 'shine' ),
		array( 'ti-shift-right' => 'shift-right' ),
		array( 'ti-shift-right-alt' => 'shift-right-alt' ),
		array( 'ti-shift-left' => 'shift-left' ),
		array( 'ti-shift-left-alt' => 'shift-left-alt' ),
		array( 'ti-shield' => 'shield' ),
		array( 'ti-notepad' => 'notepad' ),
		array( 'ti-server' => 'server' ),
		array( 'ti-pulse' => 'pulse' ),
		array( 'ti-printer' => 'printer' ),
		array( 'ti-power-off' => 'power-off' ),
		array( 'ti-plug' => 'plug' ),
		array( 'ti-pie-chart' => 'pie-chart' ),
		array( 'ti-panel' => 'panel' ),
		array( 'ti-package' => 'package' ),
		array( 'ti-music' => 'music' ),
		array( 'ti-music-alt' => 'music-alt' ),
		array( 'ti-mouse' => 'mouse' ),
		array( 'ti-mouse-alt' => 'mouse-alt' ),
		array( 'ti-money' => 'money' ),
		array( 'ti-microphone' => 'microphone' ),
		array( 'ti-menu' => 'menu' ),
		array( 'ti-menu-alt' => 'menu-alt' ),
		array( 'ti-map' => 'map' ),
		array( 'ti-map-alt' => 'map-alt' ),
		array( 'ti-location-pin' => 'location-pin' ),
		array( 'ti-light-bulb' => 'light-bulb' ),
		array( 'ti-info' => 'info' ),
		array( 'ti-infinite' => 'infinite' ),
		array( 'ti-id-badge' => 'id-badge' ),
		array( 'ti-hummer' => 'hummer' ),
		array( 'ti-home' => 'home' ),
		array( 'ti-help' => 'help' ),
		array( 'ti-headphone' => 'headphone' ),
		array( 'ti-harddrives' => 'harddrives' ),
		array( 'ti-harddrive' => 'harddrive' ),
		array( 'ti-gift' => 'gift' ),
		array( 'ti-game' => 'game' ),
		array( 'ti-filter' => 'filter' ),
		array( 'ti-files' => 'files' ),
		array( 'ti-file' => 'file' ),
		array( 'ti-zip' => 'zip' ),
		array( 'ti-folder' => 'folder' ),
		array( 'ti-envelope' => 'envelope' ),
		array( 'ti-dashboard' => 'dashboard' ),
		array( 'ti-cloud' => 'cloud' ),
		array( 'ti-cloud-up' => 'cloud-up' ),
		array( 'ti-cloud-down' => 'cloud-down' ),
		array( 'ti-clipboard' => 'clipboard' ),
		array( 'ti-calendar' => 'calendar' ),
		array( 'ti-book' => 'book' ),
		array( 'ti-bell' => 'bell' ),
		array( 'ti-basketball' => 'basketball' ),
		array( 'ti-bar-chart' => 'bar-chart' ),
		array( 'ti-bar-chart-alt' => 'bar-chart-alt' ),
		array( 'ti-archive' => 'archive' ),
		array( 'ti-anchor' => 'anchor' ),
		array( 'ti-alert' => 'alert' ),
		array( 'ti-alarm-clock' => 'alarm-clock' ),
		array( 'ti-agenda' => 'agenda' ),
		array( 'ti-write' => 'write' ),
		array( 'ti-wallet' => 'wallet' ),
		array( 'ti-video-clapper' => 'video-clapper' ),
		array( 'ti-video-camera' => 'video-camera' ),
		array( 'ti-vector' => 'vector' ),
		array( 'ti-support' => 'support' ),
		array( 'ti-stamp' => 'stamp' ),
		array( 'ti-slice' => 'slice' ),
		array( 'ti-shortcode' => 'shortcode' ),
		array( 'ti-receipt' => 'receipt' ),
		array( 'ti-pin2' => 'pin2' ),
		array( 'ti-pin-alt' => 'pin-alt' ),
		array( 'ti-pencil-alt2' => 'pencil-alt2' ),
		array( 'ti-eraser' => 'eraser' ),
		array( 'ti-more' => 'more' ),
		array( 'ti-more-alt' => 'more-alt' ),
		array( 'ti-microphone-alt' => 'microphone-alt' ),
		array( 'ti-magnet' => 'magnet' ),
		array( 'ti-line-double' => 'line-double' ),
		array( 'ti-line-dotted' => 'line-dotted' ),
		array( 'ti-line-dashed' => 'line-dashed' ),
		array( 'ti-ink-pen' => 'ink-pen' ),
		array( 'ti-info-alt' => 'info-alt' ),
		array( 'ti-help-alt' => 'help-alt' ),
		array( 'ti-headphone-alt' => 'headphone-alt' ),
		array( 'ti-gallery' => 'gallery' ),
		array( 'ti-face-smile' => 'face-smile' ),
		array( 'ti-face-sad' => 'face-sad' ),
		array( 'ti-credit-card' => 'credit-card' ),
		array( 'ti-comments-smiley' => 'comments-smiley' ),
		array( 'ti-time' => 'time' ),
		array( 'ti-share' => 'share' ),
		array( 'ti-share-alt' => 'share-alt' ),
		array( 'ti-rocket' => 'rocket' ),
		array( 'ti-new-window' => 'new-window' ),
		array( 'ti-rss' => 'rss' ),
		array( 'ti-rss-alt' => 'rss-alt' ),
		array( 'ti-control-stop' => 'control-stop' ),
		array( 'ti-control-shuffle' => 'control-shuffle' ),
		array( 'ti-control-play' => 'control-play' ),
		array( 'ti-control-pause' => 'control-pause' ),
		array( 'ti-control-forward' => 'control-forward' ),
		array( 'ti-control-backward' => 'control-backward' ),
		array( 'ti-volume' => 'volume' ),
		array( 'ti-control-skip-forward' => 'control-skip-forward' ),
		array( 'ti-control-skip-backward' => 'control-skip-backward' ),
		array( 'ti-control-record' => 'control-record' ),
		array( 'ti-control-eject' => 'control-eject' ),
		array( 'ti-paragraph' => 'paragraph' ),
		array( 'ti-uppercase' => 'uppercase' ),
		array( 'ti-underline' => 'underline' ),
		array( 'ti-text' => 'text' ),
		array( 'ti-italic' => 'italic' ),
		array( 'ti-smallcap' => 'smallcap' ),
		array( 'ti-list' => 'list' ),
		array( 'ti-list-ol' => 'list-ol' ),
		array( 'ti-align-right' => 'align-right' ),
		array( 'ti-align-left' => 'align-left' ),
		array( 'ti-align-justify' => 'align-justify' ),
		array( 'ti-align-center' => 'align-center' ),
		array( 'ti-quote-right' => 'quote-right' ),
		array( 'ti-quote-left' => 'quote-left' ),
		array( 'ti-layout-width-full' => 'layout-width-full' ),
		array( 'ti-layout-width-default' => 'layout-width-default' ),
		array( 'ti-layout-width-default-alt' => 'layout-width-default-alt' ),
		array( 'ti-layout-tab' => 'layout-tab' ),
		array( 'ti-layout-tab-window' => 'layout-tab-window' ),
		array( 'ti-layout-tab-v' => 'layout-tab-v' ),
		array( 'ti-layout-tab-min' => 'layout-tab-min' ),
		array( 'ti-layout-slider' => 'layout-slider' ),
		array( 'ti-layout-slider-alt' => 'layout-slider-alt' ),
		array( 'ti-layout-sidebar-right' => 'layout-sidebar-right' ),
		array( 'ti-layout-sidebar-none' => 'layout-sidebar-none' ),
		array( 'ti-layout-sidebar-left' => 'layout-sidebar-left' ),
		array( 'ti-layout-placeholder' => 'layout-placeholder' ),
		array( 'ti-layout-menu' => 'layout-menu' ),
		array( 'ti-layout-menu-v' => 'layout-menu-v' ),
		array( 'ti-layout-menu-separated' => 'layout-menu-separated' ),
		array( 'ti-layout-menu-full' => 'layout-menu-full' ),
		array( 'ti-layout-media-right' => 'layout-media-right' ),
		array( 'ti-layout-media-right-alt' => 'layout-media-right-alt' ),
		array( 'ti-layout-media-overlay' => 'layout-media-overlay' ),
		array( 'ti-layout-media-overlay-alt' => 'layout-media-overlay-alt' ),
		array( 'ti-layout-media-overlay-alt-2' => 'layout-media-overlay-alt-2' ),
		array( 'ti-layout-media-left' => 'layout-media-left' ),
		array( 'ti-layout-media-left-alt' => 'layout-media-left-alt' ),
		array( 'ti-layout-media-center' => 'layout-media-center' ),
		array( 'ti-layout-media-center-alt' => 'layout-media-center-alt' ),
		array( 'ti-layout-list-thumb' => 'layout-list-thumb' ),
		array( 'ti-layout-list-thumb-alt' => 'layout-list-thumb-alt' ),
		array( 'ti-layout-list-post' => 'layout-list-post' ),
		array( 'ti-layout-list-large-image' => 'layout-list-large-image' ),
		array( 'ti-layout-line-solid' => 'layout-line-solid' ),
		array( 'ti-layout-grid4' => 'layout-grid4' ),
		array( 'ti-layout-grid3' => 'layout-grid3' ),
		array( 'ti-layout-grid2' => 'layout-grid2' ),
		array( 'ti-layout-grid2-thumb' => 'layout-grid2-thumb' ),
		array( 'ti-layout-cta-right' => 'layout-cta-right' ),
		array( 'ti-layout-cta-left' => 'layout-cta-left' ),
		array( 'ti-layout-cta-center' => 'layout-cta-center' ),
		array( 'ti-layout-cta-btn-right' => 'layout-cta-btn-right' ),
		array( 'ti-layout-cta-btn-left' => 'layout-cta-btn-left' ),
		array( 'ti-layout-column4' => 'layout-column4' ),
		array( 'ti-layout-column3' => 'layout-column3' ),
		array( 'ti-layout-column2' => 'layout-column2' ),
		array( 'ti-layout-accordion-separated' => 'layout-accordion-separated' ),
		array( 'ti-layout-accordion-merged' => 'layout-accordion-merged' ),
		array( 'ti-layout-accordion-list' => 'layout-accordion-list' ),
		array( 'ti-widgetized' => 'widgetized' ),
		array( 'ti-widget' => 'widget' ),
		array( 'ti-widget-alt' => 'widget-alt' ),
		array( 'ti-view-list' => 'view-list' ),
		array( 'ti-view-list-alt' => 'view-list-alt' ),
		array( 'ti-view-grid' => 'view-grid' ),
		array( 'ti-upload' => 'upload' ),
		array( 'ti-download' => 'download' ),
		array( 'ti-loop' => 'loop' ),
		array( 'ti-layout-sidebar-2' => 'layout-sidebar-2' ),
		array( 'ti-layout-grid4-alt' => 'layout-grid4-alt' ),
		array( 'ti-layout-grid3-alt' => 'layout-grid3-alt' ),
		array( 'ti-layout-grid2-alt' => 'layout-grid2-alt' ),
		array( 'ti-layout-column4-alt' => 'layout-column4-alt' ),
		array( 'ti-layout-column3-alt' => 'layout-column3-alt' ),
		array( 'ti-layout-column2-alt' => 'layout-column2-alt' ),
		array( 'ti-flickr' => 'flickr' ),
		array( 'ti-flickr-alt' => 'flickr-alt' ),
		array( 'ti-instagram' => 'instagram' ),
		array( 'ti-google' => 'google' ),
		array( 'ti-github' => 'github' ),
		array( 'ti-facebook' => 'facebook' ),
		array( 'ti-dropbox' => 'dropbox' ),
		array( 'ti-dropbox-alt' => 'dropbox-alt' ),
		array( 'ti-dribbble' => 'dribbble' ),
		array( 'ti-apple' => 'apple' ),
		array( 'ti-android' => 'android' ),
		array( 'ti-yahoo' => 'yahoo' ),
		array( 'ti-trello' => 'trello' ),
		array( 'ti-stack-overflow' => 'stack-overflow' ),
		array( 'ti-soundcloud' => 'soundcloud' ),
		array( 'ti-sharethis' => 'sharethis' ),
		array( 'ti-sharethis-alt' => 'sharethis-alt' ),
		array( 'ti-reddit' => 'reddit' ),
		array( 'ti-microsoft' => 'microsoft' ),
		array( 'ti-microsoft-alt' => 'microsoft-alt' ),
		array( 'ti-linux' => 'linux' ),
		array( 'ti-jsfiddle' => 'jsfiddle' ),
		array( 'ti-joomla' => 'joomla' ),
		array( 'ti-html5' => 'html5' ),
		array( 'ti-css3' => 'css3' ),
		array( 'ti-drupal' => 'drupal' ),
		array( 'ti-wordpress' => 'wordpress' ),
		array( 'ti-tumblr' => 'tumblr' ),
		array( 'ti-tumblr-alt' => 'tumblr-alt' ),
		array( 'ti-skype' => 'skype' ),
		array( 'ti-youtube' => 'youtube' ),
		array( 'ti-vimeo' => 'vimeo' ),
		array( 'ti-vimeo-alt' => 'vimeo-alt' ),
		array( 'ti-twitter' => 'twitter' ),
		array( 'ti-twitter-alt' => 'twitter-alt' ),
		array( 'ti-linkedin' => 'linkedin' ),
		array( 'ti-pinterest' => 'pinterest' ),
		array( 'ti-pinterest-alt' => 'pinterest-alt' ),
		array( 'ti-themify-logo' => 'themify-logo' ),
		array( 'ti-themify-favicon' => 'themify-favicon' ),
		array( 'ti-themify-favicon-alt' => 'themify-favicon-alt' ),

	);

	return array_merge( $icons, $themify_icons );
}

?>
