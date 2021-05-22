<?php

require_once './clases/Pedido.php';
require_once './clases/Mesa.php';
require_once './clases/usuario.php';
require_once './clases/Producto.php';



require_once './clases/IApiUsable.php';

class PedidoApi extends Pedido implements IApiUsable
{
    public function TraerUno($request, $response, $args)
    {
        /*$id=$args['id'];
    	$elPedido=Pedido::TraerUnPedido($id);
     	$newResponse = $response->withJson($elPedido, 200);
         
        return $newResponse;
        */
    }
    public function TraerTodos($request, $response, $args)
    {
        $todosLosPedidos = Pedido::TraerTodoLosPedidos();

        //Pedido::DibujarTablaPedido($todosLosPedidos);

        $newResponse = $response->withJson($todosLosPedidos, 200);
        return $newResponse;
    }

    public function CargarUno($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);

        $miPedido = new Pedido();

        $numero_pedido = Pedido::AlfanumericoRandom(5);
        $mailCliente = $ArrayDeParametros['mailCliente'];
        $numero_mesa = $ArrayDeParametros['numero_mesa'];
        $nombre_producto = $ArrayDeParametros['nombre_producto'];
        $cantidad = $ArrayDeParametros['cantidad'];
        $mail_responsable = $ArrayDeParametros['mail_responsable'];
        $fecha_hora_de_ingreso = date("Y-m-d H:i:s");

        //obtengo el id_mesa
        $idMesa = Mesa::ObtenerIdPorNumeroMesa($numero_mesa);
        if ($idMesa == -1) {
            $response->getBody()->write("ERROR. No existe una mesa con ese numero.");
            return $response;
        }

        //obtengo el id_usuario que seria el cliente
        $idCliente = Usuario::ObtenerIdCliete($mailCliente);
        if ($idCliente == -1) {
            echo "El cliente no estaba registrado por lo que el dato quedara en -1, es decir, con cliente sin especifiar";
        }

        //obtengo el id_producto
        $productos = explode("/", $nombre_producto);
        $cantidades = explode("/", $cantidad);
        for ($i = 0; $i < count($productos); $i++) {

            $idProducto = Producto::ObtenerIdProductoPorNombre($productos[$i]);
            if ($idProducto == -1) {
                $response->getBody()->write("ERROR. No existe un producto con el nombre: " . $productos[$i]);
                return $response;
            } else {

                //obtengo el id_responsable
                $idResponsable = Usuario::ObtenerIdPorMail($mail_responsable);
                if ($idResponsable == -1) {
                    $response->getBody()->write("ERROR. No existe un usuario con ese mail.");
                    return $response;
                }




                $miPedido->numero_pedido = $numero_pedido;
                $miPedido->id_usuario = $idCliente;
                $miPedido->id_estado = 3;
                $miPedido->fecha_hora_de_ingreso = $fecha_hora_de_ingreso;
                $miPedido->id_mesa = $idMesa;
                $miPedido->id_responsable = $idResponsable;


                $miPedido->cantidad = $cantidades[$i];
                $miPedido->id_producto = $idProducto;
                $miPedido->precio_final = Producto::CalcularPrecioFinal($miPedido);

                $miPedido->InsertarElPedidoParametros();

                $response->getBody()->write("Se inserto el pedido del producto: " . $productos[$i]);
            }
        }









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


    public function BorrarUno($request, $response, $args)
    {
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
       
        return $newResponse;
        */
    }

    public function ModificarUno($request, $response, $args)
    {



        
    }



    //esto esta sin terminar
    public function TraerPedidoPendiente($request, $response, $args)
    {

        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $payload = AutentificadorJWT::ObtenerData($token);


        switch ($payload->empleo) {
            case "Socio":
                $todosLosPedidos = Pedido::TraerPendientes("Socio");
                break;
            case "Mozo":
                $todosLosPedidos = Pedido::TraerPendientes("Mozo");
                break;
            case "Bartender":
                $todosLosPedidos = Pedido::TraerPendientes("Bartender");
                break;
            case "Cervezero":
                $todosLosPedidos = Pedido::TraerPendientes("Cervezero");
                break;
            case "Cocinero":
                $todosLosPedidos = Pedido::TraerPendientes("Cocinero");
                break;
            default:
                echo "ERROR, el usuario no es de los esperados.";
                break;
        }

        $newResponse = $response->withJson($todosLosPedidos, 200);

        return $newResponse;
    }

    public function TomarPedidoPendiente($request, $response, $args){
        $ArrayDeParametros = $request->getParsedBody();

        $idPedido = $ArrayDeParametros['idPedido'];
        $estado = $ArrayDeParametros['estado'];
        $tiempo_estimado = $ArrayDeParametros['tiempo_estimado'];

        $header = $request->getHeaderLine('Authorization');
        $token = trim(explode("Bearer", $header)[1]);

        $payload = AutentificadorJWT::ObtenerData($token);

        //obtengo el id_responsable
        $idResponsable = Usuario::ObtenerIdPorMail($payload->mail);
        if ($idResponsable == -1) {
            $response->getBody()->write("ERROR. No existe un usuario con ese mail.");
            return $response;
        }
        else
        {
            $resultado = Pedido::TomarPedido($idPedido, $estado, $tiempo_estimado, $idResponsable);

            $objDelaRespuesta = new stdclass();
            //var_dump($resultado);
            $objDelaRespuesta->resultado = $resultado;
            return $response->getBody()->write("Se tomo el pedido.");
        }
    }
}
