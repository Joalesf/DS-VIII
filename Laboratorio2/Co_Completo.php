<?php

require_once 'colaborador.php';

class Co_Completo extends colaborador {
    public function __construct($nombre, $salarioBase, $id) {
        parent::__construct($nombre, $salarioBase, $id);
    }

    public function calcularSalario() {
        return $this->salarioBase;
    }
}