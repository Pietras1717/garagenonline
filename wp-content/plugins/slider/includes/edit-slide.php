<?php
wp_enqueue_media();
$slideId = isset($_GET['slideid']) ? intval($_GET['slideid']) : 0;
global $wpdb;
$slideSingle = $wpdb->get_row($wpdb->prepare(
    "Select * FROM " . returnTableName("slider_tables") . " WHERE id=%d",
    $slideId
), ARRAY_A);
?>
<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Slider - Edycja slajdu <?php echo $_GET["slideid"] ?></h1>
    </div>
    <div class="plugin-body">
        <form data-id="<?php echo $slideId ?>" id="frmEditSlide" action="javascript:void(0)">
            <div class="content">
                <div class="data">
                    <div class="form-group">
                        <label for="isshow">Czy aktywny</label>
                        <input style="flex-grow: 0;" name="isshow" type="checkbox" <?php echo $slideSingle['isactive'] == 1 ? "checked" : "" ?>>
                    </div>
                    <div class="form-group">
                        <label for="heading">Nagłówek</label>
                        <input value="<?php echo $slideSingle['heading'] ?>" type="text" name="heading" id="heading">
                    </div>
                    <p class="error heading"></p>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" cols="30" rows="10"><?php echo $slideSingle['description'] ?></textarea>
                    </div>
                    <p class="error content"></p>
                </div>
                <div class="imgSection">
                    <img src="<?php echo $slideSingle['imagePath'] ?>" alt="" data-img="<?php echo $slideSingle['imagePath'] ?>">
                    <p class="error image"></p>
                    <button class="plugin_save_changes" id="sliderUploadImage">Edytuj zdjęcie</button>
                </div>
            </div>
            <input type="submit" class="plugin_save_changes" value="Zapisz zmiany">
        </form>
        <div class="info-message">
            <p class="message"><strong>Info!</strong> Tutaj komunikat</p>
            <button class="closebtn">X</button>
        </div>
    </div>
</div>