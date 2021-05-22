<?php

require_once './fpdf183/fpdf.php';


class Usuario
{
    public $idUsuario;
    public $nombre;
    public $apellido;
    public $clave;
    public $mail;
	public $fecha_de_ingreso;
    public $empleo;
	public $ruta_foto;
	public $fecha_de_salida;


    public function BorrarUsuario()
	{
	    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				UPDATE usuario 
				set fecha_de_salida=:fecha_de_salida 				
				WHERE idUsuario=:id");	
		$consulta->bindValue(':id',$this->idUsuario, PDO::PARAM_INT);		
		$consulta->bindValue(':fecha_de_salida',date("Y-m-d"), PDO::PARAM_STR);		

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
                empleo='$this->empleo',
                fecha_de_ingreso='$this->fecha_de_ingreso'
				WHERE idUsuario='$this->id'");
			return $consulta->execute();
	 }

    //  public function InsertarElCd()
	//  {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (titel,interpret,jahr)values('$this->titulo','$this->cantante','$this->año')");
	// 		$consulta->execute();
	// 		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	//  }

     public function ModificarUsuarioParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("
            update usuario 
            set nombre=:nombre,
				apellido=:apellido,
				clave=:clave,
                mail=:mail,
                empleo=:empleo,
				ruta_foto=:ruta_foto
				WHERE idUsuario=:id");
			$consulta->bindValue(':id',$this->idUsuario, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
            $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
            $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
            $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
            $consulta->bindValue(':empleo',$this->empleo, PDO::PARAM_STR);
			$consulta->bindValue(':ruta_foto',$this->ruta_foto, PDO::PARAM_STR);

			return $consulta->execute();
	 }

     public function InsertarElUsuarioParametros()
	 {
				$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
				$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into usuario (nombre,apellido,clave,mail,empleo,ruta_foto,fecha_de_ingreso)values(:nombre,:apellido,:clave,:mail,:empleo,:ruta_foto,:fecha_de_ingreso)");
			    $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
                $consulta->bindValue(':apellido',$this->apellido, PDO::PARAM_STR);
                $consulta->bindValue(':clave',$this->clave, PDO::PARAM_STR);
                $consulta->bindValue(':mail',$this->mail, PDO::PARAM_STR);
                $consulta->bindValue(':empleo',$this->empleo, PDO::PARAM_STR);
				$consulta->bindValue(':ruta_foto',$this->ruta_foto, PDO::PARAM_STR);
                $consulta->bindValue(':fecha_de_ingreso',$this->fecha_de_ingreso, PDO::PARAM_STR);
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
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

	public static function TraerUnUsuario($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select idUsuario,nombre, apellido, clave, mail, empleo,ruta_foto, fecha_de_ingreso from usuario where idUsuario = $id");
			$consulta->execute();
			$usuarioBuscado= $consulta->fetchObject('Usuario');
			return $usuarioBuscado;					
	}

	// public static function TraerUnUsuarioAnio($id,$anio) 
	// {
	// 	$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 	$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=? AND jahr=?");
	// 	$consulta->execute(array($id, $anio));
	// 	$usuarioBuscado= $consulta->fetchObject('Usuario');
    //   	return $usuarioBuscado;				
	// }

    // public static function TraerUnUsuarioAnioParamNombre($id,$anio) 
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=:id AND fecha_de_ingreso=:anio");
	// 		$consulta->bindValue(':id', $id, PDO::PARAM_INT);
	// 		$consulta->bindValue(':anio', $anio, PDO::PARAM_STR);
	// 		$consulta->execute();
	// 		$cdBuscado= $consulta->fetchObject('Usuario');
    //   		return $cdBuscado;							
	// }
	
	// public static function TraerUnUsuarioAnioParamNombreArray($id,$anio) 
	// {
	// 		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
	// 		$consulta =$objetoAccesoDato->RetornarConsulta("select * from usuario WHERE idUsuario=:id AND fecha_de_ingreso=:anio");
	// 		$consulta->execute(array(':id'=> $id,':anio'=> $anio));
	// 		$consulta->execute();
	// 		$cdBuscado= $consulta->fetchObject('Usuario');
    //   		return $cdBuscado;				

			
	// }

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
					$user->empleo = $usuario->empleo;
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
        return "Datos:".$this->nombre."  ".$this->apellido." ".$this->clave." ".$this->mail." ".$this->empleo." ".$this->fecha_de_ingreso;
	}

	public static function DibujarTablaUsuario($lista){

		echo "<br/>";
        echo "<table>";
		//echo "Id	Nombre	Apellido	Mail	Clave	Fecha de ingreso	Empleo";
		foreach($lista as $user)
		{
			echo "<tr>";
			foreach($user as $item)
			{
				echo "<td>$item</td>";
			}
            
			echo "</tr>";
		}
        echo "</table>";
		echo "<br/>";

	}

	public static function GenerarPdf()
	{
		$lista = self::TraerTodoLosUsuarios();

		$string = "";
		foreach($lista as $user){
			foreach($user as $item){
				$string = $string . $item;
			}
		}

		echo $string;

		$pdf = new FPDF('P','mm','A4');
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,$string);
		$pdf->Output('./pdfs/users.pdf','F');

		echo "pdf generado";
	}

	public static function ObtenerIdPorMail($mail)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = self::TraerTodoLosUsuarios();

        $idUsuario = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $mail)
            {
                $idUsuario = $usuario->idUsuario;
				break;
            }
        }
		return $idUsuario;
	}

	public static function ObtenerIdCliete($mailCliente){

		$arrayUsuarios = array();
        $arrayUsuarios = self::TraerTodoLosUsuarios();

        $idCliente = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->mail == $mailCliente && $usuario->empleo == "Cliente")
            {
                $idCliente = $usuario->idUsuario;
				break;
            }
        }
		return $idCliente;
	}
}
   

























?>