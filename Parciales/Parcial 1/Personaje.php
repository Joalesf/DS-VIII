<?php
class Personaje extends Origen {
    private $habilidadesManager;
    protected $vida;
    private $nombre;
    protected $mana;
    private $habilidades;
    private $nivel;

    public function __construct($nombre = "Gandalf", $vida = 200, $mana = 150, $nivel = 1) {
        $this->habilidadesManager = new Habilidad();
        $this->habilidades = $this->habilidadesManager->getHabilidades();
        $this->nombre = $nombre;
        $this->vida = $vida;
        $this->mana = $mana;
        $this->nivel = $nivel;
        parent::__construct();
    }

    public function newhabilidad($nivel) {
        $this->habilidadesManager->addHabilidad($nivel, $this->nombre);
        $this->habilidades = $this->habilidadesManager->getHabilidades();
    }

    public function recibirDaño($daño) {
        if ($this->vida <= 0) {
            throw new Exception($this->nombre . " ya está derrotado y no puede recibir más daño.");
        }
        $this->vida -= $daño;
        if ($this->vida < 0) {
            $this->vida = 0;
        }
        echo $this->nombre . " recibió " . $daño . " de daño. Vida restante: " . $this->vida . "<br>";
        if ($this->vida == 0) {
            echo "¡" . $this->nombre . " ha sido derrotado!<br>";
        }
    }

    public function subirNivel() {
        $this->nivel++;
        echo $this->nombre . " subió a nivel " . $this->nivel . ".<br>";
        $this->newhabilidad($this->nivel);
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getVida() {
        return $this->vida;
    }

    public function getMana() {
        return $this->mana;
    }

    public function reduceMana($costo) {
        $this->mana -= $costo;
        if ($this->mana < 0) {
            $this->mana = 0;
        }
    }

    public function getHabilidades() {
        return $this->habilidades;
    }
}

?>
