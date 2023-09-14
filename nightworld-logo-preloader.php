<?php
/*
Plugin Name: Nightworld Logo Preloader
Description: A simple, well-designed, customizable logo preloader
Author: Nightworld Design
Author URI: https://www.nightworldonline.com/wordpress-plugins/nw-logo-preloader
Version: 1.0
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Text Domain:nw-logo-preloader

NW Logo Preloader - Animated CSS3 Preloader for WordPress
Copyright (C) 2017  Nightworld Design

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


function nw_admin_theme_style() {
    wp_enqueue_style('nw-admin-theme', plugins_url('css/admin.css', __FILE__));
}
add_action('admin_enqueue_scripts', 'nw_admin_theme_style');
add_action('login_enqueue_scripts', 'nw_admin_theme_style');


add_action('admin_menu', 'test_plugin_setup_menu');

function test_plugin_setup_menu(){
	add_submenu_page('themes.php',  'NW Logo Preloader', 'NW Logo Preloader', 'manage_options', 'nw-logo-preloader', 'test_init' );
}

function test_init(){
	
?>
<div class="nw_admin_wrapper">

	<div class="nw_plugin_logo"><img src="<?php echo plugins_url( '/logo.png', __FILE__ ); ?>" alt="Nightworld Logo Preloader"/></div>

<?php test_handle_post(); ?>
	
	<!-- Form to handle the upload - The enctype value here is very important -->
	<form  method="post" enctype="multipart/form-data">

        <?php settings_fields( 'nw_preloader_settings' ); ?> 
    <?php do_settings_sections( 'nw_preloader_settings' ); ?>
        
        <div class="nw-admin-formrow">
    <?php
    $state=get_option('nw_preloader_state','disabled');
            ?>
        <label>Enable preloader?</label>
        <select name="nw_preloader_state">             
            <option value="disabled" <?php if ($state=='disabled') echo " selected ";?>>Disabled</option>            
            <option value="enabled" <?php if ($state=='enabled') echo " selected ";?>>Enabled</option>
        </select>
        
    </div>
        
        <div class="nw-admin-formrow">
            <label>Select your logo image</label>
            <p>Recommened format: 128x128 or 256x256 pixel, transparent PNG</p>
		<input type='file' id='test_upload_pdf' name='test_upload_pdf'></input>
        </div>
    
    <div class="nw-admin-formrow">
    <?php $style=get_option('nw_preloader_style'); ?>
        <label>Select preloader animation style</label>
        <select name="nw_preloader_style"> 
            <option value="rotateY" <?php if ($style=='rotateY') echo " selected ";?>>Rotate on Y Axis</option>
            <option value="rotateX" <?php if ($style=='rotateX') echo " selected ";?>>Rotate on X Axis</option>
            <option value="rotateZ" <?php if ($style=='rotateZ') echo " selected ";?>>Rotate on Z Axis</option>
            <option value="rotate3" <?php if ($style=='rotate3') echo " selected ";?>>Rotate on Y + X Axis</option>
            <option value="bouncer" <?php if ($style=='bouncer') echo " selected ";?>>Bouncing</option>
            <option value="woble" <?php if ($style=='woble') echo " selected ";?>>Woble</option>
            <option value="tada" <?php if ($style=='tada') echo " selected ";?>>Tada</option>
            <option value="skew" <?php if ($style=='skew') echo " selected ";?>>Skew</option>
            <option value="drunk" <?php if ($style=='drunk') echo " selected ";?>>Drunk</option>
            <option value="fadeindown" <?php if ($style=='fadeindown') echo " selected ";?>>Fade In Down</option>
        </select>
        
    </div>
    
		<?php submit_button('Save Settings') ?>

<input type="hidden" name="extra_post_info"  value="<?php echo get_option('nw_preloader_url'); ?>"/>
<?php
    $url=get_option('nw_preloader_url');    
    echo '<div class="nw-admin-formrow"><label>Current preloader</label>';
if ($url!='') { echo '<img src="'.$url.'" alt="Preloader image"/>';} else echo 'No image uploaded yet! Use the form!';
    echo '</div>'; ?>

	</form>

</div>

<?php


$date = new DateTime("2017-01-30 00:00:01");
$now = new DateTime();

if ($date < $now) {
   


?>
<div class="nw_admin_wrapper nw_admin_advert">
    
    <h1>Like this plugin? Check out <a target="_blank" href="http://www.nightworldonline.com/wordpress-plugins/nw-logo-preloader<?php echo '?site='.get_bloginfo('url'); ?>"> <span class="blue">NW Logo Preloader Premium</span> </a>for cool additional functionality! <span>Only for $5!</span></h1>
    <div class="nw_admin_list">
    <label>Premium features include:</label>
    <ul>
        <li>10+ Additional Animation Types</li>
        <li>Custom Background</li>
        <li>Gradient Background Generator</li>
        <li>Timing Function</li>
    </ul>
        </div>
    <a href="http://www.nightworldonline.com/wordpress-plugins/nw-logo-preloader<?php echo '?site='.get_bloginfo('url'); ?>" target="_blank"><button class="nw_admin_buy">Buy now at plugin's site!</button></a>
    </div>

<?php } 


}

function test_handle_post(){
	// First check if the file appears on the _FILES array
	if(isset($_FILES['test_upload_pdf'])){
        
        if ($_FILES['test_upload_pdf']['tmp_name']!='') {
		$pdf = $_FILES['test_upload_pdf'];

		// Use the wordpress function to upload
		// test_upload_pdf corresponds to the position in the $_FILES array
		// 0 means the content is not associated with any other posts
		$uploaded=media_handle_upload('test_upload_pdf', 0);
       
		// Error checking using WP functions
		if(is_wp_error($uploaded)){
			echo "Error uploading file: " . $uploaded->get_error_message();
		} else {
			echo "File upload successful!";
             update_option('nw_preloader_url',wp_get_attachment_url($uploaded),true);
		}
	}
    }
        if (isset($_POST['nw_preloader_style'])) { if ($_POST['nw_preloader_style']!='') update_option('nw_preloader_style',$_POST['nw_preloader_style'],true);}
        if (isset($_POST['nw_preloader_state'])) { if ($_POST['nw_preloader_state']!='') update_option('nw_preloader_state',$_POST['nw_preloader_state'],true);}
}


// load scripts to site
function wptuts_scripts_basic()
{
    $plugin_url = plugin_dir_url( __FILE__ );
    // Register the script like this for a plugin:
    wp_register_script( 'nw-logo-preloader-script', plugins_url( '/js/script.js?a=a32a', __FILE__ ) );
    
    // For either a plugin or a theme, you can then enqueue the script:
    wp_enqueue_script( 'nw-logo-preloader-script' );
}

add_action( 'wp_enqueue_scripts', 'wptuts_scripts_basic' );

//load CSS to site
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
// Register the style like this for a plugin:
    wp_register_style( 'nw-logo-preloader-style', plugins_url( '/css/style.css', __FILE__ ), array(), '20120208', 'all' );
    
    
    wp_enqueue_style( 'nw-logo-preloader-style');    
    
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css' );


//update preloader
if( !function_exists("update_nw_preloader_info") ) {
function update_nw_preloader_info() {
  register_setting( 'nw_preloader_settings', 'nw_preloader_url' );
register_setting( 'nw_preloader_settings', 'nw_preloader_style' );
   register_setting( 'nw_preloader_settings', 'nw_preloader_state' );
  
}
}

add_action( 'admin_init', 'update_nw_preloader_info' );

// show preloader

  function nw_insert_preloader()
  {    
    echo '<div id="proofOfMyExistence"></div>';
    $nw_preloader_url = get_option('nw_preloader_url');
    $nw_preloader_style = get_option('nw_preloader_style');
    $nw_preloader_state = get_option('nw_preloader_state');    
      if (($nw_preloader_url!='')&&($nw_preloader_state=='enabled')) {
          
           echo '<div id="page-preloader">
    <div id="pp-wrapper">
        <div id="pp-image"> 
            <div class="spinner '.$nw_preloader_style.'"><img src="'.$nw_preloader_url.'" alt="Preloader image"/>
                </div>
        </div>
    </div>
</div>';   
       
      }
    
  }
add_action('wp_body_open', 'nw_insert_preloader');






?>