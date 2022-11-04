<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/proveedor.class.php';

$aplicacion->get('/proveedor/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objproveedor = new Proveedor();
		$dataSalida = $objproveedor->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/proveedor/allActivo',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objproveedor = new Proveedor();
		$dataSalida = $objproveedor->getAllActivo();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/proveedor/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objproveedor = new Proveedor();
		$dataSalida = $objproveedor->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	

$aplicacion->post('/proveedor',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Proveedor creado';		
	try{
		// levanto los parámetros del body del request
		$razon_soc = $request->getParsedBodyParam("razon_soc", $default = "");
		$cuit = $request->getParsedBodyParam("cuit", $default = "");	
		$calle = $request->getParsedBodyParam("calle", $default = "");	
		$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
		$localidad = $request->getParsedBodyParam("localidad", $default = "");				
		$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");
		$telefono = $request->getParsedBodyParam("telefono", $default = "");		
		$email = $request->getParsedBodyParam("email", $default = "");	
		$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");

		$objproveedor = new Proveedor();

		$objproveedor->crear( $razon_soc, $cuit, $calle, $numero_calle,
								   $localidad, $cod_provincia,$telefono, $email,$id_usuario);	

		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/proveedor',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Proveedor actualizado';				 
	try{
		$id = $request->getParsedBodyParam("id_proveedor", $default = 0);
		// levanto los parámetros del body del request
		$razon_soc = $request->getParsedBodyParam("razon_soc", $default = "");
		$cuit = $request->getParsedBodyParam("cuit", $default = "");	
		$calle = $request->getParsedBodyParam("calle", $default = "");	
		$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
		$localidad = $request->getParsedBodyParam("localidad", $default = "");
		$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");		
		$telefono = $request->getParsedBodyParam("telefono", $default = "");
		$email = $request->getParsedBodyParam("email", $default = "");
		
			
		
		$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

		$objproveedor = new Proveedor();

		$objproveedor->update($id, $razon_soc, $cuit, $calle, $numero_calle, $localidad, $cod_provincia,$telefono,$email,$id_usuario);
		 
		$dataSalida = array();
		
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
	}			
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

$aplicacion->delete('/proveedor/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Proveedor eliminado';				 
	try{
		$id = $args['id'];
		// levanto los parámetros del body del request		

		$objProveedor = new Proveedor();

		$objProveedor->delete($id);
		 
		$dataSalida = array();
		
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
	}			
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

// desactivar proveedor por idusuario //
$aplicacion->put('/proveedor/desactivar/{id_proveedor}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "proveedor desactivado";		
	$statuscode = 200;	
	try{
		$objproveedor = new Proveedor();
		$objproveedor->desactivar($args['id_proveedor']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// activar proveedor por usuario
$aplicacion->put('/proveedor/activar/{id_proveedor}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "proveedor activado";		
	$statuscode = 200;	
	try{
		$objproveedor = new Proveedor();
		$objproveedor->activar($args['id_proveedor']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);
?>