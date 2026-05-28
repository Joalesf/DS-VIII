<?php

class ControladorInicio
{
    public function index()
    {
        $titulo = 'Registro de aspirantes';

        require ROOT_PATH . '/views/inicio.php';
    }
}
