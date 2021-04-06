<?php

class Usuario
{
    private $_nombre;
    private $_clave;
    private $_mail;
    
    public function __construct($_nombre, $_clave, $_mail)
    {
        $this->_nombre = $_nombre;
        $this->_clave = $_clave;
        $this->_mail = $_mail;
    }
    
    public function UsuarioToCsv()
    {
        return $this->_nombre . "," . $this->_clave . "," . $this->_mail;
    } 

    public function Guardar()
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
}


?>