
<?php

$numeros = array(
			rand(0,10),
			rand(0,10),
			rand(0,10),
			rand(0,10),
			rand(0,10)
		);

$acumulador = 0;
$contador = 0;
$promedio = 0;
$mensaje;

//var_dump($numeros);

for ($i=0; $i < 5 ; $i++) { 
	
	$acumulador = $acumulador + $numeros[$i];
	$contador++;

}

$promedio = $acumulador / $contador;

if($promedio > 6)
{
	$mensaje = "Promedio mayor a 6";
}
elseif($promedio == 6){
	$mensaje= "Promedio igual a 6";
}
else{
	$mensaje= "Promedio menor a 6";
}

echo "$mensaje";
?>