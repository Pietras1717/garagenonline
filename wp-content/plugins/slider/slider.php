<?php
/*
* Plugin Name: Slider Garagenonline
* Plugin URI: https://piotrrysz.pl/wordpress/plugins/slider
* Description: Dedykowany slider dla serwisu garagen online, zrealizowany przez programiste
* Author: Piotr Rysz
* Author URI: https://piotrrysz.pl
* Version: 1.0
*/

// Defined constans variables
define("SLIDER_INCLUDES_FOLDER", "/includes/");

if (!defined("ABSPATH"))
    exit;
if (!defined("SLIDER_PLUGIN_DIR_PATH"))
    define("SLIDER_PLUGIN_DIR_PATH", plugin_dir_path(__FILE__));

if (!defined("SLIDER_PLUGIN_URL"))
    define("SLIDER_PLUGIN_URL", plugins_url() . "/slider");


// Add plugins to menu in admin sections

function slider_plugin_menu()
{
    add_menu_page("Slider Garagenonline", "Slider - Home", "manage_options", "slides-option", "slides_option", "dashicons-embed-photo", 11);
    add_submenu_page("slides-option", "Ustawienia ogólne", "Ustawienia ogólne", "manage_options", "slides-option", "slides_option");
}

add_action("admin_menu", "slider_plugin_menu");

function slides_option()
{
    include_once(SLIDER_PLUGIN_DIR_PATH . SLIDER_INCLUDES_FOLDER . "slider-dashboard.php");
}

// Add basic styles and scripts

function add_styles_and_script()
{
    // styles
    wp_enqueue_style("style", SLIDER_PLUGIN_URL . '/assets/css/style.css');
    // scripts
    wp_enqueue_script("jquery", SLIDER_PLUGIN_URL . '/assets/js/jquery.min.js');
    wp_enqueue_script("script", SLIDER_PLUGIN_URL . '/assets/js/slider.js');
    wp_localize_script('script', 'ajax', admin_url("admin-ajax.php"));
}

add_action("init", "add_styles_and_script");

// Add ajax action
add_action("wp_ajax_slider", "slider_ajax_handler");

function slider_ajax_handler()
{
    print_r($_REQUEST);
}
