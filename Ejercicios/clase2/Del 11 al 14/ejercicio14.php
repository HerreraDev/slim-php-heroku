<?php

function esPar($valorEntero)
{
    $exito = false;
    if($valorEntero % 2 == 0)
    {
        $exito = true;
    }

    return $exito;
}

function esImpar($valorEntero)
{
    $exito = false;
    if($valorEntero % 2 != 0)
    {
        $exito = true;
    }

    return $exito;
}

/*if(esPar(1))
{
    echo "Es par";
}
else
{
    echo "Es impar";
}
echo"<br>";
if(esImpar(2))
{
    echo "Es impar";
}
else
{
    echo "Es par";
}*/

?>