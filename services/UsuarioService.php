<?php
namespace Services;
use Repositories\UsuarioRepository;

class UsuarioService {

    private UsuarioRepository $repository;

    function __construct() {
        $this->repository = new UsuarioRepository();
    }

    public function save(array $usuario) : void {
        $this->repository->save($usuario);
    }

    public function update(array $usuario) : void {
        $this->repository->update($usuario);
    }

    public function delete(string $nombre) : void {
        $this->repository->delete($nombre);
    }

    public function verifyLogin(array $data): bool|string {
       return $this->repository->comprobarUsuarioLogin($data["email"], $data["password"]);
    }

    public function existeUsuario(array $data) : bool {
        return $this->repository->comprobarExisteUsuario($data["email"]);
    }

}