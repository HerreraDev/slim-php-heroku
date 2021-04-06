<?php

$lapicera = array("color"=>"Violeta", "marca"=>"Bic", "trazo"=>"fino", "precio"=>200);
$lapiceraDos = array("color"=>"Rojo", "marca"=>"Faber Castell", "trazo"=>"Ultra fino", "precio"=>100);
$lapiceraTres = array("color"=>"Verde", "marca"=>"Micro", "trazo"=>"Grueso", "precio"=>250);


echo "Primera lapicera: ", "<br>";
	foreach ($lapicera as $clave => $valor) {
		echo "Clave: $clave Valor: $valor <br/>";
	}
echo "--------------------------------- <br/>";
echo "Segunda lapicera: ", "<br>";
	foreach ($lapiceraDos as $clave => $valor) {
		echo "Clave: $clave Valor: $valor <br/>";
	}
echo "--------------------------------- <br/>";
echo "Tercer lapicera: ", "<br>";
	foreach ($lapiceraTres as $clave => $valor) {
		echo "Clave: $clave Valor: $valor <br/>";
	}



?>