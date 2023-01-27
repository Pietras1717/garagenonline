<?php
/*
* Plugin Name: Google Reviews
* Plugin URI: https://piotrrysz.pl/wordpress/plugins/google-reviews
* Description: Dedykowany wtyczka do pobierania opinii
* Author: Piotr Rysz
* Author URI: https://piotrrysz.pl
* Version: 1.0
*/

// Defined constans variables
define("INCLUDES_FOLDER", "/includes/");

if (!defined("ABSPATH"))
    exit;
if (!defined("PLUGIN_DIR_PATH"))
    define("PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

if (!defined("PLUGIN_URL"))
    define("PLUGIN_URL", plugins_url() . "/google-reviews");

// Custom plugin icon

add_action('admin_head', 'my_custom_favicon');
function my_custom_favicon()
{
    echo '
    <style>
    .dashicons-greviews {
        background-image: url("' . plugins_url() . '/google-reviews/images/logo.png");
        background-repeat: no-repeat;
        background-position: center; 
        background-size: 20px; 
    }
    </style>
';
}

// Add plugins to menu in admin sections

function google_reviews_plugin_menu()
{
    add_menu_page("Google Reviews", "Google Reviews", "manage_options", "google-reviews", "google_reviews", "dashicons-greviews", 12);
}

add_action("admin_menu", "google_reviews_plugin_menu");

function google_reviews()
{
    include_once(PLUGIN_DIR_PATH . INCLUDES_FOLDER . "dashboard.php");
}

// Add basic styles and scripts

function google_reviews_styles_and_scripts()
{
    // styles
    wp_enqueue_style("google_reviews_styles", PLUGIN_URL . '/assets/css/style.css');
    //scripts
    wp_enqueue_script("google_reviews_script", PLUGIN_URL . '/assets/js/greviews.js');
    wp_localize_script('ajax_script', 'ajax', admin_url("admin-ajax.php"));
}

add_action("admin_enqueue_scripts", "google_reviews_styles_and_scripts");

// Add ajax action
add_action("wp_ajax_google_reviews", "google_reviews_ajax_handler");

function google_reviews_ajax_handler()
{
    global $wpdb;
    $cid = $_REQUEST['google_reviews_cid'];
    $selectQuery = $wpdb->get_results($wpdb->prepare(
        "Select * FROM " . $wpdb->prefix . "options" . " WHERE option_name='google_reviews_cid'"
    ));
    if (count($selectQuery) == 0) {
        $wpdb->insert($wpdb->prefix . "options", array(
            "option_name" => 'google_reviews_cid',
            "option_value" => $cid
        ));
    } else {
        $wpdb->update($wpdb->prefix . "options", array(
            "option_value" => $cid
        ), array("option_name" => 'google_reviews_cid'));
    }
    $wpdb->flush();
}

// Register shortcode

add_shortcode("google_reviews_pietras17", "generate_reviews");

function generate_reviews()
{
    include_once(PLUGIN_DIR_PATH . INCLUDES_FOLDER . "reviews.php");
}
