<?php

$operador = "+";

$op1 = rand(0, 9);
$op2 = rand(0, 9);

switch ($operador) {
	case '+':
			echo"Resultado: ", $op1+$op2;
		break;
	case '-':
			echo"Resultado: ", $op1-$op2;
		break;
	case '/':
		if($op2 == 0){
			echo "Error, no se puede dividir por cero";
		}
		else{
			echo"Resultado: ", $op1/$op2;
		}

		break;
	case '*':
			echo"Resultado: ", $op1*$op2;
		break;
	default:
		echo"Error operador no valido";
		break;
}




?>