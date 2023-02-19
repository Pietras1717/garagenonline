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
    wp_enqueue_style('lightbox', get_stylesheet_directory_uri() . '/css/lightbox.css', array());
    wp_enqueue_script('theme-script', get_stylesheet_directory_uri() . '/js/script.js', NULL, NULL, true);
    wp_enqueue_script('lightbox', get_stylesheet_directory_uri() . '/js/lightbox.js', NULL, NULL, true);
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
    unset($value->response['uk-cookie-consent/uk-cookie-consent.php']);
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

// Dodanie miniaturek do postów
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
    register_sidebar(array(
        'name'          => 'Shop Sidebar',
        'id'            => 'shop_sidebar',
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

// renderowanie formularza do komentarzy

function render_comment_form()
{

    $commenter = wp_get_current_commenter();
    $req = get_option('require_name_email');
    $aria_req = ($req ? " aria-required='true'" : '');
    $fields =  array(
        'author' => '<p class="comment-form-author">' . '<label for="author">' . __('Name') . '</label> ' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" size="30"' . $aria_req . ' /></p>',
        'email'  => '<p class="comment-form-email"><label for="email">' . __('Email') . '</label> ' . ($req ? '<span class="required">*</span>' : '') .
            '<input id="email" name="email" type="text" value="' . esc_attr($commenter['comment_author_email']) . '" size="30"' . $aria_req . ' /></p>',
    );
    $comments_args = array(
        'fields' =>  $fields
    );
    comment_form($comments_args);
}

// Walidacja komentarzy z dodatkowym pluginem

function comment_validation_init()
{
    if (is_single() && comments_open()) { ?>
        <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function($) {
                $('#commentform').validate({

                    rules: {
                        author: {
                            required: true,
                            minlength: 2
                        },

                        email: {
                            required: true,
                            email: true
                        },

                        comment: {
                            required: true,
                            minlength: 20
                        }
                    },

                    messages: {
                        author: "Pole autor jest wymagane",
                        email: "Podaj właściwy adres e-mail",
                        comment: "Komentarz musi mieć minimum 20 znaków"
                    },

                    errorElement: "div",
                    errorPlacement: function(error, element) {
                        element.after(error);
                    }

                });
            });
        </script>
    <?php
    }
}
add_action('wp_footer', 'comment_validation_init');

// zwraca alt z url obrazka

function get_alt_from_img($img)
{
    $id = attachment_url_to_postid($img);
    $alt = get_post_meta($id, '_wp_attachment_image_alt', true);
    return $alt;
}

// Change Quantity Input

add_action('woocommerce_after_quantity_input_field', 'silva_display_quantity_plus');

function silva_display_quantity_plus()
{
    echo '<button type="button" class="plus" >+</button>';
}

add_action('woocommerce_before_quantity_input_field', 'silva_display_quantity_minus');

function silva_display_quantity_minus()
{
    echo '<button type="button" class="minus" >-</button>';
}

// Trigger update quantity script

add_action('wp_footer', 'silva_add_cart_quantity_plus_minus');

function silva_add_cart_quantity_plus_minus()
{

    if (!is_product() && !is_cart()) return;

    wc_enqueue_js("   
           
      $('form.cart,form.woocommerce-cart-form').on( 'click', 'button.plus, button.minus', function() {
  
        var qty = $(this).closest('.quantity').find('.qty');
         var val = parseFloat(qty.val());
         var max = parseFloat(qty.attr( 'max' ));
         var min = parseFloat(qty.attr( 'min' ));
         var step = parseFloat(qty.attr( 'step' ));
 
         if ( $( this ).is( '.plus' ) ) {
            if ( max && ( max <= val ) ) {
               qty.val( max );
            } else {
               qty.val( val + step );
            }
            qty.trigger( 'change' );
         } else {
            if ( min && ( min >= val ) ) {
               qty.val( min );
            } else if ( val > 1 ) {
               qty.val( val - step );
            }
         }
 
      });
        
   ");
}

// Add theme support to product gallery

add_action('after_setup_theme', 'yourtheme_setup');

function yourtheme_setup()
{
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}

// Replace add to cart button
add_filter('woocommerce_loop_add_to_cart_link', 'replacing_add_to_cart_button', 10, 2);
function replacing_add_to_cart_button($button, $product)
{
    $button_text = __("Konfigurieren ", "woocommerce");
    $button = '<a class="button" href="' . $product->get_permalink() . '">' . $button_text . '</a>';

    return $button;
}

// disable woocommerce styles

add_filter('woocommerce_enqueue_styles', '__return_empty_array');

// change sale to angebot

add_filter('woocommerce_sale_flash', 'ds_change_sale_text');
function ds_change_sale_text()
{
    return '<span class="onsale">Angebot!</span>';
}

// remove breadcrambs in shop

// add_action('init', 'my_remove_breadcrumbs');

function my_remove_breadcrumbs()
{
    remove_action('woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0);
}


// Multi steps ACF PRO

add_action('wapf_before_wrapper', 'wapf_before_wrapper');

function wapf_before_wrapper($product)
{
    ?>
    <div class="wapf-progress">
        <div class="wapf-progress-bar"></div>
        <div class="wapf-progress-steps"></div>
    </div>
<?php
}

add_action('wapf_after_product_totals', 'wapf_after_product_totals');

function wapf_after_product_totals($product)
{
?>
    <div class="wapf_step_buttons">
        <button class="button wapf_btn_prev" style="display:none"><?php _e('Zurück', 'sw-wapf'); ?></button>
        <button class="button wapf_btn_next"><?php _e('Nächste', 'sw-wapf'); ?></button>
    </div>
<?php
}

// Checkout page add additional info

// add_action('woocommerce_after_checkout_form', function () {
//     echo '<div>tutaj dane które chce Pan Henryk</div>';
// });

// SITEMAP GENERATOR
add_action("publish_post", "eg_create_sitemap");
add_action("publish_page", "eg_create_sitemap");
function eg_create_sitemap()
{
    $postsForSitemap = get_posts(array(
        'numberposts' => -1,
        'orderby' => 'modified',
        'post_type' => array('post', 'page'),
        'order' => 'DESC'
    ));
    $sitemap = '<?xml version="1.0" encoding="UTF-8"?>';
    $sitemap .= '<?xml-stylesheet type="text/xsl" href="sitemap-style.xsl"?>';
    $sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
    foreach ($postsForSitemap as $post) {
        setup_postdata($post);
        $postdate = explode(" ", $post->post_modified);
        $sitemap .= '<url>' .
            '<loc>' . get_permalink($post->ID) . '</loc>' .
            '<priority>1</priority>' .
            '<lastmod>' . $postdate[0] . '</lastmod>' .
            '<changefreq>daily</changefreq>' .
            '</url>';
    }
    $sitemap .= '</urlset>';
    $fp = fopen(ABSPATH . "sitemap.xml", 'w');
    fwrite($fp, $sitemap);
    fclose($fp);
}

// change label

add_filter('woocommerce_default_address_fields', 'change_label', 9999);

function change_label($fields)
{

    $fields['address_1']['label'] = 'Ulica i numer';

    return $fields;
}

// change fields - remove

function wc_remove_checkout_fields($fields)
{
    // Billing fields
    unset($fields['billing']['billing_state']);
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'wc_remove_checkout_fields');


// acf tables by pietras17

function wapf_add_look_up_tables()
{

    $tables = array();
    // NEBENEINGANGSTÜR ALU NACH MASS AUS ISO 40 SEKTIONALTOR SANDWICHPANEELEN - start
    $tables['nebeneingangstur_alu_1A'] = array(
        '0.9'        => array(
            '2.0'    => 0,
            '2.1'    => 10,
            '2.2'    => 21,
            '2.3'    => 67,
            '2.4'    => 78
        ),
        '1.0'        => array(
            '2'    => 32,
            '2.1'    => 39,
            '2.2'    => 46,
            '2.3'    => 96,
            '2.4'    => 110
        ),
        '1.1'        => array(
            '2'    => 60,
            '2.1'    => 67,
            '2.2'    => 74,
            '2.3'    => 124,
            '2.4'    => 139
        ),
        '1.2'        => array(
            '2'    => 82,
            '2.1'    => 96,
            '2.2'    => 103,
            '2.3'    => 153,
            '2.4'    => 164
        ),
        '1.3'        => array(
            '2'    => 114,
            '2.1'    => 124,
            '2.2'    => 135,
            '2.3'    => 178,
            '2.4'    => 192
        )
    );
    $tables['nebeneingangstur_alu_1B'] = array(
        '0.9'        => array(
            '2'    => 32,
            '2.1'    => 42,
            '2.2'    => 49,
            '2.3'    => 92,
            '2.4'    => 114
        ),
        '1'        => array(
            '2'    => 67,
            '2.1'    => 78,
            '2.2'    => 85,
            '2.3'    => 135,
            '2.4'    => 146
        ),
        '1.1'        => array(
            '2'    => 103,
            '2.1'    => 117,
            '2.2'    => 124,
            '2.3'    => 171,
            '2.4'    => 182
        ),
        '1.2'        => array(
            '2'    => 142,
            '2.1'    => 149,
            '2.2'    => 157,
            '2.3'    => 207,
            '2.4'    => 221
        ),
        '1.3'        => array(
            '2'    => 178,
            '2.1'    => 185,
            '2.2'    => 196,
            '2.3'    => 242,
            '2.4'    => 257
        )
    );
    $tables['nebeneingangstur_alu_2A'] = array(
        '0.9'        => array(
            '2'    => 264,
            '2.1'    => 271,
            '2.2'    => 278,
            '2.3'    => 328,
            '2.4'    => 339
        ),
        '1'        => array(
            '2'    => 289,
            '2.1'    => 299,
            '2.2'    => 310,
            '2.3'    => 353,
            '2.4'    => 467
        ),
        '1.1'        => array(
            '2'    => 321,
            '2.1'    => 328,
            '2.2'    => 335,
            '2.3'    => 385,
            '2.4'    => 396
        ),
        '1.2'        => array(
            '2'    => 342,
            '2.1'    => 353,
            '2.2'    => 360,
            '2.3'    => 410,
            '2.4'    => 424
        ),
        '1.3'        => array(
            '2'    => 374,
            '2.1'    => 385,
            '2.2'    => 392,
            '2.3'    => 435,
            '2.4'    => 453
        )
    );
    $tables['nebeneingangstur_alu_2B'] = array(
        '0.9'        => array(
            '2'    => 285,
            '2.1'    => 299,
            '2.2'    => 307,
            '2.3'    => 349,
            '2.4'    => 364
        ),
        '1'        => array(
            '2'    => 321,
            '2.1'    => 332,
            '2.2'    => 339,
            '2.3'    => 389,
            '2.4'    => 399
        ),
        '1.1'        => array(
            '2'    => 360,
            '2.1'    => 367,
            '2.2'    => 374,
            '2.3'    => 424,
            '2.4'    => 435
        ),
        '1.2'        => array(
            '2'    => 396,
            '2.1'    => 403,
            '2.2'    => 414,
            '2.3'    => 456,
            '2.4'    => 467
        ),
        '1.3'        => array(
            '2'    => 431,
            '2.1'    => 439,
            '2.2'    => 449,
            '2.3'    => 496,
            '2.4'    => 510
        )
    );

    // NEBENEINGANGSTÜR ALU NACH MASS AUS ISO 40 SEKTIONALTOR SANDWICHPANEELEN - end

    // Zweiflügeltor Alu Nach Mass Aus Iso 40 Sektionaltor Sandwichpaneelen - start

    $tables['zweiflugeltor_alu_1A'] = array(
        '2'        => array(
            '2'    => 0,
            '2.125'    => 79,
            '2.250'    => 140,
            '2.275'    => 200,
            '2.500'    => 261
        ),
        '2.100'        => array(
            '2'    => 15,
            '2.125'    => 93,
            '2.250'    => 150,
            '2.275'    => 207,
            '2.500'    => 272
        ),
        '2.200'        => array(
            '2'    => 25,
            '2.125'    => 104,
            '2.250'    => 161,
            '2.275'    => 218,
            '2.500'    => 275
        ),
        '2.300'        => array(
            '2'    => 43,
            '2.125'    => 115,
            '2.250'    => 268,
            '2.275'    => 229,
            '2.500'    => 286
        ),
        '2.400'        => array(
            '2'    => 54,
            '2.125'    => 133,
            '2.250'    => 190,
            '2.275'    => 247
        ),
        '2.500'        => array(
            '2.0'    => 79,
            '2.125'    => 158,
            '2.250'    => 218
        ),
        '2.600'        => array(
            '2'    => 133,
            '2.125'    => 204,
            '2.250'    => 261
        )
    );
    $tables['zweiflugeltor_alu_1B'] = array(
        '2'        => array(
            '2'    => 147,
            '2.125'    => 229,
            '2.250'    => 304,
            '2.275'    => 379,
            '2.500'    => 454
        ),
        '2.100'        => array(
            '2'    => 165,
            '2.125'    => 247,
            '2.250'    => 318,
            '2.275'    => 390,
            '2.500'    => 461
        ),
        '2.200'        => array(
            '2'    => 179,
            '2.125'    => 261,
            '2.250'    => 336,
            '2.275'    => 411,
            '2.500'    => 486
        ),
        '2.300'        => array(
            '2'    => 193,
            '2.125'    => 275,
            '2.250'    => 347,
            '2.275'    => 418,
            '2.500'    => 490
        ),
        '2.400'        => array(
            '2'    => 207,
            '2.125'    => 290,
            '2.250'    => 365,
            '2.275'    => 440
        ),
        '2.500'        => array(
            '2.0'    => 243,
            '2.125'    => 329,
            '2.250'    => 400
        ),
        '2.600'        => array(
            '2'    => 304,
            '2.125'    => 386,
            '2.250'    => 457
        )
    );
    // Zweiflügeltor Alu Nach Mass Aus Iso 40 Sektionaltor Sandwichpaneelen - end

    // Zweiflügeltor Stahl nach Maß aus ISO 40 Sektionaltor Sandwichpaneelen - start

    $tables['zweiflugeltor_stahl'] = array(
        '1.60'        => array(
            '1.60' => 0,
            '2.0'  => 0,
            '2.10' => 0,
            '2.20' => 0,
            '2.30' => 0,
            '2.40' => 0,
            '2.50' => 4,
            '2.60' => 55,
            '2.70' => 106,
            '2.80' => 156,
            '2.90' => 207,
            '3.0' => 258,
            '3.10' => 309,
            '3.20' => 359
        ),
        '2.0'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 0,
            '2.20' => 0,
            '2.30' => 0,
            '2.40' => 0,
            '2.50' => 4,
            '2.60' => 55,
            '2.70' => 106,
            '2.80' => 156,
            '2.90' => 207,
            '3.0' => 258,
            '3.10' => 309,
            '3.20' => 359
        ),
        '2.10'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 0,
            '2.20' => 0,
            '2.30' => 0,
            '2.40' => 8,
            '2.50' => 61,
            '2.60' => 114,
            '2.70' => 167,
            '2.80' => 219,
            '2.90' => 272,
            '3.0' => 325,
            '3.10' => 377,
            '3.20' => 431
        ),
        '2.20'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 0,
            '2.20' => 0,
            '2.30' => 7,
            '2.40' => 62,
            '2.50' => 116,
            '2.60' => 172,
            '2.70' => 227,
            '2.80' => 282,
            '2.90' => 336,
            '3.0' => 393,
            '3.10' => 447,
            '3.20' => 501
        ),
        '2.30'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 0,
            '2.20' => 0,
            '2.30' => 58,
            '2.40' => 114,
            '2.50' => 172,
            '2.60' => 229,
            '2.70' => 287,
            '2.80' => 343,
            '2.90' => 401,
            '3.0' => 458,
            '3.10' => 515,
            '3.20' => 572
        ),
        '2.40'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 0,
            '2.20' => 48,
            '2.30' => 107,
            '2.40' => 167,
            '2.50' => 226,
            '2.60' => 286,
            '2.70' => 345,
            '2.80' => 405,
            '2.90' => 464,
            '3.0' => 523,
            '3.10' => 582,
            '3.20' => 642
        ),
        '2.50'        => array(
            '1.60' => 0,
            '2.0' => 0,
            '2.10' => 34,
            '2.20' => 95,
            '2.30' => 156,
            '2.40' => 218,
            '2.50' => 280,
            '2.60' => 342,
            '2.70' => 403,
            '2.80' => 465,
            '2.90' => 526,
            '3.0' => 588,
            '3.10' => 650,
            '3.20' => 712
        ),
        '2.60'        => array(
            '1.60' => 14,
            '2.0' => 14,
            '2.10' => 79,
            '2.20' => 142,
            '2.30' => 206,
            '2.40' => 269,
            '2.50' => 333,
            '2.60' => 396,
            '2.70' => 460,
            '2.80' => 525,
            '2.90' => 588,
            '3.0' => 652,
            '3.10' => 715,
            '3.20' => 779
        ),
        '2.70'        => array(
            '1.60' => 56,
            '2.0' => 56,
            '2.10' => 122,
            '2.20' => 188,
            '2.30' => 253,
            '2.40' => 320,
            '2.50' => 385,
            '2.60' => 452,
            '2.70' => 517,
            '2.80' => 582,
            '2.90' => 649,
            '3.0' => 714,
            '3.10' => 780,
            '3.20' => 846
        ),
        '2.80'        => array(
            '1.60' => 97,
            '2.0' => 97,
            '2.10' => 166,
            '2.20' => 234,
            '2.30' => 302,
            '2.40' => 370,
            '2.50' => 437,
            '2.60' => 505,
            '2.70' => 572,
            '2.80' => 641,
            '2.90' => 708,
            '3.0' => 777,
            '3.10' => 844,
            '3.20' => 912
        ),
        '2.90'        => array(
            '1.60' => 138,
            '2.0' => 138,
            '2.10' => 208,
            '2.20' => 279,
            '2.30' => 349,
            '2.40' => 418,
            '2.50' => 488,
            '2.60' => 559,
            '2.70' => 627,
            '2.80' => 698,
            '2.90' => 768,
            '3.0' => 838,
            '3.10' => 907,
            '3.20' => 977
        ),
        '3.0'        => array(
            '1.60' => 179,
            '2.0' => 179,
            '2.10' => 251,
            '2.20' => 323,
            '2.30' => 395,
            '2.40' => 467,
            '2.50' => 539,
            '2.60' => 611,
            '2.70' => 683,
            '2.80' => 754,
            '2.90' => 827,
            '3.0' => 899,
            '3.10' => 969,
            '3.20' => 1043
        ),
        '3.10'        => array(
            '1.60' => 219,
            '2.0' => 219,
            '2.10' => 293,
            '2.20' => 366,
            '2.30' => 440,
            '2.40' => 515,
            '2.50' => 588,
            '2.60' => 662,
            '2.70' => 736,
            '2.80' => 810,
            '2.90' => 884,
            '3.0' => 958,
            '3.10' => 1031,
            '3.20' => 1106
        ),
        '3.20'        => array(
            '1.60' => 258,
            '2.0' => 258,
            '2.10' => 334,
            '2.20' => 409,
            '2.30' => 486,
            '2.40' => 561,
            '2.50' => 637,
            '2.60' => 714,
            '2.70' => 789,
            '2.80' => 865,
            '2.90' => 941,
            '3.0' => 1017,
            '3.10' => 1092,
            '3.20' => 1169
        ),
        '3.30'        => array(
            '1.60' => 297,
            '2.0' => 297,
            '2.10' => 374,
            '2.20' => 453,
            '2.30' => 530,
            '2.40' => 609,
            '2.50' => 686,
            '2.60' => 764,
            '2.70' => 841,
            '2.80' => 920,
            '2.90' => 997,
            '3.0' => 1075,
            '3.10' => 1152,
            '3.20' => 1231
        ),
        '3.40'        => array(
            '1.60' => 335,
            '2.0' => 335,
            '2.10' => 415,
            '2.20' => 495,
            '2.30' => 574,
            '2.40' => 654,
            '2.50' => 734,
            '2.60' => 813,
            '2.70' => 893,
            '2.80' => 973,
            '2.90' => 1052,
            '3.0' => 1132,
            '3.10' => 1212,
            '3.20' => 1292
        ),
        '3.50'        => array(
            '1.60' => 373,
            '2.0' => 373,
            '2.10' => 454,
            '2.20' => 536,
            '2.30' => 618,
            '2.40' => 699,
            '2.50' => 780,
            '2.60' => 862,
            '2.70' => 944,
            '2.80' => 1026,
            '2.90' => 1107,
            '3.0' => 1190,
            '3.10' => 1270,
            '3.20' => 1352
        ),
        '3.60'        => array(
            '1.60' => 411,
            '2.0' => 411,
            '2.10' => 494,
            '2.20' => 577,
            '2.30' => 661,
            '2.40' => 744,
            '2.50' => 827,
            '2.60' => 911,
            '2.70' => 994,
            '2.80' => 1078,
            '2.90' => 1161,
            '3.0' => 1245,
            '3.10' => 1328,
            '3.20' => 1411
        ),
        '3.70'        => array(
            '1.60' => 447,
            '2.0' => 447,
            '2.10' => 532,
            '2.20' => 618,
            '2.30' => 703,
            '2.40' => 788,
            '2.50' => 873,
            '2.60' => 958,
            '2.70' => 1044,
            '2.80' => 1129,
            '2.90' => 1214,
            '3.0' => 1299,
            '3.10' => 1384,
            '3.20' => 1471
        ),
        '3.80'        => array(
            '1.60' => 483,
            '2.0' => 483,
            '2.10' => 570,
            '2.20' => 657,
            '2.30' => 745,
            '2.40' => 831,
            '2.50' => 919,
            '2.60' => 1006,
            '2.70' => 1092,
            '2.80' => 1180,
            '2.90' => 1266,
            '3.0' => 1353,
            '3.10' => 1441,
            '3.20' => 1528
        ),
        '3.90'        => array(
            '1.60' => 519,
            '2.0' => 519,
            '2.10' => 608,
            '2.20' => 696,
            '2.30' => 786,
            '2.40' => 873,
            '2.50' => 963,
            '2.60' => 1052,
            '2.70' => 1140,
            '2.80' => 1230,
            '2.90' => 1318,
            '3.0' => 1408,
            '3.10' => 1496,
            '3.20' => 1585
        ),
        '4.0'        => array(
            '1.60' => 553,
            '2.0' => 553,
            '2.10' => 644,
            '2.20' => 735,
            '2.30' => 826,
            '2.40' => 916,
            '2.50' => 1007,
            '2.60' => 1098,
            '2.70' => 1189,
            '2.80' => 1278,
            '2.90' => 1369,
            '3.0' => 1460,
            '3.10' => 1550,
            '3.20' => 1641
        ),
        '4.10'        => array(
            '1.60' => 588,
            '2.0' => 588,
            '2.10' => 681,
            '2.20' => 774,
            '2.30' => 865,
            '2.40' => 957,
            '2.50' => 1050,
            '2.60' => 1143,
            '2.70' => 1235,
            '2.80' => 1327,
            '2.90' => 1419,
            '3.0' => 1512,
            '3.10' => 1604,
            '3.20' => 1697
        ),
        '4.20'        => array(
            '1.60' => 622,
            '2.0' => 622,
            '2.10' => 717,
            '2.20' => 810,
            '2.30' => 904,
            '2.40' => 998,
            '2.50' => 1126,
            '2.60' => 1186,
            '2.70' => 1280,
            '2.80' => 1375,
            '2.90' => 1469,
            '3.0' => 1564,
            '3.10' => 1657,
            '3.20' => 1752
        ),
        '4.30'        => array(
            '1.60' => 655,
            '2.0' => 655,
            '2.10' => 751,
            '2.20' => 848,
            '2.30' => 943,
            '2.40' => 1039,
            '2.50' => 1134,
            '2.60' => 1230,
            '2.70' => 1326,
            '2.80' => 1422,
            '2.90' => 1517,
            '3.0' => 1614,
            '3.10' => 1709,
            '3.20' => 1805
        ),
        '4.40'        => array(
            '1.60' => 688,
            '2.0' => 688,
            '2.10' => 786,
            '2.20' => 884,
            '2.30' => 981,
            '2.40' => 1078,
            '2.50' => 1175,
            '2.60' => 1273,
            '2.70' => 1371,
            '2.80' => 1469,
            '2.90' => 1566,
            '3.0' => 1662,
            '3.10' => 1760,
            '3.20' => 1857
        )
    );

    // Zweiflügeltor Stahl nach Maß aus ISO 40 Sektionaltor Sandwichpaneelen - end

    return $tables;
}

add_filter('wapf/lookup_tables', 'wapf_add_look_up_tables');
