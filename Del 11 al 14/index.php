<?php
include "ejercicio11.php";
include "ejercicio12.php";
include "ejercicio13.php";
include "ejercicio14.php";


echo "Ejercicio11: ";
echo"<br>";
MostrarPotencias();
echo"<br>";

echo "Ejercicio12: ";
$arrayLetras = array("H", "O", "L", "A");
InvertirPalabra($arrayLetras);
echo"<br>";

echo "Ejercicio13: ";
verificarPalabra("Parcial", 20);
echo"<br>";


echo "Ejercicio14: ";
echo"<br>";
if(esPar(1))
{
    echo "Es par";
}
else
{
    echo "Es impar";
}
echo"<br>";
if(esImpar(2))
{
    echo "Es impar";
}
else
{
    echo "Es par";
}
?>