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
		$dataSalida = $objproducto->getAll();

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
			$producto = $request->getParsedBodyParam("producto", $default = "");
			$sigla_producto = $request->getParsedBodyParam("sigla_producto", $default = "");
			$objproducto = new Producto();

			$objproducto->crear($producto, $sigla_producto );	

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
			$id = $request->getParsedBodyParam("id_producto", $default = 0);
			// levanto los parámetros del body del request
			$producto = $request->getParsedBodyParam("producto", $default = "");
			

			$objproducto = new Producto();

			$objproducto->update($id, $producto );
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/producto/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'producto actualizado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objproducto = new Producto();

			$objproducto->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);
   

?>