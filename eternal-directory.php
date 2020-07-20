<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              www.pivotaldesign.ca
 * @since             1.0.0
 * @package           Eternal_Directory
 *
 * @wordpress-plugin
 * Plugin Name:       Eternal Resting Place
 * Plugin URI:        www.pivotaldesign.ca
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            Gary Tohill
 * Author URI:        www.pivotaldesign.ca
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       eternal-directory
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if (!defined('WPINC')) {
	die;
}
/**
 * GLOBAL VARIABLES
 */

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define('ETERNAL_DIRECTORY_VERSION', '1.0.0');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-eternal-directory-activator.php
 */
function activate_eternal_directory()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-eternal-directory-activator.php';
	Eternal_Directory_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-eternal-directory-deactivator.php
 */
function deactivate_eternal_directory()
{
	require_once plugin_dir_path(__FILE__) . 'includes/class-eternal-directory-deactivator.php';
	Eternal_Directory_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_eternal_directory');
register_deactivation_hook(__FILE__, 'deactivate_eternal_directory');

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path(__FILE__) . 'includes/class-eternal-directory.php';



function modify_templates()
{
	/**
	 * replaces normal single.php with custom single template for this plugin
	 */

	add_filter('single_template', 'override_single_template');
	function override_single_template($single_template)
	{

		global $post;

		$file = plugin_dir_path(__FILE__) . '/templates/single-' . $post->post_type . '.php'; //. $post->post_type .'.php';

		if (file_exists($file)) $single_template = $file;

		return $single_template;
	}

	/**
	 * custom search page
	 */
	add_filter('search_template', 'override_search_template');
	function override_search_template($search_template)
	{
		global $post;

		$file = plugin_dir_path(__FILE__) . '/templates/searchpage.php';
		if (file_exists($file)) $search_template = $file;
		return $search_template;
	}
	
	/**
	 * replaces normal archive.php with custom single template for this plugin
	 */

	add_filter('archive_template', 'override_archive_template');
	function override_archive_template($archive_template)
	{

		global $post;

		$file = plugin_dir_path(__FILE__) . '/templates/archive-' . $post->post_type . '.php';

		if (file_exists($file)) $archive_template = $file;

		return $archive_template;
	}
}

add_action('init', 'modify_templates');



/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */

function run_eternal_directory()
{
	DEFINE('PLUGIN_NAME', 'eternal-directory');
	
	$plugin = new Eternal_Directory();
	$plugin->run();
}
run_eternal_directory();
