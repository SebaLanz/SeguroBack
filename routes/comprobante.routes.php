<?php
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

require_once 'clases/comprobante.class.php';
require_once 'clases/comprobantetipo.class.php';

$aplicacion->get('/comprobante/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;
	try{
		$objComprobante = new Comprobante();
		$dataSalida = $objComprobante->getAll();			
	}catch (Exception $e){
		$statuscode = 500;	
		$statusmsg = 'Error :'.$e->getMessage();			
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);
} )->add($aplicacion->mw_verificarToken);

$aplicacion->get('/comprobante/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
	$dataSalida = array();
	$statusmsg = "ok";		
	$statuscode = 200;	
	try{
		$objComprobante = new Comprobante();
		$dataSalida = $objComprobante->getById($args['id']);			
	}catch (Exception $e){
		$statuscode = 500;		
		$statusmsg = 'Error :'.$e->getMessage();
	}
	return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
} )->add($aplicacion->mw_verificarToken);

$aplicacion->post('/comprobante',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'Comprobante creado';		
		try{
			// levanto los parámetros del body del request
			$id_comprobante_tipo = $request->getParsedBodyParam("id_comprobante_tipo", $default = "");
			$fecha = $request->getParsedBodyParam("fecha", $default = "");
			$fecha_ingreso = $request->getParsedBodyParam("fecha_ingreso", $default = "");
			$nro_comprobante = $request->getParsedBodyParam("nro_comprobante", $default = "");	
			$id_proveedor = $request->getParsedBodyParam("id_proveedor", $default = "");	

			$objComprobante = new Comprobante();

			$objComprobante->crear( $id_comprobante_tipo, $fecha, $fecha_ingreso, $nro_comprobante,
                           			$id_proveedor);	

			$dataSalida = array();
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();			
		}
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

$aplicacion->put('/comprobante',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'comprobante actualizado';				 
		try{
			$id = $request->getParsedBodyParam("id_comprobante", $default = 0);
			// levanto los parámetros del body del request
			$id_comprobante_tipo = $request->getParsedBodyParam("id_comprobante_tipo", $default = "");
			$fecha = $request->getParsedBodyParam("fecha", $default = "");
			$fecha_ingreso = $request->getParsedBodyParam("fecha_ingreso", $default = "");
			$nro_comprobante = $request->getParsedBodyParam("nro_comprobante", $default = "");	
			$id_proveedor = $request->getParsedBodyParam("id_proveedor", $default = "");

			$objComprobante = new Comprobante();

			$objComprobante->update($id, $id_comprobante_tipo, $fecha, $fecha_ingreso, $nro_comprobante,
                                     $id_proveedor);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);

	$aplicacion->delete('/comprobante/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
		$dataSalida = array();
		$statuscode = 201;
		$statusmsg = 'comprobante borrado';				 
		try{
			$id = $args['id'];
			// levanto los parámetros del body del request		

			$objComprobante = new Comprobante();

			$objComprobante->delete($id);
			 
			$dataSalida = array();
			
		}catch (Exception $e){
			$statuscode = 500;
			$statusmsg = 'Error :'.$e->getMessage();
		}			
		return getResponse($response, $statuscode, $dataSalida, $statusmsg);
	})->add($aplicacion->mw_verificarToken);



    $aplicacion->get('/comprobantetipo/all',  function(Request $request, Response $response, $args) use ($aplicacion){	
        $dataSalida = array();
        $statusmsg = "ok";		
        $statuscode = 200;
        try{
            $objComprobanteTipo = new ComprobanteTipo();
            $dataSalida = $objComprobanteTipo->getAll();			
        }catch (Exception $e){
            $statuscode = 500;	
            $statusmsg = 'Error :'.$e->getMessage();			
        }
        return getResponse($response, $statuscode, $dataSalida, $statusmsg);
    } )->add($aplicacion->mw_verificarToken);
    
    $aplicacion->get('/comprobantetipo/{id}',  function(Request $request, Response $response, $args) use ($aplicacion){
        $dataSalida = array();
        $statusmsg = "ok";		
        $statuscode = 200;	
        try{
            $objComprobanteTipo = new ComprobanteTipo();
            $dataSalida = $objComprobanteTipo->getById($args['id']);			
        }catch (Exception $e){
            $statuscode = 500;		
            $statusmsg = 'Error :'.$e->getMessage();
        }
        return getResponse($response, $statuscode, $dataSalida, $statusmsg);	
    } )->add($aplicacion->mw_verificarToken);	
   

?>