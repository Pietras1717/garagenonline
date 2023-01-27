<head>
    <link rel="stylesheet" href="<?php echo PLUGIN_URL ?>/assets/css/reviews.css">
</head>
<?php
global $wpdb;
$cid = $wpdb->get_row($wpdb->prepare(
    "Select * FROM " . $wpdb->prefix . "options" . " WHERE option_name='google_reviews_cid'"
), ARRAY_A)["option_value"];
echo download_reviews($cid);



function download_reviews($cid)
{
    $ch = curl_init('https://www.google.com/maps?cid=' . $cid);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/83.0.4103.116 Safari/537.36');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $result = curl_exec($ch);
    curl_close($ch);
    $pattern = '/window\.APP_INITIALIZATION_STATE(.*);window\.APP_FLAGS=/ms';
    if (preg_match($pattern, $result, $match)) {
        $match[1] = trim($match[1], ' =;');
        $reviews  = json_decode($match[1]);
        $reviews  = ltrim($reviews[3][6], ")]}'");
        $reviews  = json_decode($reviews);
        $customer = $reviews[6][11];
        $reviews  = $reviews[6][52][0];
    }
    if (isset($reviews)) {

        array_multisort(array_map(function ($element) {
            return $element[4];
        }, $reviews), SORT_DESC, $reviews);
?>
        <div class="google-reviews">
            <!-- <div class="heading">
                <h3>Opinie z google</h3>
            </div> -->
            <img class="reviews-logo" src="<?php echo PLUGIN_URL ?>/images/google_reviews_heading.png" alt="Google Reviews Garagenonline" srcset="">
            <div class="reviews-list">
                <?php
                foreach ($reviews as $review) {
                ?>
                    <div class="single-reviews">
                        <div class="user">
                            <img src="<?php echo $review[0][2] ?>" alt="">
                            <p><?php echo $review[0][1] ?></p>
                        </div>
                        <div class="rate">
                            <?php
                            for ($i = 1; $i <= $review[4]; ++$i) {
                            ?>
                                <span>⭐</span>
                            <?php
                            };
                            for ($i = 1; $i <= 5 - $review[4]; ++$i) {
                            ?>
                                <span>☆</span>
                            <?php
                            }
                            ?>
                        </div>
                        <p class="description">
                            <?php echo $review[3] ?>
                        </p>
                        <p class="time">
                            <?php echo $review[1] ?>
                        </p>
                    </div>
        <?php
                }
            }
        }
        $wpdb->flush();
        ?>
            </div>
        </div>