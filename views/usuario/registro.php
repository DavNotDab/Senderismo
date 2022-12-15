
<h1>Registrar un nuevo usuario</h1>


<div class="form_content">
    <form action="<?=base_url?>Usuario/save" method="post" class="form">
        <label for="nombre">Nombre:</label>
        <input type="text" name="data[nombre]" id="nombre" required class="input_field">
        <br>
        <label for="email">Email:</label>
        <input type="email" name="data[email]" id="email" required class="input_field">
        <br>
        <label for="password">Contrase&ntilde;a:</label>
        <input type="password" name="data[password]" id="password" required class="input_field">
        <br>
        <span class="error"> <?= $error ?? ""?></span>
        <br>
        <input type="submit" value="Registrarse" class="submit">
    </form>
</div>