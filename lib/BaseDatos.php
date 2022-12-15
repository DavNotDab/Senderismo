<?php
namespace lib;
use PDO;
use PDOException;

class BaseDatos {

    private PDO $conexion;
    private mixed $resultado;

    public function __construct(
        private readonly string $servidor = SERVIDOR,
        private readonly string $usuario = USUARIO,
        private readonly string $password = PASSWORD,
        private readonly string $baseDatos = BASE_DATOS
    ) {
        $this->conexion = $this->conectar();
    }

    private function conectar(): PDO {
        try {
            $opciones = array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                PDO::MYSQL_ATTR_FOUND_ROWS => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            return new PDO("mysql:host=$this->servidor;dbname=$this->baseDatos", $this->usuario, $this->password, $opciones);
        }
        catch (PDOException $e) {
            echo "Ha surgido un error y no se puede conectar a la base de datos: " . $e->getMessage();
            exit;
        }
    }

    public function consulta(string $consultaSQL) : void {
        $this->resultado = $this->conexion->query($consultaSQL);
    }

    public function consultaPrep(string $consultaSQL, array $parametros = null) : bool {
        $this->resultado = $this->conexion->prepare($consultaSQL);

        try {
            if ($parametros != null) {
                $this->resultado->execute($parametros);
            } else {
                $this->resultado->execute();
            }
            return true;
        } catch (PDOException $e) {
            if ($this->conexion->inTransaction()) {
                $this->conexion->rollBack();
            }
            var_dump($e->getMessage());
            return false;
        }
    }

    public function transactionBegin() : void {
        $this->conexion->beginTransaction();
    }

    public function transactionCommit() : void {
        $this->conexion->commit();
    }

    public function extraerRegistro() : bool|array {
        return ($fila = $this->resultado->fetch(PDO::FETCH_ASSOC)) ? $fila : false;
    }

    public function extraerTodos() : array {
        return $this->resultado->fetchAll(PDO::FETCH_ASSOC);
    }

}