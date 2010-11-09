<?php
/*
	Plugin Name: Simple "Coming soon" And "Under construction"
	Plugin URI: http://mariokostelac.com/
	Description: A brief description of the Plugin.
	Version: 1.0.1
	Author: Mario Kostelac
	Author URI: http://mariokostelac.com
	License: GPL2
*/
/*  Copyright 2010  Mario Kostelac  (email : mario.kostelac@gmail.com)

	This program is free software; you can redistribute it and/or modify
	it under the terms of the GNU General Public License, version 2, as 
	published by the Free Software Foundation.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program; if not, write to the Free Software
	Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

	define( 'SCS_THEMES_DIR', 'themes' );
	define( 'SCS_PLUGIN_URL', WP_PLUGIN_URL . '/' . basename ( dirname ( __FILE__ ) ) . '/' );

	add_action( 'template_redirect', 'scs_template_redirect' );
	add_action( 'admin_menu', 'scs_admin_menu' );
	register_deactivation_hook( __FILE__, 'scs_deactivate' );
	
	include_once 'functions.php';
	include_once 'page-options.php';
	
	/**
	 * Function called on WP hook scs_admin_menu
	 * Adds options submenu
	 */
	function scs_admin_menu()
	{
		// follow page-options.php
		$page = add_options_page('Simple Coming Soon and Under Construction', 'Simple Coming Soon', 'manage_options', 'simple_coming_soon', 'scs_manage_options');
		add_action( "admin_print_styles-$page", 'scs_admin_head' );
	}
	
	/**
	 * Enqueues required css and js files only to plugin's page
	 */
	function scs_admin_head()
	{	
		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-tabs' );
		wp_enqueue_script( 'coming-soon', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/js/init.js' );
		wp_enqueue_style( 'coming-soon', WP_PLUGIN_URL.'/'.basename(dirname(__FILE__)).'/css/admin.css' );
	}
	
	/**
	 * Deactivation function for this plugin
	 * ATM, it just deletes the option row from DB
	 */
	function scs_deactivate()
	{
		return delete_option( basename(dirname(__FILE__)) );
	}

?>
