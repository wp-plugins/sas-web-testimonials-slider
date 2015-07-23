<?php
 class Testimonial{

 	public function __construct()
 	{
 		
 	}
 	
 	public function swt_testimonial_setting_form()
 	{	
 		?>
 		<form method="post" action="options.php">
 			<?php
			
			settings_fields('swt-testimonial-settings-group');
			global $swt_testimonial_options;
			$swt_testimonial_options = get_option('swt_testimonial_options');
			 
			 ?>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Type of transition between slides', 'swt_testimonial'); ?>
						</th>
						<td>
							<p><input id="swt_testimonial_options[horizontal]" name="swt_testimonial_options[transition_type]" type="radio" value="horizontal" <?php checked('horizontal' == $swt_testimonial_options['transition_type'] ); ?> />
							<label class="descriptionr" for="swt_testimonial_options[horizontal]"><?php _e('Testimonial in Horizontal Format', 'swt_testimonial'); ?></label>
							</p>
							<p><input id="swt_testimonial_options[vertical]" name="swt_testimonial_options[transition_type]" type="radio" value="vertical" <?php checked( 'vertical' == $swt_testimonial_options['transition_type']); ?> />
							<label class="descriptionr" for="swt_testimonial_options[vertical]"><?php _e('Testimonial in vertical Format', 'swt_testimonial'); ?></label>
							</p>
							<p><input id="swt_testimonial_options[fade]" name="swt_testimonial_options[transition_type]" type="radio" value="fade" <?php checked( 'fade' == $swt_testimonial_options['transition_type'] ); ?> />
							<label class="descriptionr" for="swt_testimonial_options[fade]"><?php _e('Testimonial in fade Format', 'swt_testimonial'); ?></label>
							</p>
						</td>
						<td>
							<p>If you like this plugin, Buy me a beer.</p>
							<a class="button button-primary button-hero load-customize hide-if-no-customize" href="http://www.skmukhiya.com.np/donation-page/" target="_blank">Buy me a beer.</a>
						</td>
					</tr>
				</tbody>
			</table>	
 
			<h3 class="title"><?php _e('Slider Settings', 'swt_testimonial'); ?></h3>
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Slide transition duration (in ms)', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[slide_transition]" name="swt_testimonial_options[slide_transition]" type="text" class="regular-text" value="<?php 
							echo  esc_attr($swt_testimonial_options['slide_transition']); ?>"/>
							<label class="description" for="swt_testimonial_options[slide_transition]"><?php _e('Slide transition duration (in ms)', 'swt_testimonial'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Margin between each slide', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[margin_between_slide]" name="swt_testimonial_options[margin_between_slide]" type="text" class="regular-text" value="<?php echo $swt_testimonial_options['margin_between_slide']; ?>"/>
							<label class="description" for="swt_testimonial_options[margin_between_slide]"><?php _e('Margin between each slide.', 'swt_testimonial'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Starting slide index (zero-based)', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[slide_index]" name="swt_testimonial_options[slide_index]" type="text" class="regular-text" value="<?php echo $swt_testimonial_options['slide_index']; ?>"/>
							<label class="description" for="swt_testimonial_options[slide_index]"><?php _e('Starting slide index (0/1).', 'swt_testimonial'); ?></label>
						</td>
					</tr>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Start slider on a random slide', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[start_slider_random]" name="swt_testimonial_options[start_slider_random]" class="regular-text" type="text" value="<?php echo $swt_testimonial_options['start_slider_random']; ?>"/>
							<label class="description" for="swt_testimonial_options[start_slider_random]"><?php _e('Start slider on a random slide.(0/1)', 'swt_testimonial'); ?></label>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Infinite Loop', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[infinite_loop]" name="swt_testimonial_options[infinite_loop]" class="regular-text" type="text" value="<?php echo $swt_testimonial_options['infinite_loop']; ?>"/>
							<label class="description" for="swt_testimonial_options[infinite_loop]"><?php _e('If true, clicking "Next" while on the last slide will transition to the first slide & vice-versa(0/1)', 'swt_testimonial'); ?></label>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Hide Control On End', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[hide_control_on_end]" name="swt_testimonial_options[hide_control_on_end]" class="regular-text" type="text" value="<?php echo $swt_testimonial_options['hide_control_on_end']; ?>"/>
							<label class="description" for="swt_testimonial_options[hide_control_on_end]"><?php _e('If true, "Next" control will be hidden on last slide and vice-versa(0/1)', 'swt_testimonial'); ?></label>
						</td>
					</tr>

					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('Testimonial Text Font Size', 'swt_testimonial'); ?>
						</th>
						<td>
							<input id="swt_testimonial_options[testimonial_font_size]" name="swt_testimonial_options[testimonial_font_size]" class="regular-text" type="text" value="<?php if (!empty($swt_testimonial_options['testimonial_font_size'])) echo $swt_testimonial_options['testimonial_font_size']; ?>"/>
							<label class="description" for="swt_testimonial_options[testimonial_font_size]"><?php _e('px , Enter Font Size(Only Number.).', 'swt_testimonial'); ?></label>
						</td>
					</tr>
				</tbody>
			</table>	
 
			<p class="submit">
				<input type="submit" class="button-primary" id="swt-testimonial-submit" name="swt-testimonial-submit" value="<?php esc_attr_e('Save Settings', 'swt_testimonial_domain'); ?>" />
			</p>
 
		</form>
 		<?php
 		
 	}

 }
?>
