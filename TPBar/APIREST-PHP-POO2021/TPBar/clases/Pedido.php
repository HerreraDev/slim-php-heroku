<?php

//cada producto es un pedido de la misma mesa

//el responsable va a mandar una peticion http para cambiar el estado del pedido

//esta sin terminar, falta crear la tabla y los metodos para hacer alta y listado.

class Pedido{ 

    public $idPedido;
    public $numero_pedido; //genero aleatoriamente
    public $id_usuario;
    public $id_mesa; //mando numero de mesa y obtengo el id
    public $id_estado; //siempre inicia en abierto
    public $id_producto; //mando el nombre y obtengo el id
    public $cantidad;
    public $id_responsable; //mando el mail y obtengo el id
    public $precio_final; //se calcula cantidad * precio
    public $fecha_hora_de_ingreso;

    
    public static function AlfanumericoRandom($length) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        return substr(str_shuffle($chars), 0, $length);
    }

    public function InsertarElPedidoParametros()
	 {
		$objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedidos (numero_pedido,id_usuario,id_mesa,id_estado,id_producto, cantidad, id_responsable, precio_final, fecha_hora_de_ingreso)values(:numero_pedido,:id_usuario,:id_mesa,:id_estado,:id_producto,:cantidad, :id_responsable, :precio_final, :fecha_hora_de_ingreso)");

		$consulta->bindValue(':numero_pedido',$this->numero_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':id_usuario',$this->id_usuario, PDO::PARAM_INT);
        $consulta->bindValue(':id_mesa',$this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':id_estado',$this->id_estado, PDO::PARAM_INT);
        $consulta->bindValue(':id_producto',$this->id_producto, PDO::PARAM_INT);
        $consulta->bindValue(':cantidad',$this->cantidad, PDO::PARAM_INT);
        $consulta->bindValue(':id_responsable',$this->id_responsable, PDO::PARAM_INT);
        $consulta->bindValue(':precio_final',$this->precio_final, PDO::PARAM_INT);
        $consulta->bindValue(':fecha_hora_de_ingreso',$this->fecha_hora_de_ingreso, PDO::PARAM_STR);
		$consulta->execute();
		return $objetoAccesoDato->RetornarUltimoIdInsertado();
	 }

     public static function TraerTodoLosPedidos()
     {
        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
        $consulta =$objetoAccesoDato->RetornarConsulta("select * from pedidos");
        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_CLASS, "Pedido");		
     }

     public static function TomarPedido($idPedido, $estado, $tiempo, $idResponsable){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
		$consulta =$objetoAccesoDato->RetornarConsulta("
				UPDATE pedidos
				set id_estado=:estado,
                id_responsable=:idResponsable,
                tiempo_estimado=:tiempo_estimado
				WHERE idPedido=:id");	
		$consulta->bindValue(':id',$idPedido, PDO::PARAM_INT);	$consulta->bindValue(':estado',$estado, PDO::PARAM_INT);		
        $consulta->bindValue(':idResponsable',$idResponsable, PDO::PARAM_INT);
        $consulta->bindValue(':tiempo_estimado',$tiempo, PDO::PARAM_INT);


		$consulta->execute();
		return $consulta->rowCount();
     }


     public static function TraerPendientes($empleo){

        $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 


        switch ($empleo) {
            case "Socio":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT idPedido, nombre, id_estado, cantidad, tiempo_estimado FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto");
                break;
            case "Mozo":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT idPedido, nombre, id_estado, cantidad, tiempo_estimado FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto");
                break;
            case "Bartender":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = 'bar' and id_estado = 3");
                break;
            case "Cervezero":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = 'cerveza' and id_estado = 3");
                break;
            case "Cocinero":
                $consulta = $objetoAccesoDato->RetornarConsulta("SELECT idPedido, nombre, id_estado, cantidad FROM `pedidos` INNER JOIN producto ON pedidos.id_producto = producto.idProducto WHERE producto.tipo = 'cocina' and id_estado = 3");
                break;
            default:
                echo "ERROR, el usuario no es de los esperados.";
                break;
        }

        $consulta->execute();			
        return $consulta->fetchAll(PDO::FETCH_OBJ);		

     }




}










?>