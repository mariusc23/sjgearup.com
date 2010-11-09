
	<?php global $scs_option; $theme_options = $scs_option['theme_options']; ?>
	
	<div class="theme-options">
	
		<h4>Basic options</h4>
		<label for="page_title">Page title</label>
		<input type="text" id="page_title" name="theme_options[page_title]" value="<?php echo ( isset( $theme_options['page_title'] ) ) ? $theme_options['page_title'] : 'The site is under construction'; ?>" />

		<label for="heading">Header text</label>
		<input type="text" id="heading" name="theme_options[heading]" value="<?php echo ( isset( $theme_options['heading'] ) ) ? $theme_options['heading'] : 'This website is under construction'; ?>" />

		<label for="time_text">Estimated time text</label>
		<input type="text" id="time_text" name="theme_options[time_text]" value="<?php echo ( isset( $theme_options['time_text'] ) ) ? $theme_options['time_text'] : 'Estimated Time Remaining Before Launch'; ?>" />

		<label for="social_heading">Social box heading</label>
		<input type="text" id="social_heading" name="theme_options[social_heading]" value="<?php echo ( isset( $theme_options['social_heading'] ) ) ? $theme_options['social_heading'] : 'You may find us below:'; ?>" />

		<label for="email">Email adress</label>
		<input type="text" id="email" name="theme_options[email]" value="<?php echo ( isset( $theme_options['email'] ) ) ? $theme_options['email'] : 'support@yoursite.com'; ?>" />

		<label for="tel">Phone number</label>
		<input type="text" id="tel" name="theme_options[tel]" value="<?php echo ( isset( $theme_options['tel'] ) ) ? $theme_options['tel'] : '555-534-231'; ?>" />

		<label for="expiry_date">Expiry date</label>
		<input type="text" id="expiry_date" name="theme_options[expiry_date]" value="<?php echo ( isset( $theme_options['expiry_date'] ) ) ? $theme_options['expiry_date'] : date('m.d.Y|H:i:s', time() +30*24*60*60 ); ?>" />
		<p class="explanation">month.day.year|hour:minute:second</p>

		<label for="expiry_text">Expiry text</label>
		<textarea id="expiry_text" name="theme_options[expiry_text]"><?php echo ( isset( $theme_options['expiry_text'] ) ) ? stripslashes($theme_options['expiry_text']) : 'Write text here if you haven\'t filled expiry date field.'; ?></textarea>
	
	</div>
	
	<div class="theme-options">
		
		<h4>Graphic elements</h4>
		
		<label for="theme_logo">Logo (~220x44px)</label>
		<input type="file" id="theme_logo" name="theme_options[logo]" />
		<?php if ( $theme_options['logo'] ): ?><input class="button" type="submit" name="remove_logo" value="Remove logo" /><?php endif; ?>
		
		<label for="body_bg">Body background</label>
		<input type="file" id="body_bg" name="theme_options[body_bg]" />
		<?php if ( $theme_options['body_bg'] ): ?><input class="button" type="submit" name="remove_bg" value="Remove background" /><?php endif; ?>
		
		<label for="body_bg_color">Body background color</label>
		<input type="text" id="body_bg_color" name="theme_options[body_bg_color]" value="<?php echo ( isset( $theme_options['body_bg_color'] ) ) ? stripslashes($theme_options['body_bg_color']) : '#aaaaaa'; ?>" />
		
	</div>
		
	<div class="theme-options">
			
		<h4>Social networks</h4>
		<p>Fill the fields with links to your social profile(s) or leave it blank.</p>

		<label for="twitter">Twitter</label>
		<input type="text" id="twitter" name="theme_options[twitter]" value="<?php echo ( isset( $theme_options['twitter'] ) ) ? $theme_options['twitter'] : ''; ?>" />

		<label for="facebook">Facebook</label>
		<input type="text" id="facebook" name="theme_options[facebook]" value="<?php echo ( isset( $theme_options['facebook'] ) ) ? $theme_options['facebook'] : ''; ?>" />

		<label for="youtube">Youtube</label>
		<input type="text" id="youtube" name="theme_options[youtube]" value="<?php echo ( isset( $theme_options['youtube'] ) ) ? $theme_options['youtube'] : ''; ?>" />

		<label for="flickr">Flickr</label>
		<input type="text" id="flickr" name="theme_options[flickr]" value="<?php echo ( isset( $theme_options['flickr'] ) ) ? $theme_options['flickr'] : ''; ?>" />

		<p id="credits">
			This theme is created by Madalin Tudose ( <a target="_blank" href="http://mariokostelac.com/redirect/?url=<?php echo urlencode('http://www.ourtuts.com/free-site-under-construction-template/'); ?>">ourtuts.com</a>  ) and really thanks to him for creating such a nice theme.
		</p>
			
	</div>
