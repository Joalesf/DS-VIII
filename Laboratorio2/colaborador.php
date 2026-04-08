<?php

abstract class colaborador {
    protected $nombre;
    protected $salarioBase;
    protected $id;

    public function __construct($nombre, $salarioBase, $id) {
        $this->nombre = $nombre;
        $this->salarioBase = $salarioBase;
        $this->id = $id;
    }

    abstract public function calcularSalario();

    public function getNombre() {
        return $this->nombre;
    }

    public function getId() {
        return $this->id;
    }
}