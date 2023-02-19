<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <div class="container">
        <!-- Breadcrumbs -->
        <?php get_template_part("/template-parts/breadcrumbs"); ?>
        <!-- Single Post -->
        <div class="blog-posts blog">
            <div class="posts-container">
                <div class="posts blog">
                    <div class="one-post">
                        <div class="img">
                            <img src="<?php echo get_the_post_thumbnail_url() ?>" alt="<?php echo get_post_meta(get_post_thumbnail_id(), '_wp_attachment_image_alt', true) ?>">
                        </div>
                        <div class="info">
                            <img class="avatar" src="https://pietras17.ct8.pl/wp-content/uploads/2023/01/cropped-favicon.webp" alt="Henryk Filipowicz" srcset="">
                            <span class="author">Garagenonline</span>
                            <!-- <span class="data"><?php echo get_the_date('Y-m-d') ?></span> -->
                        </div>
                        <div class="post-text">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                                echo '<a class="category" href="' . esc_url(get_category_link($categories[0]->term_id)) . '">' . esc_html($categories[0]->name) . '</a>';
                            }
                            ?>
                            <h2 class="title"><?php echo the_title() ?></h2>
                            <div class="content">
                                <?php echo the_content() ?>
                            </div>
                        </div>
                    </div>
                    <div class="one-post">
                        <?php //comments_template(); 
                        ?>
                    </div>
                </div>
            </div>
            <div class="widgets">
                <?php dynamic_sidebar('blog_right'); ?>
            </div>
        </div>
        <!-- wpisy blogowe -->
        <?php
        $categories_id = array();
        $current_category = get_the_category();
        foreach ($current_category as $cc) {
            $categories_id[] = $cc->term_id;
        }
        $recent_post = new WP_Query(array("posts_per_page" => 3, 'cat' => $categories_id, "orderby" => "date", "order" => "DESC", 'post__not_in' => array(get_the_ID())));
        if ($recent_post->have_posts()) : ?>
            <div class="blog-posts">
                <h3>Powiązane wpisy</h3>
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
                                    <!-- <span class="data"><?php echo get_the_date('Y-m-d') ?></span> -->
                                </div>
                            </div>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>
<?php
get_footer();
