<?php
/**
 * @package MediaElementJS
 * @version 2.0.1.1
 */
/*
Plugin Name: MediaElementJS - HTML5 Audio and Video
Plugin URI: http://mediaelementjs.com/
Description: A video and audio plugin for WordPress built on MediaElement HTML5 video and audio player library. Embeds video or audio in your post or page using HTML5 with Flash or Silverlight fallback support for non-HTML5 browsers. Video support: MP4, Ogg, WebM, WMV. Audio support: MP3, WMA, WAV
Author: John Dyer
Version: 2.0.1.1
Author URI: http://johndyer.me/
License: GPLv3, MIT
*/

/*
Adapted from: http://videojs.com/ plugin
*/

$mediaElementPlayerIndex = 1;

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'mep_install'); 

function mep_install() {
	add_option('mep_default_video_height', 270);
	add_option('mep_default_video_width', 480);
	add_option('mep_default_video_type', '');
	add_option('mep_default_audio_type', '');
}

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'mep_remove' );
function mep_remove() {
	delete_option('mep_default_video_height');
	delete_option('mep_default_video_width');
	delete_option('mep_default_video_type');
	delete_option('mep_default_audio_type');
}

// create custom plugin settings menu
add_action('admin_menu', 'mep_create_menu');

function mep_create_menu() {

	//create new top-level menu
	add_options_page('MediaElement Settings', 'MediaElement Settings', 'administrator', __FILE__, 'mep_settings_page');

	//call register settings function
	add_action( 'admin_init', 'register_mysettings' );
}


function register_mysettings() {
	//register our settings
	register_setting( 'mep_settings', 'mep_default_video_height' );
	register_setting( 'mep_settings', 'mep_default_video_width' );
	register_setting( 'mep_settings', 'mep_default_video_type' );
	register_setting( 'mep_settings', 'mep_default_audio_type' );
}


function mep_settings_page() {
?>
<div class="wrap">
<h2>MediaElement.js HTML5 Player Options</h2>

<p>See <a href="http://mediaelementjs.com/">MediaElementjs.com</a> for more details on how the HTML5 player and Flash fallbacks work.</p>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>


	<h3 class="title"><span>Video Settings</span></h3>
		
	<table  class="form-table">
		<tr valign="top">
			<th scope="row">
				<label for="mep_default_video_width">Default Width</label>
			</th>
			<td >
				<input name="mep_default_video_width" type="text" id="mep_default_video_width" value="<?php echo get_option('mep_default_video_width'); ?>" />
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">
				<label for="mep_default_video_height">Default Height</label>
			</th>
			<td >
				<input name="mep_default_video_height" type="text" id="mep_default_video_height" value="<?php echo get_option('mep_default_video_height'); ?>" />
			</td>
		</tr>	
		<tr valign="top">
			<th scope="row">
				<label for="mep_default_video_type">Default Type</label>
			</th>
			<td >
				<input name="mep_default_video_type" type="text" id="mep_default_video_type" value="<?php echo get_option('mep_default_video_type'); ?>" /> <span class="description">such as "video/mp4"</span>
			</td>
		</tr>		
	</table>

	<h3 class="title"><span>Audio Settings</span></h3>
	

	<table  class="form-table">
		<tr valign="top">
			<th scope="row">
				<label for="mep_default_audio_type">Default Type</label>
			</th>
			<td >
				<input name="mep_default_audio_type" type="text" id="mep_default_audio_type" value="<?php echo get_option('mep_default_audio_type'); ?>" /> <span class="description">such as "audio/mp3"</span>
			</td>
		</tr>			
	</table>

	<input type="hidden" name="action" value="update" />
	<input type="hidden" name="page_options" value="mep_default_video_width,mep_default_video_height,mep_default_video_type,mep_default_audio_type" />

	<p>
		<input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" />
	</p>

</div>



</form>
</div>
<?php
}

function add_mediaelementjs_header(){


	$dir = WP_PLUGIN_URL.'/media-element-html5-video-and-audio-player/mediaelement/';
	
	echo <<<_end_
<link rel="stylesheet" href="{$dir}mediaelementplayer.min.css" type="text/css" media="screen" charset="utf-8" />
<script src="{$dir}mediaelement-and-player.min.js" type="text/javascript"></script>
_end_;
}

// If this happens in the <head> tag it fails in iOS. Boo.
function add_mediaelementjs_footer(){
/*
	$defaultVideoWidth = get_option('mep_default_video_width');
	$defaultVideoHeight = get_option('mep_default_video_height');

	echo <<<_end_
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('video[class=mep],audio[class=mep]').mediaelementplayer({defaultVideoWidth:{$defaultVideoWidth},defaultVideoHeight:{$defaultVideoHeight}});
});
</script>
_end_;
*/
}


add_action('wp_head','add_mediaelementjs_header');
add_action('wp_footer','add_mediaelementjs_footer');

function mejs_media_shortcode($tagName, $atts){
	extract(shortcode_atts(array(
		'src' => '',  
		'mp4' => '',
		'mp3' => '',
		'wmv' => '',    
		'webm' => '',
		'ogg' => '',
		'poster' => '',
		'width' => '',
		'height' => '',
		'type' => get_option('mep_default_'.$tagName.'_type'),
		'preload' => 'none',
		'autoplay' => '',
		'loop' => 'false',
		
		// old ones
		'duration' => 'true',
		'progress' => 'true',
		'fullscreen' => 'true',
		'volume' => 'true',
		
		// captions
		'captions' => '',
		'captionslang' => 'en'
	), $atts));

	if ($type) {
		$type_attribute = 'type="'.$type.'"';
	}

	if ($src) {
		$src_attribute = 'src="'.$src.'"';
	}

	if ($mp4) {
		$mp4_source = '<source src="'.$mp4.'" type="'.$tagName.'/mp4" />';
	}
	
	if ($mp3) {
		$mp3_source = '<source src="'.$mp3.'" type="'.$tagName.'/mp3" />';
	}	

	if ($webm) {
		$webm_source = '<source src="'.$webm.'" type="'.$tagName.'/webm" />';
	}

	if ($ogg) {
		$ogg_source = '<source src="'.$ogg.'" type="'.$tagName.'/ogg" />';
	}

	if ($captions) {
		$captions_source = '<track src="'.$captions.'" kind="subtitles" srclang="'.$captionslang.'" />';
	}  

	if ($width) {
		$width_attribute = 'width="'.$width.'"';
	}

	if ($height) {
		$height_attribute = 'height="'.$height.'"';
	}    

	if ($poster) {
		$poster_attribute = 'poster="'.$poster.'"';
	}

	if ($preload) {
		$preload_attribute = 'preload="'.$preload.'"';
	}

	if ($autoplay) {
		$autoplay_attribute = 'autoplay="'.$autoplay.'"';
	}

	if ($loop) {
		$loop_option = ', loop: true';
	}

	// CONTROLS
	$controls_option = ",features: ['playpause'";
	if ($progress == 'true')
		$controls_option .= ",'progress'";
	if ($duration == 'true')
		$controls_option .= ",'current','duration'";
	if ($volume == 'true')
		$controls_option .= ",'volume'";
	$controls_option .= ",'tracks'";
	if ($fullscreen == 'true')
		$controls_option .= ",'fullscreen'";		
	$controls_option .= "]";

	$defaultVideoWidth = get_option('mep_default_video_width');
	$defaultVideoHeight = get_option('mep_default_video_height');
	global $mediaElementPlayerIndex;

	$videohtml .= <<<_end_
	<{$tagName} id="wp_mep_{$mediaElementPlayerIndex}" {$src_attribute} {$type_attribute} {$width_attribute} {$height_attribute} {$poster_attribute} controls="controls" {$preload_attribute} {$autoplay_attribute}>
		{$mp4_source}
		{$mp3_source}
		{$webm_source}
		{$ogg_source}
		{$captions_source}
	</{$tagName}>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$('#wp_mep_$mediaElementPlayerIndex').mediaelementplayer({
		defaultVideoWidth:{$defaultVideoWidth}
		,defaultVideoHeight:{$defaultVideoHeight}
		{$loop_option}
		{$controls_option}
	});
});
</script>

_end_;

	$mediaElementPlayerIndex++;

  return $videohtml;
}



function mejs_audio_shortcode($atts){
	return mejs_media_shortcode('audio',$atts);
}
function mejs_video_shortcode($atts){
	return mejs_media_shortcode('video',$atts);
}

add_shortcode('audio', 'mejs_audio_shortcode');
add_shortcode('video', 'mejs_video_shortcode');
	

function mejs_init() {
    
	wp_enqueue_script( 'jquery' );
    
}    
 
add_action('init', 'mejs_init');
	
?>
