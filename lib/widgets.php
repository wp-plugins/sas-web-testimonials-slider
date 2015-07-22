<?php

// Function to register widget area
function widget_testimonials() {
	register_widget( 'widget_testimonials' );
}
add_action( 'widgets_init', 'widget_testimonials' );

/**
 * Testimonial Widget area Creation 
 */
class widget_testimonials extends WP_Widget {

	// CONSTRUCT WIDGET
	function widget_testimonials() {
		$widget_ops = array( 'classname' => 'widget_testimonials', 'description' => __( 'Testimonials', 'swt' ) );
		$this->WP_Widget( 'widget_testimonials', __( 'Sasweb - Testimonials', 'swt' ), $widget_ops );
	}
	
	// CREATE WIDGET FORM (WORDPRESS DASHBOARD)
  function form($instance) {
  
	  if ( isset( $instance[ 'title' ] ) && isset ( $instance[ 'amount' ] ) && isset($instance['category_name']) ) {
			$title = $instance[ 'title' ];
			$amount = $instance[ 'amount' ];
			$random = $instance[ 'random' ];
			$category_name = $instance['category_name'];
		}
		else {
			$title = __( 'Testimonials', 'swt' );
			$amount = __( '3', 'swt' );
			$random = false;
			$category_name = '';
		}
		if ( isset ( $instance[ 'random' ] ) ) {
			$random = $instance[ 'random' ];
		}
		else {
			$random = false;
		}
		?>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'swt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'amount' ); ?>"><?php _e( 'Total Number of Testimonial to Display:', 'swt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'amount' ); ?>" type="text" value="<?php echo esc_attr( $amount );?>" class="widefat" />
		</p>
		
		<p>
			<label for="<?php echo $this->get_field_id( 'random' ); ?>"><?php _e( 'Instead of Newest First, Order Random:', 'swt' ); ?></label> 
			<input name="<?php echo $this->get_field_name( 'random' ); ?>" type="checkbox" <?php checked( $random, 'on' ); ?> />
		</p>
		 
		<p>
			<label for="<?php echo $this->get_field_id( 'category_name' ); ?>"><?php _e( 'Select Category:', 'swt' ); ?></label> 
			<select class='widefat' id="<?php echo $this->get_field_id('category_name'); ?>" name="<?php echo $this->get_field_name('category_name'); ?>">
				<?php 
				$args=array(
					'post_type'                => 'post',
					'child_of'                 => 0,
					'parent'                   => '',
					'orderby'                  => 'name',
					'order'                    => 'ASC',
					'hide_empty'               => 1,
					'hierarchical'             => 1,
					'taxonomy'                 => 'testimonial_category',
					'pad_counts'               => false
					);
					$categories=get_categories( $args );
 
					foreach($categories as $category)
					{	
						if($category->name == $instance['category_name']){
							$sel = 'selected="selected"';
						} 
						else{
							$sel = '';
						}
						echo '<option '.$sel .' value="'.$category->name.'">'.$category->name.'</option>';
					}
				?>
			</select>
		</p>

		<?php
		
  }

  // UPDATE WIDGET
  function update( $new_instance, $old_instance ) {
  	  
	  $instance = $old_instance;
		$instance['title'] = ( ! empty( $new_instance['title'] ) ) ? strip_tags( $new_instance['title'] ) : '';		 
		$instance['amount'] = ( ! empty( $new_instance['amount'] ) ) ? strip_tags( $new_instance['amount'] ) : '';		 		 
		$instance['random'] = $new_instance['random'];		 		 
		$instance['category_name'] = $new_instance['category_name'];
		return $instance;
	  
  }

  /**
   * DISPLAY WIDGET ON FRONT END
   * @param [string] [$args] [shortcode arguments holder]
   * @param [string] [$instance] [holds different variable instance]
   */
  function widget( $args, $instance ) {
	  
	  extract( $args );
 
		// Widget starts to print information
		echo $before_widget;
		 
		$title = apply_filters( 'widget_title', $instance[ 'title' ] );	 
		$amount = empty( $instance[ 'amount' ] ) ? '3' : $instance[ 'amount' ];
		$amount = intval( $amount );
		$random = $instance[ 'random' ] ? true : false;
		$category_name = $instance['category_name'];
		//var_dump($category_name);
		if ( !empty( $title ) ) { 
			echo $before_title . $title . $after_title; 
		};

		// Query Featured Properties
		$args_testimonials = array(
			'post_type' 				=> 'testimonial',
			'posts_per_page' 		=> $amount,
			'testimonial_category' => $category_name
		);
		
		// Order By:
		if ( $random ) {
			$args_testimonials[ 'orderby' ] = 'rand';
		}
		
		Shortcodes::swt_load_testimonial($args_testimonials);
		
		// Widget ends printing information
		echo $after_widget;
	  
  }

}