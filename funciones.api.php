<?php

/////////////////// funciones comunes de la api de la capa rest
function getResponse($resp, $status_code, $dataRespuesta, $status_msg = "") {

	$respData = getDataToResponse($status_code, $dataRespuesta, $status_msg);	
	$r=$resp->withStatus($status_code);
	$r->getBody()->write(json_encode($respData));
	return $r->withHeader('Content-Type', 'application/json');
}

function getDataToResponse($status_code, $dataRespuesta, $status_msg){
	$respuesta["http_status_code"]=$status_code;
	$respuesta["status_msg"]=$status_msg;
	$respuesta["data"]=$dataRespuesta;
	return $respuesta;
}

//// genera un token de acceso usando jwt //////////////////////////////////////////////////
function getToken($cUsuario, $ousuario){	
	$ojwt = new Firebase\JWT\JWT();
	
	$time = time();	
	$aAccesos = getAccesos($cUsuario, $ousuario);
	
	//echo $aAccesos[0];	
	$token = array(
	    'iat' => $time, // Tiempo que inició el token
	    'exp' => $time + (60*60*10), // Tiempo que expirará el token (+10 horas)
	    'aud' => getdataAud(),
	    'data' => array('user' => $cUsuario, 'aclr' => $aAccesos)	    
	);
	
	$strjwt = $ojwt->encode($token, CONFIG_API_KEY);
	return $strjwt;

}

// obtiene y devuelve los accesos de un usuario a las rutas de la api
function getAccesos($cUsuario, $oUsuario){	
	//$oUsuario = new Usuario();
	$accesosUsuario = $oUsuario->getAccesos($cUsuario);
	$rutasAcceso = array();
    for ($i=0; $i < count($accesosUsuario); $i++) { 
        $rutasAcceso[$i] = $accesosUsuario[$i]["regular_exp"];
    }
	return $rutasAcceso;
}
/// genera datos duros de jwt para validación //////////////////////////////////////////////////////////////
function getdataAud() {
        $aud = '';        
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $aud = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $aud = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $aud = $_SERVER['REMOTE_ADDR'];
        }
        
        $aud .= @$_SERVER['HTTP_USER_AGENT'];
        $aud .= gethostname();
        
        return sha1($aud);
 }


 /// se fija si un token es válido o no devuelve true o false//////////////////////////////////
function validarToken($token, $request) {
	$lokToken = true;
	try{
	    if (!empty($token)){
	       $decode = getTokenDedoded($token);
	       if(!isset($decode->aud) || $decode->aud !== getdataAud()){	       		
	       		$lokToken = false;
	     	}else{
	     		// obtener los accesos del token
	       		$accesos = getAccesosToken($token);
	       		$ruta = $request->getUri()->getPath();
	       		$metodo = $request->getMethod();
	       		//var_dump($accesos);
	       		//echo $ruta;
	       		$lokToken = validarAccesoRuta($metodo."/".$ruta,$accesos);
	     	}
	    }else{
	    	$lokToken = false;
	    }   
    } catch ( Exception $e) {
    	 $lokToken = false ;
    }
  	return $lokToken;
}


// devuelve el nombre de usuariuo al que pertenece un token /////////
function getUserToken($token){
	$cUser = '';	
	if (!empty($token)){
		
		$decode = getTokenDedoded($token);
		//var_dump($decode);
		if(isset($decode->data->user) ){
				//echo $decode->data;
	       		$cUser = $decode->data->user;
		}else{
			$cUser =$token;
		}
	}
	
	return $cUser;
}

// devuelve el array de rutas a las que puede acceder un token
function getAccesosToken($token){
	$rutas = array();	
	if (!empty($token)){
		
		$decode = getTokenDedoded($token);
		//var_dump($decode);
		if(isset($decode->data->aclr) ){
				//echo $decode->data;
	       		$rutas = $decode->data->aclr;
		}
	}
	
	return $rutas;
}

// obtiene el objeto decodeado del token jwt
function getTokenDedoded($token){	
	$ojwt = new Firebase\JWT\JWT();
	$decodedToken = $ojwt->decode($token,CONFIG_API_KEY,array('HS256') );	
	return $decodedToken;
}

// valida que la ruta a la que se accede esté dentro de los permisos del usuario
function validarAccesoRuta($ruta,$accesos){

	$okacceso = false; 
	
	 foreach($accesos as $acceso){  				
		 if(preg_match($acceso,$ruta)==1){     
		 	$okacceso = true;
		    break;
		 }
	  }
	
  
	return $okacceso;  
}

?>