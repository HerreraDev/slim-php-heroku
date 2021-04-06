<?php

$num = rand(20, 60);
$mensaje;
$mensaje2;

$num = (string)$num;

switch($num[0])
{
	case '2':
		$mensaje = "Veinti";
		if($num[1] == "0")
			{
				$mensaje = "Veinte";
			}
		break;
	case '3':
		$mensaje = "Treinta y ";
		if($num[1] == "0")
			{
				$mensaje = "Treinta";
			}
		break;
	case '4':
			$mensaje = "Cuarenta y ";
			if($num[1] == "0")
			{
				$mensaje = "Cuarenta";
			}
		break;
	case '5':
			$mensaje = "Cincuenta y ";
			if($num[1] == "0")
			{
				$mensaje = "Cincuenta";
			}
		break;
	case '6':
			$mensaje = "Sesenta y ";
			if($num[1] == "0")
			{
				$mensaje = "Sesenta";
			}
		break;
	
	default:
		echo "No modificar el random";
		break;
}

switch($num[1])
    {
    	case "0":
            $mensaje2 = "";
            break;
        case "1":
            $mensaje2 = "uno.";
            break;
        case "2":
            $mensaje2 = "dos.";
            break;
        case "3":
            $mensaje2 = "tres.";
            break;
        case "4":
            $mensaje2 = "cuatro.";
            break;
        case "5":
            $mensaje2 = "cinco.";
            break;
        case "6":
            $mensaje2 = "seis.";
            break;
        case "7":
            $mensaje2 = "siete.";
            break;
        case "8":
            $mensaje2 = "ocho.";
            break;
        case "9":
            $mensaje2 = "nueve.";
            break;                                                                                            
    }

echo "$mensaje$mensaje2";

?>