<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/plan_pago.class.php';

	$aplicacion->get('/plan_pago/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
		$dataSalida = array();
		$statusmsg = "ok";		
		$statuscode = 200;
		try{
			$oplan_pago = new Plan_pago();
			$dataSalida = $oplan_pago->getAll();			
		}catch (Exception $e){
			$statuscode = 500;	
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	} )->add($aplicacion->mw_verificarToken);

	$aplicacion->get('/plan_pago/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statusmsg = "ok";		
		$statuscode = 200;	
		try{
			$oplan_pago = new Plan_pago();
			$dataSalida = $oplan_pago->getById($args['id']);			
		}catch (Exception $e){
			$statuscode = 500;		
			$statusmsg = 'Error :'.$e->getMessage();
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
	} )->add($aplicacion->mw_verificarToken);
	

	$aplicacion->post('/plan_pago',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Plan creado';		
		try{
			// levanto los parámetros del body del request
			$id_automovil = $request->getParsedBodyParam("id_automovil", $default = "");
			$id_tipo_plan = $request->getParsedBodyParam("id_tipo_plan", $default = "");
			$id_medios_pago = $request->getParsedBodyParam("id_medios_pago", $default = "");
			$abonó = $request->getParsedBodyParam("abonó", $default = "");
			$fecha = $request->getParsedBodyParam("fecha", $default = "");
	
			$oplan = new Plan_pago();
	
			$oplan->crear($id_automovil, $id_tipo_plan,$id_medios_pago,$abonó,$fecha);	
	
			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error Creando Pagos: ->  '.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->put('/plan_pago/actualizar',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Pago actualizado';				 
		try{
			$id = $request->getParsedBodyParam("id_plan_pago", $default = 0);
			// levanto los parámetros del body del request
			$id_automovil = $request->getParsedBodyParam("id_automovil", $default = "");
			$id_tipo_plan = $request->getParsedBodyParam("id_tipo_plan", $default = "");
			$id_medios_pago = $request->getParsedBodyParam("id_medios_pago", $default = "");
			$abonó = $request->getParsedBodyParam("abonó", $default = "");
			$fecha = $request->getParsedBodyParam("fecha", $default = "");


			$oplan = new Plan_pago();

			$oplan->update($id, $id_automovil, $id_tipo_plan,$id_medios_pago,$abonó,$fecha);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/plan_pago/delete/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Pago borrado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objPago = new Plan_pago();

			$objPago->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);


	
?>