<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/empleado.class.php';

$aplicacion->get('/empleado/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objEmpleado = new Empleado();
		$dataSalida = $objEmpleado->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/empleado/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objEmpleado = new Empleado();
		$dataSalida = $objEmpleado->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	


$aplicacion->post('/empleado',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Emleado creado';		
		try{
			// levanto los parámetros del body del request
			$nombre = $request->getParsedBodyParam("nombre", $default = "");
			$apellido = $request->getParsedBodyParam("apellido", $default = "");
			$email = $request->getParsedBodyParam("email", $default = "");
			$calle = $request->getParsedBodyParam("calle", $default = "");	
			$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
			$localidad = $request->getParsedBodyParam("localidad", $default = "");				
			$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");	
			$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

			$objEmpleado = new Empleado();

			$objEmpleado->crear( $nombre, $apellido, $email, $calle, $numero_calle,
                           			$localidad, $cod_provincia, $id_usuario);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/empleado',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Empleado actualizado';				 
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

			$objEmpleado = new Empleado();

			$objEmpleado->update($id, $nombre, $apellido, $email, $calle, $numero_calle, $localidad, $cod_provincia, $id_usuario);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/empleado/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Empleado actualizado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objEmpleado = new Empleado();

			$objEmpleado->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);
   

?>