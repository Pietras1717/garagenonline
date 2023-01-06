<div class="plugin-wrapper">
    <div class="plugin-heading">
        <h1>Slider - Dashboard</h1>
    </div>
    <div class="plugin-body">
        <form action="javascript:void(0)">
            <div class="left-column">
                <h3>Basic Settings</h3>
                <div class="form-inputs">
                    <div class="form-group">
                        <label for="sliderActive">Aktywacja slidera</label>
                        <div class="switch">
                            <input type="checkbox" checked>
                            <span class="slider round"></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="sliderCount">Maksymalna liczba slajdów</label>
                        <select>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="sliderDuration">Czas trwania przejścia</label>
                        <input type="number" value="1000" step="1000" min="1000" max="15000">
                    </div>
                </div>
            </div>
            <div class="right-column">
                <h3>Actions</h3>
                <button class="plugin_save_changes" type="submit">Zapisz zmiany</button>
            </div>
        </form>
    </div>
</div>