<?php
include_once "FiguraGeometrica.php";

class Rectangulo extends FiguraGeometrica{

    private $_ladoDos;
    private $_ladoUno;

    public function __construct($l1, $l2)
    {
        parent::__construct();
        $this->_ladoDos = $l2;
        $this->_ladoUno = $l1;
        $this->CalcularDatos();
    }


    public function ToString()
    {
        parent::ToString();
        echo "Lado uno: ", $this->_ladoUno , "<br/>";
        echo "Lado dos: ", $this->_ladoDos, "<br/>";
    }

    protected function CalcularDatos()
	{
	    $this->_superficie = $this->_ladoUno * $this->_ladoDos;
	    $this->_perimetro = ($this->_ladoUno * 2) + ($this->_ladoDos * 2);
	}

    function Dibujar()
    {
        for ($i=0; $i < $this->_ladoDos; $i++) 
		{ 
			for ($j=0; $j < $this->_ladoUno; $j++)
			{ 
			
				echo "*";
			}

			echo "<br/>";
		}
    }


}


?>