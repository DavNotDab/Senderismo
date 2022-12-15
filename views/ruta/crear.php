
<h2>Crear Ruta</h2>

<div class="form_content">
    <form action="<?=base_url?>Ruta/save" method="post" class="form">
        <label for="titulo">T&iacute;tulo:</label>
        <input type="text" name="data[titulo]" id="titulo" required class="input_field">
        <br>
        <label for="descripcion">Descripci&oacute;n:</label>
        <input type="text" name="data[descripcion]" id="descripcion" required class="input_largo">
        <br>
        <label for="desnivel">Desnivel (m):</label>
        <input type="number" name="data[desnivel]" id="desnivel" min="0" max="7999" required class="input_corto">
        <br>
        <label for="distancia">Distancia (Km):</label>
        <input type="number" name="data[distancia]" id="distancia" step=".01" min="0" max="999" required class="input_corto">
        <br>
        <label for="dificultad">Dificultad:</label>
        <select name="data[dificultad]" id="dificultad" required class="input_corto">
            <option value="1" selected>1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
        </select>
        <br>
        <label for="notas">Notas:</label>
        <textarea name="data[notas]" id="notas" cols="70" rows="8" placeholder="Notas..."></textarea>
        <br>
        <span class="error"><?= $error ?? "" ?></span>
        <br>
        <input type="submit" value="Añadir" class="submit">
    </form>
</div>