<?php

$fecha = date("d/m/Y");
$fechaIngles = date("M/d/Y");


echo "Fecha actual: ", $fecha;
echo "<br>";
echo "Fecha actual formato ingles: ", $fechaIngles;

echo "<br>";

switch (date($format = "m")) {
	case 12:
	case 1:
	case 2:
		echo "<br/>Estacion: verano";
		break;
	case 3:
	case 4:
	case 5:
		echo "<br/>Estacion: otoño";
		break;
	case 6:
	case 7:
	case 8:
		echo "<br/>Estacion: invierno";
		break;	
	default:
		echo "<br/>Estacion: primavera";
		break;
}


?>