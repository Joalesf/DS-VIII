<?php
require_once 'Colaborador.php';

class TiempoCompleto extends Colaborador {

    public function calcularSalario() {
        return $this->salarioBase;
    }

    public function getTipo() {
        return "Tiempo Completo";
    }
}

?>