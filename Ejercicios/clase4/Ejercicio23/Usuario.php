<?php

class Usuario
{
    private $_nombre;
    private $_clave;
    private $_mail;
    private $_id;
    private $_fechaRegistro;
    private $_rutaFoto;
    
    public function __construct($_nombre, $_clave, $_mail, $_rutaFoto = "Aun no tiene ruta")
    {
        $this->_nombre = $_nombre;
        $this->_clave = $_clave;
        $this->_mail = $_mail;
        $this->_id = random_int(1,10000);
        $this->_fechaRegistro = new DateTime("now");
        $this->_rutaFoto = $_rutaFoto;
    }
    
    public function UsuarioToCsv()
    {
        return $this->_nombre . "," . $this->_clave . "," . $this->_mail;
    } 

    public function jsonSerialize()
    {
        return get_object_vars($this);
    }

    public function GetRutaFoto()
    {
        return $this->_rutaFoto;
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
    public static function LeerDeJson($archivo)
    {
        $direccionArchivo = fopen($archivo, "r");

        if($direccionArchivo != false)
        {

            $arrayUsuarios = json_decode($direccionArchivo);
            
            return $arrayUsuarios;

        }
        else
        {
            echo "No existe el archivo";
        }
        
    }
    //-----------------------------------------------------------//


    public static function GuardarJsonEImagen(Usuario $user)
    {
        $user->GuardarEnJson();

        move_uploaded_file($_FILES["foto"]["tmp_name"], $user->_rutaFoto);
    }

    public static function DibujarLista($lista)
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
}


?>