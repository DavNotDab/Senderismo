<?php $ruta = $_SESSION["ruta"]; ?>

<h2>Editar Ruta</h2>

<div class="form_content">
    <form action="<?=base_url?>Ruta/update" method="post" class="form">
        <input type="hidden" name="data[id]" value="<?= $ruta->getId() ?>">
        <label for="titulo">T&iacute;tulo:</label>
        <input type="text" name="data[titulo]" id="titulo" value="<?= $ruta->getTitulo()?>" required class="input_field">
        <br>
        <label for="descripcion">Descripci&oacute;n:</label>
        <input type="text" name="data[descripcion]" id="descripcion" value="<?= $ruta->getDescripcion()?>" required class="input_largo">
        <br>
        <label for="desnivel">Desnivel (m):</label>
        <input type="number" name="data[desnivel]" id="desnivel" min="0" max="7999" value="<?= $ruta->getDesnivel()?>" required class="input_corto">
        <br>
        <label for="distancia">Distancia (Km):</label>
        <input type="number" name="data[distancia]" id="distancia" min="0" max="999" value="<?= $ruta->getDistancia()?>" step=".01" required class="input_corto">
        <br>
        <label for="dificultad">Dificultad:</label>
        <select name="data[dificultad]" id="dificultad" required class="input_corto">
            <option value="1" <?php if($ruta->getDificultad() == 1) echo "selected"?>>1</option>
            <option value="2" <?php if($ruta->getDificultad() == 2) echo "selected"?>>2</option>
            <option value="3" <?php if($ruta->getDificultad() == 3) echo "selected"?>>3</option>
            <option value="4" <?php if($ruta->getDificultad() == 4) echo "selected"?>>4</option>
            <option value="5" <?php if($ruta->getDificultad() == 5) echo "selected"?>>5</option>
        </select>
        <br>
        <label for="notas">Notas:</label>
        <textarea name="data[notas]" id="notas" cols="70" rows="8" placeholder="Notas..."><?= $ruta->getNotas()?></textarea>
        <br>
        <span class="error"><?= $error ?? "" ?></span>
        <br>
        <input type="submit" value="Editar" class="submit">
    </form>
</div>