<?php
namespace Controllers;

use models\Ruta;
use models\Comentario;
use Lib\Pages;
use Services\RutaService;

class RutaController {
    private RutaService $service;
    private Pages $pages;

    public function __construct() {
        $this->service = new RutaService();
        $this->pages = new Pages();
    }

    // Muestra todas las rutas
    public function mostrarTodas() : void {
        $rutas = $this->service->getAll();
        $this->pages->render("ruta/listar", ["rutas" => $rutas]);
    }

    // Guarda una ruta validando sus datos antes
    // Si los datos no son válidos se genera un error y se vuelve a mostrar el formulario
    public function save() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["data"])) {
                $valido = Ruta::validar_ruta($_POST["data"]);
                if ($valido === true) {
                    $existe = $this->service->existeRuta($_POST["data"]["titulo"]);
                    if ($existe === true) {
                        $error = "La ruta ya existe, elija otro título";
                        $this->pages->render("ruta/crear", ["error" => $error]);
                    }
                    else {
                        $this->service->save($_POST["data"]);
                        header("Location: ".base_url);
                    }
                } else {
                    $this->pages->render("ruta/crear", ["error" => $valido]);
                }
            }
        }
        $this->pages->render("ruta/crear");
    }

    // Modifica una ruta existente validando sus datos antes
    // Si los datos no son válidos se genera un error y se vuelve a mostrar el formulario
    public function update() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["data"])) {
                $valido = Ruta::validar_ruta($_POST["data"]);
                if ($valido === true) {
                    $existe = $this->service->existeRuta($_POST["data"]["titulo"]);
                    if ($existe === true) {
                        $error = "La ruta ya existe, elija otro título";
                        $this->pages->render("ruta/editar", ["error" => $error]);
                    }
                    else {
                        $this->service->update($_POST["data"]);
                        header("Location: ".base_url);
                    }

                } else {
                    $this->pages->render("ruta/editar", ["error" => $valido]);
                }
            }
        }
        else {
            // Si el método es GET se cargan los datos de la ruta a modificar
            if (isset($_GET["ruta"])) {
                $ruta = $this->getRuta($_GET["ruta"]);
                $_SESSION["ruta"] = $ruta;
            }
        }
        $this->pages->render("ruta/editar");
    }

    // Elimina la ruta si se pulsa el botón de confirmar en el formulario
    public function delete() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if ($_POST["ruta"] != "X") {
                $this->service->delete($_POST["ruta"]);
            }
            // Se borre o no la ruta, se cambia el método a GET para cargar la lista de rutas por defecto
            $_SERVER['REQUEST_METHOD'] = 'GET';
            $_GET["ruta"] = $_POST["ruta"];
        }

        $this->pages->render("ruta/listar", ["rutas" => $this->service->getAll()]);

    }

    // Devuelve un objeto Ruta dado su id
    public function getRuta($id_ruta) : Object {
        $datos = $this->service->getRuta($id_ruta);
        return Ruta::fromArray($datos);
    }

    // Devuelve un array de objetos Comentario dado el id de la ruta a la que pertenecen
    public function getComentarios($id_ruta) : array {
        $comentariosData = $this->service->getComentarios($id_ruta);
        $comentarios = [];

        foreach ($comentariosData as $comentarioData) {
            $comentarios[] = Comentario::fromArray($comentarioData);
        }

        return $comentarios;
    }

    // Busca en la base de datos las rutas que coincidan con el texto introducido en el formulario
    public function buscar() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST["data"])) {
                // Antes de realizar la búsqueda se valida el texto introducido
                // Si no es válido se muestra un error
                $valido = Ruta::validar_busqueda($_POST["data"]["busqueda"]);
                if ($valido === true) {
                    $rutas = $this->service->buscar($_POST["data"]);

                    if (count($rutas) == 0) {
                        $this->pages->render("ruta/listar", ["error" => "No se han encontrado rutas"]);
                    } else {
                        $this->pages->render("ruta/listar", ["rutas" => $rutas]);
                    }
                } else {
                    $this->pages->render("ruta/listar", ["error" => $valido]);
                }
            }
        }
    }

}