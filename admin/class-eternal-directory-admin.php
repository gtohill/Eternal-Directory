<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       www.pivotaldesign.ca
 * @since      1.0.0
 *
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Eternal_Directory
 * @subpackage Eternal_Directory/admin
 * @author     Gary Tohill <info@pivotaldesign.ca>
 */
class Eternal_Directory_Admin
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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct($plugin_name, $version)
	{

		$this->plugin_name = $plugin_name;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style($this->plugin_name, plugin_dir_url(__FILE__) . 'css/eternal-directory-admin.css', array(), $this->version, 'all');
	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script($this->plugin_name, plugin_dir_url(__FILE__) . 'js/eternal-directory-admin.js', array('jquery'), $this->version, false);
	}

	public static function eternal_directory_admin_cf()
	{
		/** 
		 * add ability for form to upload files
		 */
		add_action('post_edit_form_tag', 'update_edit_form');
		function update_edit_form()
		{
			echo 'enctype="multipart/form-data"';
		}

		/**
		 * creates menu option in admin area
		 */

		/*
		* adds a custom box to post page
		*/
		function eternity_add_custom_box()
		{

			$screens = ['post', 'eternal_resting'];
			foreach ($screens as $screen) {

				add_meta_box(
					'eternity_location_box_id',           // Unique ID
					'Burial Location',  // Box title
					'eternity_custom_location_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
				add_meta_box(
					'eternity_year_box_id',           // Unique ID
					'Year Of Birth and Death - Public Display',  // Box title
					'eternity_custom_year_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
				add_meta_box(
					'eternity_date_box_id',           // Unique ID
					'Date Of Birth and Death - Admin Only',  // Box title
					'eternity_custom_date_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
				add_meta_box(
					'eternity_background_image_box_id',           // Unique ID
					'Hero Image',  // Box title
					'eternity_custom_background_image_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
				add_meta_box(
					'eternity_map_box_id',           // Unique ID
					'Cemetery',  // Box title
					'eternity_custom_map_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
				add_meta_box(
					'eternity_service_box_id',           // Unique ID
					'Interment Details',  // Box title
					'eternity_service_box_html',  // Content callback, must be of type callable
					$screen                   // Post type
				);
			}
		}
		add_action('add_meta_boxes', 'eternity_add_custom_box');


		/**
		 * add html elements to display deceased year of birth and year of death
		 */
		function eternity_custom_year_box_html($post)
		{
			//$value = get_post_meta($post->ID, '_eternal_year_meta_key', true);
?>
			<label for="eternity_dob_year_field">Date of Birth</label>
			<input type="text" name="eternity_dob_year_field" value="<?php echo get_post_meta($post->ID, '_eternity_dob_year_meta_key', true); ?>" />
			<label for="eternity_dod_year_field">Date of Death</label>
			<input type="text" name="eternity_dod_year_field" value="<?php echo get_post_meta($post->ID, '_eternity_dod_year_meta_key', true); ?>" />
		<?php
		}

		/**
		 * add html elements to custom date post type
		 */
		function eternity_custom_date_box_html($post)
		{
			$value = get_post_meta($post->ID, '_eternal_date_meta_key', true);
		?>
			<label for="eternity_dob_field">Date of Birth</label>
			<input type="date" name="eternity_dob_field" value="<?php echo get_post_meta($post->ID, '_eternity_dob_meta_key', true); ?>" />
			<label for="eternity_dod_field">Date of Death</label>
			<input type="date" name="eternity_dod_field" value="<?php echo get_post_meta($post->ID, '_eternity_dod_meta_key', true); ?>" />
		<?php
		}


		/**
		 * add html element for burial location of deceased
		 */
		function eternity_custom_location_box_html($post)
		{
			$value = get_post_meta($post->ID, '_eternity_location_meta_key', true);
		?>
			<label for="eternity_location_field">Deceased Final Resting Place</label>
			<input type="text" name="eternity_location_field" value="<?php echo get_post_meta($post->ID, '_eternity_location_meta_key', true); ?>" />
		<?php
		}


		/**
		 * add html elements to upload and display hero background image
		 */
		function eternity_custom_background_image_box_html($post)
		{
			$value = get_post_meta($post->ID, '_eternity_background_image_meta_key', true);
		?>
			<img src="<?php echo $value; ?>">
			<label for="eternity_background_image_field">Hero Banner Image</label>
			<input type="file" name="eternity_background_image_field" value="<?php echo $value; ?>" />

			<input type="checkbox" id="eternity_delete_background_image" name="eternity_delete_background_image" value="delete">
			<label for="eternity_delete_background_image"> Delete Hero Image</label><br>
		<?php
		}

		/**
		 * add html element to upload and display map of cemetery to help
		 * berived find loved one.
		 */
		function eternity_custom_map_box_html($post)
		{
			$value = get_post_meta($post->ID, '_eternity_map_meta_key', true);
		?>
			<img src="<?php echo $value; ?>">
			<label for="eternity_add_map_field">Add Cemetery Map</label>
			<input type="file" name="eternity_add_map_field" value="<?php echo $value; ?>" />
			<input type="checkbox" id="eternity_delete_map_field" name="eternity_delete_map_field" value="delete">
			<label for="eternity_delete_map_field"> Delete Cemetery Map</label><br>
		<?php
		}

		/**
		 * add html element to set information about the burial date, time and location
		 */
		function eternity_service_box_html($post)
		{
			$time_value = get_post_meta($post->ID, '_eternity_interment_time_meta_key', true);
			$date_value = get_post_meta($post->ID, '_eternity_interment_date_meta_key', true);
			$location_value = get_post_meta($post->ID, '_eternity_interment_location_meta_key', true);
			$address_value = get_post_meta($post->ID, '_eternity_interment_address_meta_key', true);
			$phone_value = get_post_meta($post->ID, '_eternity_interment_phone_meta_key', true);
		?>
			<style>
				.interment-container {
					width: 500px;
					clear: both;
					padding-bottom:10px;
				}

				.interment-container input {
					width: 100%;
					clear: both;
				}
			</style>

			<div class="interment-container">
				<label for="eternity_interment_time_field">Interment Time</label>
				<input type="text" name="eternity_interment_time_field" value=<?php echo $time_value ?>>
			</div>

			<div class="interment-container">
				<label for="eternity_interment_date_field">Date of Interment</label>
				<input type="date" name="eternity_interment_date_field" value=<?php echo $date_value ?>>
			</div>

			<div class="interment-container">
				<label for="eternity_interment_location_field">Interment Location</label>
				<input type="text" name="eternity_interment_location_field" value=<?php echo $location_value ?>>
			</div>

			<div class="interment-container">
				<label for="eternity_interment_address_field">Address for Interment</label>
				<textarea name="eternity_interment_address_field" cols="50" rows="10"><?php echo $address_value ?></textarea>
			</div>

			<div class="interment-container">
				<label for="eternity_interment_phone_field">Phone Number</label>
				<input type="text" name="eternity_interment_phone_field" value=<?php echo $phone_value ?>>
			</div>

<?php
		}

		/**
		 * save the post data to the database
		 * data is saved to wp_postmeta
		 */
		function eternity_save_postdata($post_id)
		{

			if (array_key_exists('eternity_location_field', $_POST)) {
				update_post_meta(
					$post_id,
					'_eternity_location_meta_key',
					$_POST['eternity_location_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_dob_meta_key',
					$_POST['eternity_dob_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_dod_meta_key',
					$_POST['eternity_dod_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_dob_year_meta_key',
					$_POST['eternity_dob_year_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_dod_year_meta_key',
					$_POST['eternity_dod_year_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_interment_time_meta_key',
					$_POST['eternity_interment_time_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_interment_date_meta_key',
					$_POST['eternity_interment_date_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_interment_location_meta_key',
					$_POST['eternity_interment_location_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_interment_address_meta_key',
					$_POST['eternity_interment_address_field']
				);
				update_post_meta(
					$post_id,
					'_eternity_interment_phone_meta_key',
					$_POST['eternity_interment_phone_field']
				);
			}
			if (!empty($_FILES['eternity_background_image_field']['name'])) {

				/** upload custom image */
				$upload = wp_upload_bits($_FILES['eternity_background_image_field']['name'], null, file_get_contents($_FILES['eternity_background_image_field']['tmp_name']));
				//$upload = wp_handle_upload($uploadedfile, $upload_overrides);
				update_post_meta(
					$post_id,
					'_eternity_background_image_meta_key',
					$upload['url']
				);
			}
			if (!empty($_POST['eternity_delete_background_image'])) {
				update_post_meta(
					$post_id,
					'_eternity_background_image_meta_key',
					''
				);
			}



			if (!empty($_FILES['eternity_add_map_field']['name'])) {

				/** upload custom image */
				$upload = wp_upload_bits($_FILES['eternity_add_map_field']['name'], null, file_get_contents($_FILES['eternity_add_map_field']['tmp_name']));

				update_post_meta(
					$post_id,
					'_eternity_map_meta_key',
					$upload['url']
				);
			}
			if (!empty($_POST['eternity_delete_map_field'])) {
				update_post_meta(
					$post_id,
					'_eternity_map_meta_key',
					''
				);
			}
		}
		add_action('save_post', 'eternity_save_postdata');
	}
}
