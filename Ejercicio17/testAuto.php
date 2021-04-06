<?php

include "Auto.php";


$auto1 = new Auto("Chevrolet", "Rojo");
$auto2 = new Auto("Chevrolet", "Azul");


$auto3 = new Auto("Peugeot", "Amarillo",20530.3);
$auto4 = new Auto("Peugeot", "Amarillo",50150.4);

$auto5 = new Auto("Renault", "Verde", 61510, new DateTime("2020-6-22"));



$auto3->AgregarImpuestos(1500);
$auto4->AgregarImpuestos(1500);
$auto5->AgregarImpuestos(1500);


$sumaAutos = Auto::Add($auto1, $auto2);

echo "La suma de los dos primeros autos da: ", $sumaAutos, "<br/>", "--------------------------", "<br/>";

if($auto1->Equals($auto2))
{
    Echo "Los primeros dos coches son iguales", "<br/>";
}
else
{
    Echo "Los primeros dos coches no son iguales", "<br/>";
}

if($auto1->Equals($auto5))
{
    Echo "El primer coche y el quinto son iguales", "<br/>";
}
else
{
    Echo "El primer coche y el quinto no son iguales", "<br/>";
}
echo "----------------------------", "<br/>";
Auto::MostrarAuto($auto1);
echo "----------------------------", "<br/>";
Auto::MostrarAuto($auto3);
echo "----------------------------", "<br/>";
Auto::MostrarAuto($auto5);


?>