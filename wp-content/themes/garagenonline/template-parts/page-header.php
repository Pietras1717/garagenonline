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