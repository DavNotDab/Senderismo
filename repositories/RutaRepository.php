<?php
namespace Repositories;
use lib\BaseDatos;
use Models\Ruta;

class RutaRepository extends BaseDatos {

    // Devuelve un array con todas las rutas
    public function getAll() : array {
        $this->consulta("SELECT * FROM rutas");
        return $this->extraer_todas();
    }

    private function extraer_todas() : array {
        $rutas = [];
        $rutasData = $this->extraerTodos();

        foreach ($rutasData as $rutaData) {
            $rutas[] = Ruta::fromArray($rutaData);
        }

        return $rutas;
    }

    // Guarda una ruta en la base de datos
    public function save(array $ruta) : void {
        $this->consultaPrep("INSERT INTO rutas (titulo, descripcion, desnivel, distancia, dificultad, notas) VALUES (:titulo, :descripcion, :desnivel, :distancia, :dificultad, :notas)", $ruta);

    }

    // Modifica una ruta en la base de datos
    public function update(array $ruta) : void {
        $this->consultaPrep("UPDATE rutas SET titulo = :titulo, descripcion = :descripcion, desnivel = :desnivel, distancia = :distancia, dificultad = :dificultad, notas = :notas WHERE id = :id", $ruta);
    }

    // Borra una ruta de la base de datos
    public function delete(string $id) : void {
        $this->consultaPrep("DELETE FROM rutas WHERE id = :id", ["id"=>$id]);
    }

    // Devuelve un array con los datos de una ruta dada su id
    // Si ocurre un error devuelve false
    public function getRuta($id_ruta) : bool|array {
        $this->consultaPrep("SELECT * FROM rutas WHERE id = :id_ruta", ["id_ruta"=>$id_ruta]);
        return $this->extraerRegistro();
    }

    // Busca y devuelve las rutas que coincidan con la categoria en la que buscar y el texto a buscar dados
    public function buscar($categoria, $busqueda) : array {
        $busqueda = "%$busqueda%";
        $this->consultaPrep("SELECT * FROM rutas WHERE LOWER($categoria) LIKE LOWER('$busqueda')");
        return $this->extraer_todas();
    }

    public function existeRuta(string $titulo) : bool {
        $this->consultaPrep("SELECT * FROM rutas WHERE titulo = :titulo", ["titulo"=>$titulo]);
        return $this->extraerRegistro() !== false;
    }

}
