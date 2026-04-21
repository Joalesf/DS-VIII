<?php
require_once 'Colaborador.php';

class PorHora extends Colaborador {
    private $horas;
    private $tarifa;

    public function __construct($nombre, $identificacion, $horas, $tarifa) {
        parent::__construct($nombre, 0, $identificacion);
        $this->horas = $horas;
        $this->tarifa = $tarifa;
    }

    public function calcularSalario() {
        return $this->tarifa * $this->horas;
    }

    public function getTipo() {
        return "Por Hora";
    }
}
?>