<?php



include_once "./clases/Usuario.php";
include_once "./clases/Producto.php";
include_once "./clases/Venta.php";


$archivoParaLeer = $_GET["listado"];

switch($archivoParaLeer)
{
    case "usuarios":
        $lista = Usuario::TraerTodoLosUsuarios();
        Usuario::DibujarLista($lista);
        break;
    case "productos":
        $lista = Producto::TraerTodoLosProductos();
        Producto::DibujarLista($lista);
        break;
    case "ventas":
        $lista = Venta::TraerTodaLasVentas();
        Venta::DibujarLista($lista);
        break;
    default:
        echo "ERROR. Tabla inexsistente";
    break;

}





?>