<?php
namespace Services;
use Repositories\ComentarioRepository;

class ComentarioService {

    private ComentarioRepository $repository;

    function __construct() {
        $this->repository = new ComentarioRepository();
    }

    public function save(array $comentario) : void {
        $this->repository->save($comentario);
    }

    public function delete(string $id_ruta) : void {
        $this->repository->delete($id_ruta);
    }


}