<?php

include_once "./clases/Usuario.php";
include_once "./clases/Producto.php";
include_once "./clases/Venta.php";


//--------------------------------------------------------//
// A. Obtener los detalles completos de todos los usuarios y poder ordenarlos alfabéticamente de forma ascendente o descendente.
/*$orden = $_GET["orden"];
$lista = Usuario::UsuariosOrdenadosAlfabeticamente($orden);
Usuario::DibujarTablaUsuario($lista);
*/


//--------------------------------------------------------//
//B. Obtener los detalles completos de todos los productos y poder ordenarlos alfabéticamente de forma ascendente y descendente.
/*$orden = $_GET["orden"];
$listaProductos = Producto::ProductosOrdenadosAlfabeticamente($orden);
Producto::DibujarTablaProducto($listaProductos);
*/

//--------------------------------------------------------//
//C. Obtener todas las compras filtradas entre dos cantidades.
/*$listaVentas = Venta::VentasEntreCantidades($_GET["cantidad1"],$_GET["cantidad2"]);
Venta::DibujarTablaVentas($listaVentas);*/

//--------------------------------------------------------//
//D. Obtener la cantidad total de todos los productos vendidos entre dos fechas.
/*$cantidadVentas = Venta::CantidadTotalProductosVendidos($_GET["fecha1"], $_GET["fecha2"]);
foreach ($cantidadVentas as $cantidades) {
    echo $cantidades;
}
*/

//--------------------------------------------------------//
//E. Mostrar los primeros “N” números de productos que se han enviado.
/*$ventas = Venta::NumerosProductosEnviados($_GET["limite"]);
foreach ($ventas as $producto) {
   echo "<ul>";
   echo "<li>"." ".$producto->GetIdProducto()."</li>";
   echo "</ul>";
}
*/

//--------------------------------------------------------//
//F. Mostrar los nombres del usuario y los nombres de los productos de cada venta.
/*$ventas = Venta::NombresDeUsersProdsVentas();
Venta::DibujarTablaVentas($ventas);
*/

//--------------------------------------------------------//
//G. Indicar el monto (cantidad * precio) por cada una de las ventas.
/*$lista = Venta::MontoTotalPorVenta();
Venta::MostrarDatosVenta($lista);
*/

//--------------------------------------------------------//
//H.Obtener la cantidad total de un producto (ejemplo:1003) vendido por un usuario(ejemplo: 104).
/*$ventaTotal = Venta::VentaTotalProductoPorUsuario($_GET["idProducto"], $_GET["idUsuario"]);
foreach ($ventaTotal as $total) {
    foreach($total as $num)
    {
        echo "Total vendido del producto ".$_GET["idProducto"]." por el usuario ".$_GET["idUsuario"].": $num";
    }
}*/

//--------------------------------------------------------//
//I. Obtener todos los números de los productos vendidos por algún usuario filtrado por localidad (ejemplo: ‘Avellaneda’).
/*$ventasLocalidad = Venta::VentasPorLocalidad($_GET["localidad"]);
echo "Vendidos en la lolcalidad ".$_GET["localidad"];
foreach ($ventasLocalidad as $total) 
{
    foreach($total as $num)
    {
        echo $num, "<br/>";
    }
}
*/

//--------------------------------------------------------//
//J. Obtener los datos completos de los usuarios filtrando por letras en su nombre o apellido.
/*$usuarios = Usuario::FiltrarPorNombreOApellido($_GET["letra"]);
Usuario::DibujarTablaUsuario($usuarios);
*/

//--------------------------------------------------------//
//K. Mostrar las ventas entre dos fechas del año.
$ventasPorFechas = Venta::VentaEntreFechas($_GET["fecha1"], $_GET["fecha2"]);
Venta::DibujarTablaVentas($ventasPorFechas);

?>