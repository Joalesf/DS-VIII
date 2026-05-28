<?php

require_once __DIR__ . '/../config/Herramientas.php';

class ModeloAspirante
{
    private PDO $bd;

    public function __construct()
    {
        $this->bd = BaseDatos::conectar();
    }

    public function obtenerPorUsuario(int $usuarioId): ?array
    {
        $sql = 'SELECT *
                FROM aspirantes
                WHERE usuario_id = :usuario_id
                LIMIT 1';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $consulta->execute();

        $resultado = $consulta->fetch();

        return $resultado === false ? null : $resultado;
    }

    public function guardar(int $usuarioId, array $datos): bool
    {
        if ($this->obtenerPorUsuario($usuarioId)) {
            return $this->actualizar($usuarioId, $datos);
        }

        return $this->insertar($usuarioId, $datos);
    }

    private function insertar(int $usuarioId, array $datos): bool
    {
        $sql = 'INSERT INTO aspirantes (
                    usuario_id, cedula_pasaporte, nombre, apellido, estado_civil,
                    genero, tipo_sangre, fecha_nacimiento, nacionalidad,
                    telefono, residencia, correo
                ) VALUES (
                    :usuario_id, :cedula_pasaporte, :nombre, :apellido, :estado_civil,
                    :genero, :tipo_sangre, :fecha_nacimiento, :nacionalidad,
                    :telefono, :residencia, :correo
                )';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':cedula_pasaporte', $datos['cedula_pasaporte']);
        $consulta->bindValue(':nombre', $datos['nombre']);
        $consulta->bindValue(':apellido', $datos['apellido']);
        $consulta->bindValue(':estado_civil', $datos['estado_civil']);
        $consulta->bindValue(':genero', $datos['genero']);
        $consulta->bindValue(':tipo_sangre', $datos['tipo_sangre']);
        $consulta->bindValue(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $consulta->bindValue(':nacionalidad', $datos['nacionalidad']);
        $consulta->bindValue(':telefono', $datos['telefono']);
        $consulta->bindValue(':residencia', $datos['residencia']);
        $consulta->bindValue(':correo', $datos['correo']);

        return $consulta->execute();
    }

    private function actualizar(int $usuarioId, array $datos): bool
    {
        $sql = 'UPDATE aspirantes SET
                    cedula_pasaporte = :cedula_pasaporte,
                    nombre = :nombre,
                    apellido = :apellido,
                    estado_civil = :estado_civil,
                    genero = :genero,
                    tipo_sangre = :tipo_sangre,
                    fecha_nacimiento = :fecha_nacimiento,
                    nacionalidad = :nacionalidad,
                    telefono = :telefono,
                    residencia = :residencia,
                    correo = :correo
                WHERE usuario_id = :usuario_id';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':usuario_id', $usuarioId, PDO::PARAM_INT);
        $consulta->bindValue(':cedula_pasaporte', $datos['cedula_pasaporte']);
        $consulta->bindValue(':nombre', $datos['nombre']);
        $consulta->bindValue(':apellido', $datos['apellido']);
        $consulta->bindValue(':estado_civil', $datos['estado_civil']);
        $consulta->bindValue(':genero', $datos['genero']);
        $consulta->bindValue(':tipo_sangre', $datos['tipo_sangre']);
        $consulta->bindValue(':fecha_nacimiento', $datos['fecha_nacimiento']);
        $consulta->bindValue(':nacionalidad', $datos['nacionalidad']);
        $consulta->bindValue(':telefono', $datos['telefono']);
        $consulta->bindValue(':residencia', $datos['residencia']);
        $consulta->bindValue(':correo', $datos['correo']);

        return $consulta->execute();
    }

    public function obtenerTodos(): array
    {
        $sql = 'SELECT
                    a.id,
                    a.usuario_id,
                    u.usuario,
                    a.cedula_pasaporte,
                    a.nombre,
                    a.apellido,
                    a.estado_civil,
                    a.genero,
                    a.tipo_sangre,
                    a.fecha_nacimiento,
                    a.nacionalidad,
                    a.telefono,
                    a.residencia,
                    a.correo,
                    a.estado_solicitud,
                    a.actualizado_en
                FROM aspirantes a
                INNER JOIN usuarios u ON u.id = a.usuario_id
                ORDER BY a.actualizado_en DESC';

        $consulta = $this->bd->prepare($sql);
        $consulta->execute();

        return $consulta->fetchAll();
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = 'SELECT id
                FROM aspirantes
                WHERE id = :id
                LIMIT 1';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);
        $consulta->execute();

        $resultado = $consulta->fetch();

        return $resultado === false ? null : $resultado;
    }

    public function cambiarEstado(int $id, string $estado): bool
    {
        $sql = 'UPDATE aspirantes
                SET estado_solicitud = :estado
                WHERE id = :id';

        $consulta = $this->bd->prepare($sql);
        $consulta->bindValue(':estado', $estado);
        $consulta->bindValue(':id', $id, PDO::PARAM_INT);

        return $consulta->execute();
    }
}
