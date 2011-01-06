<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<title><?php
	/*
	 * Print the <title> tag based on what is being viewed.
	 */
	global $page, $paged;
	$FEATURED_CATEGORIES = array(15, 16, 17, 18);

	wp_title( '|', true, 'right' );

	// Add the blog name.
	bloginfo( 'name' );

	// Add the blog description for the home/front page.
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";

	// Add a page number if necessary:
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'twentyten' ), max( $paged, $page ) );

	?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="shortcut icon" href="<?php bloginfo('template_directory'); ?>/favicon.ico" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php
	wp_enqueue_script( 'jquery' );
	/* We add some JavaScript to pages with the comment form
	 * to support sites with threaded comments (when in use).
	 */
	if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );

	/* Always have wp_head() just before the closing </head>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to add elements to <head> such
	 * as styles, scripts, and meta tags.
	 */
	wp_head();
?>
</head>

<body <?php body_class(); ?>>
<div id="menu-wrapper" class="hfeed">
			<div id="access" role="navigation">
			  <?php /*  Allow screen readers / text browsers to skip the navigation menu and get right to the good stuff */ ?>
				<div class="skip-link screen-reader-text"><a href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentyten' ); ?>"><?php _e( 'Skip to content', 'twentyten' ); ?></a></div>
				<?php /* Our navigation menu.  If one isn't filled out, wp_nav_menu falls back to wp_page_menu.  The menu assiged to the primary position is the one used.  If none is assigned, the menu with the lowest ID is used.  */ ?>
				<?php wp_nav_menu( array( 'container_class' => 'menu-header', 'theme_location' => 'primary' ) ); ?>
					<div id="site-title">
						<a class="title-link" href="<?php echo home_url( '/' ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
					</div>
				</<?php echo $heading_tag; ?>>
			</div><!-- #access -->
			<br class="clear" />	
</div><!-- #menu-wrapper -->
<?php if (is_singular()) { ?>
	<?php
		$categories = get_the_category($post->ID);
		$category_ids = array();
		foreach ($categories as $category) {
			$category_ids[] = $category->term_id;
		}
		if (count(array_intersect($category_ids, $FEATURED_CATEGORIES))): ?>
            <div id="carousel-bg" class="mini-carousel-bg">
                <div id="carousel">
                	<?php $featured_posts = get_featured_posts_in_category($category_ids[0]);
                    header_featured_posts($featured_posts); ?>
                </div><!-- #mini-carousel -->
            </div><!-- #mini-carousel-bg -->
		<?php endif; ?>
<?php } else { ?>
<div id="carousel-bg">
    <div id="carousel">
    	<?php // get the first post of the first category
			$first_category_posts = get_featured_posts_in_category($FEATURED_CATEGORIES[0]);
			$image_src = wp_get_attachment_image_src(get_post_thumbnail_id( $first_category_posts[0]->ID ), 'post-thumbnail');
			$image_src = $image_src[0];
		?>
    	<a id="carousel-image-link" href="<?php echo get_permalink($featured_posts[0]); ?>"><img src="<?php echo $image_src; ?>" height="420px" width="960px" alt="Description." /></a>
        <div id="carousel-menu">
			<ul id="carousel-list">
            	<li class="odd active"><a href="#" title="Top stories and current events from around the world."><h4>Top Stories</h4></a></li>
            	<li class="even"><a href="#" title="Health and wellness articles."><h4>Health</h4></a></li>
            	<li class="odd"><a href="#" title="All about sports."><h4>Sports</h4></a></li>
            	<li class="even"><a href="#" title="Useful articles on technology."><h4>Tech</h4></a></li>
            </ul>
        </div><!-- #carousel-menu -->
        <br class="clear" />
        <?php $first_category = true;
		foreach ($FEATURED_CATEGORIES as $category_id):
			if ($first_category) {
				$carousel_posts = $first_category_posts;
			} else {
				$carousel_posts = get_featured_posts_in_category($category_id);
			}
			header_featured_posts($carousel_posts, $first_category);
        	$first_category = false;
		endforeach; ?>
    </div><!-- #carousel -->
</div><!-- #carousel-bg --><?php } ?>
<div id="wrapper" class="hfeed">
	<div id="header">
	</div><!-- #header -->
	<div id="graybar"></div><!-- #graybar -->
	<div id="main">
