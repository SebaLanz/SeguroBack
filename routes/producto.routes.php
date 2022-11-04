<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/producto.class.php';

$aplicacion->get('/producto/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		
		$objproducto = new Producto();
		$dataSalida = $objproducto->getProductosAll();

	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/producto/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objproducto = new Producto();
		$dataSalida = $objproducto->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);	


$aplicacion->post('/producto',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'producto creado';		
		try{
			// levanto los parámetros del body del request
			$id_producto = $request->getParsedBodyParam("id_producto", $default = "");
			$codigo_producto = $request->getParsedBodyParam("codigo_producto", $default = "");
			$producto = $request->getParsedBodyParam("producto", $default = "");
			$detalle = $request->getParsedBodyParam("detalle", $default = "");
			$id_rubro = $request->getParsedBodyParam("id_rubro", $default = "");
			
			$objproducto = new Producto();

			$objproducto->crear($id_producto,$codigo_producto,$producto,$detalle,$id_rubro);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/producto',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'producto actualizado';				 
		try{
			$id_producto = $request->getParsedBodyParam("id_producto", $default = "");
			// levanto los parámetros del body del request
			$producto = $request->getParsedBodyParam("producto", $default = "");
			$detalle = $request->getParsedBodyParam("detalle", $default = "");
			$id_rubro = $request->getParsedBodyParam("id_rubro", $default = "");

			$objproducto = new Producto();


			$objproducto->crear($id_producto,$codigo_producto,$producto,$detalle,$id_rubro);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage(); 
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	
   
$aplicacion->put('/producto/desactivar/{id_producto}', function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "producto desactivado";		
	$statuscode = 200;	
	try{
		$objproducto = new Producto();
		$objproducto->desactivar($args['id_producto']);
		$dataSalida = array();
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

?>