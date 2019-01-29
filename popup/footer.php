<?php
add_action( 'wp_enqueue_scripts', 'popup_wp_enqueue_scripts' );
function popup_wp_enqueue_scripts() {
	wp_enqueue_script('jQuery');
}

add_action('init', 'popup_init');
function popup_init() {
	global $hidefbpopup;
	$hidefbpopup= false;
}

add_shortcode('hidefbpopup', 'popup_shortcode_hidefbpopup');
function popup_shortcode_hidefbpopup() {
	global $hidefbpopup;
	if(is_singular()) {	
		$hidefbpopup= true;
	}
}

add_action('wp_footer', 'popup_show');
function popup_show() {
	global $hidefbpopup;
	$data = get_option('popup_settings');
	if(isset($data['enable_disable_plugin']) && (!$hidefbpopup)) {
		$displayPopup = false;
		
		/*Begin Where to Show*/
		if((is_home() || is_front_page())) { //Show in Home Page
			if(isset($data['show_in_home'])) {
				$displayPopup = true;
			}
		} else if(is_single()) { //Show in Single Post
			if(isset($data['show_in_post'])) {
				$displayPopup = true;
			}
		} else if(is_page()) { //Show in Single Page
			if(isset($data['show_in_page'])) {
				$displayPopup = true;
			}
		} else {
			if(isset($data['show_everywhere'])) {
				$displayPopup = true;
			}
		}
		/*End Where to Show*/
		
		/*Begin When to Show*/
		if($displayPopup) {
			if(is_user_logged_in()) {
				if(isset($data['show_loggedin_users'])) {
					$displayPopup = true;
				} else {
					$displayPopup = false;
				}
			} else {
				if(isset($data['show_loggedout_users'])) {
					$displayPopup = true;
				} else {
					$displayPopup = false;
				}
			}
		}
		/*End When to Show*/
		if($displayPopup) {
			echo '<script type="text/javascript" src="'.POPUP_URL.'/js/jquery.colorbox-min.js"></script>';
			echo '<link rel="stylesheet" href="'.POPUP_URL.'/css/style.css" />';
			echo '<script type="text/javascript">'."\r\n";
			echo 'jQuery(document).ready(function() {'."\r\n";
				echo 'if('.((isset($data['appear_always']))?'1':'document.cookie.indexOf("visited=true") == -1').') {'."\r\n";
					echo 'var expires = new Date((new Date()).valueOf() + 1000*60*60*24*'.(isset($data['days_until_popup_shows_again'])?$data['days_until_popup_shows_again']:'1').');'."\r\n";
					echo 'document.cookie = "visited=true;expires=" + expires.toUTCString();'."\r\n";
					echo 'setTimeout(function() {'."\r\n";
						echo 'jQuery.colorbox({width:"400px", inline:true, href:"#subscribe", '.((isset($data['lock_scroll']))?'onOpen: function() { jQuery("body").css("overflow", "hidden"); }, onClosed: function() { jQuery("body").css("overflow", "auto"); }':'').'});'."\r\n";
					echo '}, '.(isset($data['seconds_popup_appear'])?$data['seconds_popup_appear']:'0').' * 1000);'."\r\n";					
				echo '}'."\r\n";
			echo '});'."\r\n";
			echo '</script>'."\r\n";
			echo '<div style="display:none">';
				echo '<div id="subscribe" style="padding: 10px; background: #fff;">';
					echo '<h3 class="box-title">'.(isset($data['title_text'])?$data['title_text']:'yeet').'</h3>';
					 /* if(isset($data['show_author_link'])) {
						echo '<div align=left style="font-size:10px;">';
							$link = generateLink();
							echo $link;
						echo '</div>';
					}*/ 
				echo '</div>';
			echo '</div>';
		}
	}
}


?>