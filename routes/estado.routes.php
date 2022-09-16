<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/estado.class.php';

$aplicacion->get('/estado/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objEstado = new Estado();
		$dataSalida = $objEstado->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error  1234:'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/estado/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objEstado = new Estado();
		$dataSalida = $objEstado->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	


$aplicacion->post('/estado',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Estado creado';		
		try{
			// levanto los parámetros del body del request
			$Descripcion = $request->getParsedBodyParam("descripcion", $default = "");

			$objEstado = new Estado();

			$objEstado->crear( $Descripcion);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/estado',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Estado actualizado';				 
		try{
			$id = $request->getParsedBodyParam("id_estado", $default = 0);
			// levanto los parámetros del body del request
			$Descripcion = $request->getParsedBodyParam("Descricion", $default = "");	

			$objEstado = new Estado();

			$objEstado->update($id, $Descripcion);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/estado/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Estado eliminado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objEstado = new Estado(); 

			$objEstado->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);
   

?>