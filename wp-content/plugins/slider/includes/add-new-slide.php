<?php wp_enqueue_media() ?>
<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Slider - Add new slide</h1>
    </div>
    <div class="plugin-body">
        <form id="frmNewSlide" action="javascript:void(0)">
            <div class="content">
                <div class="data">
                    <div class="form-group">
                        <label for="heading">Nagłówek</label>
                        <input type="text" name="heading" id="heading">
                    </div>
                    <p class="error heading"></p>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="" cols="30" rows="10"></textarea>
                    </div>
                    <p class="error content"></p>
                </div>
                <div class="imgSection">
                    <img src="<?php echo SLIDER_PLUGIN_URL . "/assets/img/previewImage.png" ?>" alt="" data-img="">
                    <p class="error image"></p>
                    <button class="plugin_save_changes" id="sliderUploadImage">Dodaj zdjęcie</button>
                </div>
            </div>
            <input type="submit" class="plugin_save_changes" value="Dodaj slajd">
        </form>
    </div>
</div>