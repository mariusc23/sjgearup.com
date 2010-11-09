<?php
/**
 * @package MediaElementJS
 * @version 1.0.1
 */
/*
Plugin Name: MediaElementJS - HTML5 Audio and Video
Plugin URI: http://mediaelementjs.com/
Description: A video and audio plugin for WordPress built on MediaElement HTML5 video and audio player library. Embeds video or audio in your post or page using HTML5 with Flash or Silverlight fallback support for non-HTML5 browsers. Video support: MP4, Ogg, WebM, WMV. Audio support: MP3, WMA, WAV
Author: John Dyer
Version: 1.0.1
Author URI: http://johndyer.name
License: GPLv3, MIT
*/

/*
Adapted from: http://videojs.com/ plugin
*/

/* Runs when plugin is activated */
register_activation_hook(__FILE__,'mep_install'); 

function mep_install() {
	add_option('mep_default_video_height', 480);
	add_option('mep_default_video_width', 270);
}

/* Runs on plugin deactivation*/
register_deactivation_hook( __FILE__, 'mep_remove' );
function mep_remove() {
	delete_option('mep_default_video_height');
	delete_option('mep_default_video_width');
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
}


function mep_settings_page() {
?>
<div>
<h2>MediaElementJS Options</h2>

<form method="post" action="options.php">
<?php wp_nonce_field('update-options'); ?>

<table >
	<tr valign="top">
		<th scope="row">Default Width</th>
		<td >
			<input name="mep_default_video_width" type="text" id="mep_default_video_width" value="<?php echo get_option('mep_default_video_width'); ?>" />
		</td>
	</tr>
	<tr valign="top">
		<th scope="row">Default Height</th>
		<td >
			<input name="mep_default_video_height" type="text" id="mep_default_video_height" value="<?php echo get_option('mep_default_video_height'); ?>" />
		</td>
	</tr>	
</table>

<input type="hidden" name="action" value="update" />
<input type="hidden" name="page_options" value="mep_default_video_width,mep_default_video_height" />

<p>
<input type="submit" value="<?php _e('Save Changes') ?>" />
</p>

</form>
</div>
<?php
}

function add_mediaelementjs_header(){
	$defaultVideoWidth = get_option('mep_default_video_width');
	$defaultVideoHeight = get_option('mep_default_video_height');

  $dir = WP_PLUGIN_URL.'/media-element-html5-video-and-audio-player/mediaelement/';
  echo <<<_end_
  <link rel="stylesheet" href="{$dir}mediaelementplayer.css" type="text/css" media="screen" charset="utf-8" />
  <script src="{$dir}mediaelement.js" type="text/javascript"></script>
  <script src="{$dir}mediaelementplayer.js" type="text/javascript"></script>
  <script type="text/javascript" charset="utf-8">
  jQuery(document).ready(function($) {
		$('video[class=mep],audio[class=mep]').mediaelementplayer({defaultVideoWidth:{$defaultVideoWidth},defaultVideoHeight:{$defaultVideoHeight}});
  });
  </script>
_end_;
}
add_action('wp_head','add_mediaelementjs_header');

function video_shortcode($atts){
  extract(shortcode_atts(array(
    'src' => '',
    'type' => '',
    'mp4' => '',
    'wmv' => '',    
    'webm' => '',
    'ogg' => '',
    'poster' => '',
    'width' => '',
    'height' => '',
    'preload' => false,
    'autoplay' => false,
  ), $atts));

  if ($src) {
    $src_attribute = 'src="'.$src.'"';
  }
  
  if ($type) {
    $type_attribute = 'type="'.$type.'"';
  }  
  
  if ($mp4) {
    $mp4_source = '<source src="'.$mp4.'" type="video/mp4" />';
  }

  if ($webm) {
    $webm_source = '<source src="'.$webm.'" type="video/webm" />';
  }

  if ($ogg) {
    $ogg_source = '<source src="'.$ogg.'" type="video/ogg" />';
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
    $preload_attribute = 'preload="preload"';
  }

  if ($autoplay) {
    $autoplay_attribute = 'autoplay="autoplay"';
  }
  
  if ($src) {
    $src_attribute = 'src="'.$src.'"';
  }  

  $videohtml .= <<<_end_
      <video class="mep" {$src_attribute} {$type_attribute} {$width_attribute} {$height_attribute} {$poster_attribute} controls="controls" {$preload_attribute} {$autoplay_attribute}>
      {$mp4_source}
      {$webm_source}
      {$ogg_source}
    </video>
_end_;

  return $videohtml;
}
add_shortcode('video', 'video_shortcode');


function audio_shortcode($atts){
  extract(shortcode_atts(array(
    'src' => '',
    'type' => '',
    'mp3' => '',
    'webm' => '',
    'ogg' => '',
    'poster' => '',
    'preload' => false,
    'autoplay' => false,
  ), $atts));

  if ($src) {
    $src_attribute = 'src="'.$src.'"';
  }
  
  if ($type) {
    $type_attribute = 'type="'.$type.'"';
  }    

  if ($mp3) {
    $mp3_source = '<source src="'.$mp3.'" type="audio/mp3" />';
  }

  if ($webm) {
    $webm_source = '<source src="'.$webm.'" type="audio/webm" />';
  }

  if ($ogg) {
    $ogg_source = '<source src="'.$ogg.'" type="audio/ogg" />';
  }

  if ($poster) {
    $poster_attribute = 'poster="'.$poster.'"';
  }

  if ($preload) {
    $preload_attribute = 'preload="preload"';
  }

  if ($autoplay) {
    $autoplay_attribute = 'autoplay="autoplay"';
  }
  
  if ($src) {
    $src_attribute = 'src="'.$src.'"';
  }  

  $audiohtml .= <<<_end_
      <audio class="mep" {$src_attribute} {$type_attribute} {$poster_attribute} controls="controls" {$preload_attribute} {$autoplay_attribute}>
      {$mp3_source}
      {$webm_source}
      {$ogg_source}
    </audio>
_end_;

  return $audiohtml;
}
add_shortcode('audio', 'audio_shortcode');
	

?>
