<?php

$a = 2;
$b = 4;
$c = 6;

$intermedio;

if($a > $b && $a < $c || $a < $b && $a > $c){

	$intermedio = $a;
}
else if($b> $a && $b < $c || $b < $a && $b > $c){

	$intermedio = $b;
}
else if($c> $a && $c < $b || $c < $a && $c > $b)
{
	$intermedio = $c;
}
else
{
	$intermedio = "No hay";
}

echo"Intemedio: " , $intermedio;

?>