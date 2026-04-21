<?php
require_once 'Colaborador.php';

class PorComision extends Colaborador {
    private $comision;

    public function __construct($nombre, $salarioBase, $identificacion, $comision) {
        parent::__construct($nombre, $salarioBase, $identificacion);
        $this->comision = $comision;
    }

    public function calcularSalario() {
        return $this->salarioBase + $this->comision;
    }

    public function getTipo() {
        return "Por Comisión";
    }
}
?>