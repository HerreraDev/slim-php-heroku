<?php

class Producto
{

    private $_id;
    private $_codigoBarra;
    private $_nombre;
    private $_tipo;
    private $_stock;
    private $_precio;


    public function __construct($_codigoBarra,$_nombre, $_tipo, $_stock, $_precio, $_id = null)
    {
        $this->_codigoBarra = $_codigoBarra;
        $this->_nombre = $_nombre;
        $this->_tipo = $_tipo;
        $this->_stock = $_stock;
        if($_id == null)
        {
            $this->_id = random_int(1,10000);
        }
        else
        {
            $this->_id = $_id;
        }
        $this->_precio = $_precio;
    }


    public function GetCodigoBarra()
    {
        return $this->_codigoBarra;
    }

    public function GetNombre()
    {
        return $this->_nombre;
    }

    public function GetTipo()
    {
        return $this->_tipo;
    }

    public function GetStock()
    {
        return $this->_stock;
    }

    public function GetId()
    {
        return $this->_id;
    }

    public function GetPrecio()
    {
        return $this->_precio;
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

    public static function LeerDeJson($archivo){

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
                    $prod = new Producto($vec["_codigoBarra"],$vec["_nombre"],$vec["_tipo"],$vec["_stock"],$vec["_id"], $vec["_precio"]);
    
                    array_push($productos,$prod); 
                }
    
            }
            
            fclose($archivo);
        }

        return $productos;

    }
    //-----------------------------------------------------------//

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
}

?>