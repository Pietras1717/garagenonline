<div class="page-header">
    <img src="<?php print_r(get_field('page_header', 'options')['url']) ?>" alt="<?php print_r(get_field('page_header', 'options')['alt']) ?>">
    <div class="container">
        <div class="text">
            <h1>
                <?php
                if (is_category()) {
                    echo wp_title('Kategoria: ');
                } else if (is_tag()) {
                    echo wp_title('Tag: ');
                } else if (is_search()) {
                    echo 'Wyniki wyszukiwania dla : ' . get_query_var('s');
                } else if (is_archive()) {
                    echo wp_title('');
                } else {
                    echo wp_title('');
                }
                ?>
            </h1>
        </div>
    </div>
</div>
<div class="breadcrumbs">
    <div class="container">
        <ol>
            <?php if (!is_front_page()) : ?>
                <li><a href="/"><i class="fa fa-home"></i> Strona główna</a></li>
                <li> > </li>
            <?php endif ?>
            <?php if (is_home()) : ?>
                <li>Blog</li>
            <?php endif ?>
            <?php if (is_category()) : ?>
                <li>Kategoria: <?php echo ucfirst(get_queried_object()->name) ?></li>
            <?php endif ?>
            <?php if (is_tag()) : ?>
                <li>Tag: <?php echo ucfirst(get_queried_object()->name) ?></li>
            <?php endif ?>
            <?php if (is_404()) : ?>
                <li>404</li>
            <?php endif ?>
            <?php if (is_page()) : ?>
                <li><?php ucfirst(wp_title('')) ?></li>
            <?php endif ?>
            <?php if (is_search()) : ?>
                <li><?php echo 'Wyniki wyszukiwania dla : ' . get_query_var('s'); ?></li>
            <?php endif ?>
            <?php if (is_archive() && !is_category() && !is_tag()) : ?>
                <li><?php echo wp_title('') ?></li>
            <?php endif ?>
            <?php if (is_single()) : ?>
                <li><a href="/aktualnosci"> Blog</a></li>
                <li> > </li>
                <li><a href=<?php echo "/kategoria/" . get_the_category()[0]->slug ?>> <?php echo get_the_category()[0]->cat_name ?></a></li>
                <li> > </li>
                <li><?php ucfirst(wp_title('')) ?></li>
            <?php endif ?>
        </ol>
    </div>
</div>