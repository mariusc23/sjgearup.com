<?php
/**
 * Functions.php - file contains main functions for plugin
 */
 
 	/**
	 * Everything starts here!
	 * Function called on WP hook template_redirect
	 */
	function scs_template_redirect($template)
	{
		global $scs_options;
		$scs_options = scs_get_option();
		if ( $scs_options['logged_in_permission'] ) {
			scs_handle_template($scs_options);
		}

	}
	

	/**
	 * Get the options of plugin; if not exists, it creates them
	 */
	function scs_get_option()
	{
		$option = get_option( basename(dirname(__FILE__)) );
		if ( !$option ) {
			$option = array( 'state' => 'normal', 'logged_in_permission' => true );
			add_option(basename(dirname(__FILE__)), $option);
		}

		return $option;
	}
	

	/**
	 * Update the plugin's options
	 */
	function scs_update_option($data)
	{
		return update_option(basename(dirname(__FILE__)), $data);
	}
	
	/**
	 * Seeks for themes and fills the global array
	 */
	 function scs_get_themes()
	 {
	 	global $scs_themes;
		$scs_themes = array();
		
	 	$dir = dirname(__FILE__).'/'.SCS_THEMES_DIR.'/';
		if ($handle = opendir($dir)) {
			while (false !== ($file = readdir($handle))) {
				if ($file != "." && $file != ".." && !is_file($file) && file_exists($dir.$file.'/index.php') ) {
					$scs_themes[] = ucfirst($file);
				}
			}
			closedir($handle);
		}
		
		return true;
		
	 }
	

	/**
	 * Handle the name of template that should be loaded
	 */
	function scs_handle_template($option)
	{
		$dir = get_template_directory().'/';
		
		/* only guests should see coming soon */
		if ( !is_user_logged_in() ) {
			switch ( $option['state'] ) {
			case 'coming-soon':
				if ( file_exists($dir.'coming-soon.php') ) {
					include_once $dir.'coming-soon.php';
					exit();
				}
				else {
					/* load selected theme */
					if ( $option['expiry_date'] ) {
						list( $date,$time ) = explode( '|', $option['expiry_date'] );
						list( $month, $day, $year ) = explode( '.', $date );
						list( $hour, $minute, $second ) = explode ( ':', $time );
						$timestamp = mktime( $hour, $minute, $second, $month, $day, $year );

						/* if page should be opened now, return true and break function */
						if ( time() > $timestamp ) {
							return true;
						}
					}

					$theme = $option['active_theme'];
					$theme_dir = dirname( __FILE__ ) . '/' . SCS_THEMES_DIR . '/' . $theme . '/';
					if ( file_exists( $theme_dir . 'index.php' ) ) {
						scs_prepare_template_vars();
						include_once $theme_dir . 'index.php';
						exit();
						
					}
				}
			break;
		}
		
		}
	}
	
	
	/**
	 * Prepares public (global) vars for theme files
	 */
	function scs_prepare_template_vars()
	{
	
		global $scs_theme, $scs_options;
		
		$scs_theme = $scs_options['theme_options'];
		
		return true;
	
	}	

?>
