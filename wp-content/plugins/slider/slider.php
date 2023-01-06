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
    add_submenu_page("slides-option", "Lista slajdów", "Lista slajdów", "manage_options", "slides-list", "show_slides_list");
    add_submenu_page("slides-option", "Dodaj slajd", "Dodaj slajd", "manage_options", "add-slide", "add_new_slide");
}

add_action("admin_menu", "slider_plugin_menu");

function slides_option()
{
    include_once(SLIDER_PLUGIN_DIR_PATH . SLIDER_INCLUDES_FOLDER . "slider-dashboard.php");
}

function show_slides_list()
{
    include_once(SLIDER_PLUGIN_DIR_PATH . SLIDER_INCLUDES_FOLDER . "slider-list.php");
}

function add_new_slide()
{
    include_once(SLIDER_PLUGIN_DIR_PATH . SLIDER_INCLUDES_FOLDER . "add-new-slide.php");
}

// Add basic styles and scripts

function add_styles_and_script()
{
    // styles
    wp_enqueue_style("style", SLIDER_PLUGIN_URL . '/assets/css/style.css');
    wp_enqueue_style("datatables", SLIDER_PLUGIN_URL . '/assets/css/datatables.css');
    // scripts
    wp_enqueue_script("jquery", SLIDER_PLUGIN_URL . '/assets/js/jquery.min.js');
    wp_enqueue_script("datatables", SLIDER_PLUGIN_URL . '/assets/js/datatables.min.js');
    wp_enqueue_script("script", SLIDER_PLUGIN_URL . '/assets/js/slider.js');
    wp_localize_script('script', 'ajax', admin_url("admin-ajax.php"));
}

add_action("init", "add_styles_and_script");

// Add ajax action
add_action("wp_ajax_slider", "slider_ajax_handler");

function slider_ajax_handler()
{
    global $wpdb;
    switch ($_REQUEST['requestParam']) {
        case "save-settings":
            foreach ($_REQUEST as $params => $value) {
                if ($params !== "requestParam" && $params !== "action") {
                    $selectQuery = $wpdb->get_results($wpdb->prepare(
                        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='" . $params . "'"
                    ));

                    // Inset or update records in slider options database

                    if (count($selectQuery) == 0) {
                        $wpdb->insert(returnTableName("slider_options"), array(
                            "option_name" => $params,
                            "option_value" => $_REQUEST[$params]
                        ));
                    } else {
                        $wpdb->update(returnTableName("slider_options"), array(
                            "option_value" => $_REQUEST[$params]
                        ), array("option_name" => $params));
                    }
                }
            }
            $wpdb->flush();
        case "add-new-slide":
            $wpdb->insert(returnTableName("slider_tables"), array(
                "heading" => $_REQUEST["heading"],
                "description" => $_REQUEST["content"],
                "imagePath" => $_REQUEST["imgSrc"],
                "isActive" => false
            ));
            $wpdb->flush();
        case "delete-slide":
            $wpdb->delete(returnTableName("slider_tables"), array("id" => $_REQUEST["id"]));
            $wpdb->flush();
    }
}

// Register activation plugin HOOK

function slider_generate_database_tables()
{
    $optionsQuery = "CREATE TABLE " . returnTableName("slider_options") . " (
        `id` int NOT NULL AUTO_INCREMENT,
        `option_name` text,
        `option_value` text,
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
       ";
    $sliderTablesQuery = "CREATE TABLE " . returnTableName("slider_tables") . " (
        `id` int NOT NULL AUTO_INCREMENT,
        `heading` text,
        `description` text,
        `imagePath` varchar(255),
        `isactive` BOOLEAN,
        `insertedAt` timestamp DEFAULT CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`)
       ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3
       ";
    global $wpdb;
    require_once ABSPATH . 'wp-admin/includes/upgrade.php';
    dbDelta([$optionsQuery, $sliderTablesQuery]);
}

register_activation_hook(__FILE__, "slider_generate_database_tables");

// Register deactivation plugin HOOKS

function slider_drop_database_tables()
{
    global $wpdb;
    $args = [returnTableName("slider_options"), returnTableName("slider_tables")];
    foreach ($args as $singleArg) {
        $wpdb->query("DROP TABLE IF EXISTS " . $singleArg);
    }
}

register_deactivation_hook(__FILE__, "slider_drop_database_tables");

// Function to return table names with prefix

function returnTableName(string $name)
{
    global $wpdb;
    return $wpdb->prefix . $name;
}
