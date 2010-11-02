<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">
        <div id="footer-bar"></div>

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>
		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
<!-- javascript for the carousel container -->
<script>
$(document).ready(function() {
	var $list_items = $('#carousel-list li'), $list_carousels = $('.carousel-container'), $current_list = $list_carousels.first(),
		$current_header = $('#carousel-image-link'),
		$current_header_clone = $('#carousel-image-link').clone(),
		$current_header_image,
		last_shown_index = 0,
		speed = 'default',
		AUTO_SCROLL_SPEED = 6000,
		auto_scroll_timeout = null;

	$current_header_clone.attr('id', 'carousel-image-link-clone');
	$current_header_clone.prependTo('#carousel');
	// marking the first active image
	$current_header_image = $current_list.find('.carousel-img').first();
	$current_header_image.addClass('active');
	$list_items.click(function () {
		var which_to_show = $list_items.index($(this)), $links;
		// don't do anything if it's already showing
		if (which_to_show === last_shown_index) {
			return false;
		}
		$list_items.removeClass('active');
		$(this).addClass('active');
		last_shown_index = which_to_show;
		// hide all of the carousels
		$list_carousels.hide();
		// make the old stuff inactive
		$current_list.find('.carousel-img').removeClass('active');
		// show the one we clicked on
		$current_list = $list_carousels.eq(which_to_show);
		$current_list.fadeIn(speed);
		// make the first link active
		$links = $current_list.find('.carousel-img');
		$links.removeClass('active');
		$links.first().addClass('active');

		// change the large header image
		$current_header_image = $current_list.find('.carousel-img');
		change_current_header($current_header_image.first());
		clearTimeout(auto_scroll_timeout);
		auto_scroll_timeout = setTimeout(auto_scroll_carousel, AUTO_SCROLL_SPEED);
		return false;
	});
	
	function change_current_header($carousel_img) {
		var $tmp, current_index,
			$images = $current_list.find('.carousel-img'), $stories,
			CAROUSEL_IMAGE_COUNT = $images.length;
		// when the image changes, also change the story in .carousel-desc
		$current_header_image = $carousel_img;
		current_index = $images.index($current_header_image);
		$stories = $carousel_img.parents('.carousel-container').find('.carousel-desc');
		$stories.hide();
		$stories.eq(current_index).show();
		// make the clone point to the next one
		$current_header_clone.find('img').attr('src', $carousel_img.find('img').attr('src'));
		$current_header_clone.attr('href', $stories.eq(current_index).find('a').attr('href'));
		$current_header_clone.css('z-index', '-50');
		$current_header_clone.hide();
		$current_header.css('z-index', '-60');
		$current_header.fadeOut(speed);
		$current_header_clone.fadeIn(speed);
		// swap header and clone
		$tmp = $current_header_clone;
		$current_header_clone = $current_header;
		$current_header = $tmp;
	}
	
	$('#carousel .carousel-img').click(function () {
		if ($(this).hasClass('active')) {
			return false;
		}
		$(this).parents('.carousel-stories').find('.carousel-img').removeClass('active');
		change_current_header($(this));
		$(this).addClass('active');
		clearTimeout(auto_scroll_timeout);
		auto_scroll_timeout = setTimeout(auto_scroll_carousel, AUTO_SCROLL_SPEED);
		return false;
	});
	
	function auto_scroll_carousel(arg1, first_call) {
		if (first_call !== undefined) {
			setTimeout(auto_scroll_carousel, AUTO_SCROLL_SPEED);
			return false;
		}
		var $images = $current_list.find('.carousel-img'),
			CAROUSEL_IMAGE_COUNT = $images.length,
			current_index = $images.index($current_header_image),
			next_index = (current_index + 1) % CAROUSEL_IMAGE_COUNT;
		$images.eq(next_index).click();
	}
	auto_scroll_carousel(true, true);
});
</script>
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-19454061-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</body>
</html>
