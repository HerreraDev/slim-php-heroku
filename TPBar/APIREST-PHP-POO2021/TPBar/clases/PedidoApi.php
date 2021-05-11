<?php

require_once './clases/Pedido.php';
require_once 'mesa.php';
require_once 'usuario.php';
require_once 'producto.php';



require_once 'IApiUsable.php';

class PedidoApi extends Pedido implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	/*$id=$args['id'];
    	$elPedido=Pedido::TraerUnPedido($id);
     	$newResponse = $response->withJson($elPedido, 200);
         */  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$todosLosPedidos=Pedido::TraerTodoLosPedidos();

        //Pedido::DibujarTablaPedido($todosLosPedidos);

     	$newResponse = $response->withJson($todosLosPedidos,200);  
    	return $newResponse;
    }

      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);

        $numero_pedido = Pedido::AlfanumericoRandom(5);
        $nombre_cliente= $ArrayDeParametros['nombre_cliente'];
        $numero_mesa= $ArrayDeParametros['numero_mesa'];
        $estado = "con cliente esperando pedido";
        $nombre_producto= $ArrayDeParametros['nombre_producto'];
        $cantidad= $ArrayDeParametros['cantidad'];
        $mail_responsable= $ArrayDeParametros['mail_responsable'];
        $fecha_hora_de_ingreso = date("Y-m-d H:i:s");

        //obtengo el id_mesa
        $idMesa = Mesa::ObtenerIdPorNumeroMesa($numero_mesa);
        if($idMesa == -1)
        {
            $response->getBody()->write("ERROR. No existe una mesa con ese numero.");
            return $response;
        }

        //obtengo el id_producto
        $idProducto = Producto::ObtenerIdProductoPorNombre($nombre_producto);
        if($idProducto == -1)
        {
            $response->getBody()->write("ERROR. No existe un producto con ese nombre.");
            return $response;
        }

        //obtengo el id_responsable
        $idResponsable = Usuario::ObtenerIdPorMail($mail_responsable);
        if($idResponsable == -1)
        {
            $response->getBody()->write("ERROR. No existe un usuario con ese mail.");
            return $response;
        }

        $miPedido = new Pedido();

        $miPedido->numero_pedido = $numero_pedido;
        $miPedido->nombre_cliente = $nombre_cliente;
        $miPedido->estado = $estado;
        $miPedido->cantidad = $cantidad;
        $miPedido->fecha_hora_de_ingreso = $fecha_hora_de_ingreso;


        $miPedido->id_mesa = $idMesa;
        $miPedido->id_producto = $idProducto;
        $miPedido->id_responsable = $idResponsable;
        $miPedido->precio_final = Producto::CalcularPrecioFinal($miPedido);

        $miPedido->InsertarElPedidoParametros();
        
        $response->getBody()->write("Se inserto el pedido.");

        /*
        $archivos = $request->getUploadedFiles();
        $destino="./fotos/Pedidos/";
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
        /*$id=$args['id'];
        $Pedido= new Pedido();
        $Pedido->idPedido=$id;
        $cantidadDeBorrados=$Pedido->BorrarPedido();

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
       */  
         return $newResponse;
   }
     
     public function ModificarUno($request, $response, $args) {
         /*
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);
        
        $id= $ArrayDeParametros['id'];
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $clave= $ArrayDeParametros['clave'];
        $mail= $ArrayDeParametros['mail'];
        $empleo= $ArrayDeParametros['empleo'];
        
	    $miPedido = new Pedido();
        $miPedido->idPedido = $id;
        $miPedido->nombre=$nombre;
        $miPedido->apellido=$apellido;
        $miPedido->clave=$clave;
        $miPedido->mail=$mail;
        $miPedido->empleo=$empleo;

	   	$resultado =$miPedido->ModificarPedidoParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);
        */		
    }

    // public function LoginPedido($request, $response, $args)
    // {
    //     $ArrayDeParametros = $request->getParsedBody();

    //     $mail = $ArrayDeParametros['mail'];
    //     $clave = $ArrayDeParametros['clave'];

    //     $user = new Pedido();
    //     $user->mail=$mail;
    //     $user->clave=$clave;

    //     $respuesta = Pedido::VerificarPedidoDB($user);

    //     switch($respuesta){
    //         case -1:
    //             echo "No existe";
    //             break;
    //         case 0:
    //             echo "Mail correcto pero clave incorrecta";
    //             break;
    //         case 1:
    //             echo "Logueado";
    //             break;
    //     };


}


