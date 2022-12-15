<?php
namespace Services;
use Repositories\RutaRepository;
use Repositories\ComentarioRepository;

class RutaService {

    private RutaRepository $repository;
    private ComentarioRepository $comentarioRepository;

    function __construct() {
        $this->repository = new RutaRepository();
        $this->comentarioRepository = new ComentarioRepository();
    }

    public function getAll() : ?array {
        return $this->repository->getAll();
    }

    public function save(array $ruta) : void {
        $this->repository->save($ruta);
    }

    public function update(array $ruta) : void {
        $this->repository->update($ruta);
    }

    // Para borrar una ruta se hace una transacción que borra primero los comentarios y luego la ruta
    public function delete(string $id) : void {
        $this->repository->transactionBegin();
        $this->comentarioRepository->delete($id);
        $this->repository->delete($id);
        $this->repository->transactionCommit();
    }

    public function getRuta($id_ruta) : array {
        return $this->repository->getRuta($id_ruta);
    }

    public function getComentarios($id_ruta) : array {
        return $this->comentarioRepository->getComentarios($id_ruta);
    }

    public function buscar(array $data) : array {
        return $this->repository->buscar($data["categoria"], $data["busqueda"]);
    }

    public function existeRuta($titulo) : bool {
        return $this->repository->existeRuta($titulo);
    }

}