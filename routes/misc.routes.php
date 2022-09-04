<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/geodata.class.php';   


$aplicacion->get('/misc/provincia/all',  function(Request $request, Response $response, array $args) use ($aplicacion){
	$statuscode = 200;
	$statusmsg = 'ok';
	try{			
		$ogeodata = new Geodata();
		$dataSalida = $ogeodata->getAllProvincia();	
	}catch (Exception $e){
		$statuscode = 500;
		$statusmsg = 'Error :'.$e->getMessage();
		$dataSalida = array();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

	

   	


?>