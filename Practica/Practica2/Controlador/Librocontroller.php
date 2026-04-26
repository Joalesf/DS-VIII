<?php
class LibroController
{
    private $modelo;

    public function __construct()
    {
        $this->modelo = new Libro();
    }

    public function listar()
    {
        return $this->modelo->listar();
    }

    public function guardar($datos)
    {
        $nombre = trim($datos['nombre']);
        $autor = trim($datos['autor']);
        $categoria = trim($datos['categoria']);
        $anio = (int) $datos['anio'];

        if ($nombre === '' || $autor === '' || $categoria === '' || $anio <= 0) {
            header('Location: Index.php?accion=crear&mensaje=Complete todos los campos&tipo=error');
            exit();
        }

        $guardado = $this->modelo->guardar($nombre, $autor, $categoria, $anio);

        if ($guardado) {
            header('Location: Index.php?mensaje=Libro guardado correctamente&tipo=exito');
        } else {
            header('Location: Index.php?accion=crear&mensaje=No se pudo guardar el libro&tipo=error');
        }

        exit();
    }

    public function obtenerLibro($id)
    {
        return $this->modelo->obtenerPorId((int) $id);
    }

    public function actualizar($datos)
    {
        $id = (int) $datos['id'];
        $nombre = trim($datos['nombre']);
        $autor = trim($datos['autor']);
        $categoria = trim($datos['categoria']);
        $anio = (int) $datos['anio'];

        if ($id <= 0 || $nombre === '' || $autor === '' || $categoria === '' || $anio <= 0) {
            header('Location: Index.php?mensaje=Datos invalidos para actualizar&tipo=error');
            exit();
        }

        $actualizado = $this->modelo->actualizar($id, $nombre, $autor, $categoria, $anio);

        if ($actualizado) {
            header('Location: Index.php?mensaje=Libro actualizado correctamente&tipo=exito');
        } else {
            header('Location: Index.php?mensaje=No se pudo actualizar el libro&tipo=error');
        }

        exit();
    }

    public function eliminar($id)
    {
        $eliminado = $this->modelo->eliminar((int) $id);

        if ($eliminado) {
            header('Location: Index.php?mensaje=Libro eliminado correctamente&tipo=exito');
        } else {
            header('Location: Index.php?mensaje=No se pudo eliminar el libro&tipo=error');
        }

        exit();
    }
}
?>
