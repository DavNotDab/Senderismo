<?php
namespace Models;

use Utils\Utils;
use Exception;

class Ruta {

    public function __construct(
        private int    $id,
        private string $titulo,
        private string $descripcion,
        private int    $desnivel,
        private float  $distancia,
        private int    $dificultad,
        private string $notas
    ) {}


    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitulo(): string {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void {
        $this->titulo = $titulo;
    }

    public function getDescripcion(): string {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): void {
        $this->descripcion = $descripcion;
    }

    public function getDesnivel(): int {
        return $this->desnivel;
    }

    public function setDesnivel(int $desnivel): void {
        $this->desnivel = $desnivel;
    }

    public function getDistancia(): float {
        return $this->distancia;
    }

    public function setDistancia(float $distancia): void {
        $this->distancia = $distancia;
    }

    public function getDificultad(): int {
        return $this->dificultad;
    }

    public function setDificultad(int $dificultad): void {
        $this->dificultad = $dificultad;
    }

    public function getNotas(): string {
        return $this->notas;
    }

    public function setNotas(string $notas): void {
        $this->notas = $notas;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "titulo" => $this->titulo,
            "descripcion" => $this->descripcion,
            "desnivel" => $this->desnivel,
            "distancia" => $this->distancia,
            "dificultad" => $this->dificultad,
            "notas" => $this->notas
        ];
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['titulo'],
            $array['descripcion'],
            $array['desnivel'],
            $array['distancia'],
            $array['dificultad'],
            $array['notas']
        );
    }


      ////////////////////////////////////////////////////
     ///                 VALIDACIONES                 ///
    ////////////////////////////////////////////////////


    // Valida los datos de una ruta.
    // Si algún dato no es válido devuelve un error específico
    public static function validar_ruta(array $datosRuta) : bool|string {
        $titulo = Utils::validar_nombre($datosRuta["titulo"]);
        $descripcion = Utils::validar_texto($datosRuta["descripcion"]);
        $desnivel = Utils::validar_desnivel($datosRuta["desnivel"]);
        $distancia = Utils::validar_distancia($datosRuta["distancia"]);
        $dificultad = Utils::validar_dificultad($datosRuta["dificultad"]);
        $notas = Utils::validar_notas($datosRuta["notas"]);

        return ($titulo !== true) ? $titulo : (
        ($descripcion !== true) ? $descripcion : (
        ($desnivel !== true) ? $desnivel : (
        ($distancia !== true) ? $distancia : (
        ($dificultad !== true) ? $dificultad : (
        ($notas !== true) ? $notas : true)))));
    }

    // valida el texto de una búsqueda. En caso de que no sea válido devuelve un error
    public static function validar_busqueda(string $busqueda) : bool|string {
        try {
            if (!preg_match("/^[a-zA-Z0-9\s.,áéíóúÁÉÍÓÚñÑ]*$/", $busqueda)) {
                throw new Exception("La búsqueda no puede contener caracteres especiales");
            }
            if (strlen($busqueda) < 3) {
                throw new Exception("La búsqueda debe tener al menos 3 caracteres");
            }
            if (strlen($busqueda) > 50) {
                throw new Exception("La búsqueda no puede tener más de 50 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}