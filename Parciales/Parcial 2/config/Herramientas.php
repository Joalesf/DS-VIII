<?php

class BaseDatos
{
    public static function conectar(): PDO
    {
        $host = '127.0.0.1';
        $baseDatos = 'parcial2_rh';
        $usuario = 'root';
        $password = '';

        $dsn = "mysql:host=$host;dbname=$baseDatos;charset=utf8mb4";

        try {
            $pdo = new PDO($dsn, $usuario, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            exit('No se pudo conectar con la base de datos.');
        }
    }
}
