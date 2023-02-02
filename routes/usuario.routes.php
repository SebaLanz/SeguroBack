<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/usuario.class.php';   

$aplicacion->post('/login',  function(Request $request, Response $response, $args) use ($aplicacion){	   		
	//**
	// obtener los bodyparams usuario y pass
	// si alguno está vacío response status 400 'Error : Faltan datos en la petición '
	// si están los dos y objusuario->login es true, obtener el token y devolverlo con 200 en datasalida
	// si login es false devolver response status 401 'Error : Usuario o clave incorrectos '

	$dataSalida["token"]="";
	try{
		//echo "puto";
		$statuscode = 200;
		$statusmsg = 'ok';
		$usuario = $request->getParsedBodyParam("usuario", $default = "");
		$pass = $request->getParsedBodyParam("pass", $default = "*");
		
		if(empty($usuario) || empty($pass) ){
			$statuscode = 400;
			$statusmsg = ' Faltan datos en la petición ';
		}else{			
			$ousuario = new Usuario();
			$loginResp = $ousuario->login($usuario,$pass);
			if($loginResp == 1 || $loginResp == 2){
				$dataSalida["login_status"]="OK";
				$dataSalida["token"]=getToken($usuario, $ousuario );
				if($loginResp == 2){

					$dataSalida["login_status"]="RENEWPASS";
				}
			}else{
				$statuscode = 401;
				$statusmsg = ' Usuario o clave incorrectos';
			}
		}
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} );


$aplicacion->get('/usuario/all',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getAll();	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/usuario/img/{id_usuario}',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getImgPerfil($args['id_usuario']);	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

// obtener id usuario logeado
$aplicacion->get('/usuario/id/{usuario}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getByUserName($args['usuario']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

	// lista de usuarios libres
$aplicacion->get('/usuario/allfree',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getAllFree();	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

// crear un usuario
$aplicacion->post('/usuario',  function(Request $request, Response $response, $args) use ($aplicacion){
	$statuscode = 201;
	$statusmsg = 'Usuario creado';
	try{
		$usuario = $request->getParsedBodyParam("usuario", $default = "");
		$email = $request->getParsedBodyParam("email", $default = "");			
		$ousuario = new Usuario();
		$ousuario->crear($usuario,$email);			
		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);




// cambiar clave
$aplicacion->put('/usuario/clave',  function(Request $request, Response $response, $args) use ($aplicacion){
	$statuscode = 201;
	$statusmsg = 'Clave actualizada';
	try{			
		$clave = $request->getParsedBodyParam("clave", $default = "");
		$clave2 = $request->getParsedBodyParam("clave2", $default = "");			
		$ousuario = new Usuario();
		// acá usa $aplicacion->usuario porque es el usuario del token (sólo puede cambiar la clave de su propio usuario)

		$ousuario->updateClave($aplicacion->usuario,$clave,$clave2);			
		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
})->add($aplicacion->mw_verificarToken);

// desactivar usuario por usuario
$aplicacion->put('/usuario/desactivar/{usuario}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "usuario desactivado";		
	$statuscode = 200;	
	try{
		$ousuario = new Usuario();
		$ousuario->desactivar($args['usuario']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// activar usuario por usuario
$aplicacion->put('/usuario/activar/{usuario}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "usuario activado";		
	$statuscode = 200;	
	try{
		$ousuario = new Usuario();
		$ousuario->activar($args['usuario']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// cambio email por usuario
$aplicacion->put('/usuario/{usuario}/{email}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "Mail de usuario actualizado";		
	$statuscode = 200;	
	try{
		$ousuario = new Usuario();
		$ousuario->updateEmail($args['usuario'],$args['email']);
		$dataSalida = array();			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


// obtener usuario por id
$aplicacion->get('/usuario/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

// obtener ultimo usuario
$aplicacion->get('/usuario/ultimoid/id',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$ousuario = new Usuario();
		$dataSalida = $ousuario->getLastId();	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);



?>