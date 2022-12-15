<?php
namespace Models;

use Utils\Utils;

class Comentario {

    public function __construct(
        private int    $id,
        private int    $id_ruta,
        private string $nombre,
        private string $texto,
        private string $fecha
    ) {}

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getId_ruta(): int {
        return $this->id_ruta;
    }

    public function setId_ruta(int $id_ruta): void {
        $this->id_ruta = $id_ruta;
    }

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getTexto(): string {
        return $this->texto;
    }

    public function setTexto(string $texto): void {
        $this->texto = $texto;
    }

    public function getFecha(): string {
        return $this->fecha;
    }

    public function setFecha(string $fecha): void {
        $this->fecha = $fecha;
    }

    public function toArray(): array {
        return [
            "id" => $this->id,
            "id_ruta" => $this->id_ruta,
            "nombre" => $this->nombre,
            "texto" => $this->texto,
            "fecha" => $this->fecha
        ];
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['id'],
            $array['id_ruta'],
            $array['nombre'],
            $array['texto'],
            $array['fecha'],
        );
    }


      ////////////////////////////////////////////////////
     ///                 VALIDACIONES                 ///
    ////////////////////////////////////////////////////


    // Valida un comentario y en caso de error devuelve un string con el error
    public static function validar_comentario(array $datosComentario) : bool|string {
        $nombre = Utils::validar_nombre($datosComentario["nombre"]);
        $texto = Utils::validar_texto($datosComentario["texto"]);

        if ($nombre === true) {
            if ($texto === true) return true;
            else return $texto;
        }
        else return $nombre;
    }
}