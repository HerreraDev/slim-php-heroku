<?php

include_once "./clases/usuario.php";
include_once "./clases/Pedido.php";


class Logs
{

    public static function LogUsuario($mail)
    {

        $idResponsable = Usuario::ObtenerIdPorMail($mail);
        if ($idResponsable != -1) {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta = $objetoAccesoDato->RetornarConsulta("INSERT INTO `userLogs`(`id_usuario`, `hora_inicio_sesion`) VALUES (:id_usuario,:hora_inicio_sesion)");

            $consulta->bindValue(':id_usuario',$idResponsable, PDO::PARAM_INT);
            $consulta->bindValue(':hora_inicio_sesion',date("Y-m-d H:i:s"), PDO::PARAM_INT);

            $consulta->execute();            
        }
    }

    //Loguea los siguientes datos:
    //-idPedido
    //-id_estado
    //-id_responsable
    public static function logPedido($idPedido)
    {

        $id_estadoAux = -1;
        $id_responsableAux = -1;

        $pedidos = Pedido::TraerTodoLosPedidos();

        foreach ($pedidos as $pedido) {
            if ($pedido->idPedido == $idPedido) {
                $id_estadoAux = $pedido->id_estado;
                $id_responsableAux = $pedido->id_responsable;
                break;
            }
        }

        if ($id_estadoAux != -1 && $id_responsableAux != -1) {

            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso();

            $consulta = $objetoAccesoDato->RetornarConsulta("
				INSERT INTO `pedidosLogs` (`id_pedido`,`id_estado`,`id_responsable`,`fecha_hora_log`) VALUES(:id_pedido,:estado,:idResponsable,:fecha_hora)");

            $consulta->bindValue(':id_pedido', $idPedido, PDO::PARAM_INT);
            $consulta->bindValue(':estado', $id_estadoAux, PDO::PARAM_INT);
            $consulta->bindValue(':idResponsable', $id_responsableAux, PDO::PARAM_INT);
            $consulta->bindValue(':fecha_hora', date("Y-m-d H:i:s"), PDO::PARAM_INT);

            $consulta->execute();
            return $consulta->rowCount();
        }
    }
}
