<?php
/* 
Plugin Name: pop-up
Version: 1.0
Description: dit is voor een popup met text
*/
if(!defined('POPUP_URL'))
	define('POPUP_URL',WP_PLUGIN_URL.'/popup');
require_once (dirname(__FILE__).'/settings.php');
require_once (dirname(__FILE__).'/controls.php');
require_once (dirname(__FILE__).'/footer.php');
/* Begin MCE Button */
add_action('admin_enqueue_scripts', 'popup_admin_enqueue_scripts');
function popup_admin_enqueue_scripts() {
	wp_enqueue_style('popup', POPUP_URL.'/css/mce.css');
}

add_action('init', 'popup_admin_head');
function popup_admin_head() {
	if(!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
		return;
	}
	if('true' == get_user_option('rich_editing')) {
		add_filter('mce_external_plugins', 'popup_mce_external_plugins');
		add_filter('mce_buttons', 'popup_mce_buttons');
	}
}

function popup_mce_external_plugins($plugin_array) {
	$plugin_array['popup'] = POPUP_URL.'/js/mce.js';
	return $plugin_array;	 
}

function popup_mce_buttons($buttons) {
	array_push($buttons, 'popup');
	return $buttons;
}
/* End MCE Button */
?>