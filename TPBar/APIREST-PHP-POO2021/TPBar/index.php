<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require_once '../vendor/autoload.php';
require_once './clases/AccesoDatos.php';

require_once './clases/usuarioApi.php';
require_once './clases/ProductoApi.php';
require_once './clases/MesaApi.php';
require_once './clases/PedidoApi.php';


require_once './clases autenticacion/MWparaCORS.php';
require_once './clases autenticacion/MWParaAutenticar.php';


$config['displayErrorDetails'] = true;
$config['addContentLengthHeader'] = false;


$app = new \Slim\App(["settings" => $config]);

/*LLAMADA A METODOS DE INSTANCIA DE UNA CLASE*/

$app->post('/login', \usuarioApi::class . ':LoginUsuario');

$app->group('/usuario', function () {
 
  $this->get('/', \usuarioApi::class . ':traerTodos');

  $this->get('/pdf', \Usuario::class . ':GenerarPdf');
 
  $this->get('/{id}', \usuarioApi::class . ':traerUno');

  $this->post('/', \usuarioApi::class . ':CargarUno');

  $this->delete('/{id}', \usuarioApi::class . ':BorrarUno');

  $this->put('/', \usuarioApi::class . ':ModificarUno');
     
})->add(\MWParaAutenticar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/producto', function () {
 
  $this->get('/', \ProductoApi::class . ':traerTodos');
   
  $this->get('/{id}', \ProductoApi::class . ':traerUno');
  
  $this->post('/', \ProductoApi::class . ':CargarUno');
  
  $this->delete('/{id}', \ProductoApi::class . ':BorrarUno');
  
  $this->put('/', \ProductoApi::class . ':ModificarUno');
  
       
})->add(\MWParaAutenticar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/mesa', function () {
 
  $this->get('/', \MesaApi::class . ':traerTodos');
   
  $this->get('/{id}', \MesaApi::class . ':traerUno');
  
  $this->post('/', \MesaApi::class . ':CargarUno');
  
  $this->delete('/{id}', \MesaApi::class . ':BorrarUno');
  
  $this->put('/', \MesaApi::class . ':ModificarUno');
         
})->add(\MWParaAutenticar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');

$app->group('/pedido', function () {
 
  $this->get('/', \PedidoApi::class . ':traerTodos');
   
  $this->get('/{id}', \PedidoApi::class . ':traerUno');
  
  $this->post('/', \PedidoApi::class . ':CargarUno');
  
  $this->delete('/{id}', \PedidoApi::class . ':BorrarUno');
  
  $this->put('/tomar', \PedidoApi::class . ':TomarPedidoPendiente');


  
       
})->add(\MWParaAutenticar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');


$app->group('/pendientes', function(){

  $this->get('/', \PedidoApi::class . ':TraerPedidoPendiente');

  

})->add(\MWParaAutenticar::class . ':VerificarUsuario')->add(\MWparaCORS::class . ':HabilitarCORS8080');





$app->run();














?>