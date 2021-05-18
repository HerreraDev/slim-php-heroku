<?php

include_once "./clases/usuario.php";

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
}
