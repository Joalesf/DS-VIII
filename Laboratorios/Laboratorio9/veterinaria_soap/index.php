<?php
declare(strict_types=1);

$urlServicio = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost') . '/veterinaria_soap/soap_server.php';
$resultado = null;
$error = null;

try {
    $cliente = new SoapClient(null, [
        'location' => $urlServicio,
        'uri' => 'http://localhost/veterinaria_soap',
        'trace' => true,
        'exceptions' => true,
        'encoding' => 'UTF-8',
    ]);

    $resultado = $cliente->listarProductos();
} catch (Throwable $excepcion) {
    $error = $excepcion->getMessage();
}
?>
<!doctype html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Prueba SOAP - Veterinaria Patitas</title>
    <style>
        body {
            color: #1f2937;
            font-family: Arial, sans-serif;
            line-height: 1.5;
            margin: 32px auto;
            max-width: 900px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #d1d5db;
            padding: 10px;
            text-align: left;
        }

        th {
            background: #f3f4f6;
        }

        .error {
            background: #fee2e2;
            border: 1px solid #fca5a5;
            color: #991b1b;
            padding: 12px;
        }
    </style>
</head>
<body>
    <h1>Servicio SOAP legacy</h1>
    <p><strong>URL:</strong> <?= htmlspecialchars($urlServicio, ENT_QUOTES, 'UTF-8') ?></p>

    <?php if ($error !== null): ?>
        <div class="error"><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></div>
    <?php else: ?>
        <?php $productos = is_object($resultado) ? ($resultado->productos ?? []) : ($resultado['productos'] ?? []); ?>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Producto</th>
                    <th>Precio</th>
                    <th>Stock</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <?php $producto = (array) $producto; ?>
                    <tr>
                        <td><?= htmlspecialchars((string) $producto['id'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td><?= htmlspecialchars((string) $producto['nombre'], ENT_QUOTES, 'UTF-8') ?></td>
                        <td>$<?= number_format((float) $producto['precio'], 2) ?></td>
                        <td><?= htmlspecialchars((string) $producto['stock'], ENT_QUOTES, 'UTF-8') ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
