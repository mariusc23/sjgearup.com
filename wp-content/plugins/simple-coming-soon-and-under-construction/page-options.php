<?php

	function scs_manage_options()
	{
		global $scs_option;
		$scs_option = scs_get_option();
		$scs_active_theme = $scs_option['active_theme'];
		
		/* "activation hook"
			if there is no activate theme, load ourtuts */
		if ( ! $scs_option['active_theme'] ) {
			$scs_option['active_theme'] = $scs_active_theme = 'ourtuts';
			scs_update_option( $scs_option );
		}

		if ( $_POST ) {
			$scs_option['state'] = $_POST['state'];
			$scs_option['active_theme'] = $_POST['theme'];
			$scs_option['theme_options'] = $_POST['theme_options'];
			
			/* trigger theme activation */
			if ( file_exists( dirname( __FILE__ ).'/'.SCS_THEMES_DIR.'/'.strtolower($_POST['theme']).'/functions.php' ) ) {
				include_once dirname( __FILE__ ).'/'.SCS_THEMES_DIR.'/'.strtolower($_POST['theme']).'/functions.php';
				$scs_option = apply_filters( 'scs_' . strtolower($_POST['theme']) . '_update', $scs_option );
			}
			
			/* counter */
			$scs_option['expiry_date'] = $_POST['theme_options']['expiry_date'] ? $_POST['theme_options']['expiry_date'] : '';
			if ( !$scs_option['expiry_date'] ) {
				unset( $scs_option['expiry_date'] );
			}
			scs_update_option( $scs_option );
		}
		$scs_active_theme = $scs_option['active_theme'];
		scs_get_themes();
		
		?>
		
		<div id="cs-options" class="wrap">

			<form method="post" action="" enctype="multipart/form-data">

				<ul class="nav">
					<li><a target="_blank" href="http://blog.mariokostelac.com/simple-coming-soon/">Plugin's webpage</a></li>
					<li><a target="_blank" href="http://blog.mariokostelac.com/simple-coming-soon/">Help</a><li>
				</ul>
	
				<h2>Simple Coming Soon and Under Construction</h2>
	
				<div id="tabs">

					<ul>
						<li><a href="#general">General</a></li>
						<li><a href="#theme-options">Theme Options</a></li>
					</ul>
					
					<div id="general">
						<label>Site state
							<select name="state">
								<option value="normal" <?php if ( $scs_option['state'] == 'normal' ) echo 'selected="selected"'; ?>>Usual, running site</option>
								<option value="coming-soon" <?php if ( $scs_option['state'] == 'coming-soon' ) echo 'selected="selected"'; ?>>Coming soon page</option>
							</select>
						</label>
	
						<h3>Steps</h3>
						<ol id="steps">
							<li>Select the site state</li>
							<li>Select the template (and fill text fields) <strong>OR</strong></li>
							<li>Create coming-soon.php file into the active theme directory</li>
						</ol>
	
						<p class="description">
							Independent of selected state, logged users always see full site without any restrictions,
							while guests see the selected state (full site or coming soon page).
						</p>
					</div>
					
					<div id="theme-options">
					
						<label>
							<?php global $scs_themes; ?>
							<?php if ( is_array( $scs_themes ) ): ?>
							Choose the theme you like
							<select id="theme" name="theme">
								<?php foreach( $scs_themes as $t ): ?>
								<option <?php if ( strtolower( $t ) == strtolower( $scs_active_theme )  ) echo 'selected="1"'; ?> value="<?php echo strtolower($t); ?>"><?php echo $t; ?></option>
								<?php endforeach; ?>
							</select>
							<?php else: ?>
								We're sorry, but there is no themes. Appearently someone's deleted them.
							<?php endif; ?>
						</label>
						
						<div class="theme-options">
							<?php include_once dirname( __FILE__ ).'/'.SCS_THEMES_DIR.'/'.$scs_active_theme.'/options.php';  ?>
						</div>
						
					</div>
					
				</div>
				
				<input type="submit" id="scs-submit" name="save_changes" class="button-primary" value="Save changes" />
				
			</form>
	
		</div>
		
		<?php
	
	}

?>