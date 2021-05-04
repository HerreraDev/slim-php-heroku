<?php

class Usuario
{
    public $idUsuario;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
    public $localidad;
    public $fecha_de_registro;


    public function BorrarUsuario()
	{
	    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from usuario 				
				WHERE idUsuario=:id");	
		$consulta->bindValue(':id',$this->idUsuario, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	}

    public static function BorrarUsuarioPorFechaRegistro($año)
	 {

		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
			delete 
			from usuario 				
			WHERE fecha_de_registro=:fecha_de_registro");	
		$consulta->bindValue(':anio',$año, PDO::PARAM_INT);		
		$consulta->execute();
		return $consulta->rowCount();
	 }

     public function ModificarUsuario()
	 {

			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
				update usuario 
				set nombre='$this->nombre',
				apellido='$this->apellido',
				clave='$this->clave',
                mail='$this->mail',
                localidad='$this->localidad',
                fecha_de_registro='$this->fecha_de_registro'
				WHERE idUsuario='$this->id'");
			return $consulta->execute();
	 }

     public function InsertarElCd()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (titel,interpret,jahr)values('$this->titulo','$this->cantante','$this->año')");
			$consulta->execute();
			return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public function ModificarUsuarioParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
            update usuario 
            set nombre=:nombre,
				apellido=:apellido,
				clave=:clave,
                mail=:mail,
                localidad=:localidad
				WHERE idUsuario=:id");
			$consulta->bindValue(':id',$this->idUsuario, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
            $consulta->bindValue(':localidad',$this->localidad, PDO::PARAM_STR);
			return $consulta->execute();
	 }

     public function InsertarElUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,localidad,fecha_de_registro)values(:nombre,:apellido,:clave,:mail,:localidad,:fecha_de_registro)");
			    $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
                $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
                $consulta->bindValue(':localidad',$this->localidad, PDO::PARAM_STR);
                $consulta->bindValue(':fecha_de_registro',$this->fecha_de_registro, PDO::PARAM_STR);
				$consulta->execute();
				return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

	 public function GuardarUsuario()
	 {
	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuarioParametros();
	 		}else {
	 			$this->InsertarElUsuarioParametros();
	 		}
	 }

     public static function TraerTodoLosUsuarios()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select idUsuario,nombre, apellido, clave, mail, localidad,fecha_de_registro from usuario");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idUsuario,nombre, apellido, clave, mail, localidad,fecha_de_registro from usuario where idUsuario = $id");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('Usuario');
			return $usuarioBuscado;					
	}

	public static function TraerUnUsuarioAnio($id,$anio) 
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=? AND jahr=?");
		$consulta->execute(array($id, $anio));
		$usuarioBuscado= $consulta->fetchObject('Usuario');
      	return $usuarioBuscado;				
	}

    public static function TraerUnUsuarioAnioParamNombre($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=:id AND fecha_de_registro=:anio");
			$consulta->bindValue(':id', $id, PDO::PARAM_INT);
			$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('Usuario');
      		return $cdBuscado;				

			
	}
	
	public static function TraerUnUsuarioAnioParamNombreArray($id,$anio) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=:id AND fecha_de_registro=:anio");
			$consulta->execute(array(':id'=> $id,':anio'=> $anio));
			$consulta->execute();
			$cdBuscado= $consulta->fetchObject('Usuario');
      		return $cdBuscado;				

			
	}

	public static function VerificarUsuarioDB($user)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = self::TraerTodoLosUsuarios();

        $verificado = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $user->mail)
            {

                if($usuario->clave == $user->clave)
                {
                    $verificado = 1;
                }
                else
                {
                    $verificado = 0;
                }
            }
        }
		return $verificado;
	}

	public function mostrarDatos()
	{
        return "Datos:".$this->nombre."  ".$this->apellido." ".$this->clave." ".$this->mail." ".$this->localidad." ".$this->fechaDeRegistro;
	}
}
   

























?>