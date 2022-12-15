<?php use Utils\Utils; ?>
<?php if (isset($error)) : ?>
    <p class="errorFatal"><?= $error ?></p>
<?php endif; ?>

<?php if (isset($rutas)) : ?>
    <table class="listado_rutas">
        <tr class="header_listado">
            <th>T&iacute;tulo</th>
            <th>Descripci&oacute;n</th>
            <th>Desnivel (m)</th>
            <th>Distancia (Km)</th>
            <th>Dificultad (Sobre 5)</th>
            <?php if (isset($_SESSION["identity"])) : ?>
                <th colspan="4">Operaciones</th>
            <?php else: ?>
                <th colspan="4">Inicia sesi&oacute;n para realizar operaciones</th>
            <?php endif; ?>
        </tr>

        <?php foreach ($rutas as $ruta) : ?>
            <tr>
                <?php foreach ($ruta->toArray() as $key => $value) : ?>
                    <?php if ($key != "notas" && $key != "id") : ?>
                        <td><?= $value ?></td>
                    <?php endif; ?>
                <?php endforeach; ?>
                <?php if (isset($_SESSION["identity"])) : ?>
                    <td>
                        <form action="<?=base_url.'Comentario/save&ruta='.$ruta->getId()?>" method="GET">
                            <input type="submit" name="comentar" value="Comentar" class="submit">
                        </form>
                    </td>
                    <td>
                        <form action="<?= base_url.'Ruta/update&ruta='.$ruta->getId()?>" method="GET">
                            <input type="submit" name="update" value="Editar" class="submit">
                        </form>
                    </td>
                    <?php if ($_SERVER["REQUEST_METHOD"] == "GET") : ?>
                        <?php if (!isset($_GET["ruta"])) $_GET["ruta"] = ""; ?>
                        <?php if ($ruta->getId() == $_GET["ruta"]) : ?>
                            <td>
                                <form action="<?=base_url.'Ruta/delete'?>" method="POST">
                                    <button class="submit" type="submit" name="ruta" value="X">&#10005;</button>
                                </form>
                            </td>
                            <td>
                                <form action="<?=base_url.'Ruta/delete'?>" method="POST">
                                    <button class="submit" type="submit" name="ruta" value="<?=$ruta->getId()?>">&#10003;</button>
                                </form>
                            </td>
                        <?php else: ?>
                            <td colspan="2">
                                <form action="<?=base_url.'Ruta/delete&ruta='.$ruta->getId()?>" method="GET">
                                    <input type="submit" name="ruta" value="Eliminar" class="submit">
                                </form>
                            </td>
                        <?php endif; ?>
                    <?php endif; ?>

                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>
    <br><br>
    <p>El nº total de rutas es: <b><?=count($rutas)?></b></p>
    <?php $larga = Utils::getLarga($rutas); ?>
    <span>La ruta m&aacute;s larga tiene: <b><?=$larga->getDistancia()?></b></span>
<?php endif; ?>
