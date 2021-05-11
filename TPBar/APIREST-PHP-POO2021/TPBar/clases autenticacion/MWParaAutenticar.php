<?php

class MWParaAutenticar{


    public function VerificarUsuario($request, $response, $next) {
         
        if($request->isGet())
        {
           $response->getBody()->write('<p>NO necesita credenciales para los get</p>');
           $response = $next($request, $response);
        }
        else
        {
          $response->getBody()->write('<p>Verifico credenciales</p>');
          $ArrayDeParametros = $request->getParsedBody();
          $mail=$ArrayDeParametros['mail'];
          $empleo=$ArrayDeParametros['empleo'];
          if($empleo=="socio")
          {
            $response->getBody()->write("<h3>Bienvenido $mail </h3>");
            $response = $next($request, $response);
          }
          else
          {
            $response->getBody()->write('<p>no tenes habilitado el ingreso</p>');
          }  
        }
        $response->getBody()->write('<p>vuelvo del verificador de credenciales</p>');
        return $response;   
    }


}


?>