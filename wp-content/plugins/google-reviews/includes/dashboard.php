<?php
global $wpdb;
?>
<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Google Reviews - Dashboard</h1>
    </div>
    <div class="plugin-body">
        <form action="javascript:void(0)" id="frmGoogleReviews">
            <div class="left-column">
                <h3>Basic Settings</h3>
                <div class="form-inputs">
                    <div class="form-group">
                        <?php
                        $cid = $wpdb->get_row($wpdb->prepare(
                            "Select * FROM " . $wpdb->prefix . "options" . " WHERE option_name='google_reviews_cid'"
                        ), ARRAY_A);
                        ?>
                        <label for="GoogleReviewCid">Google Place CID</label>
                        <input class="optionsInput" name="GoogleReviewCid" type="text" value="<?php echo $cid["option_value"] ?>">
                    </div>
                </div>
            </div>
            <div class="right-column">
                <h3>Actions</h3>
                <button class="greviews_save_changes" type="submit">Zapisz zmiany</button>
            </div>
        </form>
        <div class="about-plugin">
            <div>
                <h3>Plugin information</h3>
                <span>Plugin version:</span><span>1.0</span>
            </div>
            <div>
                <h3>Plugin author</h3>
                <span>Piotr Rysz</span>
            </div>
            <div>
                <div class="shortcode">
                    <input type="text" value="[google_reviews_pietras17]" readonly>
                    <button id="copyShortcodeClipboard" class="plugin_save_changes">Kopiuj shortcode</button>
                </div>
            </div>
        </div>
        <div class="info-message">
            <p class="message"><strong>Info!</strong> Tutaj komunikat</p>
            <button class="closebtn">X</button>
        </div>
    </div>
</div>
<?php
$wpdb->flush();
?>