<?php
header("Access-Control-Allow-Origin: *"); // permite que la api se consuma desde cualquier url
header('Access-Control-Allow-Credentials: true'); // permite uso de credenciales o cabeceras invisibles (para autenticar)
header('Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS'); // metodos que se pueden usar en la api
header("Access-Control-Allow-Headers: X-Requested-With"); // permitimos cnsultar las cabeceras de los request
header('Content-Type: aplication/json; charset=utf-8'); // codificación latina
header('P3P: CP="IDC DSP COR CURa ADMa OUR IND PHY ONL COM STA"'); // cualquier tipo de navegador web o cliente pueda acceder al API via P3P (protocolo de privacidad de datos standard)

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;


require_once 'vendor/autoload.php';

require_once 'config/constantes.php';

require_once 'funciones.api.php';


error_reporting(0);
//$config = ["settings" => ["displayErrorDetails" => true]];
$aplicacion =  new \Slim\App();
$aplicacion->usuario = "";
// middleware de validación de token, se puede aplicar a cualquier método api
$aplicacion->mw_verificarToken = function ($request, $response, $next) use ($aplicacion){    
	// obtengo los request headers 	
	$headers = apache_request_headers(); 	   
	// verifico que tenga el Authorization Header
	if (isset($headers['Authorization'])) {		
		// obtengo el token que me mandan
		$token = substr($headers['Authorization'],7);		
		// valida el token
		if (!(validarToken($token, $request))) { 			
			$response = getResponse($response, 401, array(), " No autorizado ");
		} else {
			//procede utilizar el recurso o metodo del llamado		
			$aplicacion->usuario = getUserToken($token);
			$response = $next($request, $response);			
		}
	} else {
		// no validó token	
		$response = getResponse($response, 400, array(), " Falta token de autorización ");		
	}
    return $response;
};

require_once 'routes/usuario.routes.php'; // endpoints de usuario
require_once 'routes/cliente.routes.php'; // endpoints de empleado
require_once 'routes/misc.routes.php'; // endpoints de miscelaneas
require_once 'routes/rubro.routes.php'; // endpoints de rubro
require_once 'routes/estado.routes.php'; // endpoints de estado
require_once 'routes/proveedor.routes.php'; // endpoints de proveedor
require_once 'routes/informe.routes.php'; // endpoints de informe.
require_once 'routes/automovil.routes.php'; // endpoints de automovil.
require_once 'routes/plan.routes.php'; // endpoints de plan.
require_once 'routes/plan_pago.routes.php'; // endpoints de pagos.
require_once 'routes/medio_de_pago.routes.php'; // endpoints de pagos.
require_once 'routes/usuarioPerfil.routes.php'; // endpoints de usuarioPerfil.








$aplicacion->run();




?>