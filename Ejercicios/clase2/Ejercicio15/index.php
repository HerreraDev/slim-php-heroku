<?php

include_once "Triangulo.php";
include_once "Rectangulo.php";


$rectangulo = new Rectangulo(7,6);

$rectangulo->SetColor("Rojo");

$rectangulo->ToString();


echo "-------------------------------", "<br/>";

$triangulo = new Triangulo (7,6);

$triangulo->SetColor("Verde");

$triangulo->ToString();
?>