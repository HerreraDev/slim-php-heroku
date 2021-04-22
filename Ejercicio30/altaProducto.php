<?php

include_once "./clases/Producto.php";

if(isset($_POST["codigoBarra"]) && isset($_POST["nombre"]) && isset($_POST["tipo"]) && isset($_POST["stock"]) && isset($_POST["precio"]))
{

    $codigoBarra = $_POST["codigoBarra"];
    $nombre = $_POST["nombre"];
    $tipo = $_POST["tipo"];
    $stock = $_POST["stock"];
    $precio = $_POST["precio"];


    $producto = Producto::ConstructorParametrizado($codigoBarra, $nombre, $tipo, $stock, $precio);

    echo Producto::ExisteProductoBD($producto);




        



    
}
else
{
    echo "Faltan datos o el codigo de barras no es igual a 6 caracteres de longitud";
}



?>