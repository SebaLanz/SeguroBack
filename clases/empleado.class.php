<?php
require_once ("baseBiz.class.php");
require_once ("usuario.class.php");

class Empleado extends BaseBiz{   

    public function getAll(){
        try{
            $sqlStat = "SELECT e.id_empleado,e.nombre,
                        e.apellido,e.calle,e.numero_calle,
                        e.localidad,ifnull(p.provincia,'') AS provincia,
                        e.email,ifnull(e.id_usuario,0) as id_usuario
                        from empleado e
                        left JOIN provincia p ON e.cod_provincia = p.cod_provincia";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo empleados : ".$e->getMessage());         
        }
    }

    public function getById($id_empleado){
        try{
            $selectStat = "select * from empleado where id_empleado = $id_empleado";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El empleado con id $id_empleado no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo empleado : ".$e->getMessage());         
        }
    }

 
    public function crear( $nombre, $apellido, $email="", $calle="", $numero_calle = "",
                           $localidad="", $cod_provincia = null, $id_usuario=null){ 

        if(!empty($nombre) && !empty($apellido)){
            
            $insertFields = " INSERT INTO empleado( nombre, apellido ";
            $insertValues = " VALUES ('$nombre', '$apellido'";
            
            // campos no obligatorios
            if(!empty($email)){
                $insertFields .= ",email";
                $insertValues .= ",'$email'";                
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
            if($cod_provincia!=null){
                $insertFields .= ",cod_provincia";
                $insertValues .= ",'$cod_provincia'";                
            }
            if($id_usuario!=null){
                $oUser = new Usuario();
                // usando usuario valido que exista el id
                try{
                    $oUser->getByIdFree($id_usuario);
                }catch (Exception $e){
                    throw new Exception(" El Id de usuario no está libre o no existe  ");
                }
                $insertFields .= ",id_usuario";
                $insertValues .= ",$id_usuario";                
            }
            $insertFields .= ")";
            $insertValues .= ")"; 
            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
        }else{
            throw new Exception(" El nombre y apellido son obligatorios para crear un empleado : ".$e->getMessage());  
        }
    }


public function update( $id_empleado=0, $nombre, $apellido, $email="", $calle="", $numero_calle, $localidad="",  $cod_provincia = null, $id_usuario=null){ 
     

        if(!empty($id_empleado)){
            $registroEmpleado = $this->getByid($id_empleado);
            
            $updateStat = " update empleado set ";
            $updateFields = "";
            $updateFilter = " where id_empleado = $id_empleado";

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
            $updateFields .= " email ='$email'";
           
            $updateFields .= ", calle ='$calle'";
            
            $updateFields .= ", numero_calle ='$numero_calle'";
            
            if($cod_provincia!=null){
                $updateFields .= ", cod_provincia ='$cod_provincia'";
            }else{
                $updateFields .= ", cod_provincia = NULL ";
            }
           
            $updateFields .= ", localidad ='$localidad'";

            if($id_usuario!=null){
                if($registroEmpleado[0]["id_usuario"]!=$id_usuario){
                    // le está cambiando el usuario al empleado                    

                    $oUser = new Usuario();
                    throw new Exception(" hice new user  ");
                    // usando usuario valido que exista el id
                    try{
                        $oUser->getByIdFree($id_usuario);
                    }catch (Exception $e){
                        throw new Exception(" El Id de usuario no está libre o no existe  ");
                    }
                }
                $updateFields .= ", id_usuario = $id_usuario";
            }else{
                $updateFields .= ", id_usuario = NULL ";
            }
            $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
            throw new Exception(" El id_empleado es obligatorio para modificar un empleado : ".$e->getMessage());  
        }
    }

    public function delete($id_empleado){       
        
        try{       
            $this->getByid($id_empleado);// valida que exista                                  
            $this->NoResultQuery("DELETE FROM empleado WHERE id_empleado = $id_empleado ");              
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando empleado : ".$e->getMessage());         
        }
    }


}
?>