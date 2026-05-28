<?php

require_once ROOT_PATH . '/models/Aspirante.php';

class ControladorAspirante
{
    public function index()
    {
        if (!estaLogueado()) {
            header('Location: ' . url('login'));
            exit;
        }

        if (esRh()) {
            header('Location: ' . url('rh'));
            exit;
        }

        $titulo = 'Mi solicitud';
        $errores = array();
        $mensaje = '';
        $usuarioId = (int) $_SESSION['usuario_id'];
        $modeloAspirante = new ModeloAspirante();
        $solicitud = $modeloAspirante->obtenerPorUsuario($usuarioId);
        $datos = $solicitud ? $solicitud : $this->datosVacios();
        $estadoSolicitud = $solicitud ? $solicitud['estado_solicitud'] : 'no revisado';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $datos = $this->obtenerDatosFormulario();
            $errores = $this->validarDatos($datos);

            if (empty($errores)) {
                $guardado = $modeloAspirante->guardar($usuarioId, $datos);

                if ($guardado) {
                    $mensaje = 'Tu informacion fue guardada correctamente.';
                    $solicitud = $modeloAspirante->obtenerPorUsuario($usuarioId);
                    $datos = $solicitud ? $solicitud : $datos;
                    $estadoSolicitud = $solicitud ? $solicitud['estado_solicitud'] : 'no revisado';
                } else {
                    $errores[] = 'No se pudo guardar la informacion. Intenta nuevamente.';
                }
            }
        }

        require ROOT_PATH . '/views/aspirante.php';
    }

    private function datosVacios()
    {
        return array(
            'cedula_pasaporte' => '',
            'nombre' => '',
            'apellido' => '',
            'estado_civil' => '',
            'genero' => '',
            'tipo_sangre' => '',
            'fecha_nacimiento' => '',
            'nacionalidad' => '',
            'telefono' => '',
            'residencia' => '',
            'correo' => '',
        );
    }

    private function obtenerDatosFormulario()
    {
        return array(
            'cedula_pasaporte' => isset($_POST['cedula_pasaporte']) ? trim($_POST['cedula_pasaporte']) : '',
            'nombre' => isset($_POST['nombre']) ? trim($_POST['nombre']) : '',
            'apellido' => isset($_POST['apellido']) ? trim($_POST['apellido']) : '',
            'estado_civil' => isset($_POST['estado_civil']) ? trim($_POST['estado_civil']) : '',
            'genero' => isset($_POST['genero']) ? trim($_POST['genero']) : '',
            'tipo_sangre' => isset($_POST['tipo_sangre']) ? trim($_POST['tipo_sangre']) : '',
            'fecha_nacimiento' => isset($_POST['fecha_nacimiento']) ? trim($_POST['fecha_nacimiento']) : '',
            'nacionalidad' => isset($_POST['nacionalidad']) ? trim($_POST['nacionalidad']) : '',
            'telefono' => isset($_POST['telefono']) ? trim($_POST['telefono']) : '',
            'residencia' => isset($_POST['residencia']) ? trim($_POST['residencia']) : '',
            'correo' => isset($_POST['correo']) ? trim($_POST['correo']) : '',
        );
    }

    private function validarDatos(array $datos): array
    {
        $errores = array();

        $obligatorios = array(
            'cedula_pasaporte' => 'La cedula o pasaporte es obligatorio.',
            'nombre' => 'El nombre es obligatorio.',
            'apellido' => 'El apellido es obligatorio.',
            'genero' => 'El genero es obligatorio.',
            'fecha_nacimiento' => 'La fecha de nacimiento es obligatoria.',
            'nacionalidad' => 'La nacionalidad es obligatoria.',
            'telefono' => 'El telefono es obligatorio.',
            'residencia' => 'La residencia es obligatoria.',
            'correo' => 'El correo electronico es obligatorio.',
        );

        foreach ($obligatorios as $campo => $textoError) {
            if ($datos[$campo] === '') {
                $errores[] = $textoError;
            }
        }

        if ($datos['cedula_pasaporte'] !== '' && !preg_match('/^[a-zA-Z0-9-]{4,30}$/', $datos['cedula_pasaporte'])) {
            $errores[] = 'La cedula o pasaporte solo puede usar letras, numeros y guion.';
        }

        if ($datos['nombre'] !== '' && !preg_match('/^[\p{L}\s]{2,80}$/u', $datos['nombre'])) {
            $errores[] = 'El nombre solo puede usar letras y espacios.';
        }

        if ($datos['apellido'] !== '' && !preg_match('/^[\p{L}\s]{2,80}$/u', $datos['apellido'])) {
            $errores[] = 'El apellido solo puede usar letras y espacios.';
        }

        if ($datos['nacionalidad'] !== '' && !preg_match('/^[\p{L}\s]{2,80}$/u', $datos['nacionalidad'])) {
            $errores[] = 'La nacionalidad solo puede usar letras y espacios.';
        }

        if ($datos['genero'] !== '' && !in_array($datos['genero'], array('femenino', 'masculino', 'otro'))) {
            $errores[] = 'El genero seleccionado no es valido.';
        }

        if ($datos['estado_civil'] !== '' && !in_array($datos['estado_civil'], array('soltero', 'casado', 'divorciado', 'viudo', 'union libre'))) {
            $errores[] = 'El estado civil seleccionado no es valido.';
        }

        if ($datos['tipo_sangre'] !== '' && !in_array($datos['tipo_sangre'], array('A+', 'A-', 'B+', 'B-', 'AB+', 'AB-', 'O+', 'O-'))) {
            $errores[] = 'El tipo de sangre seleccionado no es valido.';
        }

        if ($datos['fecha_nacimiento'] !== '' && !$this->fechaEsValida($datos['fecha_nacimiento'])) {
            $errores[] = 'La fecha de nacimiento no es valida.';
        }

        if ($datos['telefono'] !== '' && !preg_match('/^[0-9+\-\s]{7,30}$/', $datos['telefono'])) {
            $errores[] = 'El telefono solo puede usar numeros, espacios, + y guion.';
        }

        if ($datos['residencia'] !== '' && strlen($datos['residencia']) < 8) {
            $errores[] = 'La residencia debe tener minimo 8 caracteres.';
        }

        if ($datos['correo'] !== '' && !filter_var($datos['correo'], FILTER_VALIDATE_EMAIL)) {
            $errores[] = 'El correo electronico no es valido.';
        }

        return $errores;
    }

    private function fechaEsValida(string $fecha): bool
    {
        $tiempo = strtotime($fecha);

        if ($tiempo === false) {
            return false;
        }

        if (date('Y-m-d', $tiempo) !== $fecha) {
            return false;
        }

        return $tiempo <= time();
    }
}
