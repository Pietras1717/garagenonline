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
