<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://paper-leaf.com
 * @since             1.0.0
 * @package           Ubc_Vpfo_Templates_Styles
 *
 * @wordpress-plugin
 * Plugin Name:       UBC VPFO Templates and Styles
 * Plugin URI:        https://paper-leaf.com
 * Description:       Provides an additional layer of templates and styles that sits on top of the UBC CLF
 * Version:           1.0.0
 * Author:            Paperleaf ZGM
 * Author URI:        https://paper-leaf.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ubc-vpfo-templates-styles
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'UBC_VPFO_TEMPLATES_STYLES_VERSION', '1.0.0' );

/**
 * Enqueue plugin assets
 */
require plugin_dir_path( __FILE__ ) . 'includes/enqueues.php';

/**
 * Load plugin hooks
 */
require plugin_dir_path( __FILE__ ) . 'includes/hooks.php';

/**
 * Load plugin helpers
 */
require plugin_dir_path( __FILE__ ) . 'includes/helpers.php';

/**
 * Load plugin post types and taxonomies, if activated
 */
if ( get_option( 'vpfo_activate_finance_cpt', false ) ) {
	require plugin_dir_path( __FILE__ ) . 'includes/post-types.php';
}

/**
 * Load plugin page templates
 */
require plugin_dir_path( __FILE__ ) . 'includes/register-templates.php';
