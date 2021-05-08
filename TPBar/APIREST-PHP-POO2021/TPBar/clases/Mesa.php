<?php

class Mesa{

    public $idMesa;
    public $numero_de_mesa;
    public $max_personas;

    public function BorrarMesa()
	{
	    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from mesas 				
				WHERE idMesa=:id");	
		$consulta->bindValue(':id',$this->idMesa, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}

    public function ModificarMesaParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
            update mesas 
            set numero_de_mesa=:numero_de_mesa,
            max_personas=:max_personas
			WHERE idMesa=:id");
        
                
		$consulta->bindValue(':id',$this->idMesa, PDO::PARAM_INT);
		$consulta->bindValue(':numero_de_mesa',$this->numero_de_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':max_personas',$this->max_personas, PDO::PARAM_INT);

		return $consulta->execute();
	}

    public function InsertarLaMesaParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into mesas (numero_de_mesa,max_personas)values(:numero_de_mesa,:max_personas)");

		$consulta->bindValue(':numero_de_mesa',$this->numero_de_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':max_personas',$this->max_personas, PDO::PARAM_INT);

		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	}

    public static function TraerTodasLasMesas()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from mesas");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Mesa");		
	}

	public static function TraerUnaMesa($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from mesas where idMesa = $id");
			$consulta->execute();
			$mesaBuscado= $consulta->fetchObject('MEsa');
			return $mesaBuscado;					
	}

    public static function VerificarMesaDB($auxMesa)
    {

        $arrayMesas = array();
        $arrayMesas = self::TraerTodasLasMesas();

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



}









?>