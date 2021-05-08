<?php
require_once 'usuario.php';
require_once 'IApiUsable.php';

class usuarioApi extends Usuario implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$elUsuario=Usuario::TraerUnUsuario($id);
     	$newResponse = $response->withJson($elUsuario, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$todosLosUsuarios=Usuario::TraerTodoLosUsuarios();
     	$newResponse = $response->withJson($todosLosUsuarios, 200);  
    	return $newResponse;
    }
      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $clave= $ArrayDeParametros['clave'];
        $mail= $ArrayDeParametros['mail'];
        $localidad= $ArrayDeParametros['localidad'];
        $fecha_de_registro = date("Y-m-d");

        $miUsuario = new Usuario();
        $miUsuario->nombre=$nombre;
        $miUsuario->apellido=$apellido;
        $miUsuario->clave=$clave;
        $miUsuario->mail=$mail;
        $miUsuario->localidad=$localidad;
        $miUsuario->fecha_de_registro=$fecha_de_registro;

        $miUsuario->InsertarElUsuarioParametros();

        $archivos = $request->getUploadedFiles();
        $destino="./fotos/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);

        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        $extension=array_reverse($extension);

        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        $response->getBody()->write("se guardo el usuario");

        return $response;
    }

    
    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $usuario= new Usuario();
        $usuario->idUsuario=$id;
        $cantidadDeBorrados=$usuario->BorrarUsuario();

        $objDelaRespuesta= new stdclass();
       $objDelaRespuesta->cantidad=$cantidadDeBorrados;
       if($cantidadDeBorrados>0)
           {
                $objDelaRespuesta->resultado="algo borro!!!";
           }
           else
           {
               $objDelaRespuesta->resultado="no Borro nada!!!";
           }
       $newResponse = $response->withJson($objDelaRespuesta, 200);  
         return $newResponse;
   }
     
     public function ModificarUno($request, $response, $args) {
     	//$response->getBody()->write("<h1>Modificar  uno</h1>");
     	$ArrayDeParametros = $request->getParsedBody();
	    //var_dump($ArrayDeParametros);
        
        $id= $ArrayDeParametros['id'];
        $nombre= $ArrayDeParametros['nombre'];
        $apellido= $ArrayDeParametros['apellido'];
        $clave= $ArrayDeParametros['clave'];
        $mail= $ArrayDeParametros['mail'];
        $localidad= $ArrayDeParametros['localidad'];
        
	    $miUsuario = new Usuario();
        $miUsuario->idUsuario = $id;
        $miUsuario->nombre=$nombre;
        $miUsuario->apellido=$apellido;
        $miUsuario->clave=$clave;
        $miUsuario->mail=$mail;
        $miUsuario->localidad=$localidad;

	   	$resultado =$miUsuario->ModificarUsuarioParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
    }

    public function LoginUsuario($request, $response, $args)
    {
        $ArrayDeParametros = $request->getParsedBody();

        $mail = $ArrayDeParametros['mail'];
        $clave = $ArrayDeParametros['clave'];

        $user = new Usuario();
        $user->mail=$mail;
        $user->clave=$clave;

        $respuesta = Usuario::VerificarUsuarioDB($user);

        switch($respuesta){
            case -1:
                echo "No existe";
                break;
            case 0:
                echo "Mail correcto pero clave incorrecta";
                break;
            case 1:
                echo "Logueado";
                break;
        };


    }


}