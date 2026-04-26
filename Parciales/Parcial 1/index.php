<?php
//Integrantes
//Richard Rdriguez
//Edgar Rosario
//Jose Sanchez
//Leonardo Liang

abstract class Origen {
    public $experiencia = 0;

    public function __construct($experiencia = 0) {
        $this->experiencia = $experiencia;
    }
}

require_once 'Personaje.php';
require_once 'Enemigo.php';
require_once 'Ronda_Ataque.php';
require_once 'Habilidad.php';

echo "<h2>Inicio del Combate RPG</h2><br>";
$personaje = new Personaje();
$enemigo = new Enemigo();

$ronda = new Ronda_Ataque();
$ronda->iniciarCombate($personaje, $enemigo);

echo "<h2>Fin del Combate</h2>";?>
