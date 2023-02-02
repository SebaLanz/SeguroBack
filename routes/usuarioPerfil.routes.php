<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/usuarioPerfil.class.php';   

//Me trae que permiso tiene el usuario (ADMINISTRADOR - INVITADO)
$aplicacion->get('/usuarioPerfil/all/{id_usuario}',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objUPerfil = new UsuarioPerfil();
		$dataSalida = $objUPerfil->getAll($args['id_usuario']);			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);


//Me trae el PERFIL del usuario logeado

$aplicacion->get('/usuarioPerfil/allPerfil/{id_usuario}',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objUPerfil = new UsuarioPerfil();
		$dataSalida = $objUPerfil->getById($args['id_usuario']);			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->post('/usuarioPerfil',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Perfil de usuario creado';		
	try{
		// levanto los parámetros del body del request
		$nombre = $request->getParsedBodyParam("nombre", $default = "");
		$apellido = $request->getParsedBodyParam("apellido", $default = "");
		$dni = $request->getParsedBodyParam("dni", $default = "");
		$calle = $request->getParsedBodyParam("calle", $default = "");	
		$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
		$localidad = $request->getParsedBodyParam("localidad", $default = "");		
		$telefono = $request->getParsedBodyParam("email", $default = "");		
		$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");	
		$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

		$objUsuarioPerfil = new UsuarioPerfil();

		$objUsuarioPerfil->crear( $nombre, $apellido,$dni, $calle, $numero_calle,
								   $localidad,$telefono, $cod_provincia, $id_usuario);	

		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/usuarioPerfil/actualizar',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Perfil actualizado';				 
	try{
		// levanto los parámetros del body del request
		$id_usuario_perfil = $request->getParsedBodyParam("id_usuario_perfil", $default = 0);
		$nombre = $request->getParsedBodyParam("nombre", $default = "");
		$apellido = $request->getParsedBodyParam("apellido", $default = "");
		$dni = $request->getParsedBodyParam("dni", $default = "");
		$calle = $request->getParsedBodyParam("calle", $default = "");	
		$numero_calle = $request->getParsedBodyParam("numero_calle", $default = "");	
		$localidad = $request->getParsedBodyParam("localidad", $default = "");		
		$telefono = $request->getParsedBodyParam("telefono", $default = "");		
		$cod_provincia = $request->getParsedBodyParam("cod_provincia", $default = "");	
		$id_usuario = $request->getParsedBodyParam("id_usuario", $default = "");	

		$objUsuarioPerfil = new UsuarioPerfil();

		$objUsuarioPerfil->update($id_usuario_perfil,$nombre, $apellido,$dni, $calle, $numero_calle,
								   $localidad,$telefono, $cod_provincia, $id_usuario);	
		
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
	}			
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/usuarioPerfil/actualizar/img',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statuscode = 201;
	$statusmsg = 'Imagen actualizada';				 
	try{
		// levanto los parámetros del body del request
		$id_usuario = $request->getParsedBodyParam("id_usuario", $default = 0);
		$imgPerfil = $request->getParsedBodyParam("imgPerfil", $default = "");

		$objUsuarioPerfil = new UsuarioPerfil();

		$objUsuarioPerfil->updateImg($id_usuario,$imgPerfil);	
		
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
	}			
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

 	
?>