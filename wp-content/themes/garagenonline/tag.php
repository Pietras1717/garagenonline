<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <div class="container">
        <!-- Breadcrumbs -->
        <?php get_template_part("/template-parts/breadcrumbs"); ?>
        <!-- wpisy blogowe -->
        <?php
        $recent_post = new WP_Query(array('post_type' => 'post', 'post_per_page' => 1, 'tag' => get_queried_object()->name));
        if ($recent_post->have_posts()) : ?>
            <div class="blog-posts blog">
                <div class="posts-container">
                    <div class="category-info">
                        <h2>
                            <?php echo get_queried_object()->name ?>
                        </h2>
                        <p class="desc">
                            <?php echo get_queried_object()->description ?>
                        </p>
                    </div>
                    <div class="posts blog">
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
                    <?php
                    $total = $recent_post->post_count;
                    ?>
                    <?php if (!$total) : ?>
                        <div class="empty">
                            Aktualnie nie mamy wpisów dla kategorii: <?php echo get_queried_object()->name ?>
                        </div>
                    <?php endif ?>
                    <div class="pagination">
                        <?php echo theme_pagination(); ?>
                    </div>
                </div>
                <div class="widgets">
                    <?php dynamic_sidebar('blog_right'); ?>
                </div>
            </div>
        <?php endif;
        wp_reset_postdata(); ?>
    </div>
</main>
<?php
get_footer();
