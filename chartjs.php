<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://https://github.com/Jerl92
 * @since             1.0.0
 * @package           Chartjs
 *
 * @wordpress-plugin
 * Plugin Name:       ChartJS
 * Plugin URI:        https://https://github.com/Jerl92/Chart.js
 * Description:       Chart.js : HTML5 Charts for Wordpress
 * Version:           1.0.0
 * Author:            Jeremie Langevin
 * Author URI:        https://https://github.com/Jerl92/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       chartjs
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
define( 'CHARTJS_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-chartjs-activator.php
 */
function activate_chartjs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chartjs-activator.php';
	Chartjs_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-chartjs-deactivator.php
 */
function deactivate_chartjs() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-chartjs-deactivator.php';
	Chartjs_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_chartjs' );
register_deactivation_hook( __FILE__, 'deactivate_chartjs' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-chartjs.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_chartjs() {

	$plugin = new Chartjs();
	$plugin->run();

}
run_chartjs();
