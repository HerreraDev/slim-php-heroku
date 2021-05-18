<?php
require_once './clases/usuario.php';
require_once './Logs/Logs.php';
require_once './clases/IApiUsable.php';
require_once './clases autenticacion/AutentificadorJWT.php';

class usuarioApi extends Usuario implements IApiUsable
{
  public function TraerUno($request, $response, $args)
  {
    $id = $args['id'];
    $elUsuario = Usuario::TraerUnUsuario($id);
    $newResponse = $response->withJson($elUsuario, 200);
    return $newResponse;
  }
  public function TraerTodos($request, $response, $args)
  {
    $todosLosUsuarios = Usuario::TraerTodoLosUsuarios();

    //Usuario::DibujarTablaUsuario($todosLosUsuarios);

    $newResponse = $response->withJson($todosLosUsuarios, 200);
    return $newResponse;
  }
  public function CargarUno($request, $response, $args)
  {
    $ArrayDeParametros = $request->getParsedBody();
    //var_dump($ArrayDeParametros);
    $nombre = $ArrayDeParametros['nombre'];
    $apellido = $ArrayDeParametros['apellido'];
    $clave = $ArrayDeParametros['clave'];
    $mail = $ArrayDeParametros['mail'];
    $empleo = $ArrayDeParametros['empleo'];
    $fecha_de_ingreso = date("Y-m-d");

    if ($empleo != "Bartender" && $empleo != "Cervecero" && $empleo != "Cocinero" && $empleo != "Mozo" && $empleo != "Socio" && $empleo != "Cliente") {
      $response->getBody()->write("ERROR. Solo se pueden ingresar los siguientes empleos: Bartender - Cervecero - Cocinero - Mozo - Socio o Cliente. ¡¡RECUERDE RESPETAR MAYUSCULAS Y MINUSCULAS!!");
      return $response;
    }

    $miUsuario = new Usuario();
    $miUsuario->nombre = $nombre;
    $miUsuario->apellido = $apellido;
    $miUsuario->clave = $clave;
    if($empleo == "Cliente"){
      $miUsuario->clave = "Sin clave";
    }
    $miUsuario->mail = $mail;
    $miUsuario->empleo = $empleo;
    $miUsuario->fecha_de_ingreso = $fecha_de_ingreso;

    $archivos = $request->getUploadedFiles();
    $destino = "./fotos/usuarios/";
    //var_dump($archivos);
    //var_dump($archivos['foto']);

    $nombreAnterior = $archivos['foto']->getClientFilename();
    $extension = explode(".", $nombreAnterior);
    //var_dump($nombreAnterior);
    $extension = array_reverse($extension);

    $archivos['foto']->moveTo($destino . $mail . "." . $extension[0]);

    $miUsuario->ruta_foto = $destino . $mail . "." . $extension[0];

    



    if (Usuario::VerificarUsuarioDB($miUsuario) == 0 || Usuario::VerificarUsuarioDB($miUsuario) == 1) {
      $response->getBody()->write("ERROR. Ya existe un usuario registrado con ese mail, ingrese otro.");
    } else {
      $miUsuario->InsertarElUsuarioParametros();
      $response->getBody()->write("Se registro el usuario con exito");
    }








    return $response;
  }


  public function BorrarUno($request, $response, $args)
  {
    $id = $args['id'];
    $usuario = new Usuario();
    $usuario->idUsuario = $id;
    $cantidadDeBorrados = $usuario->BorrarUsuario();

    $objDelaRespuesta = new stdclass();
    $objDelaRespuesta->cantidad = $cantidadDeBorrados;
    if ($cantidadDeBorrados > 0) {
      $objDelaRespuesta->resultado = "Usuario dado de baja.";
    } else {
      $objDelaRespuesta->resultado = "No se pudo dar de baja";
    }
    $newResponse = $response->withJson($objDelaRespuesta, 200);
    return $newResponse;
  }

  public function ModificarUno($request, $response, $args)
  {
    //$response->getBody()->write("<h1>Modificar  uno</h1>");
    $ArrayDeParametros = $request->getParsedBody();
    //var_dump($ArrayDeParametros);

    $id = $ArrayDeParametros['id'];
    $nombre = $ArrayDeParametros['nombre'];
    $apellido = $ArrayDeParametros['apellido'];
    $clave = $ArrayDeParametros['clave'];
    $mail = $ArrayDeParametros['mail'];
    $empleo = $ArrayDeParametros['empleo'];

    $miUsuario = new Usuario();
    $miUsuario->idUsuario = $id;
    $miUsuario->nombre = $nombre;
    $miUsuario->apellido = $apellido;
    $miUsuario->clave = $clave;
    $miUsuario->mail = $mail;
    $miUsuario->empleo = $empleo;

    $resultado = $miUsuario->ModificarUsuarioParametros();
    $objDelaRespuesta = new stdclass();
    //var_dump($resultado);
    $objDelaRespuesta->resultado = $resultado;
    return $response->withJson($objDelaRespuesta, 200);
  }

  public function LoginUsuario($request, $response, $args)
  {
    $ArrayDeParametros = $request->getParsedBody();

    $mail = $ArrayDeParametros['mail'];
    $clave = $ArrayDeParametros['clave'];

    $user = new Usuario();
    $user->mail = $mail;
    $user->clave = $clave;

    $respuesta = Usuario::VerificarUsuarioDB($user);

    switch ($respuesta) {
      case -1:
        echo "No existe";
        break;
      case 0:
        echo "Mail correcto pero clave incorrecta";
        break;
      case 1:
        $datos = ["empleo" => $user->empleo, "mail" => $user->mail];
        echo AutentificadorJWT::CrearToken($datos);

        Logs::LogUsuario($user->mail);
        break;
    };
  }
}
