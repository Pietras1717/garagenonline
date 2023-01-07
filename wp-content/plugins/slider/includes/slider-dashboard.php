<?php
global $wpdb;
?>
<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Slider - Dashboard</h1>
    </div>
    <div class="plugin-body">
        <form action="javascript:void(0)" id="frmSettings">
            <div class="left-column">
                <h3>Basic Settings</h3>
                <div class="form-inputs">
                    <div class="form-group">
                        <?php
                        $sliderActive = $wpdb->get_row($wpdb->prepare(
                            "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderActive'"
                        ), ARRAY_A);
                        ?>
                        <label for="sliderActive">Aktywacja slidera</label>
                        <input class="optionsInput" name="sliderActive" type="checkbox" <?php echo  $sliderActive["option_value"] == "true" ? "checked" : ""  ?>>
                    </div>
                    <div class="form-group">
                        <?php
                        $sliderCount = $wpdb->get_row($wpdb->prepare(
                            "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderCount'"
                        ), ARRAY_A);
                        ?>
                        <label for="sliderCount">Maksymalna liczba slajdów</label>
                        <select class="optionsInput" name="sliderCount">
                            <option <?php echo $sliderCount["option_value"] == 1 ? "selected" : "" ?> value="1">1</option>
                            <option <?php echo $sliderCount["option_value"] == 2  ? "selected" : "" ?> value="2">2</option>
                            <option <?php echo $sliderCount["option_value"] == 3  ? "selected" : "" ?> value="3">3</option>
                            <option <?php echo $sliderCount["option_value"] == 4  ? "selected" : "" ?> value="4">4</option>
                            <option <?php echo $sliderCount["option_value"] == 5  ? "selected" : "" ?> value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <?php
                        $sliderDuration = $wpdb->get_row($wpdb->prepare(
                            "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='sliderDuration'"
                        ), ARRAY_A);
                        ?>
                        <label for="sliderDuration">Czas trwania przejścia</label>
                        <input class="optionsInput" name="sliderDuration" type="number" value="<?php echo  !$sliderDuration ? 1000 : $sliderDuration["option_value"] ?>" step="1000" min="1000" max="15000">
                    </div>
                    <div class="form-group">
                        <?php
                        $sliderBlockColor = $wpdb->get_row($wpdb->prepare(
                            "Select * FROM " . returnTableName("slider_options") . " WHERE option_name='blockColor'"
                        ), ARRAY_A);
                        ?>
                        <label for="blockColor">Czas trwania przejścia</label>
                        <input class="optionsInput" name="blockColor" type="color" value="<?php echo  !$sliderDuration ? "#000000" : $sliderBlockColor["option_value"] ?>">
                    </div>
                </div>
            </div>
            <div class="right-column">
                <h3>Actions</h3>
                <button class="plugin_save_changes" type="submit">Zapisz zmiany</button>
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
                    <input type="text" value="[do_shortcode]" readonly>
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