<?php

//duda con el enunciado, "los primeros 10 números impares" se refiere a los 10 primeros impares contando desde 1 para arriba o a los 10 primeros impares que encuentre aleatoriamente.

$impares = array();
$contador = 0;

for ($i=0; count($impares) < 10 ; $i++) { 
	if($i%2 != 0){
		$impares[] = $i; 
	}
}

echo "Imprimir con for", "<br>";
for ($i=0; $i < count($impares); $i++) { 
	echo "Numero: ", $impares[$i];
	echo "<br>";
}

echo "<br>", "Imprimir con while ", "<br>";
$auxContadorWhile = 0;
while ($auxContadorWhile < count($impares)) {
	echo "Numero: ", $impares[$auxContadorWhile];
	echo "<br>";

	$auxContadorWhile++;
}

echo "<br>", "Imprimir con foreach ", "<br>";
foreach ($impares as $numeroImpar) {
	echo "Numero: $numeroImpar";
	echo "<br>";
}



?>