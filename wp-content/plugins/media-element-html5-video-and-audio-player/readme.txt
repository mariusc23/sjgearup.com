=== MediaElement.js - HTML5 Video & Audio Player ===
Contributors: johndyer
Donate link: http://mediaelementjs.com/
Tags: html5, video, audio, player, flash, Silverlight, javascript, mp4, mp3, ogg, webm, wmv
Requires at least: 2.8
Tested up to: 3.0.1
Stable tag: 1.0

MediaElement.js is an HTML5 video and audio player with Flash fallback. Supports IE, Firefox, Opera, Safari, Chrome and iPhone, iPad, Android.

== Description ==

A video plugin for WordPress built on the MediaElement.js HTML5 video and audio player library. Provides Flash or Silverlight fallback players for non-HTML5 browsers and also supports iPhone, iPad, and Andriod.
Supports MP4, OGG, WebM, WMV, MP3, WAV, WMA files.

Check out <a href="http://mediaelementjs.com/">mediaElementjs.com</a> for more information and examples.

### Typical Usage for video

	[video src="http://mysite.com/mymedia.mp4" width="640" height="360"]

###  Video Shortcode Options

= src =
This location of any audio or video file
    
    [video src="http://mysite.com/mymedia.mp4"]

= mp4 =
The location of the h.264/MP4 source for the video.
    
    [video mp4="http://mysite.com/mymedia.mp4"]

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
The width of the video or audio

    [video width="640"]

= height =
The height of the video or audio

    [video height="264"]

= preload =
Start loading the video as soon as possible, before the user clicks play.

    [video preload="true"]

= autoplay =
Start playing the video as soon as it's ready.

    [video autoplay="true"]

= Simple Video =
Basic playback options

    [video src="http://mysite.com/mymedia.mp4" width="640" height="360"]

= All Attributes Video =
All options enabled

    [video mp4="http://mysite.com/mymedia.mp4" ogg="http://mysite.com/mymedia.ogg" webm="http://mysite.com/mymedia.webm" poster="http://mysite.com/mymedia.png" preload="true" autoplay="true" width="640" height="264"]

### Audio Shortcode Options 

= src =
This location of any audio file
    
    [audio src="http://mysite.com/mymedia.mp3"]

= mp3 =
The location of the MP3 audio source.

    [audio mp3="http://mysite.com/mymedia.mp3"]

= ogg =
The location of the Vorbis/Ogg source for the audio 

    [video ogg="http://mysite.com/mymedia.ogg"]

= webm =
The location of the VP8/WebM source for the audio 

    [video ogg="http://mysite.com/mymedia.webm"]

= preload =
Start loading the audio as soon as possible, before the user clicks play.

    [video preload="true"]

= autoplay =
Start playing the audio as soon as it's ready.

    [video autoplay="true"]

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