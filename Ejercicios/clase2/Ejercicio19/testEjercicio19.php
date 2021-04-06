<?php

include_once "Pasajero.php";
include_once "Vuelo.php";

$pasajero1 = new Pasajero("Perez", "Juan", "23000333", true);
$pasajero2 = new Pasajero("Perez", "Silvia", "10000025", false);

$pasajero3 = new Pasajero("Gomez", "Juan", "77498498", true);
$pasajero4 = new Pasajero("Gomez", "Silvia", "19874984", false);
//Pasajero::MostrarPasajero($pasajero2);

$vuelo1 = new Vuelo(null,"Empresa x", 100, 4);
$vuelo2 = new Vuelo(null,"Empresa z", 200, 4);

$vuelo1->AgregarPasajero($pasajero1);
$vuelo1->AgregarPasajero($pasajero2);
echo "MUESTRO EL PRIMER VUELO CON SUS DOS PASAJEROS: ", "<br/>";
echo $vuelo1->MostrarVuelo();
"<br/>";

echo "<br/>", "MUESTRO EL SEGUNDO VUELO CON SUS DOS PASAJEROS: ", "<br/>";
$vuelo2->AgregarPasajero($pasajero3);
$vuelo2->AgregarPasajero($pasajero4);
echo $vuelo2->MostrarVuelo();
"<br/>";

echo "<br/>", "INTENTO AGREGAR UN PASAJERO QUE YA ESTA EN EL VUELO 1: ", "<br/>";
if(!($vuelo1->AgregarPasajero($pasajero1)))
{
    echo "ERROR, pasajero1 ya existente en vuelo 1", "<br/>";
}
"<br/>";

echo "<br/>", "PRUEBO SI FUNCIONA EL METODO DE SUMAR VUELOS: ", "<br/>";
echo "Recaudado entre vuelo1 y vuelo 2 : ", Vuelo::Add($vuelo1,$vuelo2), "<br/>";

echo "<br/>", "REMUEVO EL PASAJERO1 DEL VUELO1: ", "<br/>";
Vuelo::Remove($vuelo1 ,$pasajero1);
echo $vuelo1->MostrarVuelo();

echo "<br/>", "VUELO A INTENTAR REMOVER EL PASAJERO1 DEL VUELO1: ", "<br/>";
echo Vuelo::Remove($vuelo1 ,$pasajero1);







?>