<?php

include_once "./clases/AccesoDatos.php";

class Usuario
{
    private $id;
    private $nombre;
    private $apellido;
    private $clave;
    private $mail;
    private $localidad;
    private $fechaDeRegistro;

    
    public function __construct($nombre, $apellido, $clave, $mail, $localidad, $fechaDeRegistro)
    {
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->clave = $clave;
        $this->mail = $mail;
        $this->localidad = $localidad;
        $this->fechaDeRegistro = $fechaDeRegistro;

    }

    public function mostrarDatos()
	{
	  	return "Datos:".$this->id."  ".$this->nombre."  ".$this->apellido." ".$this->clave." ".$this->mail." ".$this->localidad." ".$this->fechaDeRegistro;
	}

    public function InsertarElUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,localidad,fecha_de_registro)values(:nombre,:apellido,:clave,:mail,:localidad,:fechaDeRegistro)");
                $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':apellido', $this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(':clave', $this->clave, PDO::PARAM_STR);
                $consulta->bindValue(':mail', $this->mail, PDO::PARAM_STR);
                $consulta->bindValue(':localidad', $this->localidad, PDO::PARAM_STR);
                $consulta->bindValue(':fechaDeRegistro', $this->fechaDeRegistro, PDO::PARAM_STR);
                $consulta->execute();		
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}


}


?>