<?php
class Habilidad {
    private $habilidades = [
        ["numero" => 1, "name" => "Golpe Basico", "dañoBase" => 20, "constoMana" => 0],
        ["numero" => 2, "name" => "Bola de Fuego", "dañoBase" => 50, "constoMana" => 30],
    ];

    private $habilidadesEnemigo = [
        ["numero" => 1, "name" => "Ataque Físico", "dañoBase" => 30],
        ["numero" => 2, "name" => "Lanzar Piedra", "dañoBase" => 50],
    ];


    public function getHabilidades() {
        return $this->habilidades;
    }

    public function getHabilidadesEnemigo() {
        return $this->habilidadesEnemigo;
    }

    public function addHabilidad($nivel, $nombre) {
        switch ($nivel) {
            case 2:
                $this->habilidades[] = ["numero" => 3, "name" => "temblor", "dañoBase" => 20, "constoMana" => 10];
                echo $nombre . " aprendió: temblor, costo de mana: 10, daño base: 20 <br>";
                break;
            case 3:
                $this->habilidades[] = ["numero" => 4, "name" => "aturdir", "dañoBase" => 30, "constoMana" => 0];
                echo $nombre . " aprendió: aturdir, costo de mana: 0, daño base: 30 <br>";
                break;
            case 4:
                $this->habilidades[] = ["numero" => 5, "name" => "Chorro de Agua", "dañoBase" => 30, "constoMana" => 15];
                echo $nombre . " aprendió: Chorro de Agua, costo de mana: 15, daño base: 30 <br>";
                break;
            case 5:
                $this->habilidades[] = ["numero" => 6, "name" => "Fragmento de Hielo", "dañoBase" => 40, "constoMana" => 25];
                echo $nombre . " aprendió: Fragmento de Hielo, costo de mana: 25, daño base: 40 <br>";
                break;
            case 6:
                $this->habilidades[] = ["numero" => 7, "name" => "Rayo de Trueno", "dañoBase" => 50, "constoMana" => 35];
                echo $nombre . " aprendió: Rayo de Trueno, costo de mana: 35, daño base: 50 <br>";
                break;
            case 7:
                $this->habilidades[] = ["numero" => 8, "name" => "Ilusiones magicas", "dañoBase" => 60, "constoMana" => 50];
                echo $nombre . " aprendió: Ilusiones magicas, costo de mana: 50, daño base: 60 <br>";
                break;
            case 8:
                $this->habilidades[] = ["numero" => 9, "name" => "Lluvia de Meteoritos", "dañoBase" => 80, "constoMana" => 70];
                echo $nombre . " aprendió: Lluvia de Meteoritos, costo de mana: 70, daño base: 80 <br>";
                break;
            case 9:
                $this->habilidades[] = ["numero" => 10, "name" => "Tornado de fuego", "dañoBase" => 100, "constoMana" => 90];
                echo $nombre . " aprendió: Tornado de fuego, costo de mana: 90, daño base: 100 <br>";
                break;
            case 10:
                $this->habilidades[] = ["numero" => 11, "name" => "Doom", "dañoBase" => 9999999, "constoMana" => 0];
                echo $nombre . " aprendió: Doom, costo de mana: 0, daño base: 9999999 <br>";
                break;
                
            default:
                echo "No hay nuevas habilidades disponibles para este nivel. <br>";
                break;
        }
    }
}
?>