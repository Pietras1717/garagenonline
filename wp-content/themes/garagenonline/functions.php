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
if (!current_user_can('manage_options')) {
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

// Funkcja dla mini koszyka

function custom_mini_cart()
{
?>
    <div class="mini-cart">
        <?php
        woocommerce_mini_cart();

        ?>
        <a class="continue-shopping" href="<?php echo esc_url(apply_filters('woocommerce_continue_shopping_redirect', wc_get_page_permalink('shop'))); ?>">
            <?php echo __('Continue shopping', 'woocommerce') ?>
        </a>
    </div>
<?php
}
add_shortcode('mini-cart', 'custom_mini_cart');


// Dodanie własnego logo przy logowaniu
function my_custom_login_logo()
{
    $logo_url = (function_exists('the_custom_logo') && get_theme_mod('custom_logo')) ? wp_get_attachment_image_src(get_theme_mod('custom_logo'), 'full') : false;
    $logo_url = ($logo_url) ? $logo_url[0] : generate_get_option('logo');
    $logo_url = esc_url(apply_filters('generate_logo', $logo_url));
?>
    <style type="text/css">
        .login h1 a {
            background-image: url(<?php echo $logo_url ?>) !important;
            margin: 0 auto;
            background-size: 250px;
            width: 100%;
            max-width: 300px;
        }
    </style>
<?php
}

add_filter('login_head', 'my_custom_login_logo');

// Dodanie miniaturek do posty
add_theme_support('post-thumbnails');


// Usunięcie strony autora

add_action('template_redirect', 'my_custom_disable_author_page');

function my_custom_disable_author_page()
{
    global $wp_query;
    if (is_author()) {
        $wp_query->set_404();
        // status_header(404);
        wp_redirect(home_url());
    }
}

// Filtr do mniejszego tekstu dla krotkiego opisu

add_filter('excerpt_length', function ($length) {
    return 25;
});

// Dodanie Options Page
if (function_exists('acf_add_options_page')) {
    acf_add_options_page(array(
        'page_title'     => 'Ustawienia szablonu',
        'menu_title'    => 'Ustawienia szablonu',
        'menu_slug'     => 'theme-general-settings',
        'capability'    => 'edit_posts',
        'redirect'        => false
    ));
    acf_add_options_sub_page(array(
        'page_title'     => 'Narzędzia analityczne',
        'menu_title'    => 'Narzędzia analityczne',
        'parent_slug'    => 'theme-general-settings',
    ));
}

// Inicjalizacja widżetów

function arphabet_widgets_init()
{

    register_sidebar(array(
        'name'          => 'Blog Sidebar',
        'id'            => 'blog_right',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'arphabet_widgets_init');


// Funkcja do paginacji

function theme_pagination()
{

    global $wp_query;
    $totalPages = $wp_query->max_num_pages;
    $currentPage = max(1, get_query_var('paged'));

    if ($totalPages > 1) {

        $big = '9999999';
        return paginate_links(array(
            'format'        => 'page/%#%',
            'base'          => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
            'current'       => $currentPage,
            'total'         => $totalPages,
            'prev_text'     => __('Poprzednia', 'domain'),
            'next_text'     => __('Następna', 'domain')
        ));
    }
}
