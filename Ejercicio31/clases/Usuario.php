<?php

include_once "AccesoDatos.php";

class Usuario
{
    private $idUsuario;
    private $nombre;
    private $apellido;
    private $clave;
    private $mail;
    private $localidad;
    private $fechaDeRegistro;

    
    public function __construct()
    {
    }

    public static function constructorParametrizado($nombre = "Sin nombre", $apellido = "Sin apellido", $clave, $mail, $localidad = "Sin localidad", $fechaDeRegistro = "Sin fecha", $idUsuario=-1)
    {
        $user = new Usuario();

        $user->nombre = $nombre;
        $user->apellido = $apellido;
        $user->clave = $clave;
        $user->mail = $mail;
        $user->localidad = $localidad;
        $user->fechaDeRegistro = date("Y-m-d");
        $user->idUsuario = $idUsuario;

        return $user;
    }

    public function mostrarDatos()
	{
	  	return "Datos:".$this->nombre."  ".$this->apellido." ".$this->clave." ".$this->mail." ".$this->localidad." ".$this->fechaDeRegistro;
	}

    public function UsuarioToCsv()
    {
        return $this->_nombre . "," . $this->_clave . "," . $this->_mail;
    } 

    public function UsuarioToJson()
    {
        return "Nombre: " . $this->_nombre . "," . " Foto: " . "<img src='".$this->GetRutaFoto()."' width='100px' height='100px'/>";
    }


    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function GetNombre()
    {
        return $this->_nombre;
    }

    public function GetId()
    {
        return $this->id;
    }
    
    //Metodos para CSV
    //-----------------------------------------------------------//
    public function GuardarEnCsv()
    {
        $direccionArchivo = fopen("usuarios.csv","a");

        if ($direccionArchivo != false)
        {
            if(fwrite($direccionArchivo, $this->UsuarioToCsv(). "\n") != false)
            {
                fclose($direccionArchivo);
                return 1;
            }
            else
            {
                fclose($direccionArchivo);
                return 0;
            }
                    
        }
    }
    public static function LeerCsv($archivo)
    {

        $direccionArchivo = fopen($archivo, "r");

        $arrayUsuarios = array();
        $arrayDatos = array();
        $array = array();

        if($direccionArchivo != false)
        {

            while(!feof($direccionArchivo))
            {
                $array = fgetcsv($direccionArchivo,200000,",",'"',"\n");
                $string = implode(",",$array);
                $arrayDatos = explode(",",$string);
                $user = new usuario($arrayDatos[0],$arrayDatos[1],$arrayDatos[2]);

                array_push($arrayUsuarios,$user);

            }
            fclose($direccionArchivo);
            return $arrayUsuarios;

        }
        else
        {
            echo "No existe el archivo";
        }
    }

    public static function DibujarListaCsv($lista)
    {
        echo "<ul>";
        foreach ($lista as $user) {
            $string = $user->UsuarioToCsv();
            echo "<li>$string</li>";
        }
        echo "</ul>";
    }

    public static function VerificarUsuario($user)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = Usuario::LeerCsv("usuarios.csv");

        /*foreach($arrayUsuarios as $key=>$usuario)
        {
            if($arrayUsuarios[$key]->_mail == $user->_mail)
            {
                $index = $key;
                break;
            }
        }*/
        
        $verificado = -1;
        foreach($arrayUsuarios as $usuario)
        {
            if($usuario->_mail == $user->_mail)
            {
                if($usuario->_clave == $user->_clave)
                {
                    $verificado = 1;
                }
                else
                {
                    $verificado = 0;
                }
            }
        }

        if($verificado == -1)
        {
            echo "Usuario no registrado";
        }
        else
        {
            if($verificado)
            {
                echo "Verificado";
            }
              else
            {
                echo "Error en los datos";
            }
        }
    }
    //-----------------------------------------------------------//

    //Metodos para JSON
    //-----------------------------------------------------------//
    public function GuardarEnJson()
    {

        $direccionArchivo = fopen("usuarios.json","a");
        

        if ($direccionArchivo != false)
        {
            if(fwrite($direccionArchivo, json_encode($this->jsonSerialize()). "\n") != false)
            {
                fclose($direccionArchivo);
                return 1;
            }
            else
            {
                fclose($direccionArchivo);
                return 0;
            }
                    
        }
    }

    public static function LeerDeJson($archivo){

        $vec = array();
        $users = array();
        $archivo = fopen($archivo, "r");


        if($archivo != false){

            while(!feof($archivo))
            {
                $lectura = fgets($archivo);
                $vec = json_decode($lectura, true);
    
                $user = new Usuario($vec["_nombre"],$vec["_clave"],$vec["_mail"],$vec["_id"], $vec["_fechaRegistro"], $vec["_rutaFoto"]);
    
                array_push($users,$user); 
    
            }
            
            fclose($archivo);
        }

        return $users;

    }

    public static function GuardarJsonEImagen(Usuario $user)
    {
        $user->GuardarEnJson();

        move_uploaded_file($_FILES["foto"]["tmp_name"], $user->_rutaFoto);
    }

    public static function DibujarListaJSON($lista)
    {
        echo "<ul>";
        foreach ($lista as $user) {
            $string = $user->UsuarioToJson();
            echo "<li>$string</li>";
        }
        echo "</ul>";
    }
    //-----------------------------------------------------------//


    //Metodos para DB
    //-----------------------------------------------------------//

    public function InsertarElUsuarioParametrosDB()
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

    public static function TraerTodoLosUsuariosDB()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select idUsuario,nombre, apellido, clave, mail, localidad,fecha_de_registro from usuario");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Usuario");		
	}

    public static function DibujarListaDB($lista)
    {
        echo "<ul>";
        foreach ($lista as $user) {
            $string = $user->mostrarDatos();
            echo "<li>$string</li>";
        }
        echo "</ul>";
    }

    public static function VerificarUsuarioDB($user)
    {

        $arrayUsuarios = array();
        $arrayUsuarios = self::traerTodoLosUsuariosDB();

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

        if($verificado == -1)
        {
            echo "Usuario no registrado";
        }
        else
        {
            if($verificado)
            {
                echo "Verificado";
            }
              else
            {
                echo "Error en los datos";
            }
        }
    }

    /**
     * Verifica que el usuario exista segun el id pasado por parametro.
     */
    public static function VerificarUsuarioPorId($idUsuario)
    {
        $listaUsuarios = array();
        $listaUsuarios = self::TraerTodoLosUsuariosDB();
        $verificado = false;

        foreach($listaUsuarios as $usuario)
        {
            if($usuario->idUsuario == $idUsuario)
            {
               $verificado = true;
               break;
            }
        }

        return $verificado;
    }


}




?>