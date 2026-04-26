<?php
class DevsConf
{
    private $host = 'localhost';
    private $usuario = 'root';
    private $clave = '';
    private $baseDatos = 'practica2_libros';
    private $conexion;

    public function conectar()
    {
        $this->conexion = new mysqli($this->host, $this->usuario, $this->clave);

        if ($this->conexion->connect_error) {
            die('Error de conexion: ' . $this->conexion->connect_error);
        }

        $this->conexion->query("CREATE DATABASE IF NOT EXISTS $this->baseDatos");
        $this->conexion->select_db($this->baseDatos);
        $this->conexion->set_charset('utf8');

        $this->crearTabla();

        return $this->conexion;
    }

    private function crearTabla()
    {
        $sql = "CREATE TABLE IF NOT EXISTS libros (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    nombre VARCHAR(150) NOT NULL,
                    autor VARCHAR(120) NOT NULL,
                    categoria VARCHAR(80) NOT NULL,
                    anio INT NOT NULL
                )";

        $this->conexion->query($sql);
    }
}
?>
