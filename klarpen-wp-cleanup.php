<?php
/**
 * Plugin Name:     KLarpen WP Cleanup
 * Plugin URI:      https://github.com/KLarpen/klarpen-wp-cleanup
 * Description:     Custom code to cleanup / remove / switch off unused WP features. The plugin intended to use by developers only: there is no UI! More details at the README.md and the plugin's file itself.
 * Author:          KLarpen
 * Author URI:      https://github.com/KLarpen
 * Text Domain:     klrpn-wpcleanup
 * Domain Path:     /languages
 * Version:         0.1.0
 *
 * @package         Klarpen_WP_Cleanup
 */

/**
 * Holder function for the command to deregister/dequeue unused core scripts and styles
 */
function klrpn_exclude_unused_scripts_n_styles(){
	if (!is_admin()) {
    # List of commands for the front-end only
		wp_deregister_script( 'wp-embed' );
	}
}
# Comment the action if not used
add_action( 'init', 'klrpn_exclude_unused_scripts_n_styles' );

# Completely switch off the Emoji: START
add_filter('emoji_svg_url', '__return_empty_string');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');    
remove_filter('the_content_feed', 'wp_staticize_emoji');
remove_filter('comment_text_rss', 'wp_staticize_emoji');  
remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
function wph_remove_emojis_tinymce($plugins) {
	if (is_array($plugins)) {
		return array_diff($plugins, array('wpemoji'));
	} else {
		return array();
	}
}
add_filter('tiny_mce_plugins', 'wph_remove_emojis_tinymce');
add_filter('option_use_smilies', '__return_false');
# Completely switch off the Emoji: END

# Remove standart widgets
add_action( 'widgets_init', 'klrpn_unregister_basic_widgets' );
function klrpn_unregister_basic_widgets() {
	unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	// unregister_widget('WP_Widget_Archives');
	// unregister_widget('WP_Widget_Links');
	// unregister_widget('WP_Widget_Meta');
	// unregister_widget('WP_Widget_Search');
	// unregister_widget('WP_Widget_Text');
	// unregister_widget('WP_Widget_Categories');
	// unregister_widget('WP_Widget_Recent_Posts');
	unregister_widget('WP_Widget_Recent_Comments');
	unregister_widget('WP_Widget_RSS');
	// unregister_widget('WP_Widget_Tag_Cloud');
	// unregister_widget('WP_Nav_Menu_Widget'); 
	// unregister_widget('WP_Widget_Media_Audio');
	// unregister_widget('WP_Widget_Media_Video');
	// unregister_widget('WP_Widget_Media_Gallery');
	// unregister_widget('WP_Widget_Media_Image');
}

# Удаление виджетов из Консоли WordPress
add_action( 'wp_dashboard_setup', 'klrpn_clear_wp_dash' );
function klrpn_clear_wp_dash(){
	$dash_side   = & $GLOBALS['wp_meta_boxes']['dashboard']['side']['core'];
	$dash_normal = & $GLOBALS['wp_meta_boxes']['dashboard']['normal']['core'];

	unset( $dash_side['dashboard_quick_press'] );       // Быстрая публикация
	unset( $dash_side['dashboard_primary'] );           // Блог WordPress
	unset( $dash_side['dashboard_secondary'] );         // Другие Новости WordPress

	// unset( $dash_normal['dashboard_incoming_links'] );  // Входящие ссылки
	// unset( $dash_normal['dashboard_recent_comments'] ); // Последние комментарии
	// unset( $dash_normal['dashboard_plugins'] );         // Последние Плагины
}
# Удаление виджета "Добро пожаловать"
remove_action( 'welcome_panel', 'wp_welcome_panel' );

# Switch off RSS Feeds
// remove_action( 'do_feed_rdf',  'do_feed_rdf',  10, 1 );
// remove_action( 'do_feed_rss',  'do_feed_rss',  10, 1 );
remove_action( 'do_feed_rss2', 'do_feed_rss2', 10, 1 );
remove_action( 'do_feed_atom', 'do_feed_atom', 10, 1 );

# Cleanup HTML Head
add_action( 'wp', function(){
	// remove_action( 'wp_head', 'feed_links_extra', 3 );
	// remove_action( 'wp_head', 'feed_links', 2 );
  remove_action( 'wp_head', 'rsd_link' );
  remove_action( 'wp_head', 'wlwmanifest_link' ); 
  remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );// Короткая ссылка - без ЧПУ <link rel='shortlink'
  // remove_action( 'wp_head', 'wp_resource_hints', 2); // Prints resource hints to browsers for pre-fetching, pre-rendering and pre-connecting to web sites.
});

# Убираем версию WordPress
// add_filter('the_generator', '__return_empty_string');
