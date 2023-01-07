<head>
    <link rel="stylesheet" href="<?php echo SLIDER_PLUGIN_URL ?>/assets/css/slider.css">
</head>

<body>
    <?php
    global $wpdb;
    $active = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderActive'"
    ), ARRAY_A)['option_value'];
    $blockColor = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='blockColor'"
    ), ARRAY_A)['option_value'];
    $sliderDuration = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderDuration'"
    ), ARRAY_A)['option_value'];
    $sliderCount = $wpdb->get_row($wpdb->prepare(
        "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderCount'"
    ), ARRAY_A)['option_value'];

    if ($active) {
        $getSlides = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM " . returnTableName("slider_tables") . " WHERE isactive='1' ORDER BY ID DESC LIMIT " . $sliderCount
        ), ARRAY_A);
        if (count($getSlides) > 0) : ?>

            <section class="slider" data-color="<?php echo $blockColor ?>" data-time="<?php echo $sliderDuration ?>">
                <div class="slides">
                    <?php $count = 1;
                    foreach ($getSlides as $slide) :
                    ?>
                        <div class="single-slide <?php echo  $count == 1 ? "active" : "" ?>">
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
                        $count++;

                    endforeach ?>
                </div>
                <div class="dots">
                    <?php $count = 1;
                    foreach ($getSlides as $slide) :
                    ?>
                        <div class="single-dot <?php echo  $count == 1 ? "active" : "" ?>">
                        </div>
                    <?php
                        $count++;
                    endforeach ?>
                </div>
            </section>

    <?php endif;
    }
    ?>
    <script src="<?php echo SLIDER_PLUGIN_URL ?>/assets/js/script.js"></script>
</body>