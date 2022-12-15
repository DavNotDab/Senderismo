<?php
namespace Controllers;

use Models\Usuario;
use Lib\Pages;
use Services\UsuarioService;


class UsuarioController {
    private UsuarioService $service;
    private Pages $pages;

    public function __construct() {
        $this->service = new UsuarioService();
        $this->pages = new Pages();
    }

    // Guarda un usuario en la base de datos
    public function save() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Primero se valida que los datos enviados por el formulario sean correctos
            // En caso de no serlos se vuelve al formulario y se muestra un error
            $valido = Usuario::validarSave($_POST["data"]);
            if ($valido === true) {
                // Si son correctos, se cifra la contraseña y se comprueba si el usuario existe
                $_POST["data"]["password"] = password_hash($_POST["data"]["password"], PASSWORD_BCRYPT, ["cost" => 4]);
                $existe = $this->service->existeUsuario($_POST["data"]);

                // Si existe se vuelve al formulario y se muestra un error
                if ($existe === true) {
                    $link = base_url."Usuario/login";
                    $error = "<p class='error'>El usuario ya existe,<br> <a href='$link'>inicie sesión</a></p>";
                    $this->pages->render("usuario/registro", ["error" => $error]);
                }
                else {
                    // Si no existe, se guarda el usuario y se redirige a la página de login
                    $this->service->save($_POST["data"]);
                    $this->pages->render("usuario/guardado", ["mensaje" => "Usuario guardado"]);
                    header("Refresh: 2; url=".base_url."usuario/login");
                    return;
                }
            }
            else {
                $this->pages->render("usuario/registro", ["error" => $valido]);
            }
        }
        $this->pages->render("usuario/registro");
    }

    // Funcion para iniciar sesión
    public function login() : void{
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Primero se valida que los datos enviados por el formulario sean correctos
            $valido = Usuario::validarLogin($_POST["data"]);
            if ($valido === true) {
                // Si son correctos, se comprueba si el usuario existe
                $existe = $this->service->existeUsuario($_POST["data"]);
                if ($existe === true) {
                    // Si existe, se comprueba si la contraseña es correcta
                    $estado = $this->service->verifyLogin($_POST["data"]);
                    if ($estado === true) {
                        // Si es correcta, se guarda el usuario en la sesión y se redirige a la página de inicio
                        // Si no es correcta, se vuelve al formulario y se muestra un error
                        $email = $_POST["data"]["email"];
                        $_SESSION["identity"] = str_split($email, strpos($email, "@"))[0];
                        header("Location: " . base_url);
                    } else {
                        $error = $estado;
                    }
                } else {
                    $link = base_url."Usuario/save";
                    $error = "<p class='error'>El usuario no existe,<br> <a href='$link'>Reg&iacute;strese</a></p>";
                }
            } else {
                $error = $valido;
            }
        }
        // Si el login no es correcto, se vuelve al formulario y se muestra el error correspondiente
        $this->pages->render("usuario/login", ["error" => $error ?? ""]);
    }

    // Funcion para cerrar sesión. Borra la sesión de usuario y redirige a la página de inicio
    public function logout() : void {
        session_start();
        if (isset($_SESSION["identity"])) {
            unset($_SESSION["identity"]);
        }
        session_destroy();
        header("Location: ".base_url);
    }

    // Función por defecto que no hace nada
    public function index(): void{}

}

