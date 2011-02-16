<?php
/*
Plugin Name: Quick Page/Post Redirect
Plugin URI: http://fischercreativemedia.com/wordpress-plugins/quick-pagepost-redirct-plugin/
Description: Redirect Pages or Posts to another page or post or external location quickly. Adds a redirect box to the page or post edit page where you can specify the redirect Location and type which can be to another WordPress page/post or an external URL. Additional 301 Redirects can also be added for non-existant posts or pages - helpful for sites converted to WordPress. Allows for redirects to open in a new window as well as giving you the ability to add the rel=nofollow to redirected links.
Author: Don Fischer
Author URI: http://www.fischercreativemedia.com/
Donate link: http://www.fischercreativemedia.com/wordpress-plugins/donate/
Version: 3.2.3

Version info:
See change log in readme.txt file.

    Copyright (C) 2009/2010 Donald J. Fischer

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//=======================================
// Redirect Class (for non page post redirects).
// Original Simple 301 Redirects Class created by Scott Nelle (http://www.scottnelle.com/)
//=======================================
	if (!class_exists("quick_page_post_redirects")) {
		class quick_page_post_redirects {
		
			//generate the link to the options page under settings
			function create_menu(){
			  add_options_page('Quick Redirects', 'Quick Redirects', 10, 'redirects-options', array($this,'options_page'));
			}
			
			//generate the options page in the wordpress admin
			function options_page(){
				$tohash = get_bloginfo('url').'/';

			?>
			<div class="wrap">
			<script type="text/javascript">
			jQuery(document).ready(function() {
				jQuery(".delete-qppr").click(function(){
					var mainurl = '<?php echo get_bloginfo('url');?>/';
					var thepprdel = jQuery(this).attr('id');
					if(confirm('Are you sure you want to delete this redirect?')){
						jQuery.ajax({ 
							url: mainurl+"/",
							data : "pprd="+thepprdel+"&scid=<?php echo md5($tohash);?>",
							success: function(data){
								jQuery('#row'+thepprdel).remove();
							}, 
							complete: function(){}
						});
						return false;
					}else{
						return false;
					}
				});
			});
			</script>
			<h2>Quick 301 Redirects</h2>
			<br/>This section is useful if you have links from an old site and need to have them redirect to a new location on the current site, or if you have an existing URL that you need to send some place else and you don't want to have a Page or Post created to use the other Page/Post Redirect option.
			<br/>
			<br/>To add additional 301 redirects, put the URL you want to redirect in the Request field and the Place you want it to redirect to, in the Destination field.
			<br/>To delete a redirect, empty both fields and save the changes.
			<br/>
			<br/><b>PLEASE NOTE:</b> The <b>Request</b> field MUST be relative to the ROOT directory and contain the <code>/</code> at the beginning. The <b>Destination</b> field can be any valid URL or relative path (from root).<br/><br/>
			<form method="post" action="options-general.php?page=redirects-options">
			<table>
				<tr>
					<th align="left">Request</th>
					<th align="left">Destination</th>
					<th align="left">&nbsp;</th>
				</tr>
				<tr>
					<td><small>example: <code>/about.htm</code> or <code>/test-directory/landing-zone/</code></small></td>
					<td><small>example: <code><?php echo get_option('home'); ?>/about/</code> or  <code><?php echo get_option('home'); ?>/landing/</code></small></td>
					<td>&nbsp;</td>
				</tr>
				<?php echo $this->expand_redirects(); ?>
				<tr>
					<td><input type="text" name="quickppr_redirects[request][]" value="" style="width:35em" />&nbsp;&raquo;&nbsp;</td>
					<td><input type="text" name="quickppr_redirects[destination][]" value="" style="width:35em;" /></td>
					<td></td>
				</tr>
			</table>
			
			<p class="submit">
			<input type="submit" name="submit_301" class="button-primary" value="<?php _e('Save Changes') ?>" />
			</p>
			</form>
			</div>
			
			<?php
			} // end of function options_page
			
			//utility function to return the current list of redirects as form fields
			function expand_redirects(){
				$redirects = get_option('quickppr_redirects');
				$output = '';
				if (!empty($redirects)) {
					$ww=1;
					foreach ($redirects as $request => $destination) {
						$output .= '
						<tr id="rowpprdel-'.$ww.'">
							<td><input type="text" name="quickppr_redirects[request][]" value="'.$request.'" style="width:35em" />&nbsp;&raquo;&nbsp;</td>
							<td><input type="text" name="quickppr_redirects[destination][]" value="'.$destination.'" style="width:35em;" /></td>
							<td>&nbsp;<a href="javascript:void();" id="pprdel-'.$ww.'" class="delete-qppr">x</a>&nbsp;</td>
						</tr>
						';
					$ww++;
					}
				} // end if
				return $output;
			}
			
			//save the redirects from the options page to the database
			function save_redirects($data){
				$redirects = array();
				
				for($i = 0; $i < sizeof($data['request']); ++$i) {
					$request = trim($data['request'][$i]);
					$destination = trim($data['destination'][$i]);
				
					if ($request == '' && $destination == '') { continue; }
					else { $redirects[$request] = $destination; }
				}
	
				update_option('quickppr_redirects', $redirects);
			}
			
			//Read the list of redirects and if the current page is found in the list, send the visitor on her way
			function redirect(){
				// this is what the user asked for
				$userrequest = str_replace(get_option('home'),'',$this->getAddress());
				$userrequest = rtrim($userrequest,'/');
				
				$redirects = get_option('quickppr_redirects');
				if (!empty($redirects)) {
					foreach ($redirects as $storedrequest => $destination) {
						// compare user request to each 301 stored in the db
						if($userrequest == rtrim($storedrequest,'/')) {
							header ('HTTP/1.1 301 Moved Permanently');
							header ('Location: ' . $destination);
							exit();
						}
						else { unset($redirects); }
					}
				}
			} // end funcion redirect
			
			//utility function to get the full address of the current request - credit: http://www.phpro.org/examples/Get-Full-URL.html
			function getAddress(){
				if(!isset($_SERVER['HTTPS'])){$_SERVER['HTTPS']='';}
				$protocol = $_SERVER['HTTPS'] == 'on' ? 'https' : 'http'; //check for https
				return $protocol.'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; //return the full address
			}
			
		} // end class quick_page_post_redirects
	} // end check for existance of class

// Call the 301 class (for non-existant 301 redirects)
	$redirect_plugin = new quick_page_post_redirects();

// Variables
//----------
	global $wpdb;
	global $wp_query;
	global $ppr_nofollow;
	global $ppr_newindow;
	global $ppr_url;
	global $ppr_url_rewrite;
	global $ppr_type;
	global $ppr_curr_version;
	global $ppr_metaurl;
	$ppr_curr_version = '3.2.1';
	$ppr_nofollow = array();
	$ppr_newindow = array();
	$ppr_url = array();
	$ppr_url_rewrite = array();
	
// Actions & Filters
//----------
	add_action('admin_menu', 'add_edit_box_ppr');
	add_action('save_post', 'ppr_save_postdata', 1, 2); // save the custom fields
	add_action('template_redirect','ppr_do_redirect', 1, 2);
	add_action('init', 'ppr_init_metaclean', 1);
	add_action('wp','ppr_new_nav_menu');
	add_action('plugin_action_links_' . plugin_basename(__FILE__), 'ppr_filter_plugin_actions');
	add_action('wp','ppr_parse_request');
	add_filter('query_vars','ppr_queryhook'); 
	add_filter('plugin_row_meta', 'ppr_filter_plugin_links', 10, 2);
	if (isset($redirect_plugin)) {
		add_action('init', array($redirect_plugin,'redirect'), 1); // add the redirect action, high priority
		add_action('admin_menu', array($redirect_plugin,'create_menu')); // create the menu
		if (isset($_POST['submit_301'])) {$redirect_plugin->save_redirects($_POST['quickppr_redirects']);} //if submitted, process the data
	}
	
// Functions
//----------
	function ppr_queryhook($vars) {
		$vars[] = 'pprd';
		$vars[] = 'scid';
		return $vars;
	}
	
	//Hook into the Query Parse and get our vars to see if the page is the one we want.
	function ppr_parse_request($wp) {
		global $wp;
		$quickppr_redirects = array();
		if(array_key_exists('pprd', $wp->query_vars) && array_key_exists('scid', $wp->query_vars)){
			$tohash = get_bloginfo('url').'/';
			if( $wp->query_vars['pprd'] !='' && $wp->query_vars['scid'] == md5(get_bloginfo('url').'/')){
				$theDel = str_replace('pprdel-','',$wp->query_vars['pprd']);
				$redirects = get_option('quickppr_redirects');
				if (!empty($redirects)) {
					$ww=1;
					foreach ($redirects as $request => $destination) {
						if($ww != (int)$theDel){
							$quickppr_redirects[$request]=$destination;
						}
					$ww++;
					}
				} // end if
				update_option('quickppr_redirects',$quickppr_redirects);
				echo 1;
				exit;
			}else{
				echo 0;
				exit;
			}
		}else{
			return;
		}

	}

	function ppr_filter_plugin_actions($links){
		$new_links = array();
		$fcmlink = 'http://www.fischercreativemedia.com/wordpress-plugins';
		$new_links[] = '<a href="'.$fcmlink.'/donate/">Donate</a>';
		return array_merge($links,$new_links );
	}
	function ppr_filter_plugin_links($links, $file){
		if ( $file == plugin_basename(__FILE__) ){
			$adminlink = get_bloginfo('url').'/wp-admin/';
			$fcmlink = 'http://www.fischercreativemedia.com/wordpress-plugins';
			$links[] = '<a href="'.$adminlink.'options-general.php?page=redirects-options">Quick Redirects</a>';
			$links[] = '<a target="_blank" href="'.$fcmlink.'/quick-pagepost-redirect-plugin/">FAQ</a>';
			$links[] = '<a target="_blank" href="'.$fcmlink.'/donate/">Donate</a>';
		}
		return $links;
	}
	
	function ppr_new_nav_menu($items){
		global $ppr_nofollow;
		global $ppr_newindow;
		global $ppr_url;
		global $ppr_url_rewrite;
		global $ppr_type;
		add_filter( 'wp_get_nav_menu_items','ppr_new_nav_menu_fix',1,1);
		add_filter( 'wp_list_pages','ppr_fix_targetsandrels');
		add_filter( 'page_link','ppr_filter_pages',20, 2 );
		add_filter( 'post_link','ppr_filter_pages',20, 2 );
		return $items;
	}
	
	function ppr_new_nav_menu_fix($ppr){
		global $ppr_nofollow;
		global $ppr_newindow;
		global $ppr_url;
		global $ppr_url_rewrite;
		global $ppr_type;
		global $wpdb;
		$thefirstppr = array();
		
		$select_tiems = $wpdb->get_results("SELECT post_id,meta_key,meta_value FROM $wpdb->postmeta WHERE (meta_key='_pprredirect_type' OR meta_key='_pprredirect_url' OR meta_key='_pprredirect_rewritelink' OR meta_key = '_pprredirect_active' OR meta_key='_pprredirect_newwindow' OR meta_key='_pprredirect_relnofollow') AND meta_value!='' ORDER BY post_id ASC;");
		if(!empty($select_tiems)){
			foreach($select_tiems as $pprs){
				$thefirstppr[$pprs->post_id][$pprs->meta_key] = $pprs->meta_value;
				$thefirstppr[$pprs->post_id]['post_id'] = $pprs->post_id;
			}
		}
		if(!empty($thefirstppr)){
			foreach($thefirstppr as $ppitems){
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_newwindow'])){
					$ppr_newindow[] = $ppitems['post_id'];
				}
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_relnofollow'])){
					$ppr_nofollow[] = $ppitems['post_id'];
				}
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_rewritelink']) && isset($ppitems['_pprredirect_url'])){
					$ppr_url_rewrite[] = $ppitems['post_id'];
					$ppr_url[$ppitems['post_id']]['URL'] = $ppitems['_pprredirect_url'];
				}
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_type'])){
					$ppr_type[$ppitems['post_id']]['type'] = $ppitems['_pprredirect_type'];
				}
			}
		}	
		$newmenu = array();
		if(!empty($ppr)){
			foreach($ppr as $ppd){
				if(in_array($ppd->object_id,$ppr_newindow)){
					$ppd->target = '_blank';
					$ppd->classes[] = 'ppr-new-window';
				}
				if(in_array($ppd->object_id,$ppr_nofollow)){
					$ppd->xfn = 'nofollow';
					$ppd->classes[] = 'ppr-nofollow';
				}
				if(in_array($ppd->object_id,$ppr_url_rewrite)){
					$ppd->url = $ppr_url[$ppd->object_id]['URL'];
					$ppd->classes[] = 'ppr-rewrite';

				}
				$newmenu[] = $ppd;
			}
		}
		return $newmenu;
	}
	
	function ppr_init_metaclean() {
		global $ppr_curr_version;
		$thepprversion = get_option('ppr_version');
		if($thepprversion != $ppr_curr_version){
			update_option( 'ppr_version', $ppr_curr_version );
		}
	}
	
	// For WordPress < 2.8 function compatibility
	if (!function_exists('esc_attr')) {
		function esc_attr($attr){return attribute_escape( $attr );}
		function esc_url($url){return clean_url( $url );}
	}
	
	function ppr_filter_pages ($link, $post) {
		global $ppr_nofollow;
		global $ppr_newindow;
		global $ppr_url;
		global $ppr_url_rewrite;
		global $ppr_type;
		global $wpdb;

		if(isset($post->ID)){	
			$id = $post->ID;
		}else{
			$id = $post;
		}
		if(is_array($ppr_url_rewrite)){
			if(in_array($id, $ppr_url_rewrite)){
				$newURL = $ppr_url[$id]['URL'];
				if(strpos($newURL,get_bloginfo('url'))>=0 || strpos($newURL,'www.')>=0 || strpos($newURL,'http://')>=0 || strpos($newURL,'https://')>=0){
					$link = esc_url( $newURL );
				}else{
					$link = esc_url( get_bloginfo('url').'/'. $newURL );
				}
			}
		}

		return $link;
	}

	function addmetatohead_theme(){
		global $ppr_metaurl;
		$meta_code = '<meta http-equiv="refresh" content="0; URL='.$ppr_metaurl.'" />';
		echo $meta_code;
		exit;//stop loading page so meta can do it's job without rest of page loading.
	}

	function ppr_do_redirect(){
		global $post,$wp_query,$ppr_active,$wpdb;
		$select_tiems = $wpdb->get_results("SELECT post_id,meta_key,meta_value FROM $wpdb->postmeta WHERE (meta_key='_pprredirect_type' OR meta_key='_pprredirect_url' OR meta_key = '_pprredirect_active') AND meta_value!='' ORDER BY post_id ASC;");
		if(!empty($select_tiems)){
			foreach($select_tiems as $pprs){
				$thefirstppr[$pprs->post_id][$pprs->meta_key] = $pprs->meta_value;
				$thefirstppr[$pprs->post_id]['post_id'] = $pprs->post_id;
			}
		}
		if(!empty($thefirstppr)){
			foreach($thefirstppr as $ppitems){
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_url'])){
					$ppr_url_rewrite[] = $ppitems['post_id'];
					$ppr_url[$ppitems['post_id']]['URL'] = $ppitems['_pprredirect_url'];
				}
				if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_type'])){
					$ppr_type[$ppitems['post_id']]['type'] = $ppitems['_pprredirect_type'];
				}
				
			}
		}		
		if($wp_query->is_single || $wp_query->is_page ):
			$thisidis_current = $post->ID;
			global $ppr_metaurl;
			if(isset($ppr_type[$thisidis_current]['type'])){$ppr_types	= $ppr_type[$thisidis_current]['type'];}else{$ppr_types	= '';}
			if(isset($ppr_url[$thisidis_current]['URL'])){$ppr_urls	= $ppr_url[$thisidis_current]['URL'];}else{$ppr_urls='';}
			
			if( $ppr_urls!=''):
				if($ppr_types===0){$ppr_types='200';}
				if($ppr_types===''){$ppr_types='302';}
					if($ppr_types=='meta'):
						//metaredirect
						$ppr_metaurl = $ppr_urls;
						add_action('wp_head', "addmetatohead_theme",1);
					else:
						//check for http:// - as full url - then we can just redirect if it is //
						if( strpos($ppr_urls, 'http://')=== 0 || strpos($ppr_urls, 'https://')=== 0){
							$offsite=$ppr_urls;
							header('Status: '.$ppr_types);
							header('Location: '.$offsite, true, $ppr_types);
							exit; //stop loading page
						}elseif(strpos($ppr_urls, 'www')=== 0){ //check if they have full url but did not put http://
							$offsite='http://'.$ppr_urls;
							header("Status: $ppr_types");
							header("Location: $offsite", true, $ppr_types);
							exit; //stop loading page
						}elseif(is_numeric($ppr_urls)){ // page/post number
							if($ppr_postpage=='page'){ //page
								$onsite=get_bloginfo('url').'/?page_id='.$ppr_url;
								header("Status: $ppr_types");
								header("Location: $onsite", true, $ppr_types);
								exit; //stop loading page
							}else{ //post
								$onsite=get_bloginfo('url').'/?p='.$ppr_urls;
								header("Status: $ppr_types");
								header("Location: $onsite", true, $ppr_types);
								exit; //stop loading page
							}
						//check permalink or local page redirect
						}else{	// we assume they are using the permalink / page name??
							$onsite=get_bloginfo('url'). $ppr_urls;
							header("Location: $onsite", true, $ppr_types);
							exit; //stop loading page
						}
						
					endif;
			endif;
		endif;
	}
	
	
//=======================================
// Add options to post/page edit pages
//=======================================
	// Adds a custom section to the Post and Page edit screens
	function add_edit_box_ppr() {
		if( function_exists( 'add_meta_box' )) {
			add_meta_box( 'edit-box-ppr', __( 'Quick Page/Post Redirect', 'ppr_plugin' ), 'edit_box_ppr_1', 'page', 'normal', 'high' ); //for page
			add_meta_box( 'edit-box-ppr', __( 'Quick Page/Post Redirect', 'ppr_plugin' ), 'edit_box_ppr_1', 'post', 'normal', 'high' ); //for post
		}
	}

	// Prints the inner fields for the custom post/page section 
	function edit_box_ppr_1() {
		global $post;
		$ppr_option1='';
		$ppr_option2='';
		$ppr_option3='';
		$ppr_option4='';
		$ppr_option5='';
		// Use nonce for verification ... ONLY USE ONCE!
		wp_nonce_field( 'pprredirect_noncename', 'pprredirect_noncename', false, true );

		// The actual fields for data entry
		echo '<label for="pprredirect_active" style="padding:2px 0;"><input type="checkbox" name="pprredirect_active" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_active',true),0).' />'. __(" Make Redirect <b>Active</b>. (check to turn on)", 'ppr_plugin' ) . '</label><br />';
		echo '<label for="pprredirect_newwindow" style="padding:2px 0;"><input type="checkbox" name="pprredirect_newwindow" id="pprredirect_newwindow" value="_blank" '. checked('_blank',get_post_meta($post->ID,'_pprredirect_newwindow',true),0).'>'. __(" Open redirect link in a <b>new window</b>.", 'ppr_plugin' ) . '</label><br />';
		echo '<label for="pprredirect_relnofollow" style="padding:2px 0;"><input type="checkbox" name="pprredirect_relnofollow" id="pprredirect_relnofollow" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_relnofollow',true),0).'>'. __(" Add <b>rel=\"nofollow\"</b> to redirect link.", 'ppr_plugin' ) . '</label><br />';
		echo '<label for="pprredirect_rewritelink" style="padding:2px 0;"><input type="checkbox" name="pprredirect_rewritelink" id="pprredirect_rewritelink" value="1" '. checked('1',get_post_meta($post->ID,'_pprredirect_rewritelink',true),0).'>'. __(" <b>Show</b> the Redirect URL below in the link instead of this page URL. <b>NOTE: You may have to use the <u>FULL</u> URL below!</b>", 'ppr_plugin' ) . '</label><br /><br />';
		echo '<label for="pprredirect_url">' . __(" <b>Redirect URL:</b>", 'ppr_plugin' ) . '</label><br />';
		if(get_post_meta($post->ID, '_pprredirect_url', true)!=''){$pprredirecturl=get_post_meta($post->ID, '_pprredirect_url', true);}else{$pprredirecturl="";}
		echo '<input type="text" style="width:75%;margin-top:2px;margin-bottom:2px;" name="pprredirect_url" value="'.$pprredirecturl.'" /><br />(i.e., <code>http://example.com</code> or <code>/somepage/</code> or <code>p=15</code> or <code>155</code>. Use <b>FULL URL</b> <i>including</i> <code>http://</code> for all external <i>and</i> meta redirects. )<br /><br />';
	
		echo '<label for="pprredirect_type">' . __(" Type of Redirect:", 'ppr_plugin' ) . '</label> ';
		if(get_post_meta($post->ID, '_pprredirect_type', true)!=''){$pprredirecttype=get_post_meta($post->ID, '_pprredirect_type', true);}else{$pprredirecttype="";}
		switch($pprredirecttype):
			case "":
				$ppr_option2=" selected";//default
				break;
			case "301":
				$ppr_option1=" selected";
				break;
			case "302":
				$ppr_option2=" selected";
				break;
			case "307":
				$ppr_option3=" selected";
				break;
			case "meta":
				$ppr_option5=" selected";
				break;
		endswitch;
		
		echo '<select style="margin-top:2px;margin-bottom:2px;width:40%;" name="pprredirect_type"><option value="301" '.$ppr_option1.'>301 Permanent</option><option value="302" '.$ppr_option2.'>302 Temporary</option><option value="307" '.$ppr_option3.'>307 Temporary</option><option value="meta" '.$ppr_option5.'>Meta Redirect</option></select> (Default is 302)<br /><br />';
		echo '<b>NOTE:</b> For This Option to work, the page or post needs to be published for the redirect to happen <i><b>UNLESS</b></i> you publish it first, then save it as a Draft. If you want to add a redirect without adding a page/post or having it published, use the <a href="./options-general.php?page=redirects-options">Quick Redirects</a> method.';
	}
	
	// When the post is saved, saves our custom data
	
	function ppr_save_postdata($post_id, $post) {
		if(isset($_REQUEST['pprredirect_noncename']) && (isset($_POST['pprredirect_active']) || isset($_POST['pprredirect_url']) || isset($_POST['pprredirect_type']) || isset($_POST['pprredirect_newwindow']) || isset($_POST['pprredirect_relnofollow']))):
			// verify authorization
			if(isset($_POST['pprredirect_noncename'])){
				if ( !wp_verify_nonce( $_REQUEST['pprredirect_noncename'], 'pprredirect_noncename' )) {
					return $post->ID;
				}
			}
		
			// check allowed to editing
			if ( 'page' == $_POST['post_type'] ) {
				if ( !current_user_can( 'edit_page', $post->ID ))
					return $post->ID;
			} else {
				if ( !current_user_can( 'edit_post', $post->ID ))
					return $post->ID;
			}
		
			// find & save the form data & put it into an array
			$mydata['_pprredirect_active'] 		= $_POST['pprredirect_active'];
			$mydata['_pprredirect_newwindow'] 	= $_POST['pprredirect_newwindow'];
			$mydata['_pprredirect_relnofollow'] = $_POST['pprredirect_relnofollow'];
			$mydata['_pprredirect_type'] 		= $_POST['pprredirect_type'];
			$mydata['_pprredirect_rewritelink'] = $_POST['pprredirect_rewritelink'];
			$mydata['_pprredirect_url']    		= stripslashes( $_POST['pprredirect_url']);
			
			if ( 0 === strpos($mydata['_pprredirect_url'], 'www.'))
				$mydata['_pprredirect_url'] = 'http://' . $mydata['_pprredirect_url'] ; // Starts with www., so add http://

			if($mydata['_pprredirect_url'] === ''){
				$mydata['_pprredirect_type'] = NULL; //clear Type if no URL is set.
				$mydata['_pprredirect_active'] = NULL; //turn it off if no URL is set
			}
			// Add values of $mydata as custom fields
			if(!empty($mydata)){
				foreach ($mydata as $key => $value) { //Let's cycle through the $mydata array!
					if( $post->post_type == 'revision' ) return; //don't store custom data twice
					$value = implode(',', (array)$value); //if $value is an array, make it a CSV (unlikely)
					
					if(get_post_meta($post->ID, $key, FALSE)) { //if the custom field already has a value
						update_post_meta($post->ID, $key, $value);
					} else { //if the custom field doesn't have a value
						add_post_meta($post->ID, $key, $value);
					}
					
					if(!$value) delete_post_meta($post->ID, $key); //delete if blank
				}
			}
		endif;
	}
	
	function ppr_fix_targetsandrels($pages) {
		global $post;
		global $ppr_nofollow;
		global $ppr_newindow;
		global $ppr_url;
		global $ppr_url_rewrite;
		global $wpdb;

		if (!$ppr_url && !$ppr_newindow && !$ppr_nofollow){
			$thefirstppr = array();
			$select_tiems = $wpdb->get_results("SELECT post_id,meta_key,meta_value FROM $wpdb->postmeta WHERE (meta_key='_pprredirect_type' OR meta_key='_pprredirect_url' OR meta_key='_pprredirect_rewritelink' OR meta_key = '_pprredirect_active' OR meta_key='_pprredirect_newwindow' OR meta_key='_pprredirect_relnofollow') AND meta_value!='' ORDER BY post_id ASC;");
			if(!empty($select_tiems)){
				foreach($select_tiems as $pprs){
					$thefirstppr[$pprs->post_id][$pprs->meta_key] = $pprs->meta_value;
					$thefirstppr[$pprs->post_id]['post_id'] = $pprs->post_id;
				}
			}
			if(!empty($thefirstppr)){
				foreach($thefirstppr as $ppitems){
					if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_newwindow'])){
						$ppr_newindow[] = $ppitems['post_id'];
					}
					if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_relnofollow'])){
						$ppr_nofollow[] = $ppitems['post_id'];
					}
					if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_rewritelink']) && isset($ppitems['_pprredirect_url'])){
						$ppr_url_rewrite[] = $ppitems['post_id'];
						$ppr_url[$ppitems['post_id']]['URL'] = $ppitems['_pprredirect_url'];
					}
					if(isset($ppitems['_pprredirect_active']) && isset($ppitems['_pprredirect_type'])){
						$ppr_type[$ppitems['post_id']]['type'] = $ppitems['_pprredirect_type'];
					}
				}
			}

			if (!$ppr_url && !$ppr_newindow && !$ppr_nofollow){
				return $pages;
			}
		}
		
		$this_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
		
		if(count($ppr_nofollow)>=1) {
			foreach($ppr_nofollow as $relid){
			$validexp="@\<li(?:.*?)".$relid."(?:.*?)\>\<a(?:.*?)rel\=\"nofollow\"(?:.*?)\>@i";
			$found = preg_match_all($validexp, $pages, $matches);
				if($found!=0){
					$pages = $pages; //do nothing 'cause it is already a rel=nofollow.
				}else{
					$pages = preg_replace('@<li(.*?)-'.$relid.'(.*?)\>\<a(.*?)\>@i', '<li\1-'.$relid.'\2><a\3 rel="nofollow">', $pages);
				}
			}
		}
		
		if(count($ppr_newindow)>=1) {
			foreach($ppr_newindow as $p){
				$validexp="@\<li(?:.*?)".$p."(?:.*?)\>\<a(?:.*?)target\=(?:.*?)\>@i";
				$found = preg_match_all($validexp, $pages, $matches);
				if($found!=0){
					$pages = $pages; //do nothing 'cause it is already a target=_blank.
				}else{
					$pages = preg_replace('@<li(.*?)-'.$p.'(.*?)\>\<a(.*?)\>@i', '<li\1-'.$p.'\2><a\3 target="_blank">', $pages);
				}
			}
		}

		return $pages;
	}
?>