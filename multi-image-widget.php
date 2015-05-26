<?php

/*
 * Plugin Name:Multi image widget
 * Plugin URI:http://roomrent.org/my-developed-plugins/multi-image-widget/
 * Description:This plugin have the feature for upload the multiple image via widget.
 * Author:shankaranand12
 * Version: 1.1
 * Author URI:http://roomrent.org/
 * Text-domain:miw
 */

// Make sure we don't expose any info if called directly
if (!function_exists('add_action')) {
    echo 'Hi there!  I\'m just a plugin, not much I can do when called directly.';
    exit;
}

define('MIW__PLUGIN_URL', plugin_dir_url(__FILE__));
define('MIW__PLUGIN_DIR', plugin_dir_path(__FILE__));

/*
 * Define constant
 */
define("MIW_TOTAL_UPLOAD_FIELD_OPTION",10);//counting will start from 1.
define("MIW_FIELD_OPTION_ARR",serialize(array("miw_1","miw_2","miw_3","miw_4","miw_5","miw_6","miw_7","miw_8","miw_9","miw_10")));
define("MIW_UPLOAD_OPTION_PREFIX","miw_");

/*
 * Adding the scripts and styles
 */
add_action('admin_enqueue_scripts', 'miw_enqueue_scripts');
add_action('wp_enqueue_scripts', 'miw_frontend_enqueue_scripts');

function miw_enqueue_scripts() {
    wp_enqueue_media();
    wp_enqueue_script("jquery");
    wp_enqueue_style("miw_customcss", MIW__PLUGIN_URL . "assets/css/miw_admin.css");
    wp_enqueue_script("miw_custom", MIW__PLUGIN_URL . "assets/js/miw_custom.js", array('jquery'), '', TRUE);
    //jssor slider for adding the slider
    
}
/*
 * Adding jssor slider script in forntend
 */
function miw_frontend_enqueue_scripts(){
    
    wp_enqueue_style("miw_owl.carousel.css", MIW__PLUGIN_URL . "assets/css/owl.carousel.css");
    wp_enqueue_style("miw_owl.theme.css", MIW__PLUGIN_URL . "assets/css/owl.theme.css");
    wp_enqueue_style("miw_frontend.css", MIW__PLUGIN_URL . "assets/css/miw_frontend.css");
    wp_enqueue_script("miw_owl.carousel.min.js", MIW__PLUGIN_URL . "assets/js/owl.carousel.min.js", array('jquery'), '', TRUE);
    wp_enqueue_script("miw_frontendcustom", MIW__PLUGIN_URL . "assets/js/miw_frontend_custom.js", array('jquery'), '', TRUE);
    
}
/*
 * Adding the widget  
 */
require MIW__PLUGIN_DIR . 'widget/miw-widget.php';
/*
 * Adding the functions file.
 */
require MIW__PLUGIN_DIR . 'include/miw-functions.php';
?>
