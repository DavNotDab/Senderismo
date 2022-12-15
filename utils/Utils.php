<?php
namespace Utils;
use Models\Ruta;
use Exception;

class Utils {

    // Borra una sesión dado su nombre
    public static function deleteSession(string $name) : void {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
    }

    // Devuelve la ruta más larga dado un array de rutas
    public static function getLarga(array $rutas) : Ruta {
        $larga = $rutas[0];
        foreach ($rutas as $ruta) {
            if ($ruta->getDistancia() > $larga->getDistancia()) {
                $larga = $ruta;
            }
        }
        return $larga;
    }


      ////////////////////////////////////////////////////
     ///                 VALIDACIONES                 ///
    ////////////////////////////////////////////////////


    public static function validar_nombre(string $titulo) : bool|string {
        try {
            if (!preg_match("/^[a-zA-Z0-9\s\-.,áéíóúÁÉÍÓÚñÑ]*$/", $titulo)) {
                throw new Exception("El nombre no puede contener caracteres especiales");
            }
            if (strlen($titulo) < 3) {
                throw new Exception("El nombre debe tener al menos 3 caracteres");
            }
            if (strlen($titulo) > 50) {
                throw new Exception("El nombre no puede tener más de 50 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validar_texto(string $texto) : bool|string {
        try {
            if (!preg_match("/^[a-zA-Z0-9\s\-_!¡?¿.,áéíóúÁÉÍÓÚñÑ]*$/", $texto)) {
                throw new Exception("El texto no puede contener caracteres especiales");
            }
            if (strlen($texto) < 3) {
                throw new Exception("El texto debe tener al menos 3 caracteres");
            }
            if (strlen($texto) > 200) {
                throw new Exception("El texto no puede tener más de 200 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validar_desnivel(int $desnivel) : bool|string {
        try {
            if ($desnivel < 0) {
                throw new Exception("El desnivel no puede ser negativo");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validar_distancia(float $distancia) : bool|string {
        try {
            if ($distancia <= 0) {
                throw new Exception("La distancia no puede ser negativa");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validar_dificultad(int $dificultad) : bool|string {
        try {
            if ($dificultad < 1 || $dificultad > 5) {
                throw new Exception("La dificultad debe estar entre 1 y 5");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validar_notas(string $notas) : bool|string {
        try {
            if (!preg_match("/^[a-zA-Z0-9\s\-_!¡?¿.,áéíóúÁÉÍÓÚñÑ]*$/", $notas)) {
                throw new Exception("Las notas no pueden contener caracteres especiales");
            }
            if (strlen($notas) > 200) {
                throw new Exception("Las notas no pueden tener más de 500 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validarNombre($nombre) : bool|string {
        try {
            if (strlen($nombre) < 3) {
                throw new Exception("El nombre debe ser de al menos 3 caracteres");
            }
            if (!preg_match("/^[a-zA-Z0-9\sáéíóúÁÉÍÓÚñÑ]*$/", $nombre)) {
                throw new Exception("El nombre solo puede contener letras y números");
            }
            if (strlen($nombre) > 50) {
                throw new Exception("El nombre no puede ser de más de 50 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validarEmail($email) : bool|string {
        try {
            if (!preg_match("/^[\w.]+@([\w-]+\.)+[\w-]{2,4}$/", $email)) {
                throw new Exception("Formato de email incorrecto");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public static function validarPassword($password) : bool|string {
        try {
            if (strlen($password) < 8) {
                throw new Exception("La contraseña debe tener al menos 8 caracteres");
            }
            if (!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[-_!¿?¡])[a-zA-Z0-9-_!¿?¡]{8,}$/", $password)) {
                throw new Exception("La contraseña debe tener mayusculas, minusculas, números y algún caracter entre -_!¿?¡");
            }
            if (strlen($password) > 50) {
                throw new Exception("La contraseña no puede ser de más de 50 caracteres");
            }
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}