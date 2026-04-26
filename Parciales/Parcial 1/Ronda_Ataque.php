<?php
class Ronda_Ataque {
    public function iniciarCombate($personaje, $enemigo) {

        $ronda = 1;
        while ($personaje->getVida() > 0 && $enemigo->getVida() > 0) {
            echo "<strong>Ronda $ronda:</strong><br>";
            
            // Personaje ataca
            $this->atacar($personaje, $enemigo);
            $personaje->experiencia += 25;
            while ($personaje->experiencia >= 10) {
                $personaje->subirNivel();
                $personaje->experiencia -= 12.5;
            }
            
            if ($enemigo->getVida() > 0) {
                // Enemigo ataca con habilidad aleatoria
                $habilidadesEnemigo = $enemigo->getHabilidades();
                $habilidadEnemigo = $habilidadesEnemigo[array_rand($habilidadesEnemigo)];
                $dañoEnemigo = $habilidadEnemigo['dañoBase'];
                echo $enemigo->getNombre() . " usó " . $habilidadEnemigo['name'] . " causando " . $dañoEnemigo . " de daño.<br>";
                try {
                    $personaje->recibirDaño($dañoEnemigo);
                } catch (Exception $e) {
                    echo $e->getMessage() . "<br>";
                }
            }
            
            $ronda++;
            echo "<br>";
        }

        if ($personaje->getVida() > 0) {
            echo "<strong>¡Victoria!</strong> " . $personaje->getNombre() . " derrotó al enemigo.<br>";
        } else {
            echo "<strong>Derrota:</strong> " . $personaje->getNombre() . " fue derrotado.<br>";
        }
    }

    public function atacar($personaje, $enemigo) {
        $habilidades = $personaje->getHabilidades();
        $habilidad = $habilidades[array_rand($habilidades)];
        
        // Si no tiene mana suficiente, usar Golpe Básico
        if ($personaje->getMana() < $habilidad['constoMana']) {
            $habilidad = $habilidades[0]; // Golpe Básico
            echo $personaje->getNombre() . " no tiene suficiente mana, usando Golpe Básico.<br>";
        }

        $daño = $habilidad['dañoBase'];
        if (rand(1, 2) == 1) {
            $daño *= 4;
            echo "¡Golpe crítico! ";
        }

        $personaje->reduceMana($habilidad['constoMana']);

        // Atacar al enemigo y reducir su vida
        echo $personaje->getNombre() . " usó " . $habilidad['name'] . " y causó " . $daño . " de daño. " . "<br>" ;
        $enemigo->recibirDaño($daño);
    }
}

?> 