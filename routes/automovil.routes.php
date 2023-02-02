<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/automovil.class.php';   

//Get all Automoviles
	
$aplicacion->get('/automovil/all/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$oautomovil = new Automovil();
		$dataSalida = $oautomovil->getAll($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

// obtener Automoviles por id de usuario relacionado a todas las tablas
$aplicacion->get('/automovil/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$oautomovil = new Automovil();
		$dataSalida = $oautomovil->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// obtener Automoviles por id sin ningun filtro
$aplicacion->get('/automovil/id/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$oautomovil = new Automovil();
		$dataSalida = $oautomovil->getByIdSimple($args['id']);		
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


// obtener Automoviles por Patente
$aplicacion->get('/automovil/patente/{patente}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$oautomovil = new Automovil();
		$dataSalida = $oautomovil->getByPatente($args['patente']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);
   	
// desactivar Automovil por Patente
$aplicacion->put('/automovil/desactivar/{patente}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "patente desactivado";		
	$statuscode = 200;	
	try{
		$oautomovil = new Automovil();
		$oautomovil->desActivar($args['patente']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// activar Automovil por Patente
$aplicacion->put('/automovil/activar/{patente}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "patente activado";		
	$statuscode = 200;	
	try{
		$oautomovil = new Automovil();
		$oautomovil->activar($args['patente']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


$aplicacion->post('/automovil/crear',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Automovil creado';		
	try{
		// levanto los parámetros del body del request Para insetar en automovil
		$id_cliente = $request->getParsedBodyParam("id_cliente");
		$patente = $request->getParsedBodyParam("patente");
		$modelo = $request->getParsedBodyParam("modelo");
		$id_marca = $request->getParsedBodyParam("id_marca");
		$id_tipo_automovil = $request->getParsedBodyParam("id_tipo_automovil");
		$objAutomovil = new Automovil();

		$objAutomovil->crear($id_cliente,$patente,$modelo,$id_marca,$id_tipo_automovil,);	

		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);


$aplicacion->put('/automovil/actualizar',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Automovil actualizado';				 
	try{	

		$id_automovil = $request->getParsedBodyParam("id_automovil", $default = 0);
		$id_cliente = $request->getParsedBodyParam("id_cliente", $default = "");
		$patente = $request->getParsedBodyParam("patente", $default = "");
		$modelo = $request->getParsedBodyParam("modelo", $default = "");
		$id_marca = $request->getParsedBodyParam("id_marca", $default = "");
		$id_tipo_automovil = $request->getParsedBodyParam("id_tipo_automovil", $default = "");

		$objAutomovil = new Automovil();

		$objAutomovil->update($id_automovil,$id_cliente,$patente,$modelo,$id_marca,$id_tipo_automovil);	
		
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
	}			
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

?>