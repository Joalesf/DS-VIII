<?php

class Co_Horas extends colaborador
{
    public $horas;

    function __construct($nombre, $salario, $id, $horas)
    {
        parent::__construct($nombre, $salario, $id);
        $this->horas = $horas;
    }
}






>