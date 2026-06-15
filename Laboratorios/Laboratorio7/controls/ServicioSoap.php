<?php
require_once __DIR__ . '/../models/Calculadora.php';

if (!class_exists('SoapServer')) {
    http_response_code(500);
    echo 'La extension SOAP de PHP no esta habilitada.';
    exit;
}

$servidor = new SoapServer(null, array(
    'uri' => 'urn:CalculadoraSoap'
));

$servidor->setClass('Calculadora');
$servidor->handle();
