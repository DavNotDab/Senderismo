
<h2>Comentarios de la ruta</h2>

<!--Tabla que muestra la información de la ruta a comentar-->
<div class="ruta_content">
    <h3>Ruta:</h3>
    <table class="listado_rutas">
        <tr class="header_listado">
            <th>T&iacute;tulo</th>
            <th>Descripci&oacute;n</th>
            <th>Desnivel (m)</th>
            <th>Distancia (Km)</th>
            <th>Dificultad (Sobre 5)</th>
            <th>Notas</th>
        </tr>
        <tr>
            <!--Se muestran los datos de la ruta-->
            <?php foreach ($_SESSION["ruta"]->toArray() as $key => $value) : ?>
                <?php if($key != "id") : ?>
                    <td><?= $value ?></td>
                <?php endif; ?>
            <?php endforeach; ?>
        </tr>
    </table>
</div>


<div class="comentarios">
    <h3>Comentarios:</h3>
    <!--Tabla que muestra los comentarios de la ruta así como el formulario para añadir uno nuevo-->
    <table class="listado_comentarios">
        <tr class="header_listado">
            <th>Nombre</th>
            <th>Fecha</th>
            <th colspan="2">Comentario</th>
        </tr>
        <tr>
            <form action="<?=base_url?>Comentario/save" method="post" class="form">
                <input type="hidden" name="data[id_ruta]" value="<?=$_SESSION["ruta"]->getId()?>">
                <td><input type="text" name="data[nombre]" required class="input_field" pattern="[a-zA-Z\sáéíóúÁÉÍÓÚñÑ]*"></td>
                <td><input type="text" name="data[fecha]" value="<?=date('Y-m-d')?>" disabled class="input_field"></td>
                <td><input type="text" name="data[texto]" required class="input_largo" pattern="[a-zA-Z0-9\s\.,!¡¿?áéíóúÁÉÍÓÚñÑ\-_]*"></td>
                <td><input type="submit" value="Comentar" class="submit"></td>
            </form>
        </tr>
        <!--Se comprueba que existe el error de este usuario comentado en esta ruta-->
        <!--Si existe se muestra el error-->
        <?php $error = "User:".$_SESSION["identity"]."-ErrorComentado".$_SESSION["ruta"]->getId(); ?>
        <?php if (isset($_SESSION[$error])) : ?>
            <tr>
                <td colspan="3"><span class="error"><?= $_SESSION[$error] ?? ""?></span></td>
            </tr>
        <?php endif; ?>
        <?php foreach ($_SESSION["comentarios"] as $comentario) : ?>
            <tr>
                <td><?= $comentario->getNombre() ?></td>
                <td><?= $comentario->getFecha() ?></td>
                <td><?= $comentario->getTexto() ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

</div>