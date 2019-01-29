<?php
add_action( 'admin_init', 'popup_settings_init' );
function popup_settings_init() {
	register_setting( 'popup_settings', 'popup_settings' );
}

add_action( 'admin_menu', 'wp_facebooks_popup_admin_menu' );
function wp_facebooks_popup_admin_menu() {
	add_options_page( 'Facebook Popup', 'Facebook Popup', 'manage_options', 'facebook_popup', 'popup_settings_content' );
}

function popup_settings_content() {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	} 
	$data = get_option('popup_settings') ;
	echo '<h2>DC - Facebook Like Popup Configuration</h2>';
	echo '<div class="wrap wp-facebook_popup">';				
		echo '<form method="post" action="options.php" >';
				settings_fields('popup_settings');
				do_settings_sections( 'popup_settings' );
				echo '<div style="margin: 30px 0 15px; padding: 5px; border: 1px solid #ddd; border-radius: 5px; position: relative;">';
					echo '<label style="font-weight: bold; position: absolute; left: 15px; top: -10px; background: #F1F1F1; padding: 0px 10px;">Enable / Disable</label>';
					echo '<div style="background: #DDDDDD; margin: 10px; padding: 10px; position: relative;">';
						echo popup_settings_get_control('checkbox',  false,  'Enable/Disable',  'popup_settings_enable_disable_plugin',  'popup_settings[enable_disable_plugin]',  (isset($data['enable_disable_plugin'])?$data['enable_disable_plugin']:''),  null, 'Enable/Disable The Plugin.');											echo '</div>';
				echo '</div>';
				echo '<div style="margin: 15px 0; padding: 5px; border: 1px solid #ddd; border-radius: 5px; position: relative;">';
					echo '<label style="font-weight: bold; position: absolute; left: 15px; top: -10px; background: #F1F1F1; padding: 0px 10px;">What to Display</label>';
					echo '<div style="background: #DDDDDD; margin: 10px; padding: 10px; position: relative;">';
						echo popup_settings_get_control('text',  false,  'Title Text',  'popup_settings_title_text',  'popup_settings[title_text]',  (isset($data['title_text'])?$data['title_text']:'Follow us on Facebook!'));
						echo '</div>';
				echo '</div>';
				echo '<div style="margin: 15px 0; padding: 5px; border: 1px solid #ddd; border-radius: 5px; position: relative;">';
					echo '<label style="font-weight: bold; position: absolute; left: 15px; top: -10px; background: #F1F1F1; padding: 0px 10px;">Where to Display</label>';
					echo '<div style="background: #DDDDDD; margin: 10px; padding: 10px; position: relative;">';
						echo popup_settings_get_control('checkbox',  false,  'Show In Home',  'popup_settings_show_in_home',  'popup_settings[show_in_home]',  (isset($data['show_in_home'])?$data['show_in_home']:''),  null, 'Whether To Show popup In Home.');
						echo popup_settings_get_control('checkbox',  false,  'Show Everywhere Else',  'popup_settings_show_everywhere',  'popup_settings[show_everywhere]',  (isset($data['show_everywhere'])?$data['show_everywhere']:''),  null, 'Whether to Show popup Everywhere.');
				echo '<p class="submit" style="text-align: center"><input type="submit" style="font-weight: bold; height: auto; font-size: 20px; padding: 10px 0px; width: 220px;" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>';
		echo '</form>';	
	echo '</div>';
}
?>