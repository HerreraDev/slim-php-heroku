<?php

require_once './models/Mesa.php';

use App\Models\Mesa as Mesa;


class auxMesa{   

    public static function VerificarMesaDB($auxMesa)
    {

        $arrayMesas = array();
        $arrayMesas = Mesa::all();

        $verificado = 0;
        foreach($arrayMesas as $mesa)
        {
            if($mesa->numero_de_mesa == $auxMesa->numero_de_mesa)
            {
                $verificado = 1;
            }
        }
		return $verificado;
	}

	public function mostrarDatos()
	{
        return "Datos: ".$this->numero_de_mesa." ".$this->max_personas;
	}

	public static function ObtenerIdPorNumeroMesa($numDeMesa)
    {

        $arrayMesas = array();
        $arrayMesas = Mesa::all();

        $idMesa = -1;
        foreach($arrayMesas as $mesa)
        {
            if($mesa->numero_de_mesa == $numDeMesa && $mesa->id_estado == 0)
            {
                $idMesa = $mesa->idMesa;
				break;
            }
        }
		return $idMesa;
	}


    public static function GuardarEnJson($mesa, $mode)
    {

        $direccionArchivo = fopen("csv/Mesas.json", $mode);

        if ($direccionArchivo != false) {
            if (fwrite($direccionArchivo, json_encode($mesa) . "\n") != false) {
                fclose($direccionArchivo);
                return 1;
            } else {
                fclose($direccionArchivo);
                return 0;
            }
        }
    }

    public static function GenerarCSV()
    {

        $mesas = array();
        $mesas = Mesa::all();

        $mode = "w";

        foreach ($mesas as $mesa) {
            self::GuardarEnJson($mesa, $mode);
            $mode = "a";
        }

        echo "Csv generado en la ruta /csv/Mesas.json";
    }
}



?>