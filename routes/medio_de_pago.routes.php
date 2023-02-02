<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/medio_pago.class.php';

	$aplicacion->get('/medio_pago/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
		$dataSalida = array();
		$statusmsg = "ok";		
		$statuscode = 200;
		try{
			$omedios = new Medio_de_pago();
			$dataSalida = $omedios->getAll();			
		}catch (Exception $e){
			$statuscode = 500;	
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	} )->add($aplicacion->mw_verificarToken);

	
	$aplicacion->get('/medio_pago/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statusmsg = "ok";		
		$statuscode = 200;	
		try{
			$omedios = new Medio_de_pago();
			$dataSalida = $omedios->getById($args['id']);			
		}catch (Exception $e){
			$statuscode = 500;		
			$statusmsg = 'Error :'.$e->getMessage();
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
	} )->add($aplicacion->mw_verificarToken);
	
	
		   
	// desactivar
	$aplicacion->put('/medio_pago/desactivar/{id_medios_pago}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statusmsg = "Medio de pago desactivado";		
		$statuscode = 200;	
		try{
			$omedios = new Medio_de_pago();
			$omedios->desActivar($args['id_medios_pago']);
			$dataSalida = array();			
		}catch (Exception $e){
			$statuscode = 500;		
			$statusmsg = 'Error :'.$e->getMessage();
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
	} )->add($aplicacion->mw_verificarToken);
	
	// activar 
	$aplicacion->put('/medio_pago/activar/{id_medios_pago}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statusmsg = "Medio de pago activado";		
		$statuscode = 200;	
		try{
			$omedios = new Medio_de_pago();
			$omedios->activar($args['id_medios_pago']);
			$dataSalida = array();			
		}catch (Exception $e){
			$statuscode = 500;		
			$statusmsg = 'Error :'.$e->getMessage();
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
	} )->add($aplicacion->mw_verificarToken);
	
	
	$aplicacion->post('/medio_pago',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Medio de pago creado';		
		try{
			// levanto los parámetros del body del request Para insetar en automovil
			$medio_pago = $request->getParsedBodyParam("medio_pago");
			$omedios = new Medio_de_pago();
	
			$omedios->crear($medio_pago);	
	
			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);
	
	
	$aplicacion->put('/medio_pago/actualizar',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Medio de pago actualizado';				 
		try{	
	
			$id_medios_pago = $request->getParsedBodyParam("id_medios_pago", $default = 0);
			$medio_pago = $request->getParsedBodyParam("medio_pago", $default = "");
			
	
			$omedios = new Medio_de_pago();
	
			$omedios->update($id_medios_pago,$medio_pago);	
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	
?>