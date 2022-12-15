<?php
namespace Repositories;

use lib\BaseDatos;


class ComentarioRepository extends BaseDatos {

    // Guarda un comentario en la base de datos
    public function save(array $comentario) : void {
        $this->consultaPrep("INSERT INTO rutas_comentarios (id_ruta, nombre, texto, fecha) VALUES (:id_ruta, :nombre, :texto, :fecha)", $comentario);
    }

    // Borra un comentario de la base de datos
    public function delete(string $id_ruta) : void {
        $this->consultaPrep("DELETE FROM rutas_comentarios WHERE id_ruta = :id_ruta", [":id_ruta"=>$id_ruta]);
    }

    // Devuelve todos los comentarios de una ruta dada
    public function getComentarios($id_ruta) : array {
        $this->consultaPrep("SELECT * FROM rutas_comentarios WHERE id_ruta = :id_ruta", [":id_ruta"=>$id_ruta]);
        return array_reverse($this->extraerTodos());
    }

}