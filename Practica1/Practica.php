<?php

$temperaturac = 10;  
$temperaturaf= "";

    $temperaturaf= ($temperaturac * 9/5) + 32;
if($temperaturaf< -50) {
    echo " La temperatura es fría ";
} elseif($temperaturaf>=50 && $temperaturaf <= 86){
    echo " La temperatura es Templada ";
} elseif($temperaturaf > 86) {
    echo " La temperatura es caliente ";    
} else {
    echo " La temperatura  caliente ";
}
?>