<?php

//indexado
$lapiceras = array();

//el indexado contiene a los arrays asociativos.
$lapiceras[0] = array("color"=>"Violeta", "marca"=>"Bic", "trazo"=>"fino", "precio"=>200);
$lapiceras[1] = array("color"=>"Rojo", "marca"=>"Faber Castell", "trazo"=>"Ultra fino", "precio"=>100);
$lapiceras[2] = array("color"=>"Verde", "marca"=>"Micro", "trazo"=>"Grueso", "precio"=>250);

//var_dump($lapiceras)

echo "Lapiceras: ", "<br>";

for ($i=0; $i < count($lapiceras) ; $i++) { 

		foreach ($lapiceras[$i] as $clave => $valor) {
		echo "Clave: $clave Valor: $valor <br/>";
	}
	echo "--------------------------------- <br/>";
}


?>