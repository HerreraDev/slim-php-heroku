<?php

abstract class FiguraGeometrica
{
    protected $_color;
    protected $_perimetro;
    protected $_superficie;
    
    function __construct()
    {
    
    }
    
    public function GetColor()
    {
        return $this->_color;
    }
    
    public function SetColor($_color)
    {
        $this->_color = $_color;
    }
    
    public function ToString(){
        echo "Color: ", $this->_color, "<br/>";;
        echo "Perimetro: ", $this->_perimetro, "<br/>";
        echo "Superficie: ", $this->_superficie, "<br/>";

        $this->Dibujar();
    }

    public abstract function Dibujar();

    protected abstract function CalcularDatos();


}


?>