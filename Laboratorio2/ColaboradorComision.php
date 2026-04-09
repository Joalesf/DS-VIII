<?php
require_once 'TiempoCompleto.php';
require_once 'PorComision.php';
require_once 'PorHora.php';

$empleados = [
    new TiempoCompleto("Carlos", 1200, "TC001"),
    new PorComision("Ana", 800, "PC001", 350),
    new PorHora("Luis", "PH001", 160, 10)
];

// Polimorfismo
foreach ($empleados as $empleado) {
    if ($empleado instanceof Colaborador) {
        $empleado->mostrarInformacion();
    }
}
?>