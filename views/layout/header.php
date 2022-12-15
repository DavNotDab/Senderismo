<?php session_start(); ?>

<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Senderismo</title>
    <link rel="stylesheet" href="<?=base_url?>styles/style.css">
</head>
<body>
<!-- HEADER -->
<header class="header">
    <div class="header_logo">
        <img src="<?=base_url?>images/senderismo.png" alt="Logo senderismo" class="logo_img">
        <a href="<?=base_url?>" class="logo_title">
            <h1>Rutas Senderismo</h1>
        </a>
    </div>
    <div class="actions">
        <form action="<?=base_url?>Ruta/buscar" method="post" class="form_buscar">
            <label for="buscar" class="label_buscar">Buscar por:</label>
            <select name="data[categoria]" id="buscar" class="submit">
                <option value="titulo">Titulo</option>
                <option value="descripcion">Descripci&oacute;n</option>
            </select>
            <input type="search" name="data[busqueda]" id="buscar" required class="input_field">
            <input type="submit" value="Buscar" class="submit">
        </form>
        <nav class="nav_menu">
            <ul class="menu_content">
                <?php if (isset($_SESSION["identity"])): ?>
                    <li><a href="<?=base_url?>Ruta/save">Crear Ruta</a></li>
                    <li><a href="<?=base_url?>Usuario/logout">Cerrar Sesi&oacute;n</a></li>
                <?php else: ?>
                    <li><a href="<?=base_url?>Usuario/login">Iniciar Sesi&oacute;n</a></li>
                    <li><a href="<?=base_url?>Usuario/save">Registrarse</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>