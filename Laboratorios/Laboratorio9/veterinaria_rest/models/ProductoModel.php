<?php
declare(strict_types=1);

class ProductoModel
{
    private SoapClient $cliente;

    public function __construct(?string $urlServicio = null)
    {
        if (!class_exists(SoapClient::class)) {
            throw new RuntimeException('La extension SOAP de PHP no esta habilitada.');
        }

        $this->cliente = new SoapClient(null, [
            'location' => $urlServicio ?: $this->urlServicioSoap(),
            'uri' => 'http://localhost/veterinaria_soap',
            'trace' => true,
            'exceptions' => true,
            'encoding' => 'UTF-8',
            'cache_wsdl' => WSDL_CACHE_NONE,
        ]);
    }

    public function listarProductos(): array
    {
        return $this->normalizar($this->cliente->listarProductos());
    }

    public function consultarProducto(int $productoId): array
    {
        return $this->normalizar($this->cliente->consultarProducto($productoId));
    }

    public function validarStock(int $productoId, int $cantidad): array
    {
        return $this->normalizar($this->cliente->validarStock($productoId, $cantidad));
    }

    public function actualizarStock(int $productoId, int $cantidad): array
    {
        return $this->normalizar($this->cliente->actualizarStock($productoId, $cantidad));
    }

    private function urlServicioSoap(): string
    {
        if (getenv('SOAP_URL')) {
            return (string) getenv('SOAP_URL');
        }

        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';

        return "http://{$host}/veterinaria_soap/soap_server.php";
    }

    private function normalizar(mixed $valor): mixed
    {
        if (is_object($valor)) {
            $valor = get_object_vars($valor);
        }

        if (is_array($valor)) {
            return array_map(fn (mixed $item): mixed => $this->normalizar($item), $valor);
        }

        return $valor;
    }
}
