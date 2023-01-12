<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <!-- Breadcrumbs -->
    <?php get_template_part("/template-parts/breadcrumbs"); ?>
    <div class="error">
        <h2>4<span><i class="fa fa-warehouse"></i></span>4</h2>
        <h3>Error: 404 seite nicht gefunden</h3>
        <p>Ups,da ist etwas schief gelaufen.</p>
        <a href="<?php echo get_home_url() ?>">Startseite</a>
    </div>
</main>
<?php
get_footer();
