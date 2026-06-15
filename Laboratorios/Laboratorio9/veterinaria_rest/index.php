<?php
declare(strict_types=1);

require_once __DIR__ . '/controllers/PedidoController.php';

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$controlador = new PedidoController();
$metodo = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$ruta = obtenerRuta();

if ($metodo === 'GET' && $ruta === '') {
    $controlador->inicio();
}

if ($metodo === 'GET' && $ruta === 'productos') {
    $controlador->listarProductos();
}

if ($metodo === 'POST' && $ruta === 'pedidos') {
    $controlador->crearPedido();
}

$controlador->noEncontrado($ruta);

function obtenerRuta(): string
{
    if (isset($_GET['route'])) {
        return trim((string) $_GET['route'], '/');
    }

    $pathInfo = $_SERVER['PATH_INFO'] ?? '';

    if ($pathInfo !== '') {
        return trim($pathInfo, '/');
    }

    $uri = parse_url((string) ($_SERVER['REQUEST_URI'] ?? ''), PHP_URL_PATH) ?: '';
    $scriptName = str_replace('\\', '/', (string) ($_SERVER['SCRIPT_NAME'] ?? ''));
    $directorioScript = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

    if ($directorioScript !== '' && str_starts_with($uri, $directorioScript)) {
        $uri = substr($uri, strlen($directorioScript));
    }

    $uri = trim($uri, '/');

    if ($uri === 'index.php') {
        return '';
    }

    if (str_starts_with($uri, 'index.php/')) {
        return trim(substr($uri, strlen('index.php/')), '/');
    }

    return $uri;
}
