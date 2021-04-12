<?php

include_once "./clases/Venta.php";

if(isset($_POST["codigoBarra"]) && isset($_POST["idUsuario"]) && isset($_POST["cantidadItems"]) )
{

    $codigoBarra = $_POST["codigoBarra"];
    $idUsuario = $_POST["idUsuario"];
    $cantidadItems = $_POST["cantidadItems"];


    $venta = new Venta(null, $codigoBarra, $idUsuario, $cantidadItems);

    echo Venta::RealizarVenta($venta);
        



    
}
else
{
    echo "Faltan datos";
}



?>