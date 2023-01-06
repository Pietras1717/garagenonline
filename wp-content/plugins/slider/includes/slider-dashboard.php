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
                        <label for="sliderActive">Aktywacja slidera</label>
                        <input class="optionsInput" name="sliderActive" type="checkbox">
                    </div>
                    <div class="form-group">
                        <label for="sliderCount">Maksymalna liczba slajdów</label>
                        <select class="optionsInput" name="sliderCount">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sliderDuration">Czas trwania przejścia</label>
                        <input class="optionsInput" name="sliderDuration" type="number" value="1000" step="1000" min="1000" max="15000">
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