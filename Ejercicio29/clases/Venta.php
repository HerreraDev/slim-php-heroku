<?php

class Venta
{
    public $idVenta;
    public $id_producto;
    public $id_usuario;
    public $cantidad;
    public $fecha_de_venta;

    public function __construct()
        {
        }

        public function mostrarDatos()
        {
            return "Datos:".$this->idVenta."  ".$this->id_producto."  ".$this->id_usuario." ".$this->cantidad." ".$this->fecha_de_venta;
        }

        public static function TraerTodaLasVentas()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select idVenta, id_producto, id_usuario, cantidad, fecha_de_venta from venta");
            $consulta->execute();			
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Venta");		
        }

        public static function DibujarLista($lista)
        {
            echo "<ul>";
            foreach ($lista as $venta) {
                $string = $venta->mostrarDatos();
                echo "<li>$string</li>";
            }
            echo "</ul>";
        }
}




?>