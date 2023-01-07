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

    if ($active) {
        $getSlides = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . returnTableName("slider_tables") . " WHERE isactive='1' ORDER BY ID DESC"
        ), ARRAY_A);
        if (count($getSlides) > 0) : ?>

            <section class="slider">
                <?php foreach ($getSlides as $slide) : ?>
                    <div class="single-slide <?php echo  $i == 1 ? "active" : "" ?>">
                        <img src="<?php echo $slide['imagePath'] ?>" alt="<?php echo image_alt_by_url($slide['imagePath']) ?>">
                        <h2><?php echo $slide['heading'] ?></h2>
                        <p class="slide_description">
                            <?php echo $slide['description'] ?>
                        </p>
                    </div>
                <?php $i++;
                endforeach ?>

            </section>

    <?php endif;
    }
    ?>
    <script src="<?php echo SLIDER_PLUGIN_URL ?>/assets/js/script.js"></script>
</body>