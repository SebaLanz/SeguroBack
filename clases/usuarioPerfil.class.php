<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("randomString.class.php");
require_once ("perfil.class.php");
require_once ("email.class.php");

class UsuarioPerfil extends BaseBiz
{


    public function getAll($id_usuario){
        try{
            $sqlStat = "SELECT u.id_usuario,u.usuario,u.email,u.activo,ifnull(p.perfil,pd.perfil) AS perfil 
                        from usuario u
                        LEFT JOIN perfil p ON u.id_perfil = p.id_perfil
                        LEFT JOIN perfil pd ON pd.esdefault = 1
                        WHERE u.id_usuario = $id_usuario";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }


    public function getById($id_usuario){
        try{
            $selectStat = "SELECT *
                           FROM usuario u
                           INNER JOIN usuario_perfil up ON u.id_usuario = up.id_usuario
                           WHERE u.id_usuario = $id_usuario";
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

    public function crear( $nombre, $apellido,$dni="", $calle="", $numero_calle = "",
                           $localidad="",$telefono="", $cod_provincia = null, $id_usuario=null){ 

        if(!empty($nombre) && !empty($apellido)){
            
            $insertFields = " INSERT INTO usuario_perfil( nombre, apellido ";
            $insertValues = " VALUES ('$nombre', '$apellido'";
            
            // campos no obligatorios
            if(!empty($dni)){
                $insertFields .= ",dni";
                $insertValues .= ",'$dni'";                
            }
            if(!empty($calle)){
                $insertFields .= ",calle";
                $insertValues .= ",'$calle'";                
            }
            if(!empty($numero_calle)){
                $insertFields .= ",numero_calle";
                $insertValues .= ",'$numero_calle'";                
            }
            if(!empty($localidad)){
                $insertFields .= ",localidad";
                $insertValues .= ",'$localidad'";                
            }
            if(!empty($telefono)){
                $insertFields .= ",telefono";
                $insertValues .= ",'$telefono'";                
            }
            if($cod_provincia!=null){
                $insertFields .= ",cod_provincia";
                $insertValues .= ",'$cod_provincia'";                
            }
            if($id_usuario!=null){
                $oUser = new Usuario();
                // usando usuario valido que exista el id
                try{
                    $oUser->getById($id_usuario);
                }catch (Exception $e){
                    throw new Exception(" El Id $id_usuario del usuario no está libre o no existe  ");
                }
                $insertFields .= ",id_usuario";
                $insertValues .= ",$id_usuario";                
            }
            $insertFields .= ")";
            $insertValues .= ")"; 
            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
        }else{
            throw new Exception(" El nombre y apellido son obligatorios para crear un perfil : ".$e->getMessage());  
        }
    }


    public function update( $id_usuario_perfil=0, $nombre, $apellido,$dni="", $calle="", $numero_calle = "",
                            $localidad="",$telefono="", $cod_provincia = null, $id_usuario=null){ 
     

        if(!empty($id_usuario_perfil)){
            $registrocliente = $this->getByid($id_usuario_perfil);
            
            $updateStat = " update usuario_perfil set ";
            $updateFields = "";
            $updateFilter = " where id_usuario = $id_usuario";

            // campos no obligatorios
            if(!empty($nombre)){
                if(!empty($updateFields)){
                   $updateFields .= ",";   
                }
                $updateFields .= " nombre ='$nombre'";             
            }
            if(!empty($apellido)){
                if(!empty($updateFields)){
                   $updateFields .= ",";   
                }
                $updateFields .= " apellido ='$apellido'";             
            }
            if(!empty($updateFields)){
                $updateFields .= ",";   
            }
            $updateFields .= " dni ='$dni'";
           
            $updateFields .= ", calle ='$calle'";
            
            $updateFields .= ", numero_calle ='$numero_calle'";

            $updateFields .= ", localidad ='$localidad'";

            $updateFields .= ", telefono ='$telefono'";
            
            if($cod_provincia!=null){
                $updateFields .= ", cod_provincia ='$cod_provincia'";
            }else{
                $updateFields .= ", cod_provincia = NULL ";
            }       
        
            $updateFields .= ", id_usuario = $id_usuario";
           
            $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
            throw new Exception(" El id_usuario_perfil es obligatorio para modificar un cliente : ".$e->getMessage());  
        }
    }

    public function updateImg($id_usuario=0,$imgPerfil){ 

        if(!empty($id_usuario)||!empty($imgPerfil)){
            
                $updateStat = " update usuario set ";
                $updateFields = "";
                $updateFilter = " where id_usuario = $id_usuario";

                $updateFields .= " imgPerfil ='$imgPerfil'";



            $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        
            }else{
            throw new Exception(" La ruta de la imagen es obligatoria: ".$e->getMessage());  
            }
    }

}
?>