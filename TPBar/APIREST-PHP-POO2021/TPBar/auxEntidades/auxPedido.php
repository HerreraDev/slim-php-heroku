<?php

//cada producto es un pedido de la misma mesa

//el responsable va a mandar una peticion http para cambiar el estado del pedido

//esta sin terminar, falta crear la tabla y los metodos para hacer alta y listado.

require_once './models/Pedido.php';
require_once './models/Ticket.php';

use App\Models\Pedido as Pedido;
use App\Models\Mesa as Mesa;
use App\Models\Ticket as Ticket;

use Illuminate\Database\Capsule\Manager as Capsule;


class auxPedido
{


    public static function AlfanumericoRandom($length)
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($chars), 0, $length);
    }



    //Toma el pedido, si el pedido esta estado 0(sin tomar), lo pasa al estado 1(en preparacion), si ya esta en estado 1(en preparacion) lo pasa el estado 2(listo para servir)
    public static function TomarPedido($idPedido, $tiempo, $idResponsable)
    {

        $estado = -1;
        $pedidos = Pedido::all();
        foreach ($pedidos as $pedido) {
            if ($pedido->idPedido == $idPedido) {
                $estado = $pedido->id_estado;
                break;
            }
        }
        echo "Estado: ", $estado;


        switch ($estado) {
            case 0:
                $consulta = Capsule::table('pedidos')->where('idPedido', $idPedido)->update([
                    'id_estado' => 1,
                    'id_responsable' => $idResponsable,
                    'tiempo_estimado' => $tiempo
                ]);
                break;
            case 1:
                $consulta = Capsule::table('pedidos')->where('idPedido', $idPedido)->update([
                    'id_estado' => 2,
                    'id_responsable' => $idResponsable,
                    'tiempo_estimado' => $tiempo
                ]);
                break;
                break;
            default:
                echo "Hubo un error, no se encontro un pedido";
                break;
        }

        return $consulta;
    }

    public static function ServirPedido($idPedido, $idResponsable)
    {
        $consulta = Capsule::table('pedidos')->where('idPedido', $idPedido)->update([
            'id_estado' => 7,
            'id_responsable' => $idResponsable,
        ]);

        $pedidos = Pedido::all();
        foreach ($pedidos as $pedido) {
            if ($pedido->idPedido == $idPedido) {
                $idMesa = $pedido->id_mesa;
                break;
            }
        }


        //Actualizo estado de la mesa
        $auxMesa = new Mesa();
        $MesaAct = $auxMesa->find($idMesa);
        $MesaAct->id_estado = 4;
        $MesaAct->save();


        return $consulta;
    }


    public static function TraerPendientes($empleo)
    {

        switch ($empleo) {
            case "Socio":

                $consulta = Capsule::select('SELECT idPedido, nombre, id_estado, cantidad, tiempo_estimado FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto');
                break;
            case "Mozo":
                $consulta = Capsule::select('SELECT idPedido, nombre, id_estado, cantidad, tiempo_estimado FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto where id_estado = 2');
                break;
            case "Bartender":
                $consulta = Capsule::select('SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = "bar" AND id_estado IN (0,1)');
                break;
            case "Cervezero":
                $consulta = Capsule::select('SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = "cerveza" AND id_estado IN (0,1)');
                break;
            case "Cocinero":
                $consulta = Capsule::select("SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = 'cocina' and id_estado IN(0,1)");
                break;
            default:
                echo "ERROR, el usuario no es de los esperados.";
                break;
        }

        return $consulta;
    }

    public static function OperacionCobro($numero_pedido, $metodoPago)
    {


        $idPedido = -1;
        $pedidos = Pedido::all();
        foreach ($pedidos as $pedido) {
            if ($pedido->numero_pedido == $numero_pedido) {
                $idPedido = $pedido->idPedido;
                break;
            }
        }

        if ($idPedido != -1) {
            $pedido = new Pedido();
            $pedido = $pedido->find($idPedido);

            $ticket = new Ticket();

            $ticket->idMesa = $pedido->id_mesa;
            $ticket->numero_de_pedido = $numero_pedido;
            $ticket->total = Capsule::table('pedidos')->where('numero_pedido', $numero_pedido)->sum("precio_final");
            $ticket->metodo_pago = $metodoPago;
            $ticket->fecha_hora_salida = date("Y-m-d H:i:s");

            $ticket->save();

            //Actualizo estado de la mesa
            $auxMesa = new Mesa();
            $MesaAct = $auxMesa->find($ticket->idMesa);
            $MesaAct->id_estado = 5;
            $MesaAct->save();

            return 1;
        } else {
            return -1;
        }
    }
}
