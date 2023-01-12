<?php
get_header();
get_template_part('template-parts/page-header');
?>
<main>
    <div class="container">
        <!-- Breadcrumbs -->
        <?php get_template_part("/template-parts/breadcrumbs"); ?>
        <div class="contact-data">
            <h2>Haben Sie irgendwelche Fragen? schreiben oder anrufen!</h2>
            <section class="data">
                <div class="dane">
                    <div class="col">
                        <h3>Dane firmy</h3>
                        <p>Garagenonline Henryk Filipowicz</p>
                        <p>Großbeerenstr 2-10 G1</p>
                        <p>12107 Berlin</p>
                        <p>Beratung und Verkauf: Montag – Freitag 08:00 – 14:30</p>
                    </div>
                    <div class="col">
                        <h3>Dane do kontaktu</h3>
                        <p>Henryk Filipowicz</p>
                        <p>Tel: <a href="tel:03096615487">030 / 966 15 487</a></p>
                        <p>
                            Email:
                            <a href="mailto:info@garagenonline.eu">info@garagenonline.eu</a>
                        </p>
                    </div>
                </div>
                <?php
                echo do_shortcode('[contact-form-7 id="277" title="Formularz 1"]');
                ?>
            </section>
        </div>
    </div>
</main>
<?php
get_footer();
