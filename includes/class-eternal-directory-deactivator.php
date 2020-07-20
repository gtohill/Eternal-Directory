<?php

/**
 * Fired during plugin deactivation
 *
 * @link       www.pivotaldesign.ca
 * @since      1.0.0
 *
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/includes
 * @author     Gary Tohill <info@pivotaldesign.ca>
 */
class Eternal_Directory_Deactivator
{

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate()
	{
		
		/**
		 * deque stylesheets
		 */
		wp_dequeue_style( PLUGIN_NAME);
		
		/** 
		 * deque scripts
		 */

		wp_dequeue_script( PLUGIN_NAME);
	}
}
