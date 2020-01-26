<?php
/*
Plugin Name: PopUpNearExit
Plugin URI: https://www.shashank.com/
Description: Whenever the mouse is moved  to the exit for the first time, the user customized popup appears and prompts the visitor to 
perform the function that the owner of the website wants. The owner can add his own code and add 
his own functionalities to the popup.
Author: Shashank
Author URI: shashanks.sgedu.site/wordpress10/
Version: 1.0
License: GPLv2
*/

if ( ! defined( 'ABSPATH' ) )
	exit;

function exit_popup_menu() {
	add_options_page('Pop Up Near Exit Settings', 'Pop Up Near Exit', 'administrator', 'exit-popup-settings', 'exit_popup_settings_page', 'dashicons-admin-generic');
}
add_action('admin_menu', 'exit_popup_menu');

function exit_popup_settings_page() { ?>
<div class="wrap">
<h2>Pop Up Near Exit Settings</h2>
<p>PopUpNearExit is </p>
<form method="post" action="options.php">
    <?php
	settings_fields( 'exit-popup-settings' );
	do_settings_sections( 'exit-popup-settings' );
	?>
    <table class="form-table">
		<tr valign="top">
			<th scope="row">Number of days that the cookie should expire in</th>
			<td>
				<input type="text" size="10" name="exit_popup_cookie_expire" value="<?php echo esc_attr( get_option('exit_popup_cookie_expire') ); ?>" /><br /><small>Ex. 10 (Set -1 for per session)</small>
			</td>
			</tr>
        <tr valign="top">
			<th scope="row">Prevent Close on Click Outside of Modalbox</th>
			<td>
				<input type="checkbox" name="exit_popup_click_outside" value="true" <?php echo ( get_option('exit_popup_click_outside') == true ) ? ' checked="checked" />' : ' />'; ?> <br /><small>Available options: true, false</small>
			</td>
		</tr>
		<tr valign="top">
			<th scope="row">Modal Width (px or %)</th>
			<td>
				<input type="text" size="10" name="exit_popup_modal_width" value="<?php echo esc_attr( get_option('exit_popup_modal_width') ); ?>" /><br /><small>Ex. 500px or 50%</small>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row">Modal Height (px or %)</th>
			<td>
				<input type="text" size="10" name="exit_popup_modal_height" value="<?php echo esc_attr( get_option('exit_popup_modal_height') ); ?>" /><br /><small>Ex. 300px or 50%</small>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row"> Select the Title Background Color </th>
			<td>
				<input type="text" size="10" name="exit_popup_popup_title_color" value="<?php echo esc_attr( get_option('exit_popup_popup_title_color') ); ?>" /><br /><small>Ex. 2e363f</small>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row">Title (Text)</th>
			<td>
				<input type="text" size="40" name="exit_popup_popup_title" value="<?php echo esc_attr( get_option('exit_popup_popup_title') ); ?>" /><br /><small>Ex. Don`t Leave Yet!</small>
			</td>
		</tr>
        <tr valign="top">
			<th scope="row">Footer (Text)</th>
			<td>
				<input type="text" size="40" name="exit_popup_popup_footer" value="<?php echo esc_attr( get_option('exit_popup_popup_footer') ); ?>" /><br /><small>Ex. Thank You!</small>
			</td>
        </tr>
        <tr valign="top">
			<th scope="row">Body and CSS edit option (HTML)</th>
			<td>
				<textarea rows="10" cols="100" name="exit_popup_popup_body"><?php echo esc_html( get_option('exit_popup_popup_body') ); ?>
			</textarea>
				<small>
				<xmp>
				HTML code example:

				<style>
				.discount-box  {
					font-size: 2em;
					font-weight: bold;
					display: inline;
					background: #ec971f;
					color: #fff;
					padding: 20px;
					padding-left: 5px;
					padding-right: 5px;;
					box-shadow: 10px 0 0 #666666, -10px 0 0 #666666;
					align: center;
				}
				</style>
				<center>
				<h4>Best Offer</h4>
				<p style="padding-top: 20px"></p>
				<p><span class="discount-box">3 For The Price Of 2!</span></p>
				<p style="padding-top: 20px"></p>
				<p><small>The offer is available to all.</small></p>
				</center>
				</xmp>
				</small>
			</td>
		</tr>
		<?php if( array_key_exists( 'wpml_object_id' , $GLOBALS['wp_filter']) ): // check for WPML ?>
 		 <tr valign="top">
 		   <th scope="row"><?php _e('Enabled language','exitpp');?></th>
  		  <td>
 		     <?php $languages = apply_filters( 'wpml_active_languages', NULL, 'orderby=id&order=desc' );
 		           $enabled_languages = get_option('exit_popup_languages');
 		     foreach ($languages as $key => $value) : ?>
 		       <label style="padding-right: 15px;"><input type="checkbox" name="exit_popup_languages[<?php echo $key;?>]" value="<?php echo $key; ?>" <?php checked( $key, $enabled_languages[$key], true); ?> />&nbsp;<?php echo $value['native_name']; ?></label>
 		     <?php endforeach; ?>
 		   </td>
  		</tr>
		<?php endif; ?>
    </table>
    <?php
	submit_button();
	?>
</form>
</div>
<?php }

function exit_popup_settings() {
	register_setting( 'exit-popup-settings', 'exit_popup_cookie_expire' );
	register_setting( 'exit-popup-settings', 'exit_popup_click_outside' );
	register_setting( 'exit-popup-settings', 'exit_popup_modal_width' );
	register_setting( 'exit-popup-settings', 'exit_popup_modal_height' );
	register_setting( 'exit-popup-settings', 'exit_popup_popup_title_color' );
	register_setting( 'exit-popup-settings', 'exit_popup_popup_title' );
	register_setting( 'exit-popup-settings', 'exit_popup_popup_body' );
	register_setting( 'exit-popup-settings', 'exit_popup_popup_footer' );
	register_setting( 'exit-popup-settings', 'exit_popup_languages' );
}
add_action( 'admin_init', 'exit_popup_settings' );

function exit_popup_deactivation() {
    delete_option( 'exit_popup_cookie_expire' );
    delete_option( 'exit_popup_click_outside' );
    delete_option( 'exit_popup_modal_width' );
    delete_option( 'exit_popup_modal_height' );
    delete_option( 'exit_popup_popup_title_color' );
    delete_option( 'exit_popup_popup_title' );
    delete_option( 'exit_popup_popup_body' );
    delete_option( 'exit_popup_popup_footer' );
	delete_option( 'exit_popup_languages' );
}
register_deactivation_hook( __FILE__, 'exit_popup_deactivation' );

function exit_popup_dependencies() {
	wp_register_script( 'exit-popup-js', plugins_url('js/exit-popup.js', __FILE__), array('jquery'), time(), false );
	wp_enqueue_script( 'exit-popup-js' );
	wp_register_style( 'exit-popup-css', plugins_url('css/exit-popup.css', __FILE__) );
	wp_enqueue_style( 'exit-popup-css' );
}
add_action( 'wp_enqueue_scripts', 'exit_popup_dependencies' );

function exit_popup() {
	
	// Check for language
	$check_lg = true;
	if( array_key_exists( 'wpml_object_id' , $GLOBALS['wp_filter']) ) {
		$epp_lg = get_option('exit_popup_languages');
  
		$current_lg = ICL_LANGUAGE_CODE;
  
		$check_lg = false;
  
		if( in_array($current_lg, $epp_lg) ) $check_lg = true;
	}
	
	if($check_lg && !isset($_COOKIE['viewedExitPopupWP']) && $_COOKIE['viewedExitPopupWP'] != 'true') {
		
	if(esc_attr( get_option('exit_popup_click_outside') ) == "true") {
		$exit_popup_click_outside = "";
	} else {
		$exit_popup_click_outside = "
      $('body').on('click', function() {
        $('#exitpopup-modal').hide();
      });
		";
	}
?>
<!-- Exit Popup -->
    <div id='exitpopup-modal'>
      <div class='underlay'></div>
	  <div class='exitpopup-modal-window' style='width:<?php echo esc_attr( get_option('exit_popup_modal_width') ); if (preg_match('(px|%)', esc_attr( get_option('exit_popup_modal_height') )) !== 1) { echo 'px'; } ?> !important; height:<?php echo esc_attr( get_option('exit_popup_modal_height') ); if (preg_match('(px|%)', esc_attr( get_option('exit_popup_modal_height') )) !== 1) { echo 'px'; } ?> !important;'>
        <div class='modal-title' style='background-color:#<?php echo esc_attr( get_option('exit_popup_popup_title_color') ); ?> !important;'>
          <h3><?php echo esc_attr( get_option('exit_popup_popup_title') ); ?></h3>
        </div>
        <div class='modal-body'>
			<?php echo do_shortcode(get_option('exit_popup_popup_body')); ?>
        </div>
        <div class='exitpopup-modal-footer'>
          <p><?php echo esc_attr( get_option('exit_popup_popup_footer') ); ?></p>
        </div>
      </div>
    </div>

	<script type='text/javascript'>
	  jQuery(document).ready(function($) {
      var _exitpopup = exitpopup(document.getElementById('exitpopup-modal'), {
        aggressive: true,
        timer: 0,
		sensitivity: 20,
		delay: 0,
        sitewide: true,
		cookieExpire: <?php echo esc_attr( get_option('exit_popup_cookie_expire') ); ?>,
        callback: function() { console.log('exitpopup fired!'); }
      });

      <?php echo $exit_popup_click_outside; ?>
      $('#exitpopup-modal .exitpopup-modal-footer').on('click', function() {
        $('#exitpopup-modal').hide();
      });
      $('#exitpopup-modal .exitpopup-modal-window').on('click', function(e) {
        e.stopPropagation();
      });
      });
	</script>
<!-- End  -->
<?php
	}//if viewedExitPopupWP
	}//function exit_popup
add_action( 'wp_footer', 'exit_popup', 10 );