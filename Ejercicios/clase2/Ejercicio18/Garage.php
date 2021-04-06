<?php

include_once "Auto.php";

class Garage{

    private $_razonSocial;
    private $_precioPorHora;
    private $_autos;

    function __construct($_razonSocial = "Sin razon social", $_precioPorHora = 0.00)
{
    $this->_razonSocial = $_razonSocial;
    $this->_precioPorHora = $_precioPorHora;
    $this->_autos = array();

}

public function MostrarGarage()
{
    echo "Razon social: ", $this->_razonSocial, "<br/>";
    echo "Precio por hora : ", $this->_precioPorHora, "<br/>";
    echo "Autos: ", "<br/>";
    if(count($this->_autos)>0)
    {
        for($i=0; $i<count($this->_autos); $i++)
        {
            Auto::MostrarAuto($this->_autos[$i]);
        }
    }
    else
    {
        echo "No hay autos aun","<br/>";
        echo "------------------------------------------", "<br/>";
    }
}

public function Equals(Auto $auto)
{
    if(in_array($auto,$this->_autos,true))
    {
        return true;
    }
    else
    {
        return false;
    }
}

public function Add(Auto $auto)
{
    if( $this->Equals($auto) == false )
    {
        array_push($this->_autos, $auto); 
    }
    else
    {
        echo "Error, no se puede agregar ya que el auto ya esta en el garage", "<br/>";
        echo "------------------------------------------", "<br/>";
    }
}

public function Remove(Auto $auto)
{
    if($this->Equals($auto))
    {
        $index = array_search($auto, $this->_autos);
        unset($this->_autos[$index]);
        $this->_autos = array_values($this->_autos);
    }
    else
    {
        echo "Error, ese auto no esta en el garage","<br/>";
    }
}




}


?>