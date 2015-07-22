<?php 
/**
 * Plugin Name: SAS WEB Testimonials Slider
 * Plugin URI: htp://www.skmukhiya.com.np
 * Description: Create Fully responsive testimonial slider, and widgets in an elegant way
 * Version: 1.0
 * Author: Suresh KUMAR Mukhiya
 * Author URI: http://upwork.com/users/~0182e0779315e50896
 * Tags: Testimonial Slider, customizable slider, testimonial slider, responsive testimonial slider
 */

if (!defined('ABSPATH'))
{
	die('-1');
}

define('SWT_OPTIONS', 'swt');
define('SWT_VER', '1.2');
define('SWT_URL', plugins_url('/', __FILE__));

//define('SNP_DIR_PATH', plugin_dir_path(__FILE__));
define('SWT_DIR_PATH', plugin_dir_path(__FILE__));	
require_once('lib/shortcode.php');
require_once('lib/widgets.php');
require_once('lib/testimonial.php');

class SASWEB_Testimonials
{
	
	public function __construct()
	{
		//action hooks
		add_action( 'init', array($this, 'swt_register_custom_post_type_testimonial' ));
		add_action('manage_testimonial_posts_custom_column', array($this,'swt_testimonial_custom_columns'),10,2);
		add_action( 'add_meta_boxes', array($this, 'swt_add_testimonial_text_box'));
		add_action( 'save_post', array( $this, 'save' ) );
		add_action( 'admin_init', array($this,'swt_plugin_admin_css'));
		add_action('admin_menu' , array($this, 'swt_testimonial_settings_page')); 
		
		//filters 
		add_filter('manage_edit-testimonial_columns', array($this, 'swt_testimonial_columns'));
	}


	public function swt_plugin_admin_css()
	{
		 

		 if(is_admin())
		 {
			wp_register_style( 'swt_admin_css', plugins_url('/assets/css/admin-init.css', __FILE__) );
			wp_enqueue_style( 'swt_admin_css' );
			// creates our settings in the options table
			register_setting('swt-testimonial-settings-group', 'swt_testimonial_options',array($this, 'swt_sanitize_options'));
		 }
		
	}

	public function swt_testimonial_settings_page()
	{
		add_submenu_page('edit.php?post_type=testimonial', 'Settings', 'Settings', 'edit_posts', basename(__FILE__), array($this,'swt_testimonial_settings_page_imp'));
	}

	public function swt_testimonial_settings_page_imp()
	{
		
		echo '<div class="wrap">';
		echo '<h2>Testimonial Settings</h2>';
		echo '<div id="welcome-panel" class="welcome-panel">';
		settings_errors(); 
		echo '<div class="welcome-panel-content"><h3>Customize Testimonial Display</h3>';
		echo '<p class="about-description">Check the <a href="#">instructions</a> page for detailed implementations.</p>';
		$testimoni = new Testimonial;
		$testimoni->swt_testimonial_setting_form();
		echo '</div>';	
		echo '</div>';
	}

	public function swt_register_custom_post_type_testimonial() 
	{

		$labels = array(
	    'name' 									=> __( 'Testimonials','swt' ),
	    'singular_name' 				=> __( 'Testimonial','swt' ),
	    'add_new' 							=> __( 'Add New','swt' ),
	    'add_new_item' 					=> __( 'Add New Testimonial','swt' ),
	    'edit_item' 						=> __( 'Edit Testimonial','swt' ),
	    'new_item' 							=> __( 'New Testimonial','swt' ),
	    'view_item' 						=> __( 'View Testimonial','swt' ),
	    'search_items' 					=> __( 'Search Testimonial','swt' ),
	    'not_found' 						=> __( 'No Testimonial found.','swt' ),
	    'not_found_in_trash' 		=> __( 'No Testimonial found in Trash.','swt' )
	  );

	  $args = array(
		  'labels' 								=> $labels,
		  
		  'public' 								=> true,
		  'show_ui' 							=> true,
		  'show_in_admin_bar' 		=> true,
		  'menu_position' 				=> 20,
		  'menu_icon' 						=> 'dashicons-format-chat',
		  'exclude_from_search' 	=> true,
		  'publicly_queryable' 		=> true,
		  'query_var' 						=> true,
		  'rewrite' 							=> true,
		  'hierarchical' 					=> true,
		  'capability_type' => 'page',
		  'supports' 							=> array( 'title', 'thumbnail' ),
		  'rewrite' 							=> array( 'slug' => __( 'testimonial', 'swt' ) )
	  );
		

		register_post_type( 'testimonial', $args );

		register_taxonomy('testimonial_category', 'testimonial', 
	        array(
	        'hierarchical' => true, 
	        'label' => 'Testimonial Categories', 
	        'singular_name' => 'Category', 
	        "rewrite" => true, 
	        "query_var" => true)
	        );

	}

	// Custom Property Columns
	public function swt_testimonial_columns($property_columns)
	{
		$property_columns = array(
	      'cb' 							=> '<input type=\'checkbox\' />',
	      'thumbnail'				=> __( 'Thumbnail','swt' ),
	      'title'						=> __( 'From','swt' ),
	      "testimonial_categories" => "Categories",
	      'testimonial' 		=> __( 'Testimonial','swt' ),
	      'date' 						=> __( 'Date','swt' )
	  );
	  return $property_columns;
	}


	//allow featured image to be set up
	public function swt_testimonial_custom_columns( $property_column, $post_id ) {
  
	  global $post;
	  
	  switch ( $property_column ) {
	    case 'thumbnail' :
	      if( has_post_thumbnail( $post->ID ) ) {
	      	the_post_thumbnail( 'thumbnail' );
	      }
	      else{
	      	_e( '-', 'swt' );
	      }
	      break;
	    case 'testimonial' :
	      echo get_post_meta( $post->ID, 'swt_testimonial_text', true ); 
	      break;

	    case 'testimonial_categories':
	    $terms = get_the_term_list( $post_id , 'testimonial_category' , '' , ',' , '' );
	        if ( is_string( $terms ) ) {
	            echo $terms;
	        } else {
	            echo 'Uncategorized';
	        }
	        break;
	  }
	  
	}


	public function swt_add_testimonial_text_box($post_type)
	{
		
		$post_types = array('testimonial');     
        if ( in_array( $post_type, $post_types )) 
        {
			add_meta_box(
				'Testimonial_Text',
				__( 'Add Testimonial Text', 'swt' ),
				array( $this, 'swt_render_meta_box_content' ),
				$post_type,
				'advanced',
				'high'
			);       
        }
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['swt_testimonial_nonce_nonce'] ) )
			return $post_id;

		$nonce = $_POST['swt_testimonial_nonce_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'swt_testimonial_nonce' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {

			if ( ! current_user_can( 'edit_page', $post_id ) )
				return $post_id;
	
		} else {

			if ( ! current_user_can( 'edit_post', $post_id ) )
				return $post_id;
		}

		/* OK, its safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['swt_testimonial_text'] );

		// Update the meta field.
		update_post_meta( $post_id, 'swt_testimonial_text', $mydata );
	}

	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function swt_render_meta_box_content( $post ) {
	
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'swt_testimonial_nonce', 'swt_testimonial_nonce_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, 'swt_testimonial_text', true );

		// Display the form, using the current value.
		echo '<p><label for="swt_testimonial_text">';
		_e( 'Enter Your Testimonial Text Here.', 'swt' );
		echo '</label> </p>';
		echo '<textarea  id="swt_testimonial_text" rows="5" name="swt_testimonial_text">'.esc_attr( $value ).'</textarea>';
	}

	public function swt_sanitize_options($input){
		$input['horizontal'] = sanitize_text_field( $input['horizontal'] ); 
		$input['vertical'] = sanitize_text_field( $input['vertical'] ); 
		$input['fade'] = sanitize_text_field( $input['fade'] ); 
		$input['slide_transition'] = sanitize_text_field( $input['slide_transition'] ); 
		$input['margin_between_slide'] = sanitize_text_field( $input['margin_between_slide'] ); 
		$input['slide_index'] = sanitize_text_field( $input['slide_index'] );
		$input['start_slider_random'] = sanitize_text_field( $input['start_slider_random'] );
		$input['infinite_loop'] = sanitize_text_field( $input['infinite_loop'] );
		$input['hide_control_on_end'] = sanitize_text_field( $input['hide_control_on_end'] );
		return $input;
	}

}
new SASWEB_Testimonials;
?>