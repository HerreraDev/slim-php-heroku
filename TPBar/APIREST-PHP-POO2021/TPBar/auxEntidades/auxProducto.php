<?php

require_once './models/Producto.php';

use App\Models\Producto as Producto;


class auxProducto{

    public static function VerificarProductoDB($prod)
    {

        $arrayProductos = array();
        $arrayProductos = Producto::all();

        $verificado = 0;
        foreach($arrayProductos as $producto)
        {
            if($producto->codigo_de_barra == $prod->codigo_de_barra)
            {
                $verificado = 1;
            }
        }
		return $verificado;
	}

	public function mostrarDatos()
	{
        return "Datos: ".$this->codigo_de_barra." ".$this->nombre."  ".$this->tipo." ".$this->stock." ".$this->precio." ".$this->fecha_de_creacion." ".$this->fecha_de_modificacion." ".$this->ruta_foto;
	}

	public static function ObtenerIdProductoPorNombre($nombreProd)
    {

        $arrayProductos = array();
        $arrayProductos = Producto::all();

        $idProd = -1;
        foreach($arrayProductos as $prod)
        {
            if($prod->nombre == $nombreProd)
            {
                $idProd = $prod->idProducto;
				break;
            }
        }
		return $idProd;
	}

	public static function CalcularPrecioFinal($pedido){
		$cant = $pedido->cantidad;
		$auxIdProd = $pedido->id_producto;

	    $prods = Producto::all();
		$precioProd = -1;

	   foreach($prods as $prod)
	   {
		   if($prod->idProducto == $auxIdProd)
		   {
			   $precioProd = $prod->precio;
			   break;
		   }
	   }

	   return $cant * $precioProd;

	}


    public static function GuardarEnJson($producto, $mode)
    {

        $direccionArchivo = fopen("csv/Productos.json", $mode);

        if ($direccionArchivo != false) {
            if (fwrite($direccionArchivo, json_encode($producto) . "\n") != false) {
                fclose($direccionArchivo);
                return 1;
            } else {
                fclose($direccionArchivo);
                return 0;
            }
        }
    }

    public static function GenerarCSV()
    {

        $productos = array();
        $productos = Producto::all();

        $mode = "w";

        foreach ($productos as $prod) {
            self::GuardarEnJson($prod, $mode);
            $mode = "a";
        }

        echo "Csv generado en la ruta /csv/Productos.json";
    }






}



?>