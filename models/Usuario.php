<?php
namespace Models;

use Utils\Utils;

class Usuario {

    public function __construct(
        private string $nombre,
        private string $email,
        private string $password
    ) {}

    public function getNombre(): string {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void {
        $this->nombre = $nombre;
    }

    public function getEmail(): string {
        return $this->email;
    }

    public function setEmail(string $email): void {
        $this->email = $email;
    }

    public function getPassword(): string {
        return $this->password;
    }

    public function setPassword(string $password): void {
        $this->password = $password;
    }

    public function toArray(): array {
        return [
            "nombre" => $this->nombre,
            "email" => $this->email,
            "password" => $this->password
        ];
    }

    public static function fromArray(array $array) : self {
        return new self(
            $array['nombre'],
            $array['email'],
            $array['password'],
        );
    }

    // Valida el login comprobando el email y la contraseña
    // En caso de que sean incorrectos se devuelve un error
    public static function validarLogin(array $data) : bool|string {
        $mail = Utils::validarEmail($data['email']);
        $pass = Utils::validarPassword($data['password']);

        if ($mail === true) {
            if ($pass === true) {
                return true;
            } else {
                return $pass;
            }
        } else {
            return $mail;
        }
    }


      ////////////////////////////////////////////////////
     ///                 VALIDACIONES                 ///
    ////////////////////////////////////////////////////


    // Valida el registro de un usuario nuevo comprobando el nombre, email y la contraseña
    // En caso de que sean incorrectos se devuelve un error
    public static function validarSave(array $data) : bool|string {
        $nombre = Utils::validarNombre($data['nombre']);
        $mail = Utils::validarEmail($data['email']);
        $pass = Utils::validarPassword($data['password']);

        if ($nombre === true) {
            if ($mail === true) {
                if ($pass === true) {
                    return true;
                } else {
                    return $pass;
                }
            } else {
                return $mail;
            }
        } else {
            return $nombre;
        }
    }



}
