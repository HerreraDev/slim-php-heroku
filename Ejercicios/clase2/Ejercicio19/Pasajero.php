<?php

class Pasajero{
    private $_apellido;
    private $_nombre;
    private $_dni;
    private $_esPlus;
    
    function __construct($_apellido, $_nombre, $_dni, $_esPLus)
    {
        $this->_apellido = $_apellido;
        $this->_nombre = $_nombre;
        $this->_dni = $_dni;
        $this->_esPlus = $_esPLus;
    }
    
    
    public function Equals(Pasajero $pasajero1)
    {
        if($this->_dni == $pasajero1->_dni)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function GetInfoPasajero()
    {
        $esPlusString = ($this->_esPlus == true) ? $esPlusString = "Si" : $esPlusString = "No";
        return "Nombre: {$this->_nombre} | " . " Apellido: {$this->_apellido}" . " | Dni: {$this->_dni}" . " | EsPlus = {$esPlusString} <br/> ----------------------- <br/>";
    }

    public static function MostrarPasajero(Pasajero $pasajero)
    {
        if($pasajero != null && is_a($pasajero,"Pasajero"))
        {
            echo $pasajero->GetInfoPasajero();
        }
        else
        {
            echo "ERROR. Pasajero es null o no es del tipo de objeto Pasajero", "<br/>";
        }
    }

}






?>