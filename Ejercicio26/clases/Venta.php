<?php

include_once "./clases/Producto.php";
include_once "./clases/Usuario.php";

class Venta{

    private $_idVenta;
    private $_codigoBarra;
    private $_idUsuario;
    private $_cantidadItems;
    

    public function __construct($_idVenta = null, $_codigoBarra,$_idUsuario, $_cantidadItems)
    {
        $this->_codigoBarra = $_codigoBarra;
        $this->_idUsuario = $_idUsuario;
        $this->_cantidadItems = $_cantidadItems;
        if($_idVenta == null)
        {
            $this->_idVenta = random_int(1,10000);
        }
        else
        {
            $this->_idVenta = $_idVenta;
        }
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function GuardarEnJson($venta)
    {

        $direccionArchivo = fopen("./archivos/ventas.json","a");
        

        if ($direccionArchivo != false)
        {
            if(fwrite($direccionArchivo, json_encode($venta->jsonSerialize()). "\n") != false)
            {
                fclose($direccionArchivo);
                return 1;
            }
            else
            {
                fclose($direccionArchivo);
                return 0;
            }
                    
        }
    }

    public static function RealizarVenta($venta)
    {

        $arrayUsuarios = array();
        $arrayProductos = array();

        $arrayUsuarios = Usuario::LeerDeJson("./archivos/usuarios.json");
        $arrayProductos = Producto::LeerDeJson("./archivos/productos.json");

        $existeUsuario = false;
        $existeProducto = false;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->GetId() == $venta->_idUsuario)
            {
                $existeUsuario = true;
                break;
            }
        }

        foreach($arrayProductos as $producto)
        {
            if($producto->GetCodigoBarra() == $venta->_codigoBarra && $producto->GetStock() > $venta->_cantidadItems)
            {
                $existeProducto = true;
                break;
            }
        }

        if($existeUsuario == true && $existeProducto == true)
        {
            Venta::GuardarEnJson($venta);
            return "Venta realizada";
        }
        else
        {
            return "No se pudo hacer";
        }




    }





}




?>