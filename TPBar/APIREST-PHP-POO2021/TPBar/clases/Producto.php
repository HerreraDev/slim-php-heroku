<?php

class Producto{


    public $idProducto;
    public $codigo_de_barra;
    public $nombre;
    public $tipo;
    public $stock;
    public $precio;
    public $fecha_de_creacion;
    public $fecha_de_modificacion;

    public function BorrarProducto()
	{
	    $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				delete 
				from producto				
				WHERE idProducto=:id");	
		$consulta->bindValue(':id',$this->idProducto, PDO::PARAM_INT);
		$consulta->execute();
		return $consulta->rowCount();
	}

    public function ModificarProductoParametros()
	{
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
            update producto 
            set nombre=:nombre,
				tipo=:tipo,
				stock=:stock,
                precio=:precio,
                fecha_de_modificacion=:fecha_de_modificacion
				WHERE idProducto=:id");
        
                
        $consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		$consulta->bindValue(':id',$this->idProducto, PDO::PARAM_INT);
		$consulta->bindValue(':tipo',$this->tipo, PDO::PARAM_STR);
        $consulta->bindValue(':stock',$this->stock, PDO::PARAM_STR);
        $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_de_modificacion',$this->fecha_de_modificacion, PDO::PARAM_STR);
		return $consulta->execute();
	}

     public function InsertarElProductoParametros()
	 {
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta = $objetoAccesoDato->RetornarConsulta("INSERT into producto (codigo_de_barra,nombre,tipo,stock,precio,fecha_de_creacion,fecha_de_modificacion)values(:codigo_de_barra,:nombre,:tipo,:stock,:precio,:fecha_de_creacion,:fecha_de_modificacion)");

			$consulta->bindValue(':codigo_de_barra',$this->codigo_de_barra, PDO::PARAM_INT);
			$consulta->bindValue(':nombre',$this->nombre, PDO::PARAM_STR);
		    $consulta->bindValue(':tipo',$this->tipo, PDO::PARAM_STR);
            $consulta->bindValue(':stock',$this->stock, PDO::PARAM_STR);
            $consulta->bindValue(':precio',$this->precio, PDO::PARAM_INT);
            $consulta->bindValue(':fecha_de_creacion',$this->fecha_de_creacion, PDO::PARAM_STR);
            $consulta->bindValue(':fecha_de_modificacion',$this->fecha_de_modificacion, PDO::PARAM_STR);

			$consulta->execute();
			return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

	 public function GuardarUsuario()
	 {
	 	if($this->id>0)
	 		{
	 			$this->ModificarUsuarioParametros();
	 		}else {
	 			$this->InsertarElUsuarioParametros();
	 		}
	 }

     public static function TraerTodoLosProductos()
	{
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("select * from producto");
		$consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");		
	}

	public static function TraerUnProducto($id) 
	{
			$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
			$consulta =$objetoAccesoDato->RetornarConsulta("select * from producto where idProducto = $id");
			$consulta->execute();
			$productoBuscado= $consulta->fetchObject('Producto');
			return $productoBuscado;					
	}

    public static function VerificarProductoDB($prod)
    {

        $arrayProductos = array();
        $arrayProductos = self::TraerTodoLosProductos();

        $verificado = 0;
        foreach($arrayProductos as $producto)
        {
            if($producto->codigo_de_barra == $prod->codigo_de_barra)
            {
                $verificado = 1;
            }
        }
		return $verificado;
	}

	public function mostrarDatos()
	{
        return "Datos: ".$this->codigo_de_barra." ".$this->nombre."  ".$this->tipo." ".$this->stock." ".$this->precio." ".$this->fecha_de_creacion." ".$this->fecha_de_modificacion;
	}











}








?>