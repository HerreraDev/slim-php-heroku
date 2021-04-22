<?php

include_once "./clases/Producto.php";
include_once "./clases/Usuario.php";

class Venta{

    private $id_producto;
    private $id_usuario;
    private $cantidad;
    private $fecha_de_venta;
    

    public function __construct()
    {
    }

    public static function ConstructorParametrizado($id_producto, $id_usuario, $cantidad)
    {
        $venta = new Venta();

        $venta->id_producto = $id_producto;
        $venta->id_usuario = $id_usuario;
        $venta->cantidad = $cantidad;
        $venta->fecha_de_venta = date("Y-m-d");

        return $venta;
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

    //Metodos para BD
    //--------------------------------------------------------------//

    public static function TraerTodasLasVentas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from venta");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");		
    }

    public function InsertarVentaParametros()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into venta (id_producto,id_usuario,cantidad,fecha_de_venta)values(:id_producto,:id_usuario,:cantidad,:fecha_de_venta)");
        $consulta->bindValue(':id_producto', $this->id_producto, PDO::PARAM_STR);
        $consulta->bindValue(':id_usuario', $this->id_usuario, PDO::PARAM_STR);
        $consulta->bindValue(':cantidad', $this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_de_venta', $this->fecha_de_venta, PDO::PARAM_INT);
        $consulta->execute();		
        return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

    public static function RealizarVentaBD($venta)
    {

        $arrayUsuarios = array();
        $arrayProductos = array();

        $arrayUsuarios = Usuario::TraerTodoLosUsuariosDB();
        $arrayProductos = Producto::TraerTodoLosProductos();

        $existeUsuario = false;
        $existeProducto = false;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->GetId() == $venta->id_usuario)
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