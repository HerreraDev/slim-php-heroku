<?php

include_once "./clases/Producto.php";

echo $_POST["codigoBarra"];

if(isset($_POST["codigoBarra"]) && isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["stock"]) && isset($_POST["precio"]))   
{
    $codigoBarra = $_POST["codigoBarra"];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $stock = $_POST["stock"];
    $precio = $_POST["precio"];

    $producto = Producto::ConstructorParametrizado($codigoBarra,$nombre,$tipo,$stock,$precio);

    if(Producto::ActualizarProductoExistente($producto))
    {
        echo " -- Producto actualizado";
    }
    else
    {
        echo "No se pudo hacer";
    }
}
else
{
    echo "Faltan cargar datos";
}



?>