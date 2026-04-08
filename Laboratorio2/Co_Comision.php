<?php

require_once 'colaborador.php';

class Co_Comision extends colaborador {
    private $ventas;
    private $porcentaje;

    public function __construct($nombre, $salarioBase, $id, $ventas, $porcentaje) {
        parent::__construct($nombre, $salarioBase, $id);
        $this->ventas = $ventas;
        $this->porcentaje = $porcentaje;
    }

    public function calcularSalario() {
        return $this->salarioBase + ($this->ventas * $this->porcentaje);
    }
}