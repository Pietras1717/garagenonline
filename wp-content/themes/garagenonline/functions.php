<?php
// Dodanie własnych styli i skryptów do heada
function wpdocs_scripts_method()
{
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js', array());
}
add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');
