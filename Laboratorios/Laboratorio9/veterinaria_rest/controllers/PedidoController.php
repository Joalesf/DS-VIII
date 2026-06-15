<?php
declare(strict_types=1);

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/ProductoModel.php';

class PedidoController
{
    private ProductoModel $productoModel;
    private ?PDO $conexion = null;

    public function __construct()
    {
        $this->productoModel = new ProductoModel();
    }

    public function inicio(): void
    {
        $this->responder([
            'nombre' => 'API REST Veterinaria Patitas',
            'descripcion' => 'Puente REST que valida pedidos contra el servicio SOAP legacy.',
            'endpoints' => [
                'GET /veterinaria_rest/index.php/productos',
                'POST /veterinaria_rest/index.php/pedidos',
            ],
            'ejemplo_pedido' => [
                'cliente' => 'Ana Perez',
                'telefono' => '6000-0000',
                'producto_id' => 1,
                'cantidad' => 2,
            ],
        ]);
    }

    public function listarProductos(): void
    {
        try {
            $respuesta = $this->productoModel->listarProductos();
            $this->responder($respuesta);
        } catch (Throwable $excepcion) {
            $this->responder([
                'exito' => false,
                'mensaje' => 'No se pudo consultar el inventario SOAP.',
                'error' => $excepcion->getMessage(),
            ], 502);
        }
    }

    public function crearPedido(): void
    {
        $datos = $this->leerDatosEntrada();
        $errores = $this->validarDatosPedido($datos);

        if ($errores !== []) {
            $this->responder([
                'exito' => false,
                'mensaje' => 'Datos invalidos para crear el pedido.',
                'errores' => $errores,
            ], 422);
        }

        $productoId = (int) $datos['producto_id'];
        $cantidad = (int) $datos['cantidad'];
        $cliente = trim((string) $datos['cliente']);
        $telefono = isset($datos['telefono']) ? trim((string) $datos['telefono']) : null;

        try {
            $validacion = $this->productoModel->validarStock($productoId, $cantidad);

            if (!($validacion['exito'] ?? false)) {
                $codigo = str_contains(strtolower((string) ($validacion['mensaje'] ?? '')), 'no encontrado') ? 404 : 409;
                $this->responder([
                    'exito' => false,
                    'mensaje' => $validacion['mensaje'] ?? 'El producto no puede procesarse.',
                    'detalle' => $validacion,
                ], $codigo);
            }

            $producto = (array) $validacion['producto'];
            $precioUnitario = (float) $producto['precio'];
            $total = $precioUnitario * $cantidad;
            $conexion = $this->obtenerConexion();

            $conexion->beginTransaction();
            $pedidoId = $this->guardarPedido(
                $conexion,
                $cliente,
                $telefono,
                $producto,
                $cantidad,
                $precioUnitario,
                $total
            );

            $actualizacion = $this->productoModel->actualizarStock($productoId, $cantidad);

            if (!($actualizacion['exito'] ?? false)) {
                $conexion->rollBack();
                $this->responder([
                    'exito' => false,
                    'mensaje' => $actualizacion['mensaje'] ?? 'No se pudo actualizar el inventario.',
                    'detalle' => $actualizacion,
                ], 409);
            }

            $conexion->commit();

            $this->responder([
                'exito' => true,
                'mensaje' => 'Pedido procesado correctamente.',
                'pedido' => [
                    'id' => $pedidoId,
                    'cliente' => $cliente,
                    'telefono' => $telefono,
                    'producto' => [
                        'id' => (int) $producto['id'],
                        'nombre' => (string) $producto['nombre'],
                        'precio_unitario' => $precioUnitario,
                    ],
                    'cantidad' => $cantidad,
                    'total' => round($total, 2),
                    'estado' => 'PROCESADO',
                ],
                'inventario' => $actualizacion['producto'] ?? null,
            ], 201);
        } catch (PDOException $excepcion) {
            if (isset($conexion) && $conexion->inTransaction()) {
                $conexion->rollBack();
            }

            $this->responder([
                'exito' => false,
                'mensaje' => 'No se pudo guardar el pedido en MySQL.',
                'error' => $excepcion->getMessage(),
            ], 500);
        } catch (Throwable $excepcion) {
            if (isset($conexion) && $conexion->inTransaction()) {
                $conexion->rollBack();
            }

            $this->responder([
                'exito' => false,
                'mensaje' => 'No se pudo procesar el pedido.',
                'error' => $excepcion->getMessage(),
            ], 502);
        }
    }

    public function noEncontrado(string $ruta): void
    {
        $this->responder([
            'exito' => false,
            'mensaje' => 'Ruta no encontrada.',
            'ruta' => $ruta,
        ], 404);
    }

    private function leerDatosEntrada(): array
    {
        $contenido = trim((string) file_get_contents('php://input'));

        if ($contenido !== '') {
            $datos = json_decode($contenido, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($datos)) {
                $this->responder([
                    'exito' => false,
                    'mensaje' => 'El cuerpo de la peticion debe ser JSON valido.',
                    'error' => json_last_error_msg(),
                ], 400);
            }

            return $datos;
        }

        return $_POST;
    }

    private function validarDatosPedido(array $datos): array
    {
        $errores = [];

        if (!isset($datos['cliente']) || trim((string) $datos['cliente']) === '') {
            $errores['cliente'] = 'El nombre del cliente es obligatorio.';
        } elseif (strlen(trim((string) $datos['cliente'])) > 100) {
            $errores['cliente'] = 'El nombre del cliente no debe superar 100 caracteres.';
        }

        if (!isset($datos['producto_id']) || filter_var($datos['producto_id'], FILTER_VALIDATE_INT) === false) {
            $errores['producto_id'] = 'El producto_id debe ser un numero entero.';
        } elseif ((int) $datos['producto_id'] <= 0) {
            $errores['producto_id'] = 'El producto_id debe ser mayor que cero.';
        }

        if (!isset($datos['cantidad']) || filter_var($datos['cantidad'], FILTER_VALIDATE_INT) === false) {
            $errores['cantidad'] = 'La cantidad debe ser un numero entero.';
        } elseif ((int) $datos['cantidad'] <= 0) {
            $errores['cantidad'] = 'La cantidad debe ser mayor que cero.';
        }

        if (isset($datos['telefono']) && strlen(trim((string) $datos['telefono'])) > 30) {
            $errores['telefono'] = 'El telefono no debe superar 30 caracteres.';
        }

        return $errores;
    }

    private function obtenerConexion(): PDO
    {
        if ($this->conexion === null) {
            $this->conexion = (new Database())->obtenerConexion();
        }

        return $this->conexion;
    }

    private function guardarPedido(
        PDO $conexion,
        string $cliente,
        ?string $telefono,
        array $producto,
        int $cantidad,
        float $precioUnitario,
        float $total
    ): int {
        $consulta = $conexion->prepare(
            'INSERT INTO pedidos (
                cliente,
                telefono,
                producto_id,
                producto_nombre,
                cantidad,
                precio_unitario,
                total,
                estado
            ) VALUES (
                :cliente,
                :telefono,
                :producto_id,
                :producto_nombre,
                :cantidad,
                :precio_unitario,
                :total,
                :estado
            )'
        );

        $consulta->execute([
            ':cliente' => $cliente,
            ':telefono' => $telefono !== '' ? $telefono : null,
            ':producto_id' => (int) $producto['id'],
            ':producto_nombre' => (string) $producto['nombre'],
            ':cantidad' => $cantidad,
            ':precio_unitario' => $precioUnitario,
            ':total' => $total,
            ':estado' => 'PROCESADO',
        ]);

        return (int) $conexion->lastInsertId();
    }

    private function responder(array $datos, int $codigo = 200): void
    {
        http_response_code($codigo);
        echo json_encode($datos, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        exit;
    }
}
