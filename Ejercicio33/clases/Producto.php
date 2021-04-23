<?php

include_once "AccesoDatos.php";

class Producto
{

    private $idProducto;
    private $codigo_de_barra;
    private $nombre;
    private $tipo;
    private $stock;
    private $precio;
    private $fecha_de_creacion;
    private $fecha_de_modificacion;


    public function __construct()
    {
    }

    public static function ConstructorParametrizado($codigo_de_barra, $nombre, $tipo, $stock, $precio){

        $prod = new Producto();

        $prod->codigo_de_barra = $codigo_de_barra;
        $prod->nombre = $nombre;
        $prod->tipo = $tipo;
        $prod->stock = $stock;
        $prod->precio = $precio;
        $prod->fecha_de_creacion = date("Y-m-d");
        $prod->fecha_de_modificacion = date("Y-m-d");
        $prod->idProducto;

        return $prod;

    }

    public function GetCodigoBarra()
    {
        return $this->codigo_de_barra;
    }

    public function GetNombre()
    {
        return $this->nombre;
    }

    public function GetTipo()
    {
        return $this->tipo;
    }

    public function GetStock()
    {
        return $this->stock;
    }

    public function GetId()
    {
        return $this->id;
    }

    public function GetPrecio()
    {
        return $this->precio;
    }

    
    //Metodos para JSON
    //-----------------------------------------------------------//

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public static function GuardarEnJson($prod, $mode)
    {

        $direccionArchivo = fopen("./archivos/productos.json",$mode);
        

        if ($direccionArchivo != false)
        {
            if(fwrite($direccionArchivo, json_encode($prod->jsonSerialize()). "\n") != false)
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

    /*public static function LeerDeJson($archivo){

        $vec = array();
        $productos = array();
        $archivo = fopen($archivo, "r");


        if($archivo != false){

            while(!feof($archivo))
            {
                $lectura = fgets($archivo);
                $vec = json_decode($lectura, true);
                
                if($vec != null)
                {
                    $prod = new Producto($vec["codigo_de_barra"],$vec["nombre"],$vec["tipo"],$vec["stock"], $vec["precio"]);
    
                    array_push($productos,$prod); 
                }
    
            }
            
            fclose($archivo);
        }

        return $productos;

    }*/

    public static function ExisteProducto(Producto $prod)
    {
        $arrayProductos = array();
        $arrayProductos = Producto::LeerDeJson("./archivos/productos.json");

        $verificado = -1;
        foreach($arrayProductos as $producto)
        {
            if($producto->_codigoBarra == $prod->_codigoBarra)
            {
                $producto->_stock += $prod->_stock;
                $verificado = 1;
                break;
            }
            else
            {
                $verificado = 0;
            }
        }

        if($verificado == -1)
        {
            echo "No se pudo hacer";
        }
        else
        {
            if($verificado)
            {
                $mode = "w";
    
                foreach($arrayProductos as $auxProd)
                {
                    Producto::GuardarEnJson($auxProd, $mode);
                    $mode = "a";
                }
     
                echo "Actualizado";
            }
            else
            {
                Producto::GuardarEnJson($prod, "a");
                echo "Ingresado";
            }
        }
        
    }
    //-----------------------------------------------------------//

    //Metodos para DB
    //-----------------------------------------------------------//

    public function mostrarDatos()
    {
        return "Datos:".$this->idProducto."  ".$this->codigo_de_barra."  ".$this->nombre." ".$this->tipo." ".$this->stock." ".$this->precio." ".$this->fecha_de_creacion." ".$this->fecha_de_modificacion;
    }

    public static function TraerTodoLosProductos()
    {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select idProducto, codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion, fecha_de_modificacion from producto");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");		
    }

    public function InsertarProductoParametros()
	{
			   $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			   $consulta =$objetoAccesoDato->RetornarConsulta("INSERT into producto (codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion)values(:codigo_de_barra,:nombre,:tipo,:stock,:precio,:fecha_de_creacion,:fecha_de_modificacion)");
			   $consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
			   $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
			   $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
			   $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
               $consulta->bindValue(':precio', $this->precio, PDO::PARAM_INT);
			   $consulta->bindValue(':fecha_de_creacion', $this->fecha_de_creacion, PDO::PARAM_STR);
			   $consulta->bindValue(':fecha_de_modificacion', $this->fecha_de_modificacion, PDO::PARAM_STR);
			   $consulta->execute();		
			   return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


    /**
     * Realiza el update de los campos del producto.
     */
    public function ModificarProductoParametros()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               UPDATE producto 
               SET nombre=:nombre,
               tipo=:tipo,
               stock=:stock,
               precio=:precio,
               fecha_de_modificacion=:fecha_de_modificacion
               WHERE codigo_de_barra=:codigo_de_barra");        
			   $consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
			    $consulta->bindValue(':nombre', $this->nombre, PDO::PARAM_STR);
			    $consulta->bindValue(':tipo', $this->tipo, PDO::PARAM_STR);
			    $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
                $consulta->bindValue(':precio', $this->precio, PDO::PARAM_STR);
			    $consulta->bindValue(':fecha_de_modificacion', $this->fecha_de_modificacion, PDO::PARAM_STR);
                return $consulta->execute();
    }

    /**
     * Realiza el update solamente del stock del producto segun su codigo de barra.
     */
    public function UpdateStockProductoBD()
    {
           $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
           $consulta =$objetoAccesoDato->RetornarConsulta("
               UPDATE producto 
               SET stock=:stock,
               fecha_de_modificacion=:fecha_de_modificacion
               WHERE codigo_de_barra=:codigo_de_barra");        
			   $consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
			   $consulta->bindValue(':stock', $this->stock, PDO::PARAM_INT);
			   $consulta->bindValue(':fecha_de_modificacion', $this->fecha_de_modificacion, PDO::PARAM_STR);
           return $consulta->execute();
    }


    
    /**
     * Verifica que exista el producto a ingresar, si existe actualiza el stock (lo suma al que tenia), sino existe lo ingresa como un producto nuevo.
     */
    public static function ExisteProductoBD(Producto $prod)
    {
        $arrayProductos = array();
        $arrayProductos = Producto::TraerTodoLosProductos();

        $verificado = -1;
        foreach($arrayProductos as $producto)
        {
            if($producto->codigo_de_barra == $prod->codigo_de_barra)
            {
                $prod->stock += $producto->stock;
                $verificado = 1;
                break;
            }
            else
            {
                $verificado = 0;
            }
        }

        if($verificado == -1)
        {
            echo "No se pudo hacer";
        }
        else
        {
            if($verificado)
            {
                $prod->UpdateStockProductoBD();
     
                echo "Actualizado";
            }
            else
            {
                $prod->InsertarProductoParametros();
                echo "Ingresado";
            }
        }
    }


    /**
     * Verifica que el producto exista, si existe le sobreescribe el stock y le modifica los datos
     * Si no existe no se podra hacer
     */

    public static function ActualizarProductoExistente(Producto $prod)
    {
        $arrayProductos = array();
        $arrayProductos = Producto::TraerTodoLosProductos();

        $verificado = -1;
        foreach($arrayProductos as $producto)
        {
            if($producto->codigo_de_barra == $prod->codigo_de_barra)
            {
                $prod->ModificarProductoParametros();
                $verificado = 1;
                break;
            }
            else
            {
                $verificado = 0;
            }
        }

        return $verificado;
    }


    /**
     * Dibuja la lista de productos pasada por parametro
     */
    public static function DibujarListaDB($lista)
    {
        echo "<ul>";
        foreach ($lista as $prod) {
            $string = $prod->mostrarDatos();
            echo "<li>$string</li>";
        }
        echo "</ul>";
    }

    /**
     * Verifica que el producto exista y tenga stock
     */
    public static function VerificarExistenciaYStock($codigoBarra, $cantidadItems)
    {
        $listaProductos = Producto::TraerTodoLosProductos();
        $verificado = -1;

        foreach($listaProductos as $producto)
        {
            if($producto->codigo_de_barra == $codigoBarra &&$cantidadItems <= $producto->stock) 
            {
                $verificado = $producto->idProducto;
                break;
            }
        }

        return $verificado;
    }


    /**
     * Descuenta stock al producto vendido por el codigo de barras
     */
    public static function DescontarStockBD($codigoBarra, $cantidadItems)
    {
        $listaProductos = Producto::TraerTodoLosProductos();

        foreach($listaProductos as $producto)
        {
            if($producto->codigo_de_barra == $codigoBarra) 
            {
                $producto->stock -= $cantidadItems;
                $producto->UpdateStockProductoBD();
                break;
            }
        }
    }

    
}

?>