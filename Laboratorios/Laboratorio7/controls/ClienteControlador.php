<?php

class ClienteControlador
{
    private $uriServicio = 'urn:CalculadoraSoap';
    private $servicioUrl;

    private $operaciones = array(
        'sumar' => 'Sumar',
        'restar' => 'Restar',
        'multiplicar' => 'Multiplicar',
        'dividir' => 'Dividir'
    );

    public function __construct($servicioUrl = null)
    {
        $this->servicioUrl = $servicioUrl ? $servicioUrl : $this->crearUrlServicio();
    }

    public function procesarSolicitud()
    {
        $vista = array(
            'operaciones' => $this->operaciones,
            'numero1' => '',
            'numero2' => '',
            'operacion' => 'sumar',
            'resultado' => null,
            'mensaje' => null,
            'error' => null,
            'servicioUrl' => $this->servicioUrl
        );

        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            return $vista;
        }

        $vista['numero1'] = trim(isset($_POST['numero1']) ? $_POST['numero1'] : '');
        $vista['numero2'] = trim(isset($_POST['numero2']) ? $_POST['numero2'] : '');
        $vista['operacion'] = isset($_POST['operacion']) ? $_POST['operacion'] : 'sumar';

        if (!isset($this->operaciones[$vista['operacion']])) {
            $vista['error'] = 'La operacion seleccionada no es valida.';
            return $vista;
        }

        $numero1 = $this->normalizarNumero($vista['numero1']);
        $numero2 = $this->normalizarNumero($vista['numero2']);

        if ($numero1 === null || $numero2 === null) {
            $vista['error'] = 'Ingresa dos numeros validos.';
            return $vista;
        }

        try {
            if (!class_exists('SoapClient')) {
                throw new Exception('La extension SOAP de PHP no esta habilitada.');
            }

            $cliente = new SoapClient(null, array(
                'location' => $this->servicioUrl,
                'uri' => $this->uriServicio,
                'trace' => true,
                'exceptions' => true
            ));

            $resultado = $cliente->__soapCall($vista['operacion'], array($numero1, $numero2));
            $vista['resultado'] = $this->formatearResultado($resultado);
            $vista['mensaje'] = $this->operaciones[$vista['operacion']] . ' completado correctamente.';
        } catch (Exception $error) {
            $vista['error'] = $error->getMessage();
        }

        return $vista;
    }

    private function crearUrlServicio()
    {
        $https = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off';
        $protocolo = $https ? 'https' : 'http';
        $host = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'localhost';
        $script = isset($_SERVER['SCRIPT_NAME']) ? $_SERVER['SCRIPT_NAME'] : '/index.php';
        $base = str_replace('\\', '/', dirname($script));

        if ($base == '/' || $base == '.') {
            $base = '';
        }

        return $protocolo . '://' . $host . $base . '/controls/ServicioSoap.php';
    }

    private function normalizarNumero($valor)
    {
        $valor = str_replace(',', '.', $valor);

        if (!is_numeric($valor)) {
            return null;
        }

        return (float) $valor;
    }

    private function formatearResultado($resultado)
    {
        $resultado = number_format((float) $resultado, 8, '.', '');
        return rtrim(rtrim($resultado, '0'), '.');
    }
}
