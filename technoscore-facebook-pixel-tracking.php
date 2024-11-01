<?php
/*
Plugin Name: Technoscore Facebook Pixel Tracking
Plugin URI: http://nddw.com/demo3/sws-res-slider/
Description: This plugin adds Facebook Pixel Tracking code to header part of Selected/All webpages.
Version:  1.0.0
Author: Technoscore
Author URI: http://www.technoscore.com/
Text Domain: techno_
*/

add_action('admin_menu', 'techno_fb_pixel_tracking');

function techno_fb_pixel_tracking() {

	//create new top-level menu
	add_menu_page('Facebook Pixel Tracking', 'Facebook Pixel Tracking', 'administrator', __FILE__, 'techno_fb_pixel_tracking_page');
	
		//call register settings function
	add_action( 'admin_init', 'techno_fb_pixel_tracking_register_settings' );
}


function techno_fb_pixel_tracking_register_settings() {
	//register our settings
	register_setting( 'techno-settings-group', 'techno_fb_pixel_page_id' );
	register_setting( 'techno-settings-group', 'techno_fb_pixel_script' );
	
}

function techno_show_fb_pixel(){
global $post;
$techno_fb_pixel_script = esc_attr( get_option('techno_fb_pixel_script') );
$techno_fb_pixel_page_id_empty = esc_attr( get_option('techno_fb_pixel_page_id') );
if(!empty($techno_fb_pixel_script)){
	if(!empty($techno_fb_pixel_page_id_empty)){
	$techno_fb_pixel_page_id = explode(',',get_option('techno_fb_pixel_page_id'));
		if(count($techno_fb_pixel_page_id)>0){
			if(in_array($post->ID,$techno_fb_pixel_page_id)){
				echo get_option('techno_fb_pixel_script'); 
			}
		}
	}else{
	echo get_option('techno_fb_pixel_script');
	}
}

}
add_action('wp_head','techno_show_fb_pixel',999);

function techno_fb_pixel_tracking_page() {

?>
<div class="wrap">
<h1>Facebook Pixel Integration</h1>
<form method="post" action="options.php">
    <?php settings_fields( 'techno-settings-group' ); ?>
    <?php do_settings_sections( 'techno-settings-group' ); ?>
    <table class="form-table">

        <tr valign="top">
        <th scope="row">List Of Page Ids</th>
        <td><input type="text" name="techno_fb_pixel_page_id" class="regular-text code" value="<?php echo esc_attr( get_option('techno_fb_pixel_page_id') ); ?>" />&nbsp; ex: 2,3,139,101 or leave blank to apply facebook pixel code on all pages</td>
        </tr>  
		
		<tr valign="top">
        <th scope="row">Facebook Pixel Script</th>
        <td>
		<textarea name="techno_fb_pixel_script" cols="100" rows="20" ><?php echo esc_attr( get_option('techno_fb_pixel_script') ); ?></textarea></td>
        </tr>  


		
    </table>
    <?php submit_button(); ?>
</form>
</div>

<?php } ?>