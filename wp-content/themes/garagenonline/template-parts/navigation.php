<div class="navbar">
    <div class="container">
        <div class="navbar-wrapper">
            <div class="close-menu-btn">
                <i class="fa fa-bars"></i>
            </div>
            <div class="logo-wrapper">
                <?php if (function_exists('the_custom_logo')) {
                    the_custom_logo();
                } ?>
                <div class="burger">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
            <?php
            wp_nav_menu(array(
                'container'            => 'nav',
                'container_class'      => 'main-menu',
                'container_id'         => 'main-menu',
                'theme_location'       => 'main_menu',
            ));
            ?>
            <div class="woocommerce-menu">
                <?php return_myaccount_menu() ?>
                <button class="show-mini-cart"><i class="fa fa-shopping-bag"></i> <?php echo number_format(WC()->cart->cart_contents_total, 2) ?> (<?php echo WC()->cart->get_cart_contents_count() ?>)</button>
            </div>
        </div>
    </div>
</div>