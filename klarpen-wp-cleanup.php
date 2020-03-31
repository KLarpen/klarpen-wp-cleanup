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

