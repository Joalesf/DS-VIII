<?php

//Integrantes 
//Richard Rdriguez
//Edgar Rosario
//Jose Sanchez 




// echo: Imprime una cadena de texto
//con parentesis
echo("Hola, Mundo!" . "\n" . "<br>");

//sin parentesis
echo "Hola Mundo" . "\n" . "<br>";

//multiple parametros
//echo "Hola " . $nombre . "!";

//Print: Imprime una cadena de texto
print("Hola, Mundo!" . "\n" . "<br>");
$r = print("Hola!");
echo $r; //1

//Printf: Formatear una cadena de texto
$nombre = "Mundo" . "\n" . "<br>";
$n = 42;
printf("Hola %s| N°: %d", $nombre, $n . "\n" . "<br>");

$p = 1234.56789;
printf("El número es: %f", $p . "\n" . "<br>"); //El número es: 1234.567890
printf("El número es: %.2f", $p . "\n" . "<br>"); //El número es: 1234.57

//Array (arreglo)
//indexado
$arr = array(1, 2, 3);
//o bien 
$arr = [1, 2, 3];

// asociativo
$arr = array(
    "nombre" => "Juan",
    "edad" => 30
);

//Mutidimensional
$mat = [[1, 2], [3, 4]];
echo $mat[0][1]; //2

//Objecto(Object)
Class Persona {
    public $Nombre;
    public $edad;
}

$juan = new Persona(); 
$juan->nombre = "Juan"; 
$juan->edad = 30; 

//numero -> string
$n = 123;
$s = "El número es: " . $n . "\n" . "<br>";
//$s = "El número es: 123";

//string -> numero
$s = "100";
$r = $s + 50; //150

//boolean -> numero
$r = 10 + true; //11

//Sintaxis general 
//$var = (tipo) $original;

//String -> int
$s = "123.45" . "\n" . "<br>";
$i = (int) $s; //123

// int -> string
$n = 150;
$s = (string) $n; //"150"

// Suma 
$n1 = 10;
$n2 = 20;
$resultado = $n1 + $n2; //30
print("La suma es: " . $resultado . "\n" . "<br>"); //La suma es: 30

// Resta
$resultado = $n1 - $n2; //-10
print("La resta es: " . $resultado . "\n" . "<br>"); //La resta es: -10

//Producto
$resultado = $n1 * $n2; //200
print("El producto es: " . $resultado . "\n" . "<br>"); //El producto es: 200

//Division
$resultado = $n1 / $n2; //0.5
print("La división es: " . $resultado . "\n" . "<br>"); //La división es: 0.5
//modulo
$resultado = $n1 % $n2; //10
print("El módulo es: " . $resultado . "\n" . "<br>  "); //El módulo es: 10

//Exponenciación
$resultado = $n1 ** 2; //100
print("La exponenciación es: " . $resultado . "\n" . "<br> "); //La exponenciación es: 100

// salto de linea
print("Hola, Mundo!\n" . "<br>"); //Hola, Mundo!

// salto de linea con HTML
print("Hola, Mundo!<br>");

//Funciones SIN parametros
function saludar() {
    return "¡Hola, Mundo!" . "\n" . "<br>";
}
echo saludar(); //¡Hola, Mundo!

//Funciones CON parametros
function sumar($a, $b) {
    return $a + $b;
}
$res = sumar(10, 20);
echo $res . "\n" . "<br>"; //30

//funcion con multiples retornos
function multiplicar(int $a, int $b): int {
    return $a * $b;
}
$res = multiplicar(5, 4);
echo $res . "\n" . "<br>"; //20

//funcion con valor por defecto
function saludarPersona($nombre = "Mundo") {
    echo "¡Hola, $nombre!" . "\n" . "<br>";
}
saludarPersona(); //¡Hola, Mundo!
saludarPersona("Juan"); //¡Hola, Juan!

?>