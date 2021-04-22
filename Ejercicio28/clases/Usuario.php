<?php

include_once "./clases/AccesoDatos.php";

class Usuario
{
    public $id;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $localidad;
    public $fechaDeRegistro;

    
    public function __construct()
    {
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

    public static function TraerTodoLosUsuarios()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select idUsuario,nombre, apellido, clave, mail, localidad,fecha_de_registro from usuario");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

    public static function DibujarLista($lista)
    {
        echo "<ul>";
        foreach ($lista as $user) {
            $string = $user->mostrarDatos();
            echo "<li>$string</li>";
        }
        echo "</ul>";
    }


}


?>