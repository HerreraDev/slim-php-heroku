<?php

include_once "./clases/Producto.php";
include_once "./clases/Usuario.php";

class Venta{

    private $idVenta;
    private $id_producto;
    private $id_usuario;
    private $cantidad;
    private $fecha_de_venta;
    

    public function __construct()
    {
    }

    public function GetIdProducto()
    {
        return $this->id_producto;
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

    public static function DibujarTablaVentas($lista){

		echo "<br/>";
        echo "<table>";
		foreach($lista as $venta)
		{
			echo "<tr>";
			foreach($venta as $item)
			{
				echo "<td>$item</td>";
			}
            
			echo "</tr>";
		}
        echo "</table>";
		echo "<br/>";

	}

    public static function MostrarDatosVenta($lista){

		foreach($lista as $venta)
		{
			echo "<ul>";
			foreach($venta as $item)
			{
				echo "<li>$item</li>";
			}
			echo "</ul>";
		}

	}
    //Metodos de listados DB
    //------------------------------------------------------//
    public static function VentasEntreCantidades($cantidad1, $cantidad2)
    {
        $listaVentas = array();
        if(isset($cantidad1) && isset($cantidad2))
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select * from venta WHERE cantidad BETWEEN :cantidad1 AND :cantidad2 ");
            $consulta->bindValue(':cantidad1', $cantidad1, PDO::PARAM_INT);
            $consulta->bindValue(':cantidad2', $cantidad2, PDO::PARAM_INT);
            $consulta->execute();			
            $listaVentas = $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");

            return $listaVentas;
        }
        else
        {
            echo "Debe cargar las dos cantidades";
        }
    }

    public static function CantidadTotalProductosVendidos($fecha1, $fecha2)
	{
        if(is_null($fecha1) && is_null($fecha2))
        {
            echo "ERROR. Ingrese las dos fechas";
        }
        else
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select SUM(cantidad) AS 'cantidadTotal' from venta WHERE fecha_de_venta BETWEEN :fechaMin AND :fechaMax");
            $consulta->bindValue(':fechaMin', $fecha1, PDO::PARAM_STR);
            $consulta->bindValue(':fechaMax', $fecha2, PDO::PARAM_STR);
            $consulta->execute();			
            return $consulta->fetch(PDO::FETCH_ASSOC);	
        }
	}

    public static function NumerosProductosEnviados($limite)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * FROM venta ORDER BY fecha_de_venta ASC LIMIT :limite");
        $consulta->bindValue(':limite', $limite, PDO::PARAM_INT);
        $consulta->execute();			
        $ventas = $consulta->fetchAll(PDO::FETCH_CLASS, "venta");
        return $ventas;
    }

    public static function NombresDeUsersProdsVentas()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select usuario.nombre as NombreDeUsuario, producto.nombre as NombreDeProducto FROM `usuario` INNER JOIN `venta` ON usuario.idUsuario = venta.id_usuario INNER JOIN `producto` ON producto.idProducto = venta.id_producto");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }

    public static function MontoTotalPorVenta()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select  venta.cantidad*producto.precio as monto FROM `venta` INNER JOIN `producto` ON venta.id_producto = producto.idProducto");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }

    public static function VentaTotalProductoPorUsuario($idproducto, $idusuario)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select SUM(venta.cantidad) from `venta` WHERE id_producto = :id_producto AND id_usuario = :idUsuario");
        $consulta->bindValue(':id_producto', $idproducto, PDO::PARAM_INT);
        $consulta->bindValue(':idUsuario', $idusuario, PDO::PARAM_INT);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }

    public static function VentasPorLocalidad($localidad)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select venta.id_producto FROM `venta` INNER JOIN `usuario` ON usuario.idUsuario = venta.id_usuario WHERE usuario.localidad = :localidad
        ");
        $consulta->bindValue(':localidad', $localidad, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);	
    }
    
    public static function VentaEntreFechas($fecha1, $fecha2)
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * FROM `venta` WHERE `fecha_de_venta` BETWEEN :fecha1 AND :fecha2");
        $consulta->bindValue(':fecha1', $fecha1, PDO::PARAM_STR);
        $consulta->bindValue(':fecha2', $fecha2, PDO::PARAM_STR);
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "venta");
    }
}




?>