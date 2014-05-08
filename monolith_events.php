<?php
/*
Plugin Name: Monolith Events
Plugin URI: http://badgersaregreat.com
Description: A simple events plugin with minimal styling for use with the Bigspring Monolith WP theme.
Version: 1.0
Author: Simon P Miles, Dave Seaton
Author URI: http://www.bigspring.co.uk
License: GPL2
*/

class MonolithEvents
{
	public function __construct() {

		//some pimping checks to see if we have ACF installed and if not use our bundled copy, coz that's how we roll
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'advanced-custom-fields/acf.php' ) ) {
			// init acf/plugin prerequisites
	 		define( 'ACF_LITE' , true );
	 		include_once('advanced-custom-fields/acf.php' );
 		}
 		
 		
 		add_action('init', array($this, 'monolith_events_setup'), 0);
 		add_action("template_redirect", array($this, 'me_theme_redirect'));
 		add_action('wp_enqueue_scripts', array($this, 'load_event_scripts'));
 	}

	///////////////////////////////////////////////////////////////////////////////////
	// PLUGIN/ACF INITIALISATION
	///////////////////////////////////////////////////////////////////////////////////

	/**
	* 
	*/
	public function monolith_events_setup() {
	
	
		function monolith_events_admin_icon() //change the event icon to the new cool dashicon ones :)
		{
		echo '
		<style>
		#adminmenu #menu-posts-events div.wp-menu-image:before { content: "\f163"; }
		</style>
		';
		}
		add_action( 'admin_head', 'monolith_events_admin_icon' );
	

	    $labels = array(
	        'name' => _x( 'Events', 'events' ),
	        'singular_name' => _x( 'Event', 'events' ),
	        'add_new' => _x( 'Add New', 'events' ),
	        'add_new_item' => _x( 'Add New Event', 'events' ),
	        'edit_item' => _x( 'Edit Event', 'events' ),
	        'new_item' => _x( 'New Event', 'events' ),
	        'view_item' => _x( 'View Event', 'events' ),
	        'search_items' => _x( 'Search Event', 'events' ),
	        'not_found' => _x( 'No events found', 'events' ),
	        'not_found_in_trash' => _x( 'No events found in Trash', 'events' ),
	        'parent_item_colon' => _x( 'Parent Event:', 'events' ),
	        'menu_name' => _x( 'Events', 'event' ),
	    );

	    $args = array(
	        'labels' => $labels,
	        'hierarchical' => true,
	        'description' => 'Product custom post type',
	        'supports' => array( 'title', 'editor', 'excerpt', 'page-attributes'),
			//'taxonomies' => array(),
	        'public' => true,
	        'show_ui' => true,
	        'show_in_menu' => true,
	        'menu_position' => 5,


	        'show_in_nav_menus' => true,
	        'publicly_queryable' => true,
	        'exclude_from_search' => false,
	        'has_archive' => true,
	        'query_var' => true,
	        'can_export' => true,
	        //'rewrite'    => array( 'slug' => 'event' ),
	        'capability_type' => 'post'
	    );

	    register_post_type( 'events', $args );

		//register the events category taxonomy
		register_taxonomy('event_categories',array (
		  0 => 'events',
		),array( 'hierarchical' => true,'label' => 'Event Categories','show_ui' => true,'query_var' => true,'rewrite' => array('slug' => 'events'),'singular_label' => 'Event Category') );
	

		/**
		 *  Register Field Groups
		 *
		 *  The register_field_group function accepts 1 array which holds the relevant data to register a field group
		 *  You may edit the array as you see fit. However, this may result in errors if the array is not compatible with ACF
		 */
		if (function_exists("register_field_group")) {

			register_field_group(array (
				'id' => 'acf_event-details',
				'title' => 'Event Details',
				'fields' => array (
					array (
						'key' => 'field_5200e221acb30',
						'label' => 'Start Date',
						'name' => 'start_date',
						'type' => 'date_picker',
						'instructions' => 'If this is a single day event then set the start and end date to be the same.',
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
					array (
						'key' => 'field_5200e14facb1f',
						'label' => 'End Date',
						'name' => 'date',
						'type' => 'date_picker',
						'date_format' => 'yymmdd',
						'display_format' => 'dd/mm/yy',
						'first_day' => 1,
					),
					array (
						'key' => 'field_5200e169acb20',
						'label' => 'Time',
						'name' => 'time',
						'type' => 'text',
						'instructions' => 'Use the 24h clock',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e19aacb21',
						'label' => 'Venue Name',
						'name' => 'venue_name',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e1b0acb22',
						'label' => 'Address One',
						'name' => 'address_one',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
								array (
						'key' => 'field_5200e1b0acb30',
						'label' => 'Address Two',
						'name' => 'address_two',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e1b0acb31',
						'label' => 'Address Three',
						'name' => 'address_three',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),

					array (
						'key' => 'field_5200e1c3acb23',
						'label' => 'City',
						'name' => 'city',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e1d0acb24',
						'label' => 'Post Code',
						'name' => 'post_code',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e1e3acb25',
						'label' => 'Country',
						'name' => 'country',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e1f4acb26',
						'label' => 'Cost',
						'name' => 'cost',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e211acb27',
						'label' => 'Facebook Link',
						'name' => 'facebook_link',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
					array (
						'key' => 'field_5200e221acb28',
						'label' => 'Website Link',
						'name' => 'website_link',
						'type' => 'text',
						'default_value' => '',
						'placeholder' => '',
						'prepend' => '',
						'append' => '',
						'formatting' => 'none',
						'maxlength' => '',
					),
				
				),
				'location' => array (
					array (
						array (
							'param' => 'post_type',
							'operator' => '==',
							'value' => 'events',
							'order_no' => 0,
							'group_no' => 0,
						),
					),
				),
				'options' => array (
					'position' => 'normal',
					'layout' => 'default',
					'hide_on_screen' => array (
						0 => 'custom_fields',
						1 => 'discussion',
						2 => 'comments',
						3 => 'slug',
						4 => 'author',
						5 => 'format',
						6 => 'categories',
						//7 => 'tags',
						8 => 'send-trackbacks',
					),
				),
				'menu_order' => 1,
			));
		}
	} // end monolith_events_setup

	///////////////////////////////////////////////////////////////////////////////////
	// TEMPLATE FALLBACK
	///////////////////////////////////////////////////////////////////////////////////

	public function me_theme_redirect() {

	    global $wp;
	    $plugindir = dirname( __FILE__ );
		$themepath = get_template_directory();

	    //Single event view
	    if ($wp->query_vars["post_type"] == 'events' && is_singular('events')) {

		        $templatefilename = 'single-events.php';
		        if (file_exists($themepath . '/' . $templatefilename)) {
		            $return_template = $themepath . '/' . $templatefilename;
		        } else {
		            $return_template = $plugindir . '/monolith-events-templates/' . $templatefilename;
		        }
	        $this->do_theme_redirect($return_template);

	    //Archive event view
	    } elseif ($wp->query_vars["post_type"] == 'events' && is_post_type_archive('events')) {

		        $templatefilename = 'archive-events.php';
		        if (file_exists($themepath . '/' . $templatefilename)) {
		            $return_template = $themepath . '/' . $templatefilename;
		        } else {
		            $return_template = $plugindir . '/monolith-events-templates/' . $templatefilename;
		        }
	        $this->do_theme_redirect($return_template);

	    //Taxonomy Page
	    } elseif ($wp->query_vars["taxonomy"] == 'events_categories') {

	        $templatefilename = 'taxonomy-events_categories.php';
	        if (file_exists($themepath . '/' . $templatefilename)) {
	            $return_template = $themepath . '/' . $templatefilename;
	        } else {
	            $return_template = $plugindir . '/monolith-events-templates/' . $templatefilename;
			}
			$this->do_theme_redirect($return_template);
		}
	}

	public function do_theme_redirect($url) {

		global $post, $wp_query;

		if (have_posts()) {

			include($url);
			die();
		} else {

			$wp_query->is_404 = true;
		}
	}

	///////////////////////////////////////////////////////////////////////////////////
	// GMAPS
	///////////////////////////////////////////////////////////////////////////////////

	/**
	 * Add gmaps dependencies
	 */
	public function load_event_scripts() {

		if(is_singular('events')) {
			wp_enqueue_script('gmapsapi', 'http://maps.google.com/maps/api/js?sensor=true', array('jquery'));
			wp_enqueue_script('gmapsjs', plugins_url('monolith-events/assets/gmaps.js'), array('jquery', 'gmapsapi'));
		}
	}
}


class MonolithCronScheduler
{
	public function __construct() {
//print_r(_get_cron_array()); print_r(date('Y-m-d G:i:s', 1390003200)); die();
		// plugin activation status
		register_activation_hook( __FILE__, array($this, 'create_daily_event_check_schedule'));
		register_deactivation_hook( __FILE__, array($this, 'remove_daily_event_check_schedule'));

		// event check hook
		add_action('me_daily_event_check', array($this, 'check_event_datetime'));
	}

	///////////////////////////////////////////////////////////////////////////////////
	// SCHEDULE REGISTRATION
	///////////////////////////////////////////////////////////////////////////////////

	/**
	* Schedule daily event check (00:00) upon plugin activation
	*/
	public function create_daily_event_check_schedule() {

		// Use wp_next_scheduled to check if the event is already scheduled
		$timestamp = wp_next_scheduled('me_daily_event_check');

		// If $timestamp == false schedule daily backups since it hasn't been done previously
		if ($timestamp == false) {

			// Schedule the event to repeat midnightly using the hook 'me_daily_event_check'
			wp_schedule_event(strtotime('midnight'), 'daily', 'me_daily_event_check');
		}
	}

	/**
	* Cancel daily event check upon plugin deactivation
	*/
	public function remove_daily_event_check_schedule() {

	 	wp_clear_scheduled_hook('me_daily_event_check');
	}

	///////////////////////////////////////////////////////////////////////////////////
	// EVENT CHECK
	///////////////////////////////////////////////////////////////////////////////////

	/**
	* Collate event dates/times (grouped by id) and update 'date_passed' field if timestamp is before current time
	*
	* TODO: look into accessing post_data table directly, this is very much a proof of concept
	* TODO: consider alternative methods for filtering datetime
	*/
	public function check_event_datetime() {

		global $wpdb;

		// retrieve date/time postmeta data from all events
		$datetime_events = $wpdb->get_results("SELECT * FROM $wpdb->postmeta WHERE meta_key = 'date' OR meta_key = 'time'", ARRAY_A);

		$events_cons = array();

		// consolidate each date/time pair under common event
		foreach ($datetime_events as $post_meta => $post_meta_value) {

			if (!array_key_exists($post_meta_value['post_id'], $events_cons)) {
				$events_cons[$post_meta_value['post_id']] = array();
			}

			// store data in multidimensional array in format $events_cons[event post id]['date/time'] = date/time value
			$events_cons[$post_meta_value['post_id']][$post_meta_value['meta_key']] = $post_meta_value['meta_value'];
		}

		// check whether the date has passed and update date_passed field(s) accordingly
		foreach ($events_cons as $event_id => $datetime_values) {

			$datetime = $datetime_values['date'] . ' ' . $datetime_values['time'] . ':00';

			if ((time() - strtotime($datetime)) > 0) {

				$wpdb->update($wpdb->postmeta, array('meta_value' => '1'), array('post_id' => $event_id, 'meta_key' => 'date_passed'));
			}
		}
	}
}


// instantiate bro
$mcs = new MonolithCronScheduler();
$me = new MonolithEvents();