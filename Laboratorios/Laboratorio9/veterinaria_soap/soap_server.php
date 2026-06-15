<?php
declare(strict_types=1);

class InventarioService
{
    private const INVENTARIO_INICIAL = [
        1 => [
            'id' => 1,
            'nombre' => 'Alimento premium para perro',
            'precio' => 18.50,
            'stock' => 25,
        ],
        2 => [
            'id' => 2,
            'nombre' => 'Arena sanitaria para gato',
            'precio' => 9.75,
            'stock' => 18,
        ],
        3 => [
            'id' => 3,
            'nombre' => 'Shampoo antipulgas',
            'precio' => 7.25,
            'stock' => 12,
        ],
        4 => [
            'id' => 4,
            'nombre' => 'Collar ajustable',
            'precio' => 5.99,
            'stock' => 30,
        ],
    ];

    public function listarProductos(): array
    {
        return [
            'exito' => true,
            'productos' => array_values($this->leerInventario()),
        ];
    }

    public function consultarProducto(int $productoId): array
    {
        $inventario = $this->leerInventario();

        if (!isset($inventario[$productoId])) {
            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado en el inventario SOAP.',
            ];
        }

        return [
            'exito' => true,
            'mensaje' => 'Producto encontrado.',
            'producto' => $inventario[$productoId],
        ];
    }

    public function validarStock(int $productoId, int $cantidad): array
    {
        if ($cantidad <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'La cantidad debe ser mayor que cero.',
            ];
        }

        $respuesta = $this->consultarProducto($productoId);

        if (!$respuesta['exito']) {
            return $respuesta;
        }

        $producto = $respuesta['producto'];
        $disponible = $producto['stock'] >= $cantidad;

        return [
            'exito' => $disponible,
            'mensaje' => $disponible
                ? 'Stock disponible.'
                : 'Stock insuficiente para procesar el pedido.',
            'producto' => $producto,
            'stock_disponible' => $producto['stock'],
        ];
    }

    public function actualizarStock(int $productoId, int $cantidad): array
    {
        if ($cantidad <= 0) {
            return [
                'exito' => false,
                'mensaje' => 'La cantidad debe ser mayor que cero.',
            ];
        }

        $archivo = $this->archivoInventario();
        $this->crearInventarioSiNoExiste();

        $gestor = fopen($archivo, 'c+');

        if ($gestor === false) {
            return [
                'exito' => false,
                'mensaje' => 'No se pudo abrir el inventario legacy.',
            ];
        }

        flock($gestor, LOCK_EX);
        $contenido = stream_get_contents($gestor);
        $inventario = json_decode($contenido ?: '{}', true);

        if (!is_array($inventario) || $inventario === []) {
            $inventario = self::INVENTARIO_INICIAL;
        }

        if (!isset($inventario[$productoId])) {
            flock($gestor, LOCK_UN);
            fclose($gestor);

            return [
                'exito' => false,
                'mensaje' => 'Producto no encontrado en el inventario SOAP.',
            ];
        }

        if ((int) $inventario[$productoId]['stock'] < $cantidad) {
            $stockDisponible = (int) $inventario[$productoId]['stock'];
            flock($gestor, LOCK_UN);
            fclose($gestor);

            return [
                'exito' => false,
                'mensaje' => 'Stock insuficiente para actualizar el inventario.',
                'stock_disponible' => $stockDisponible,
            ];
        }

        $inventario[$productoId]['stock'] = (int) $inventario[$productoId]['stock'] - $cantidad;

        rewind($gestor);
        ftruncate($gestor, 0);
        fwrite($gestor, json_encode($inventario, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        fflush($gestor);
        flock($gestor, LOCK_UN);
        fclose($gestor);

        return [
            'exito' => true,
            'mensaje' => 'Inventario actualizado correctamente.',
            'producto' => $inventario[$productoId],
        ];
    }

    private function leerInventario(): array
    {
        $this->crearInventarioSiNoExiste();

        $contenido = file_get_contents($this->archivoInventario());
        $inventario = json_decode($contenido ?: '{}', true);

        if (!is_array($inventario) || $inventario === []) {
            return self::INVENTARIO_INICIAL;
        }

        return array_map(
            static fn (array $producto): array => [
                'id' => (int) $producto['id'],
                'nombre' => (string) $producto['nombre'],
                'precio' => (float) $producto['precio'],
                'stock' => (int) $producto['stock'],
            ],
            $inventario
        );
    }

    private function crearInventarioSiNoExiste(): void
    {
        $archivo = $this->archivoInventario();

        if (!file_exists($archivo)) {
            file_put_contents(
                $archivo,
                json_encode(self::INVENTARIO_INICIAL, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );
        }
    }

    private function archivoInventario(): string
    {
        return sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'veterinaria_patitas_inventario.json';
    }
}

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'GET') {
    header('Content-Type: text/plain; charset=utf-8');
    echo "Servicio SOAP legacy de Veterinaria Patitas\n";
    echo "Metodos disponibles: listarProductos, consultarProducto, validarStock, actualizarStock\n";
    exit;
}

$servidor = new SoapServer(null, [
    'uri' => 'http://localhost/veterinaria_soap',
    'encoding' => 'UTF-8',
]);

$servidor->setClass(InventarioService::class);
$servidor->handle();
