<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("randomString.class.php");
require_once ("perfil.class.php");
require_once ("email.class.php");

class Usuario extends BaseBiz
{

    public function crearFull($usuario,$clave,$clave2,$email){
        try{
            if(empty($usuario) || empty($clave) || empty($clave2) || empty($email) ){
                 throw new Exception("Faltan datos necesarios para crear un usuario "); 
            }
            if ($clave != $clave2){
                 throw new Exception(" No coincide la verificación de clave "); 
            }
            if(!Email::is_valid_email($email)){
                throw new Exception(" La dirección de mail $email no es válida "); 
            }            
            $resultado = $this->ResultQuery("select * from usuario where usuario = '$usuario'");
            if(count($resultado) == 0){  
                    $oPerfil = new Perfil();
                    $perfilDefRegistro =  $oPerfil->getDefault();                       
                    $hashedClave = Cripto::getHash($clave);
                    $insertStat = "INSERT INTO usuario(usuario,clave,email,id_perfil)";
                    $id_perfil = $perfilDefRegistro[0]["id_perfil"];
                    $insertStat .= "VALUES('$usuario','$hashedClave','$email',$id_perfil)";
                    $this->noResultQuery($insertStat);  
                             
            }else{
              throw new Exception(" El nombre de usuario ". $usuario ." ya existe");
            } 
        }catch (Exception $e){
            throw new Exception(" Error creando usuario :".$e->getMessage());         
        }
    }

    public function crear($usuario,$email){
        try{
            if(empty($usuario) || empty($email) ){
                 throw new Exception("Faltan datos necesarios para crear un usuario "); 
            }  
            
            if(!Email::is_valid_email($email)){
                throw new Exception(" La dirección de mail $email no es válida "); 
            }

            $resultado = $this->ResultQuery("select * from usuario where usuario = '$usuario'");
            if(count($resultado) == 0){  
                    $oPerfil = new Perfil();
                    $perfilDefRegistro =  $oPerfil->getDefault(); 
                    $id_perfil = $perfilDefRegistro[0]["id_perfil"];
                    
                    $clave = RandomString::generate_string();
                    $hashedClave = Cripto::getHash($clave);

                    $insertStat = "INSERT INTO usuario(usuario,clave,email,cambiar_pass,id_perfil)";
                    $insertStat .= "VALUES('$usuario','$hashedClave','$email',1,$id_perfil)";
                    $this->noResultQuery($insertStat);  
                    // enviar mail al usuario con la clave
                    $mensaje = "Hola <b>".$usuario."</b>!<br>";
                    $mensaje .= "Tu cuenta de pTrack fue creada !<br>";
                    $mensaje .= "Ingresa con tu contraseña : ".$clave."<br>";
                    $mensaje .= "El sistema te pedirá que la cambies<br>";
                    if (!Email::sendMail("pTrakNoReply",$email,"Su cuenta de pTrak",$mensaje)){
                        throw new Exception(" No pudo enviarse el mail de bienvenida al usuario ");
                    }
                             
            }else{
              throw new Exception(" El nombre de usuario ". $usuario ." ya existe");
            } 
        }catch (Exception $e){
            throw new Exception(" Error creando usuario :".$e->getMessage());         
        }
    }

    public function login($usuario,$clave){
        try{
            $loginStatus = 0;// estado para cuando no valida las credenciales
            $hashedClave = Cripto::getHash($clave);
            $loginStat = "select * from usuario where usuario = '".$usuario."' and clave ='$hashedClave' and activo = 1";
            $registroUsuario = $this->resultQuery($loginStat);
            if(count($registroUsuario) > 0){    
                if($registroUsuario[0]["cambiar_pass"]==1){
                    $loginStatus = 2; // tiene que cambiar el password
                }else{
                    $loginStatus = 1; // está ok
                }
                
            }
            return $loginStatus;
        }catch (Exception $e){
            throw new Exception(" Error verificando usuario ".$e->getMessage());         
        }
    }


    public function getAll(){
        try{
            $sqlStat = "SELECT u.id_usuario,u.usuario,u.email,u.activo,ifnull(p.perfil,pd.perfil) AS perfil from usuario u
                    LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                    LEFT JOIN perfil pd ON pd.esdefault = 1";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuarios : ".$e->getMessage());         
        }
    }

    public function getAllFree(){
        try{
            $resultado = $this->resultQuery("select * from usuario where id_usuario not in(select id_usuario from empleado WHERE !isnull(id_usuario))");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuarios libres : ".$e->getMessage());         
        }
    }

    public function getById($id_usuario){
        try{
            $selectStat = "select * from usuario where id_usuario = $id_usuario";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El usuario con id_usuario $id_usuario no existe ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }


    public function getByIdPerfil($id_perfil){
        try{
            $selectStat = "select * from usuario where id_perfil = $id_perfil";
            $resultado = $this->resultQuery($selectStat);
            return  $resultado;            
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }

    public function getByIdFree($id_usuario){
        try{
            $selectStat = "select * from usuario where id_usuario = $id_usuario and id_usuario not in(select id_usuario from empleado WHERE !isnull(id_usuario))";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El usuario con id_usuario $id_usuario no existe ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }

    public function getByUserName($usuario){
        try{            
            $selectStatement = " select * from usuario where usuario = '$usuario' ";

            $resultado = $this->resultQuery($selectStatement);            
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El usuario usuario no existe ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }


    public function getByEmail($email){
        try{
            $selectStat = "select * from usuario where email = '$email'";
            $resultado = $this->resultQuery($selectStat);
                         
            return  $resultado;
            
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario por mail : ".$e->getMessage());         
        }
    }

    // actualiza todos los datos del usuario según lo que reciba
    public function update($usuario,$clave1 = "",$clave2 = "",$email = "" ,$id_perfil=null){
        try{
            $this->iniciarTransaccion();
            $registroUsuario = $this->getByUserName($usuario); // con esto valida que exista 
            if(!empty($clave1)){     
                $this->updateClave($usuario,$clave1,$clave2);                 
            }
            if(!empty($email)){     
                $this->updateEmail($usuario,$email);                 
            }
            if($id_perfil!=null){     
                $this->updatePerfil($usuario,$id_perfil);                
            }
            $this->commitTransaccion();
        }catch (Exception $e){
            $this->rollBackTransaccion();
            throw new Exception(" Error actualizando usuario : ".$e->getMessage());         
        }
    }

    public function updateClave($usuario,$clave1,$clave2){
        try{

            if($clave1 == $clave2){     
                $registroUsuario = $this->getByUserName($usuario);                
                $hashedClave = Cripto::getHash($clave1);           
                $updStat = "update usuario set clave='$hashedClave',cambiar_pass = 0 where usuario = '$usuario'";
                $this->noResultQuery($updStat);
            }else{
                throw new Exception(" No coincide la verificación de clave ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error actualizando usuario : ".$e->getMessage());         
        }
    }


    public function updateEmail($usuario,$email){
        try{

            if(!empty($email)){ 
                if(!Email::is_valid_email($email)){
                    throw new Exception(" La dirección de mail $email no es válida "); 
                }    
                $registroUsuario = $this->getByUserName($usuario);
                $registroEmailUsuario = $this->getByEmail($email);
                if(count($registroEmailUsuario)>0 && $registroEmailUsuario[0]["usuario"] != $usuario){
                    throw new Exception(" el email ya existe para otro usuario ");
                }
                $updStat = "update usuario set email='$email' where usuario = '$usuario'";
                $this->noResultQuery($updStat);
            }else{
                throw new Exception(" Email no puede ser vacío ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error actualizando usuario : ".$e->getMessage());         
        }
    }

    public function updatePerfil($usuario,$id_perfil){
        try{                
                $registroUsuario = $this->getByUserName($usuario); 
                $oPerfil = new Perfil();
                $oPerfil->getByid($id_perfil) ;// valida que exista el perfil       
                $updStat = "update usuario set id_perfil='$id_perfil' where usuario = '$usuario'";
                $this->noResultQuery($updStat);           
        }catch (Exception $e){
            throw new Exception(" Error actualizando usuario : ".$e->getMessage());         
        }
    }

    public function activar($usuario){
        $this->updateEstado($usuario,1);
    }

    public function desActivar($usuario){
        $this->updateEstado($usuario,0);
    }

    private function updateEstado($usuario,$estado){
        try{
            $registroUsuario = $this->getByUserName($usuario);                      
            $updStat = "update usuario set activo=$estado where usuario = '$usuario'";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" Error actualizando email de usuario : ".$e->getMessage());         
        }
    }


    public function getAccesos($usuario){
        try{
            $registroUsuario = $this->getByUserName($usuario);  
            //return $registroUsuario[0]["id_perfil"];
            $oPerfil = new Perfil();
            $accesosUsuario = $oPerfil->getAccesosById($registroUsuario[0]["id_perfil"]);            
        return $accesosUsuario;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo accesos de usuario : ".$e->getMessage());         
        }
    }

}
?>