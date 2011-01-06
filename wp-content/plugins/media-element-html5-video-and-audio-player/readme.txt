=== MediaElement.js - HTML5 Video & Audio Player ===
Contributors: johndyer
Donate link: http://mediaelementjs.com/
Tags: html5, video, audio, player, flash, mp4, mp3, ogg, webm, wmv, captions, subtitles, websrt, srt, accessible, Silverlight, javascript, 
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 1.1.5.1

MediaElement.js is an HTML5 video and audio player with Flash fallback and captions. Supports IE, Firefox, Opera, Safari, Chrome and iPhone, iPad, Android.

== Description ==

A video plugin for WordPress built on the MediaElement.js HTML5 video and audio player library. Provides Flash or Silverlight fallback players for non-HTML5 browsers and also supports iPhone, iPad, and Andriod.
Supports MP4, OGG, WebM, WMV, MP3, WAV, WMA files as well as captions with WebSRT files.

Check out <a href="http://mediaelementjs.com/">mediaElementjs.com</a> for more information and examples.

### Typical Usage for video

	[video src="http://mysite.com/mymedia.mp4" width="640" height="360"]
	
### Typical Usage for audio

	[audio src="http://mysite.com/mymedia.mp3"]	

###  Shortcode Options

= src =
This location of any audio or video file
    
    [video src="http://mysite.com/mymedia.mp4"]
    
= type =
The media type of the resource
    
    [video src="http://mysite.com/mymedia?xyz" type="video/mp4"]    

= mp4 =
The location of the h.264/MP4 source for the video.
    
    [video mp4="http://mysite.com/mymedia.mp4"]
    
= mp3 =
The location of an MP3 file for video
    
    [audio mp3="http://mysite.com/mymedia.mp3"]    

= ogg =
The location of the Theora/Ogg source for the video.

    [video ogg="http://mysite.com/mymedia.ogg"]

= webm =
The location of the VP8/WebM source for the video.

    [video ogg="http://mysite.com/mymedia.webm"]

= poster =
The location of the poster frame for the video.

    [video poster="http://mysite.com/mymedia.png"]

= width =
The width of the video

    [video width="640"]

= height =
The height of the video

    [video height="264"]
    
= loop =
Loops the video or audio when it ends
    
    [video src="http://mysite.com/mymedia.mp4" loop="true"]    

= preload =
Start loading the video as soon as possible, before the user clicks play.

    [video preload="true"]

= autoplay =
Start playing the video as soon as it's ready.

    [video autoplay="true"]

= fullscreen =
Disables the fullscreen button
    
    [video src="http://mysite.com/mymedia.mp4" fullscreen="false"]
    
= duration =
Disables the duration output
    
    [video src="http://mysite.com/mymedia.mp4" duration="false"]   
    
= volume =
Disables the volume slider
    
    [video src="http://mysite.com/mymedia.mp4" volume="false"]    
    
= progress =
Disables the progress bar
    
    [video src="http://mysite.com/mymedia.mp4" progress="false"] 
    
= captions =
URL to a WebSRT captions file
    
    [video src="http://mysite.com/mymedia.mp4" captions="http://mysite.com/mymedia.srt"]                

= Simple Video =
Basic playback options

    [video src="http://mysite.com/mymedia.mp4" width="640" height="360"]

= All Attributes Video =
All options enabled

    [video mp4="http://mysite.com/mymedia.mp4" ogg="http://mysite.com/mymedia.ogg" webm="http://mysite.com/mymedia.webm" poster="http://mysite.com/mymedia.png" preload="true" autoplay="true" width="640" height="264"]

= Simple Audio =
Basic playback options

    [audio src="http://mysite.com/mymedia.mp3"]

= All Attributes Audio =
All options enabled

    [audio mp3="http://mysite.com/mymedia.mp3" ogg="http://mysite.com/mymedia.ogg" preload="true" autoplay="true"]

== Installation ==

View <a href="http://mediaelementjs.com/">MediaElementjs.com</a> for more information.

1. Upload the `media-element-html5-video-and-audio-player` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the `Plugins` menu in WordPress
3. Use the `[video]` or `[audio]` shortcode in your post or page with the options on the front page.

== Changelog ==

= 1.1.5 =
* Updated to 1.1.5 version
* Added options to turn controls on/off
* Added loop option

= 1.1.2 =
* Updated to 1.1.2 version
* adds captions support and new style

= 1.1.0 =
* Updated to 1.1 of player

= 1.0.1 =
* Fixed URL bug
* Fixed non-src bugs

= 1.0 =
* First release.

== Upgrade Notice ==

None

== Frequently Asked Questions ==

= Where can I find out more? =

Check out <a href="http://mediaelementjs.com/">mediaElementjs.com</a> for more examples

= What does this get me over other HTML5 players? =

See original blog post at <a href="http://johndyer.name/post/MediaElement-js-a-magic-unicorn-HTML5-video-library.aspx">johndyer.name</a> for a full explanation of MediaElement.js

== Screenshots  ==

1. Video player