<?php
// Dodanie własnych styli i skryptów do heada
function wpdocs_scripts_method()
{
    // scripts
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js', true);
    // styles
    wp_enqueue_script('theme', get_stylesheet_directory_uri() . '/css/style.css', true);
}
add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');
