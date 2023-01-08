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
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/script.js', NULL, NULL, true);
}
add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');


// Ukrywanie paska edycji WP
if (current_user_can('manage_options')) {
    add_filter('show_admin_bar', '__return_false');
}


// Powiadomianie od acf
function filter_plugin_updates($value)
{
    unset($value->response['advanced-custom-fields-pro/acf.php']);
    return $value;
}
add_filter('site_transient_update_plugins', 'filter_plugin_updates');


// Dodanie Menu
if (!function_exists('mytheme_register_nav_menu')) {

    function mytheme_register_nav_menu()
    {
        register_nav_menus(array(
            'main_menu' => __('Menu Główne'),
            'my_account' => __('Moje konto'),
            'my_account_logout' => __('Moje konto - wylogowany')
        ));
    }
    add_action('after_setup_theme', 'mytheme_register_nav_menu', 0);
}

// Wsparcie dla woocommerce

function mytheme_add_woocommerce_support()
{
    add_theme_support('woocommerce');
}

add_action('after_setup_theme', 'mytheme_add_woocommerce_support');

// Return my account menu

function return_myaccount_menu()
{
    if (is_user_logged_in()) {
        wp_nav_menu(array(
            'container'            => 'nav',
            'container_class'      => 'account-menu',
            'container_id'         => 'account-menu',
            'theme_location'       => 'my_account'
        ));
    } else {
        wp_nav_menu(array(
            'container'            => 'nav',
            'container_class'      => 'account-menu',
            'container_id'         => 'account-menu',
            'theme_location'       => 'my_account_logout'
        ));
    }
}

add_action('check_admin_referer', 'logout_without_confirm', 10, 2);
function logout_without_confirm($action, $result)
{
    /**
     * Allow logout without confirmation
     */
    if ($action == "log-out" && !isset($_GET['_wpnonce'])) {
        $redirect_to = isset($_REQUEST['redirect_to']) ?
            $_REQUEST['redirect_to'] : '';
        $location = str_replace('&amp;', '&', wp_logout_url($redirect_to));;
        header("Location: $location");
        die();
    }
}


function custom_mini_cart()
{
    echo '<a href="#" class="dropdown-back" data-toggle="dropdown"> ';
    echo '<i class="fa fa-shopping-cart" aria-hidden="true"></i>';
    echo '<div class="basket-item-count" style="display: inline;">';
    echo '<span class="cart-items-count count">';
    echo WC()->cart->get_cart_contents_count();
    echo '</span>';
    echo '</div>';
    echo '</a>';
    echo '<ul class="dropdown-menu dropdown-menu-mini-cart">';
    echo '<li> <div class="widget_shopping_cart_content">';
    woocommerce_mini_cart();
    echo '</div></li></ul>';
}
add_shortcode('quadlayers-mini-cart', 'custom_mini_cart');
