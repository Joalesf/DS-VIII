<?php
declare(strict_types=1);

class Database
{
    private string $host = 'localhost';
    private string $database = 'veterinaria_patitas';
    private string $username = 'root';
    private string $password = '';

    public function obtenerConexion(): PDO
    {
        $host = getenv('DB_HOST') ?: $this->host;
        $database = getenv('DB_NAME') ?: $this->database;
        $username = getenv('DB_USER') ?: $this->username;
        $password = getenv('DB_PASS') ?: $this->password;

        $database = $this->validarNombreBaseDatos($database);
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $conexionServidor = new PDO(
            "mysql:host={$host};charset=utf8mb4",
            $username,
            $password,
            $opciones
        );

        $conexionServidor->exec(
            "CREATE DATABASE IF NOT EXISTS `{$database}` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
        );

        $conexion = new PDO(
            "mysql:host={$host};dbname={$database};charset=utf8mb4",
            $username,
            $password,
            $opciones
        );

        $this->crearTablaPedidos($conexion);

        return $conexion;
    }

    private function crearTablaPedidos(PDO $conexion): void
    {
        $conexion->exec(
            "CREATE TABLE IF NOT EXISTS pedidos (
                id INT AUTO_INCREMENT PRIMARY KEY,
                cliente VARCHAR(100) NOT NULL,
                telefono VARCHAR(30) NULL,
                producto_id INT NOT NULL,
                producto_nombre VARCHAR(120) NOT NULL,
                cantidad INT NOT NULL,
                precio_unitario DECIMAL(10, 2) NOT NULL,
                total DECIMAL(10, 2) NOT NULL,
                estado VARCHAR(30) NOT NULL DEFAULT 'PROCESADO',
                fecha_pedido TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci"
        );
    }

    private function validarNombreBaseDatos(string $database): string
    {
        if (!preg_match('/^[a-zA-Z0-9_]+$/', $database)) {
            throw new InvalidArgumentException('El nombre de la base de datos no es valido.');
        }

        return $database;
    }
}
