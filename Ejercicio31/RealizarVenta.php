<?php

include_once "./clases/Venta.php";
include_once "./clases/Producto.php";
include_once "./clases/Usuario.php";



if(isset($_POST["codigoBarra"]) && isset($_POST["idUsuario"]) && isset($_POST["cantidadItems"]))
{

    $codigoBarra = $_POST["codigoBarra"];
    $idUsuario = $_POST["idUsuario"];
    $cantidadItems = $_POST["cantidadItems"];
 
    $id_producto = Producto::VerificarProducto($codigoBarra, $cantidadItems);

    $existeUser = Usuario::VerificarUsuarioPorId($idUsuario);

    if($id_producto != -1 && ($existeUser))
    {
        $venta = Venta::ConstructorParametrizado($id_producto,$idUsuario,$cantidadItems);

        $venta->InsertarVentaParametros();

        Producto::ActualizarStockBD($codigoBarra, $cantidadItems);

        echo "Venta realizada";

    }
    else
    {
        echo "ERROR. Usuario o producto inexistente o stock insuficiente";
    }
}
else
{
    echo "Faltan datos";
}



?>