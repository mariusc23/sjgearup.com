<?php

	/* adds appropriate action to extend default plugin's save options */
	add_filter( 'scs_ourtuts_update', 'scs_ourtuts_update' );
	
	function scs_ourtuts_update( $options )
	{

		$options['theme_options']['logo'] = scs_ourtuts_upload( 'logo' );
		$options['theme_options']['body_bg'] = scs_ourtuts_upload( 'body_bg' );
		
		if ( $_POST['remove_logo'] ) {
			$options['theme_options']['logo'] = '';
		}
		elseif ( $_POST['remove_bg'] ) {
			$options['theme_options']['body_bg'] = '';
		}
	
		return $options;
	}
	
	
	/**
	 * Uploads logo for particular theme
	 */
	function scs_ourtuts_upload( $type )
	{
		
		$field_name = $type;
		
		$file = array( 
					'tmp_name' => $_FILES['theme_options']['tmp_name'][$field_name],
					'name' => $_FILES['theme_options']['name'][$field_name],
					'size' => $_FILES['theme_options']['size'][$field_name],
					'error' => $_FILES['theme_options']['error'][$field_name]
				 );
		
		$dir = WP_CONTENT_DIR . '/uploads/simple-coming-soon/';
		/* create directory if it doesn't exist (including uploads directory) */
		if ( !file_exists( dirname($dir) ) ) {
			mkdir( dirname($dir) );
		}
		if ( !file_exists( $dir ) ) {
			mkdir( $dir );
		}
		
		if ( $file['name'] ) {
			$filename = strtolower($field_name.'.'.end( explode( '.', $file['name'] ) ));
			move_uploaded_file( $file['tmp_name'], $dir . $filename );
			return WP_CONTENT_URL . '/uploads/simple-coming-soon/'.$filename;
		}
		else {
			$options = scs_get_option();
			return $options['theme_options'][$field_name];
		}
	}

?>