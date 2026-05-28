<?php

require_once ROOT_PATH . '/models/Usuario.php';

class ControladorRegistro
{
    public function procesar()
    {
        $titulo = 'Crear cuenta';
        $errores = array();
        $mensaje = '';
        $usuario = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = isset($_POST['usuario']) ? trim($_POST['usuario']) : '';
            $contrasena = isset($_POST['password']) ? $_POST['password'] : '';
            $confirmarContrasena = isset($_POST['confirmar_password']) ? $_POST['confirmar_password'] : '';

            if ($usuario === '') {
                $errores[] = 'El usuario es obligatorio.';
            }

            if ($usuario !== '' && !preg_match('/^[a-zA-Z0-9_]{4,30}$/', $usuario)) {
                $errores[] = 'El usuario debe tener entre 4 y 30 caracteres y solo puede usar letras, numeros o guion bajo.';
            }

            if (!$this->contrasenasEsSegura($contrasena)) {
                $errores[] = 'La contrasena debe tener minimo 15 caracteres, letras, numeros y caracteres especiales.';
            }

            if ($contrasena !== $confirmarContrasena) {
                $errores[] = 'Las contrasenas no coinciden.';
            }

            if (empty($errores)) {
                $modeloUsuario = new ModeloUsuario();

                if ($modeloUsuario->existeUsuario($usuario)) {
                    $errores[] = 'El usuario ya esta registrado.';
                } else {
                    $contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);
                    $creado = $modeloUsuario->crearAspirante($usuario, $contrasenaHash);

                    if ($creado) {
                        $mensaje = 'Cuenta creada correctamente. Ahora puedes iniciar sesion.';
                        $usuario = '';
                    } else {
                        $errores[] = 'No se pudo crear la cuenta. Intenta nuevamente.';
                    }
                }
            }
        }

        require ROOT_PATH . '/views/registro.php';
    }

    private function contrasenasEsSegura(string $contrasena): bool
    {
        if (strlen($contrasena) < 15) {
            return false;
        }

        $tieneLetra = preg_match('/[a-zA-Z]/', $contrasena);
        $tieneNumero = preg_match('/[0-9]/', $contrasena);
        $tieneEspecial = preg_match('/[^a-zA-Z0-9]/', $contrasena);

        return $tieneLetra && $tieneNumero && $tieneEspecial;
    }
}
