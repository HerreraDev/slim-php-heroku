<?php   

function MostrarPotencias()
{
    for($i = 1; $i <= 4 ; $i++)
    {
        echo "Potencias (0,1,2,3) del numero: ", $i;
        echo "<br>";
        for($j = 0; $j <= 3 ; $j++)
        {
            echo "Valor: ", pow($i, $j);
            echo "<br>";
        }
    }
}

//MostrarPotencias();

?>