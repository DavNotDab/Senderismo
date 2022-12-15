<?php
namespace Controllers;

use models\Comentario;
use Lib\Pages;
use Services\ComentarioService;

class ComentarioController {
    private ComentarioService $service;
    private Pages $pages;
    private RutaController $rutaController;

    public function __construct() {
        $this->service = new ComentarioService();
        $this->pages = new Pages();
        $this->rutaController = new RutaController();
    }

    // Funcion para guardar un comentario
    public function save() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Se construye el nombre de la cookie del comentario y la sesion de error.
            // A partir del nombre del usuario y el ID de la ruta
            $usuario = $_SESSION["identity"];
            $cookie = "User:".$usuario."-Comentado".$_POST["data"]["id_ruta"];
            $error = "User:".$usuario."-ErrorComentado".$_POST["data"]["id_ruta"];

            // Si existe la cookie se lanza el error y no se guarda el comentario
            if (isset($_COOKIE[$cookie])) {
                $_SESSION[$error] = "Solo puedes comentar una vez por ruta al día";
                header("Location: ".base_url."Comentario/save&ruta=".$_POST["data"]["id_ruta"]);
                return;
            }

            // Si no existe la cookie pero si el error, se borra para que no salga por defecto
            if (isset($_SESSION[$error])) unset($_SESSION[$error]);

            // Como la fecha está disabled en el formulario, se le asigna la fecha actual
            $_POST["data"]["fecha"] = Date("Y-m-d");

            // Se valida el comentario y si es correcto se guarda y se crea la cookie
            // Si no, se guarda una sesión de error con el mensaje correspondiente
            $valido = Comentario::validar_comentario($_POST["data"]);
            if ($valido === true) {
                $this->service->save($_POST["data"]);
                setcookie(htmlspecialchars($cookie), "true", time() + 86400);
            } else {
                $_SESSION[$error] = $valido;
            }

            // Se redirige a la pagina de crear comentario
            // Siempre se redirige, ya sea para mostrar el nuevo comentario o el error
            header("Location: ".base_url."Comentario/save&ruta=".$_POST["data"]["id_ruta"]);
        }
        // Si el método no es POST, se coge la ID de ruta enviada por get
        // Y se guardan las sesiones tanto de la ruta como de los comentarios
        else {
            $id_ruta = $_GET["ruta"];
            $ruta = $this->rutaController->getRuta($id_ruta);
            $comentarios = $this->rutaController->getComentarios($id_ruta);
            $_SESSION["ruta"] = $ruta;
            $_SESSION["comentarios"] = $comentarios;

            $this->pages->render("comentario/crear");
        }

    }

}
