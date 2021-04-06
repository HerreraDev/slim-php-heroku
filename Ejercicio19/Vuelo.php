<?php

class Vuelo{

    private $_fecha;
    private $_empresa;
    private $_precio;
    private $_listaDePasajeros;
    private $_cantMaxima;

    function __construct($_fecha = null, $_empresa, $_precio, $_cantMaxima = "No hay maximo establecido aun")
    {
        if(is_null($_fecha))
        {
            $this->_fecha = new DateTime("now");
        }
        else
        {
            $this->_fecha = $_fecha;
        }
        $this->_empresa = $_empresa;
        $this->_precio = $_precio;
        $this->_cantMaxima = $_cantMaxima;
        $this->_listaDePasajeros = array();
    }

    
    public function GetInfoVuelo()
    {
        $fecha = date_format($this->_fecha, 'Y-m-d');
        /*$stringPasajeros = (count($this->_listaDePasajeros)==0) ? $stringPasajeros = "No hay pasajeros aun <br/> ------------------------------------------" : "";*/
        
        $stringPasajeros ="";
        if(count($this->_listaDePasajeros)>0)
        {
            for($i=0; $i<count($this->_listaDePasajeros); $i++)
            {
                $stringPasajeros .= $this->_listaDePasajeros[$i]->GetInfoPasajero();
            }
        }
        else
        {
            $stringPasajeros = "No hay pasajeros aun <br/> 
            ------------------------------------------";
        }

        return "Fecha: {$fecha} <br/> 
        Empresa: {$this->_empresa} <br/>
        Precio: {$this->_precio} <br/> 
        Cantidad maxima: {$this->_cantMaxima} <br/> 
        Pasajeros: <br/>
        {$stringPasajeros}";

        

 
    }

    public function Equals(Pasajero $pasajero)
    {
        if(in_array($pasajero,$this->_listaDePasajeros,true))
        {
            return true;
        }
        else
        {
            return false;
        }
    }   

    public function AgregarPasajero(Pasajero $pasajero)
    {
        if( ($this->Equals($pasajero) == false) && ($this->_cantMaxima > Count($this->_listaDePasajeros)))
        {
            array_push($this->_listaDePasajeros, $pasajero); 
            return 1;
        }
        else
        {
            return 0;
        }
    }

    public function MostrarVuelo()
    {
        echo $this->GetInfoVuelo();
    }

    public static function Add(Vuelo $vuelo1, Vuelo $vuelo2)
    {
        $recaudacionVuelo1 = 0;
        $recaudacionVuelo2 = 0;
        $infoPasajeros;

        if(is_a($vuelo1, "Vuelo") && is_a($vuelo2, "Vuelo"))
        {

            for($i=0; $i<count($vuelo1->_listaDePasajeros); $i++)
            {

                $infoPasajeros = $vuelo1->_listaDePasajeros[$i]->GetInfoPasajero();


                if(str_contains($infoPasajeros, "EsPlus = Si"))
                {
                    $recaudacionVuelo1 += $vuelo1->_precio - ($vuelo1->_precio * 0.2);
                }
                else
                {
                    $recaudacionVuelo1 += $vuelo1->_precio;
                }
            }


            for($i=0; $i<count($vuelo2->_listaDePasajeros); $i++)
            {
                $infoPasajeros = $vuelo2->_listaDePasajeros[$i]->GetInfoPasajero();

                if(str_contains($infoPasajeros, "EsPlus = Si"))
                {
                    $recaudacionVuelo2 += $vuelo2->_precio - ($vuelo2->_precio * 0.2);
                }
                else
                {
                    $recaudacionVuelo2 += $vuelo2->_precio;
                }
            }

            return $recaudacionVuelo1 + $recaudacionVuelo2;

        }
        else
        {
            Echo "Algunos de los dos vuelos no es del tipo de objeto Vuelo", "<br/>";
            return -1;
        }
    }

    public static function Remove(Vuelo $vuelo, Pasajero $pasajeroParaRemover)
    {
        if($vuelo->Equals($pasajeroParaRemover))
        {
            $index = array_search($pasajeroParaRemover, $vuelo->_listaDePasajeros);
            unset($vuelo->_listaDePasajeros[$index]);
            $vuelo->_listaDePasajeros = array_values($vuelo->_listaDePasajeros);
        }
        else
        {
            echo "Error, el pasajero no esta en el vuelo","<br/>";
        }

    }

}





?>