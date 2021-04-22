<?php

    class Producto
    {
        public $idProducto;
        public $codigo_de_barra;
        public $nombre;
        public $tipo;
        public $stock;
        public $precio;
        public $fecha_de_creacion;
        public $fecha_de_modificacion;

        public function __construct()
        {
        }

        public function mostrarDatos()
        {
            return "Datos:".$this->idProducto."  ".$this->codigo_de_barra."  ".$this->nombre." ".$this->tipo." ".$this->stock." ".$this->precio." ".$this->fecha_de_creacion." ".$this->fecha_de_modificacion;
        }

        public static function TraerTodoLosProductos()
        {
            $objetoAccesoDato = AccesoDatos::dameUnObjetoAcceso(); 
            $consulta =$objetoAccesoDato->RetornarConsulta("select idProducto, codigo_de_barra, nombre, tipo, stock, precio, fecha_de_creacion, fecha_de_modificacion from producto");
            $consulta->execute();			
            return $consulta->fetchAll(PDO::FETCH_CLASS, "Producto");		
        }

        public static function DibujarLista($lista)
        {
            echo "<ul>";
            foreach ($lista as $prod) {
                $string = $prod->mostrarDatos();
                echo "<li>$string</li>";
            }
            echo "</ul>";
        }
    }
    




?>