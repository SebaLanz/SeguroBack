<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/plan.class.php';

$aplicacion->get('/plan/all',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$oplan = new Plan();
		$dataSalida = $oplan->getAll();	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

	$aplicacion->get('/plan/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statusmsg = "ok";		
		$statuscode = 200;	
		try{
			$oplan = new Plan();
			$dataSalida = $oplan->getById($args['id']);			
		}catch (Exception $e){
			$statuscode = 500;		
			$statusmsg = 'Error :'.$e->getMessage();
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
	} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/plan/tipo_plan/{tipo_plan}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$oplan = new Plan();
		$dataSalida = $oplan->getByTipoPlan($args['tipo_plan']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

$aplicacion->post('/plan',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Plan creado';		
	try{
		// levanto los parámetros del body del request
		$tipo_plan = $request->getParsedBodyParam("tipo_plan", $default = "");
		$descripcion = $request->getParsedBodyParam("descripcion", $default = "");

		$oplan = new Plan();

		$oplan->crear($tipo_plan, $descripcion);	

		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error Creando Plan: ->  '.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

// desactivar plan por id
$aplicacion->put('/plan/desactivar/{id_tipo_plan}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "Plan desactivado";		
	$statuscode = 200;	
	try{
		$oplan = new Plan();
		$oplan->desActivar($args['id_tipo_plan']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// activar plan por Patente
$aplicacion->put('/plan/activar/{id_tipo_plan}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "Plan activado";		
	$statuscode = 200;	
	try{
		$oplan = new Plan();
		$oplan->activar($args['id_tipo_plan']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


$aplicacion->put('/plan/actualizar',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Plan actualizado';				 
		try{
			$id = $request->getParsedBodyParam("id_tipo_plan", $default = 0);
			// levanto los parámetros del body del request
			$tipo_plan = $request->getParsedBodyParam("tipo_plan", $default = "");
			$descripcion = $request->getParsedBodyParam("descripcion", $default = "");


			$oplan = new Plan();

			$oplan->update($id, $tipo_plan, $descripcion);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	

?>