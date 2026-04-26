<?php
class Libro
{
    private $conexion;

    public function __construct()
    {
        $base = new DevsConf();
        $this->conexion = $base->conectar();
    }

    public function listar()
    {
        $sql = "SELECT * FROM libros ORDER BY id DESC";
        $resultado = $this->conexion->query($sql);
        $libros = array();

        if ($resultado) {
            while ($fila = $resultado->fetch_assoc()) {
                $libros[] = $fila;
            }
        }

        return $libros;
    }

    public function guardar($nombre, $autor, $categoria, $anio)
    {
        $sql = "INSERT INTO libros (nombre, autor, categoria, anio) VALUES (?, ?, ?, ?)";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param('sssi', $nombre, $autor, $categoria, $anio);

        return $sentencia->execute();
    }

    public function obtenerPorId($id)
    {
        $sql = "SELECT * FROM libros WHERE id = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
        $resultado = $sentencia->get_result();

        return $resultado->fetch_assoc();
    }

    public function actualizar($id, $nombre, $autor, $categoria, $anio)
    {
        $sql = "UPDATE libros SET nombre = ?, autor = ?, categoria = ?, anio = ? WHERE id = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param('sssii', $nombre, $autor, $categoria, $anio, $id);

        return $sentencia->execute();
    }

    public function eliminar($id)
    {
        $sql = "DELETE FROM libros WHERE id = ?";
        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bind_param('i', $id);

        return $sentencia->execute();
    }
}
?>
