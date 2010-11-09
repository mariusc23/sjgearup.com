jQuery(function(){
	jQuery('#tabs').tabs();
	
	/* changing theme */
	jQuery('#theme').change(function(){
		jQuery('#cs-options form').submit();
	});
	
});