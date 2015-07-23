<?php

	class Shortcodes{
		public function __construct()
		{
			add_shortcode('SWT_TESTIMONIALS', array($this, 'swt_testimonials'));

			add_action( 'wp_enqueue_scripts', array($this, 'swt_load_stylesheet' ));
		}


		/*-----------------------------------------------------------------------------------*/
		/* Testimonials
		/*-----------------------------------------------------------------------------------*/

		public function swt_testimonials( $atts, $content = null ) 
		{
			
			extract( shortcode_atts( array(
				'columns'		=> '2',
				'category_name' => ''
			), $atts ) );
			
			ob_start();
			
			/* TESTIMONIALS
			============================== */
			$args = array(
				'post_type' 				=> 'testimonial',
				'posts_per_page' 		=> -1,
				'category_name' => $category_name
			);
			self::swt_load_testimonial($args);

			return ob_get_clean();
			
		}

		public function swt_load_stylesheet()
		{
			wp_enqueue_style( 'swt-style', plugins_url('../assets/css/swt-style.css', __FILE__) );
			wp_enqueue_script('swt-script-start',plugins_url('../assets/js/init.js', __FILE__), array(), '1.0.0', true);
			wp_enqueue_script('swt-script',plugins_url('../assets/js/jquery.bxslider.min.js', __FILE__), array(), '1.0.0', true );

			$swt_testimonial_options = get_option('swt_testimonial_options');
			$translation_array = array(
			'transition_type' => $swt_testimonial_options['transition_type'],
			'slide_transition' => $swt_testimonial_options['slide_transition'],
			'margin_between_slide' => $swt_testimonial_options['margin_between_slide'],
			'slide_index' => $swt_testimonial_options['slide_index'],
			'start_slider_random' => $swt_testimonial_options['start_slider_random'],
			'infinite_loop' => $swt_testimonial_options['infinite_loop'],
			'hide_control_on_end' => $swt_testimonial_options['hide_control_on_end']
			);
			wp_localize_script( 'swt-script-start', 'SASWEB_Testimonials', $translation_array );

			wp_enqueue_script( 'swt-script-start' );
		}


		public static function swt_load_testimonial($args)
		{
			echo '<ul class="bxslider">';
			$query_agents = new WP_Query( $args );
			global $post;

			if ( $query_agents->have_posts() ) : 

			while ( $query_agents->have_posts() ) : $query_agents->the_post();
				 $testimonial = get_post_meta( $post->ID, 'swt_testimonial_text', true );
					
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
					
					$fontsize = get_option('swt_testimonial_options');
					$fontsize= $fontsize['testimonial_font_size'];
					if(!empty($fontsize)){
						$fontsize = intval($fontsize);
					}
						echo '<li>';
							echo '<blockquote>';
								echo '<div class="aligncenter testimonial-img size-medium">';
								
								if ( has_post_thumbnail() ) { 
									the_post_thumbnail( 'square-400' ); 
								}	
								
								echo '</div>';
								echo '<p class="testimonial-text" style="font-size:'.$fontsize.'px;">'.$testimonial.'</p>';
								echo '<p class="author-name">-'.get_the_title().'</p>';
								
							echo '</blockquote>';
							echo '</li>';
			endwhile;
			
			echo '</ul>';

			//var_dump($args);
				
			wp_reset_query();
			endif;
		} //END OF SWT LOAD 
	}

	new Shortcodes;
?>