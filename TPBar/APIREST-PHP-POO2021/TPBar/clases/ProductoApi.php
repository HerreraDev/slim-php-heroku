<?php
require_once './clases/Producto.php';
require_once './clases/IApiUsable.php';

class ProductoApi extends Producto implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$elProducto=Producto::TraerUnProducto($id);
     	$newResponse = $response->withJson($elProducto, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$todosLosProductos=Producto::TraerTodoLosProductos();

        //Producto::DibujarTablaProducto($todosLosProductos);

     	$newResponse = $response->withJson($todosLosProductos, 200);  
    	return $newResponse;
    }
      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $codigo_de_barra = $ArrayDeParametros['codigo_de_barra'];
        $nombre= $ArrayDeParametros['nombre'];
        $tipo= $ArrayDeParametros['tipo'];
        $stock= $ArrayDeParametros['stock'];
        $precio= $ArrayDeParametros['precio'];
        $fecha_de_creacion = date("Y-m-d");
        $fecha_de_modificacion = date("Y-m-d");


        $tipo = strtolower($tipo);

        if($tipo != "bar" && $tipo != "cerveza" && $tipo != "cocina")
        {
          $response->getBody()->write("ERROR. Solo se pueden ingresar los siguientes tipos de producto: bar - cerveza - cocina.");
          return $response;
        }

        $miProducto = new Producto();

        $miProducto->codigo_de_barra=$codigo_de_barra;
        $miProducto->nombre=$nombre;
        $miProducto->tipo=$tipo;
        $miProducto->stock=$stock;
        $miProducto->precio=$precio;
        $miProducto->fecha_de_creacion=$fecha_de_creacion;
        $miProducto->fecha_de_modificacion=$fecha_de_modificacion;

        if(Producto::VerificarProductoDB($miProducto))
        {
          $miProducto->ModificarProductoParametros();
          $response->getBody()->write("ADVERTENCIA. Como el producto ya existia, se actualizaron sus datos");
        }
        else
        {
          $miProducto->InsertarElProductoParametros();
          $response->getBody()->write("Se ingreso el Producto nuevo");
        }


        /*$archivos = $request->getUploadedFiles();
        $destino="./fotos/productos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);

        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        $extension=array_reverse($extension);

        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        */

        return $response;
    }

    
    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $Producto= new Producto();
        $Producto->idProducto=$id;
        $cantidadDeBorrados=$Producto->BorrarProducto();

        $objDelaRespuesta= new stdclass();
       $objDelaRespuesta->cantidad=$cantidadDeBorrados;
       if($cantidadDeBorrados>0)
           {
                $objDelaRespuesta->resultado="algo borro!!!";
           }
           else
           {
               $objDelaRespuesta->resultado="no Borro nada!!!";
           }
       $newResponse = $response->withJson($objDelaRespuesta, 200);  
         return $newResponse;
   }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);
        
        $nombre= $ArrayDeParametros['nombre'];
        $tipo= $ArrayDeParametros['tipo'];
        $stock= $ArrayDeParametros['stock'];
        $precio= $ArrayDeParametros['precio'];
        $fecha_de_modificacion = date("Y-m-d");

        
	    $miProducto = new Producto();
        $miProducto->nombre=$nombre;
        $miProducto->tipo=$tipo;
        $miProducto->stock=$stock;
        $miProducto->precio=$precio;
        $miProducto->fecha_de_modificacion=$fecha_de_modificacion;

	   	$resultado =$miProducto->ModificarProductoParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
  }


}


