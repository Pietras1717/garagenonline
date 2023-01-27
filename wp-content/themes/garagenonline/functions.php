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

add_action('wapf_before_product_totals', 'wapf_before_product_totals');

function wapf_before_product_totals($product)
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

    return $tables;
}

add_filter('wapf/lookup_tables', 'wapf_add_look_up_tables');
