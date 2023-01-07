<head>
    <link rel="stylesheet" href="<?php echo SLIDER_PLUGIN_URL ?>/assets/css/slider.css">
</head>

<body>
    <?php
    global $wpdb;
    $i = 1;
    $active = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderActive'"
    ), ARRAY_A)['option_value'];
    $blockColor = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='blockColor'"
    ), ARRAY_A)['option_value'];

    if ($active) {
        $getSlides = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . returnTableName("slider_tables") . " WHERE isactive='1' ORDER BY ID DESC"
        ), ARRAY_A);
        if (count($getSlides) > 0) : ?>

            <section class="slider">
                <?php foreach ($getSlides as $slide) : ?>
                    <div class="single-slide <?php echo  count($getSlides) == 1 ? "active" : "" ?>">
                        <div class="slide-img">
                            <img src="<?php echo $slide['imagePath'] ?>" alt="<?php echo image_alt_by_url($slide['imagePath']) ?>">
                        </div>
                        <div style="background-color:<?php echo $blockColor ?>CC" class="slide-content">
                            <h2><?php echo $slide['heading'] ?></h2>
                            <p class="slide_description">
                                <?php echo $slide['description'] ?>
                            </p>
                        </div>
                    </div>
                <?php
                endforeach ?>
                <div class="dots">
                    <?php foreach ($getSlides as $slide) : ?>
                        <div style="background-color:<?php echo  count($getSlides) == 1 ? $blockColor : $blockColor . "CC" ?>;" class="single-dot <?php echo  count($getSlides) == 1 ? "active" : "" ?>">
                        </div>
                    <?php
                    endforeach ?>
                </div>
            </section>

    <?php endif;
    }
    ?>
    <script src="<?php echo SLIDER_PLUGIN_URL ?>/assets/js/script.js"></script>
</body>