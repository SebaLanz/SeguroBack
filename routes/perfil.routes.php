<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/perfil.class.php';

$aplicacion->get('/perfil/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objPerfil = new perfil();
		$dataSalida = $objPerfil->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/perfil/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objPerfil = new Perfil();
		$dataSalida = $objPerfil->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	


$aplicacion->post('/perfil',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Perfil creado';		
		try{
			// levanto los parámetros del body del request
			$perfil = $request->getParsedBodyParam("perfil", $default = "");
			$esdefault = $request->getParsedBodyParam("esdefault", $default = "");	

			$objPerfil = new Perfil();

			$objPerfil->crear( $perfil, $esdefault);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/perfil',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Perfil actualizado';				 
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

			$objPerfil = new Perfil();

			$objPerfil->update($id_perfil, $perfil, $esdefault);
			 
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
		$statusmsg = 'cliente actualizado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objCliente = new Cliente();

			$objCliente->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);
   

?>