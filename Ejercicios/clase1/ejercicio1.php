<?php

	$resultado = 0;
	$numerosContados = 0;


	for($i = 1; $resultado < 1000; $i ++)
	{
		$resultado += $i;
		echo "Suma: ", $resultado - $i;
		echo "<br>";


		$numerosContados ++;
	}

		echo "Cantidad de numeros sumados: ", $numerosContados;
?>