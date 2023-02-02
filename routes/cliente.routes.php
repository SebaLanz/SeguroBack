<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/cliente.class.php';

// no lo uso x ahora
/*$aplicacion->get('/cliente/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objcliente = new Cliente();
		$dataSalida = $objcliente->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);*/

$aplicacion->get('/cliente/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objcliente = new cliente();
		$dataSalida = $objcliente->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/cliente/all/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objcliente = new cliente();
		$dataSalida = $objcliente->getAllByUserLog($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	


$aplicacion->post('/cliente',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'cliente creado';		
		try{
			// levanto los parámetros del body del request
			$nombre = $request->getParsedBodyParam("nombre", $default = "");
			$apellido = $request->getParsedBodyParam("apellido", $default = "");
			$dni = $request->getParsedBodyParam("dni", $default = "");
			$email = $request->getParsedBodyParam("email", $default = "");
			$calle = $request->getParsedBodyParam("calle", $default = "");	
			$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
			$localidad = $request->getParsedBodyParam("localidad", $default = "");				
			$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");	
			$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

			$objcliente = new Cliente();

			$objcliente->crear( $nombre, $apellido,$dni, $email, $calle, $numero_calle,
                           			$localidad, $cod_provincia, $id_usuario);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/cliente',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'cliente actualizado';				 
		try{
			$id = $request->getParsedBodyParam("id_empleado", $default = 0);
			// levanto los parámetros del body del request
			$nombre = $request->getParsedBodyParam("nombre", $default = "");
			$apellido = $request->getParsedBodyParam("apellido", $default = "");
			$email = $request->getParsedBodyParam("email", $default = "");
			$calle = $request->getParsedBodyParam("calle", $default = "");	
			$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
			$localidad = $request->getParsedBodyParam("localidad", $default = "");	

			$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");	
			$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

			$objcliente = new Cliente();

			$objcliente->update($id, $nombre, $apellido, $email, $calle, $numero_calle, $localidad, $cod_provincia, $id_usuario);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/cliente/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'cliente eliminado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objcliente = new Cliente();

			$objcliente->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	
	// desactivar Automovil por Patente
$aplicacion->put('/cliente/desactivar/{id_empleado}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "Cliente desactivado";		
	$statuscode = 200;	
	try{
		$objcliente = new Cliente();
		$objcliente->desActivar($args['id_empleado']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// activar Automovil por Patente
$aplicacion->put('/cliente/activar/{id_empleado}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "Cliente activado";		
	$statuscode = 200;	
	try{
		$objcliente = new Cliente();
		$objcliente->activar($args['id_empleado']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

   

?>