<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <div class="container">
        <!-- Breadcrumbs -->
        <?php get_template_part("/template-parts/breadcrumbs"); ?>
        <?php the_content() ?>
    </div>
</main>
<?php
get_footer();
