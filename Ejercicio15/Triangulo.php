<?php

include_once "FiguraGeometrica.php";

class Triangulo extends FiguraGeometrica{

    private $_altura;
    private $_base;

    public function __construct($b, $h)
    {
        parent::__construct();
        $this->_altura = $h;
        $this->_base = $b;
        $this->CalcularDatos();
    }

    protected function CalcularDatos()
	{
		$this->_superficie = ($this->_base * $this->_altura) / 2;
		$this->_perimetro = ($this->_altura * 2) + $this->_base;
	}

    function Dibujar()
    {
        for($i=0;$i<=$this->_altura ;$i++){  
            for($j=1;$j<=$i;$j++){  
            echo "* ";  
            }  
            echo "<br>";  
        }
    }

    public function ToString()
    {
        parent::ToString();
        echo "Altura : ", $this->_altura, "<br/>";
        echo "Base: ", $this->_base, "<br/>";
    }

}


?>