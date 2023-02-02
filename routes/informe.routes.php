<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/informe.class.php';

$aplicacion->get('/informe/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		
		$objInforme= new Informe();

		$dataSalida = $objInforme->getAll();


	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/informe/Me',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		
		$objInforme= new Informe();
		$dataSalida = $objInforme->getMe();


	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/informe/Mp',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		
		$objInforme= new Informe();
		$dataSalida = $objInforme->getMp();


	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/informe/Pe',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		
		$objInforme= new Informe();
		$dataSalida = $objInforme->getPe();


	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

//Dpe = Detalle producto elavorado.
$aplicacion->get('/informe/Dpe/{nro_stock}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objInforme= new Informe();
		$dataSalida = $objInforme->getMateriaDePE($args['nro_stock']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


//Muep = Materia utilizada en producto elavorado.
$aplicacion->get('/informe/Muep/{nro_stock}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objInforme= new Informe();
		$dataSalida = $objInforme->getMateriaUtilizadaEnPe($args['nro_stock']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);


//NPE = Nombre de producto terminado
$aplicacion->get('/informe/NPE/{nro_stock}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objInforme= new Informe();
		$dataSalida = $objInforme->getNombrePE($args['nro_stock']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

?>