<?php
require_once __DIR__ . '/controls/ClienteControlador.php';

$controlador = new ClienteControlador();
$vista = $controlador->procesarSolicitud();

require __DIR__ . '/view/cliente.php';
