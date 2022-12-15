<?php
namespace Repositories;

use lib\BaseDatos;

class UsuarioRepository extends BaseDatos {

    // Comprueba los datos de un usuario que va a iniciar sesión
    // Si los datos son correctos devuelve true, si no un mensaje de error
    public function comprobarUsuarioLogin($email, $password): bool|string {
        $sql = "SELECT email, password FROM usuarios WHERE email = :email";
        $this->consultaPrep($sql, [":email" => $email]);
        $datos = $this->extraerRegistro();

        if ($datos === false) {
            return "ERROR:<br> Usuario no registrado.";
        }

        return $this->verifyPassword($password, $datos["password"]) ? true : "ERROR:<br> Contraseña incorrecta.";
    }

    // Comprueba si existe un usuario con el email indicado en la base de datos
    // Si existe devuelve true, si no false
    public function comprobarExisteUsuario($email) : bool {
        $sql = "SELECT email FROM usuarios WHERE email = :email";
        $this->consultaPrep($sql, [":email" => $email]);
        return $this->extraerRegistro() !== false;
    }

    // Guarda un usuario en la base de datos
    public function save(array $usuario) : void {
        $this->consultaPrep("INSERT INTO usuarios (nombre, email, password) VALUES (:nombre, :email, :password)", $usuario);
    }

    // Actualiza los datos de un usuario en la base de datos
    public function update(array $usuario) : void {
        $this->consultaPrep("UPDATE usuarios SET nombre = :usuario, clave = :clave, rol = :rol WHERE codigo = :codigo", $usuario);
    }

    // Elimina un usuario de la base de datos
    public function delete(string $nombre) : void {
        $this->consultaPrep("DELETE FROM usuarios WHERE nombre = :nombre", [":nombre"=>$nombre]);
    }

    // Comprueba si la contraseña introducida coincide con la contraseña encriptada de la base de datos
    public function verifyPassword($clave, $hash) : bool {
        return password_verify($clave, $hash);
    }

}
