<?php



function verificarPalabra($palabra, $max) {
    
    $palabrasAuxiliares = array("Recuperatorio", "Parcial", "Programacion");
    $exito = 0;
    if(strlen($palabra) > $max)
    {
        echo "Error, palabra excede variable max";
    }
    elseif(in_array($palabra, $palabrasAuxiliares, true))
    {
        echo "La palabra esta dentro de las esperadas (Recuperatorio, Parcial o Programacion)";
        $exito = 1;
    }
    else
    {
        echo "La palabra no esta dentro de las deseadas (Recuperatorio, Parcial o Programacion)";
    }
    return $exito;
  }


  //verificarPalabra("Parcial", 20);

?>