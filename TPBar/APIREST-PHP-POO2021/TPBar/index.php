<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';

require_once './clases/usuarioApi.php';
require_once './clases/ProductoApi.php';
require_once './clases/MesaApi.php';



$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;

/*
¡La primera línea es la más importante! A su vez en el modo de 
desarrollo para obtener información sobre los errores
 (sin él, Slim por lo menos registrar los errores por lo que si está utilizando
  el construido en PHP webserver, entonces usted verá en la salida de la consola 
  que es útil).

  La segunda línea permite al servidor web establecer el encabezado Content-Length, 
  lo que hace que Slim se comporte de manera más predecible.
*/

$app = new \Slim\App(["settings" => $config]);

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/


$app->group('/usuario', function () {
 
  $this->get('/', \usuarioApi::class . ':traerTodos');

  $this->get('/pdf', \Usuario::class . ':GenerarPdf');
 
  $this->get('/{id}', \usuarioApi::class . ':traerUno');

  $this->post('/', \usuarioApi::class . ':CargarUno');

  $this->delete('/{id}', \usuarioApi::class . ':BorrarUno');

  $this->put('/', \usuarioApi::class . ':ModificarUno');

  //$this->post('/login', \usuarioApi::class . ':LoginUsuario');

     
});

$app->group('/producto', function () {
 
  $this->get('/', \ProductoApi::class . ':traerTodos');
   
  $this->get('/{id}', \ProductoApi::class . ':traerUno');
  
  $this->post('/', \ProductoApi::class . ':CargarUno');
  
  $this->delete('/{id}', \ProductoApi::class . ':BorrarUno');
  
  $this->put('/', \ProductoApi::class . ':ModificarUno');
  
       
});

$app->group('/mesa', function () {
 
  $this->get('/', \MesaApi::class . ':traerTodos');
   
  $this->get('/{id}', \MesaApi::class . ':traerUno');
  
  $this->post('/', \MesaApi::class . ':CargarUno');
  
  $this->delete('/{id}', \MesaApi::class . ':BorrarUno');
  
  $this->put('/', \MesaApi::class . ':ModificarUno');
         
});





$app->run();














?>