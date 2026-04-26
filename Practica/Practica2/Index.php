<?php
require_once 'Config/DevsConf.php';
require_once 'Models/Libro.php';
require_once 'Controlador/Librocontroller.php';

$controlador = new LibroController();
$accion = isset($_GET['accion']) ? $_GET['accion'] : 'listar';

switch ($accion) {
    case 'crear':
        include 'Vistas/Crear.php';
        break;

    case 'guardar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlador->guardar($_POST);
        } else {
            header('Location: Index.php');
        }
        break;

    case 'editar':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $libro = $controlador->obtenerLibro($id);

        if (!$libro) {
            header('Location: Index.php?mensaje=Libro no encontrado&tipo=error');
            exit();
        }

        include 'Vistas/Editar.php';
        break;

    case 'actualizar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $controlador->actualizar($_POST);
        } else {
            header('Location: Index.php');
        }
        break;

    case 'eliminar':
        $id = isset($_GET['id']) ? $_GET['id'] : 0;
        $controlador->eliminar($id);
        break;

    default:
        $libros = $controlador->listar();
        include 'Vistas/Listar.php';
        break;
}
?>
