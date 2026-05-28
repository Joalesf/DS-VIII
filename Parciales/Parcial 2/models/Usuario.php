<?php

require_once __DIR__ . '/../config/Herramientas.php';

class ModeloUsuario
{
    private PDO $bd;

    public function __construct()
    {
        $this->bd = BaseDatos::conectar();
    }

    public function existeUsuario(string $usuario): bool
    {
        $sql = 'SELECT id FROM usuarios WHERE usuario = :usuario LIMIT 1';
        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->execute();

        return $consulta->fetch() !== false;
    }

    public function crearAspirante(string $usuario, string $contrasenaHash): bool
    {
        $sql = "INSERT INTO usuarios (usuario, password_hash, rol)
                VALUES (:usuario, :password_hash, 'aspirante')";

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->bindValue(':password_hash', $contrasenaHash);

        return $consulta->execute();
    }

    public function buscarPorUsuario(string $usuario): ?array
    {
        $sql = 'SELECT id, usuario, password_hash, rol, intentos_fallidos, bloqueado_hasta
                FROM usuarios
                WHERE usuario = :usuario
                LIMIT 1';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario', $usuario);
        $consulta->execute();

        $resultado = $consulta->fetch();

        return $resultado === false ? null : $resultado;
    }

    public function aumentarIntentosFallidos(int $id): void
    {
        $sql = "UPDATE usuarios
                SET intentos_fallidos = intentos_fallidos + 1,
                    bloqueado_hasta = CASE
                        WHEN intentos_fallidos + 1 >= 5 THEN DATE_ADD(NOW(), INTERVAL 15 MINUTE)
                        ELSE bloqueado_hasta
                    END
                WHERE id = :id";

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }

    public function limpiarIntentosFallidos(int $id): void
    {
        $sql = 'UPDATE usuarios
                SET intentos_fallidos = 0,
                    bloqueado_hasta = NULL
                WHERE id = :id';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();
    }
}
