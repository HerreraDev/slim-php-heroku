<?php

class Auto {

private $_color;
private $_precio;
private $_marca;
private Datetime $_fecha;

function __construct($_marca = "Sin marca", $_color = "Sin color", $_precio = "Sin precio", $_fecha = null)
{
    $this->_color = $_color;
    $this->_precio = $_precio;
    $this->_marca = $_marca;
    if(is_null($_fecha))
    {
        $this->_fecha = new DateTime("now");
    }
    else
    {
        $this->_fecha = $_fecha;
    }

}

public function AgregarImpuestos($_impuesto)
{
    $this->_precio += $_impuesto;
}

public static function MostrarAuto(Auto $a1)
{
    if(is_null($a1))
    {
        echo "Error, auto is null";
    }
    else
    {
        echo "Color: ", $a1->_color , "<br/>";
        echo "Precio: ", $a1->_precio , "<br/>";
        echo "Marca: ", $a1->_marca , "<br/>";
        echo "Fecha: ", date_format($a1->_fecha, 'Y-m-d'), "<br/>";
        echo "----------------------------------------", "<br/>";
    }
}

public function Equals(Auto $auto)
{
    if($this->_marca == $auto->_marca)
    {
        return true;
    }
    else
    {
        return false;
    }
}

public static function Add(Auto $auto1, Auto $auto2)
{
    if(($auto1->Equals($auto2)) && $auto1->_color == $auto2->_color)
    {
        return $auto1->_precio + $auto2->_precio;
    }
    else
    {
        echo "Para poder realizar la operacion, se necesita que los autos sean de la misma marca y del mismo color", "<br/>";

        return 0;
    }



}


}


?>