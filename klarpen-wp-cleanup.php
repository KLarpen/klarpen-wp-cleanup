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
