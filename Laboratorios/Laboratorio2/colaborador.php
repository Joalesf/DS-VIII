<?php
//Integrantes
//Richard Rdriguez
//Edgar Rosario
//Jose Sanchez
abstract class Colaborador {
    protected $nombre;
    protected $salarioBase;
    private $identificacion;

    public function __construct($nombre, $salarioBase, $identificacion) {
        $this->nombre = $nombre;
        $this->salarioBase = $salarioBase;
        $this->identificacion = $identificacion;
    }
3
    abstract public function calcularSalario();
    abstract public function getTipo();

    public function mostrarInformacion() {
        echo "Tipo de Contrato: " . $this->getTipo() . "<br>";
        echo "Nombre: " . $this->nombre . "<br>";
        echo "ID: " . $this->identificacion . "<br>";
        echo "Salario: $" . $this->calcularSalario() . "<br>";
        echo "--------------------------<br>";
    }
}
?>
