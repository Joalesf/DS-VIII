<?php

require_once 'colaborador.php';

class Co_Horas extends colaborador {
    private $horasTrabajadas;
    private $pagoPorHora;

    public function __construct($nombre, $id, $horasTrabajadas, $pagoPorHora) {
        parent::__construct($nombre, 0, $id);
        $this->horasTrabajadas = $horasTrabajadas;
        $this->pagoPorHora = $pagoPorHora;
    }

    public function calcularSalario() {
        return $this->horasTrabajadas * $this->pagoPorHora;
    }
}