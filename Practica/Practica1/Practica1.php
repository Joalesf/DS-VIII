<?php
//Integrantes
//Richard Rdriguez
//Edgar Rosario
//Jose Sanchez



//PROBLEMA #1
$temperaturac = 10;  
$temperaturaf= "";

    $temperaturaf= ($temperaturac * 9/5) + 32;
if($temperaturaf< -50) {
    echo " La temperatura es fría ";
} elseif($temperaturaf>=50 && $temperaturaf <= 86){
    echo " La temperatura es Templada ";
} else if($temperaturaf > 86) {
    echo " La temperatura es caliente ";    
} 




// PROBLEMA #2
$peso=95;
$altura = 1.70;
$message;

// funcion que calcula el indice de masa corporal
function indiceCopororal($a,$b){

    return $a/($b^2);
}
//llamado a la funcion para asignarle el resultado a una variable
$imc = indiceCopororal($peso,$altura);
echo $imc .'<br>';


// validaciones para definir el peso
if($imc < 18.5)
    $message="esta bajo de peso";
else if($imc >= 18.5 && $imc <= 24.9)
    $message ="se encuentra saludable";
else if ($imc >= 25 && $imc <= 29.9 )
    $message= "papa tas gordo";
else 
    $message= " busca medico que tas obeso";

// resultado
echo $message . "\n" . "<br>";





//PROBLEMA #3
//EL usuario ingresa dos números enteros y un operador matemático
$num1 = 10;
$num2 = 5;  
$operador = "+";

//Validar que los números sean enteros
if (!is_int($num1) || !is_int($num2)) {
    print("Error: Debes ingresar números enteros." . "\n" . "<br>");
    exit; 
}


// Realizar la operación
switch ($operador) {
    case '+':
        $resultado = $num1 + $num2;
        break;
    case '-':
        $resultado = $num1 - $num2;
        break;
    case '*':
        $resultado = $num1 * $num2;
        break;
    case '/':
        if ($num2 == 0) {
            print("Error: No se puede dividir por cero." . "\n" . "<br>");
            exit; 
        }
        $resultado = $num1 / $num2;
        break;
    default:
        print("Error: Operador no válido. Usa +, -, *, o /" . "\n" . "<br>");
        exit; 
}
print("El resultado de la operación es: " . $resultado . "\n" . "<br>");

?>