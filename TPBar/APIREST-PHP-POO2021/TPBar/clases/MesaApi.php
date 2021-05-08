<?php
require_once 'Mesa.php';
require_once 'IApiUsable.php';

class MesaApi extends Mesa implements IApiUsable
{
 	public function TraerUno($request, $response, $args) {
     	$id=$args['id'];
    	$laMesa=Mesa::TraerUnaMesa($id);
     	$newResponse = $response->withJson($laMesa, 200);  
    	return $newResponse;
    }
     public function TraerTodos($request, $response, $args) {
      	$todasLasMesas=Mesa::TraerTodasLasMesas();
     	$newResponse = $response->withJson($todasLasMesas, 200);  
    	return $newResponse;
    }
      public function CargarUno($request, $response, $args) {
     	 $ArrayDeParametros = $request->getParsedBody();
        //var_dump($ArrayDeParametros);
        $numero_de_mesa = $ArrayDeParametros['numero_de_mesa'];
        $max_personas= $ArrayDeParametros['max_personas'];


        $miMesa = new Mesa();
        
        $miMesa->numero_de_mesa=$numero_de_mesa;
        $miMesa->max_personas=$max_personas;


        $miMesa->InsertarLaMesaParametros();

        /*$archivos = $request->getUploadedFiles();
        $destino="./fotos/Mesas/";
        //var_dump($archivos);
        //var_dump($archivos['foto']);

        $nombreAnterior=$archivos['foto']->getClientFilename();
        $extension= explode(".", $nombreAnterior)  ;
        //var_dump($nombreAnterior);
        $extension=array_reverse($extension);

        $archivos['foto']->moveTo($destino.$nombre.".".$extension[0]);
        */
        $response->getBody()->write("se guardo el Mesa");

        return $response;
    }

    
    public function BorrarUno($request, $response, $args) {
        $id=$args['id'];
        $Mesa= new Mesa();
        $Mesa->idMesa=$id;
        $cantidadDeBorrados=$Mesa->BorrarMesa();

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
        
        $numero_de_mesa = $ArrayDeParametros['numero_de_mesa'];
        $max_personas= $ArrayDeParametros['max_personas'];


        $miMesa = new Mesa();
        
        $miMesa->numero_de_mesa=$numero_de_mesa;
        $miMesa->max_personas=$max_personas;

	   	$resultado =$miMesa->ModificarMesaParametros();
	   	$objDelaRespuesta= new stdclass();
		//var_dump($resultado);
		$objDelaRespuesta->resultado=$resultado;
		return $response->withJson($objDelaRespuesta, 200);		
  }


}


