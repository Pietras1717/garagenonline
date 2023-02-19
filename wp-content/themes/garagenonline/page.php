<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <div class="container">
        <!-- Breadcrumbs -->
        <?php get_template_part("/template-parts/breadcrumbs"); ?>
        <div class="single-page">
            <?php
            // content z wp
            the_content();
            ?>
        </div>
    </div>
</main>
<!-- Moduł do referenzen -->
<?php if (get_field('referenzen_block') && get_field('referenzen_block')['aktywna_sekcja'] == "tak") : ?>
    <div class="referenzen">
        <div class="container">
            <h2 class="referenzen-title">Lesen Sie, was Kunden sagen</h2>
            <div class="refenzes">
                <?php $imgIndex = 0;
                foreach (get_field('referenzen_block')['opinie_klientow'] as $single) : ?>
                    <div class="single-referenze" style="<?php echo  $imgIndex > 3 ? "display:none;" : "" ?>">
                        <div class="txt">
                            <?php
                            echo $single['opinia_klienta'];
                            ?>
                        </div>
                        <h3>Fotos von der Umsetzung</h3>
                        <div class="images">
                            <?php
                            $images = $single['zdjecia_z_realizacji'];
                            ?>
                            <?php foreach ($images as $image) : ?>
                                <a href="<?php echo $image ?>" data-title="<?php echo get_alt_from_img($image) ?>" data-lightbox="referenzen-<?php echo $imgIndex ?>"><img src="<?php echo $image ?>" alt="<?php echo get_alt_from_img($image) ?>"></a>
                            <?php endforeach ?>
                        </div>
                    </div>
                <?php $imgIndex++;
                endforeach;  ?>
            </div>
            <div class="loadmore">
                <a href="#" id="loadMore">Mehr laden</a>
            </div>
        </div>
    </div>
<?php endif ?>
<!-- Moduł do montageanleitungen -->
<?php if (get_field('montageanleitungen')) : ?>
    <div class="montageanleitungen">
        <div class="container">
            <div class="montageanleitungen-container">
                <?php
                foreach (get_field('montageanleitungen') as $single) : ?>
                    <a href="<?php echo $single['pdf'] ?>" target="_blank" class="single-montageanleitungen">
                        <img src="https://pietras17.ct8.pl/wp-content/uploads/2023/01/pdficon.webp" alt="pdficon">
                        <p class="file-title">
                            <?php echo $single['tytul_pliku'] ?>
                        </p>
                    </a>
                <?php
                endforeach;  ?>
            </div>
        </div>
    </div>
<?php endif ?>
<!-- Moduł do montageanleitungen -->
<?php if (get_field('montagefilme')) : ?>
    <div class="montagefilme">
        <div class="container">
            <div class="montagefilme-container">
                <?php
                foreach (get_field('montagefilme') as $single) : ?>
                    <div class="single-montagefilme">
                        <p class="title"><?php echo $single['tytul_filmu'] ?></p>
                        <video controls="true" src="<?php echo $single['video_file'] ? $single['video_file'] : $single['video_url'] ?>"></video>
                    </div>
                <?php
                endforeach;  ?>
            </div>
        </div>
    </div>
<?php endif ?>
<?php
get_footer();
