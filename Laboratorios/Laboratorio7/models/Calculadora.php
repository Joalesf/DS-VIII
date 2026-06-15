<?php

class Calculadora
{
    public function sumar($numero1, $numero2)
    {
        return $numero1 + $numero2;
    }

    public function restar($numero1, $numero2)
    {
        return $numero1 - $numero2;
    }

    public function multiplicar($numero1, $numero2)
    {
        return $numero1 * $numero2;
    }

    public function dividir($numero1, $numero2)
    {
        if ($numero2 == 0) {
            throw new SoapFault('Server', 'No se puede dividir entre cero.');
        }

        return $numero1 / $numero2;
    }
}
