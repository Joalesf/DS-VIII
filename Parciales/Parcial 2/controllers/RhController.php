<?php

require_once ROOT_PATH . '/models/Aspirante.php';

class ControladorRh
{
    public function index()
    {
        if (!estaLogueado()) {
            header('Location: ' . url('login'));
            exit;
        }

        if (!esRh()) {
            http_response_code(403);
            require ROOT_PATH . '/views/error403.php';
            return;
        }

        $titulo = 'Panel RH';
        $errores = array();
        $mensaje = '';
        $modeloAspirante = new ModeloAspirante();
        $estadosValidos = array('no revisado', 'considerado', 'no considerado');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $solicitudId = isset($_POST['solicitud_id']) ? (int) $_POST['solicitud_id'] : 0;
            $estado = isset($_POST['estado_solicitud']) ? trim($_POST['estado_solicitud']) : '';

            if ($solicitudId <= 0) {
                $errores[] = 'La solicitud seleccionada no es valida.';
            }

            if (!in_array($estado, $estadosValidos)) {
                $errores[] = 'El estado seleccionado no es valido.';
            }

            if (empty($errores) && $modeloAspirante->obtenerPorId($solicitudId) === null) {
                $errores[] = 'La solicitud no existe.';
            }

            if (empty($errores)) {
                $actualizado = $modeloAspirante->cambiarEstado($solicitudId, $estado);

                if ($actualizado) {
                    $mensaje = 'Estado actualizado correctamente.';
                } else {
                    $errores[] = 'No se pudo actualizar el estado.';
                }
            }
        }

        $solicitudes = $modeloAspirante->obtenerTodos();

        require ROOT_PATH . '/views/rh.php';
    }
}
