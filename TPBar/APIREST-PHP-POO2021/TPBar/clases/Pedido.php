<?php

//cada producto es un pedido de la misma mesa

//el responsable va a mandar una peticion http para cambiar el estado del pedido

//esta sin terminar, falta crear la tabla y los metodos para hacer alta y listado.

class Pedido{ 

    public $idPedido;
    public $numero_pedido; //genero aleatoriamente
    public $nombre_cliente;
    public $id_mesa; //mando numero de mesa y obtengo el id
    public $estado; //siempre inicia en abierto
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
		$consulta =$objetoAccesoDato->RetornarConsulta("INSERT into pedidos (numero_pedido,nombre_cliente,id_mesa,estado,id_producto, cantidad, id_responsable, precio_final, fecha_hora_de_ingreso)values(:numero_pedido,:nombre_cliente,:id_mesa,:estado,:id_producto,:cantidad, :id_responsable, :precio_final, :fecha_hora_de_ingreso)");

		$consulta->bindValue(':numero_pedido',$this->numero_pedido, PDO::PARAM_INT);
        $consulta->bindValue(':nombre_cliente',$this->nombre_cliente, PDO::PARAM_STR);
        $consulta->bindValue(':id_mesa',$this->id_mesa, PDO::PARAM_INT);
        $consulta->bindValue(':estado',$this->estado, PDO::PARAM_STR);
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




}










?>