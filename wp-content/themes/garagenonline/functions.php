<?php
// Dodanie Custom Logo
add_action('after_setup_theme', 'themename_custom_logo_setup');
function themename_custom_logo_setup()
{
    $defaults = array(
        'height'               => 100,
        'width'                => 400,
        'flex-height'          => true,
        'flex-width'           => true,
        'header-text'          => array('site-title', 'site-description'),
        'unlink-homepage-logo' => true,
    );

    add_theme_support('custom-logo', $defaults);
}

// Dodanie możliwości importu SVG
function cc_mime_types($mimes)
{
    $mimes['svg'] = 'image/svg+xml';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');


// Dodanie własnych styli i skryptów do heada
function wpdocs_scripts_method()
{
    wp_enqueue_style('theme-css', get_stylesheet_directory_uri() . '/css/style.css', array());
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/script.js', array());
}
add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');


// Ukrywanie paska edycji WP
if (current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}
