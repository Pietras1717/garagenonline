<?php
get_header();
do_shortcode("[display_slider]");
?>
<main>
    <div class="container">
        <?php
        // content z wp
        the_content();
        ?>
        <!-- sekcja z 3 blokami -->
        <div class="three-blocks">
            <?php
            if (get_field('section_three_block')["is_active"] == "tak") : ?>
                <div class="about">
                    <h2><?php echo get_field('section_three_block')["heading"] ?></h2>
                    <p><?php echo get_field('section_three_block')["description"] ?></p>
                </div>
                <div class="columns">
                    <?php foreach (get_field('section_three_block')["sekcja_z_kolumnami"]['single_column'] as $single) : ?>
                        <div class="single">
                            <img src="<?php echo $single['obraz'] ?>" alt="">
                            <div class="copy">
                                <h4><?php echo $single['heading'] ?></h4>
                                <p><?php echo $single['description'] ?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif ?>
        </div>
        <!-- Sekcja z produktami -->
        <div class="blog-posts">
            <h3>UNSERE PRODUKTE</h3>
            <?php echo do_shortcode('[products limit="9" columns="3" visibility="featured" ]'); ?>
            <div class="home-link">
                <div class="inner">
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')) ?>">Pozostałe produkty</a>
                </div>
            </div>
        </div>
        <!-- wpisy blogowe -->
        <?php
        $recent_post = new WP_Query(array('post_per_page' => 3, 'orderby' => 'date', 'order' => 'DESC'));
        if ($recent_post->have_posts()) : ?>
            <div class="blog-posts">
                <h3>OSTATNIE WPISY NA NASZYM BLOGU</h3>
                <div class="posts-container">
                    <div class="posts">
                        <?php while ($recent_post->have_posts()) : $recent_post->the_post() ?>
                            <div class="single-post" onclick="window.location='<?php echo the_permalink() ?>'">
                                <div class="img">
                                    <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?>">
                                </div>
                                <div class="post-text">
                                    <h2 class="title"><?php echo the_title() ?></h2>
                                    <?php
                                    $categories = get_the_category();
                                    if (!empty($categories)) {
                                        echo '<a class="category" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                                    }
                                    ?>
                                    <p class="short-description">
                                        <?php echo get_the_excerpt() ?>
                                    </p>
                                </div>
                                <div class="info">
                                    <img class="avatar" src="https://pietras17.ct8.pl/wp-content/uploads/2023/01/cropped-favicon.webp" alt="Henryk Filipowicz" srcset="">
                                    <span class="author">Garagenonline</span>
                                    <span class="data"><?php echo get_the_date('Y-m-d') ?></span>
                                </div>
                            </div>
                        <?php endwhile ?>
                    </div>
                </div>
                <div class="home-link">
                    <div class="inner">
                        <a href="<?php echo get_post_type_archive_link('post') ?>">Przejdź na blog</a>
                    </div>
                </div>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>
        <!-- sekcja warum wir -->
        <div class="warum_wir">
            <?php if (get_field('section_warum_wir')["is_active"] == "tak") : ?>
                <?php foreach (get_field('section_warum_wir')["icons_blocks"] as $single) : ?>
                    <div class="single">
                        <i class="<?php echo $single['klasa_ikonki'] ?>"></i>
                        <div class="copy">
                            <h5><?php echo $single['heading'] ?></h5>
                            <p><?php echo $single['description'] ?></p>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</main>
<?php
get_footer();
