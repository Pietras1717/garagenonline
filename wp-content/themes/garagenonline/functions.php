<?php
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
        'page_title'     => 'Ustawienia stopki',
        'menu_title'    => 'Ustawienia stopki',
        'parent_slug'    => 'theme-general-settings',
    ));
    acf_add_options_sub_page(array(
        'page_title'     => 'Narzędzia analityczne',
        'menu_title'    => 'Narzędzia analityczne',
        'parent_slug'    => 'theme-general-settings',
    ));
}


// Dodanie własnych styli i skryptów do heada
function wpdocs_scripts_method()
{
    // scripts
    wp_enqueue_script('jquery', get_stylesheet_directory_uri() . '/js/jquery.min.js', true);
    // styles
    wp_enqueue_style('theme', get_stylesheet_directory_uri() . '/css/style.css', true);
}
add_action('wp_enqueue_scripts', 'wpdocs_scripts_method');


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


// Wyłącznie dodawanych domyślnie emotikonek

function disable_emojis()
{
    remove_action('wp_head', 'print_emoji_detection_script', 7);
    remove_action('admin_print_scripts', 'print_emoji_detection_script');
    remove_action('wp_print_styles', 'print_emoji_styles');
    remove_action('admin_print_styles', 'print_emoji_styles');
    remove_filter('the_content_feed', 'wp_staticize_emoji');
    remove_filter('comment_text_rss', 'wp_staticize_emoji');
    remove_filter('wp_mail', 'wp_staticize_emoji_for_email');
    add_filter('tiny_mce_plugins', 'disable_emojis_tinymce');
    add_filter('wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2);
}
add_action('init', 'disable_emojis');

function disable_emojis_tinymce($plugins)
{
    if (is_array($plugins)) {
        return array_diff($plugins, array('wpemoji'));
    } else {
        return array();
    }
}
function disable_emojis_remove_dns_prefetch($urls, $relation_type)
{
    if ('dns-prefetch' == $relation_type) {
        $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

        $urls = array_diff($urls, array($emoji_svg_url));
    }

    return $urls;
}


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
            background-size: 280px;
            width: 280px;
        }
    </style>
<?php
}
add_filter('login_head', 'my_custom_login_logo');

// Inicjalizacja widżetów


function arphabet_widgets_init()
{

    register_sidebar(array(
        'name'          => 'Stopka - kolumna 1',
        'id'            => 'footer_col_1',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => 'Stopka - kolumna 2',
        'id'            => 'footer_col_2',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => 'Stopka - kolumna 3',
        'id'            => 'footer_col_3',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => 'Stopka - kolumna 4',
        'id'            => 'footer_col_4',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
    register_sidebar(array(
        'name'          => 'Stopka - kolumna 5',
        'id'            => 'footer_col_4',
        'before_widget' => '<div>',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="rounded">',
        'after_title'   => '</h2>',
    ));
}
add_action('widgets_init', 'arphabet_widgets_init');
