<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       www.pivotaldesign.ca
 * @since      1.0.0
 *
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/public
 * @author     Gary Tohill <info@pivotaldesign.ca>
 */
class Eternal_Directory_Public
{

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eternal_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eternal_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/eternal-directory-public.css', array(), $this->version, 'all');
		wp_enqueue_style('eternal-google-fonts', 'https://fonts.googleapis.com/css2?family=Courgette&display=swap', false);
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts()
	{

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Eternal_Directory_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Eternal_Directory_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/eternal-directory-public.js', array('jquery'), $this->version, false);
	}

	public function load_ajax_calls()
	{
		add_action('wp_ajax_nopriv_get_eternal_cpt_comments', 'get_eternal_cpt_comments');
		function get_eternal_cpt_comments()
		{
			$id = intval($_GET['post_id']);
			$comments = get_comments(['post_id' => $id]);
			wp_send_json_success($comments);
		}

		/**
		 * ajax call to get service information from db
		 */
		add_action('wp_ajax_nopriv_get_eternal_cpt_interment', 'get_eternal_cpt_interment');
		function get_eternal_cpt_interment()
		{
			// get id 
			$id = intval($_GET['post_id']);
			$date = get_post_meta($id, '_eternity_interment_date_meta_key');
			$time  = get_post_meta($id, '_eternity_interment_time_meta_key');
			$location = get_post_meta($id, '_eternity_interment_location_meta_key');
			$address = get_post_meta($id, '_eternity_interment_address_meta_key');
			$phone = get_post_meta($id, '_eternity_interment_phone_meta_key');

			wp_send_json_success([$date, $time, $location, $address, $phone]);
		}
	}

	public function modify_comments_form()
	{
		/**
		 * remove url field of comment form in testamonial section
		 */
		function remove_website_field($fields)
		{
			unset($fields['url']);
			unset($fields['title_reply']);

			return $fields;
		}

		add_filter('comment_form_default_fields', 'remove_website_field');

		/**
		 * change title of comment form in testamonial section 
		 */
		add_filter('comment_form_defaults', 'set_my_comment_title', 20);
		function set_my_comment_title($defaults)
		{
			$defaults['title_reply'] = __('Share A Memory');
			return $defaults;
		}
	}

	
}
