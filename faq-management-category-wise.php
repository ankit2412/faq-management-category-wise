<?php

/**
 * The plugin bootstrap file
 *
 * @link              https://www.ankit-jani.com
 * @since             1.0.0
 * @package           Faq_Management_Category_Wise
 *
 * @wordpress-plugin
 * Plugin Name:       FAQ Management Category Wise
 * Plugin URI:        https://www.faq-management-category-wise.com
 * Description:       Category wise handle FAQs.
 * Version:           1.0.0
 * Author:            Ankit Jani
 * Author URI:        https://www.ankit-jani.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       faq-management-category-wise
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'ABSPATH' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'FAQ_MANAGEMENT_CATEGORY_WISE_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-faq-management-category-wise-activator.php
 */
function activate_faq_management_category_wise() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-faq-management-category-wise-activator.php';
	Faq_Management_Category_Wise_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-faq-management-category-wise-deactivator.php
 */
function deactivate_faq_management_category_wise() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-faq-management-category-wise-deactivator.php';
	Faq_Management_Category_Wise_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_faq_management_category_wise' );
register_deactivation_hook( __FILE__, 'deactivate_faq_management_category_wise' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-faq-management-category-wise.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_faq_management_category_wise() {

	$plugin = new Faq_Management_Category_Wise();
	$plugin->run();

}
run_faq_management_category_wise();
