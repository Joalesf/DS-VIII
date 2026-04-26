<?php
require_once 'Habilidad.php';
class Enemigo {
    private $nombre = "Orco";
    private $vida;
    private $habilidades;
    private $habilidadesManager;

    public function __construct($nombre = "Orco", $vida = 500) {
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->habilidadesManager = new Habilidad();
        $this->habilidades = $this->habilidadesManager->getHabilidadesEnemigo();
    }

    public function recibirDaño($daño) {
        $this->vida -= $daño;
        if ($this->vida < 0) {
            $this->vida = 0;
        }
        echo $this->nombre . " recibió " . $daño . " de daño. Vida restante: " . $this->vida . "<br>";
        if ($this->vida == 0) {
            echo "¡" . $this->nombre . " ha sido derrotado!<br>";
        }
    }

    public function getVida() {
        return $this->vida;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getHabilidades() {
        return $this->habilidades;
    }
}
?>