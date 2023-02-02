<?php
require_once ("baseBiz.class.php");
require_once ("usuario.class.php");

class Cliente extends BaseBiz{   

    // no lo uso x ahora
    /*public function getAll($id_usuario){
        try{
            $sqlStat = "SELECT e.id_empleado,e.nombre,e.dni,
                                e.apellido,e.dni,e.calle,e.numero_calle,
                                e.localidad,p.provincia,
                                e.email,ifnull(e.id_usuario,0) as id_usuario, e.activo
                        from cliente e
                        left JOIN provincia p ON e.cod_provincia = p.cod_provincia
                        WHERE e.id_usuario = $id_usuario";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo clientes : ".$e->getMessage());         
        }
    }*/

    //select by id de la tabla cliente
    public function getById($id_empleado){
        try{
            $selectStat = "select * from cliente where id_empleado = $id_empleado";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El cliente con id $id_empleado no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo cliente : ".$e->getMessage());         
        }
    }

    //select all con filtro, TODOS LOS USUARIOS RELACIONADOS AL USUARIO LOGEADO.
    public function getAllByUserLog($id_usuario){
        try{
            $sqlStat = "SELECT * 
                        FROM usuario u
                        inner JOIN cliente cli ON u.id_usuario = u.id_usuario
                        left JOIN provincia p ON cli.cod_provincia = p.cod_provincia
                        WHERE cli.id_usuario = $id_usuario
                        GROUP BY cli.id_empleado";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo clientes : ".$e->getMessage());         
        }
    }

 
    public function crear( $nombre, $apellido,$dni="" ,$email="", $calle="", $numero_calle = "",
                           $localidad="", $cod_provincia = null, $id_usuario=null){ 

        if(!empty($nombre) && !empty($apellido)){
            
            $insertFields = " INSERT INTO cliente( nombre, apellido ";
            $insertValues = " VALUES ('$nombre', '$apellido'";
            
            // campos no obligatorios
            if(!empty($dni)){
                $insertFields .= ",dni";
                $insertValues .= ",'$dni'";                
            }
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
                /*$oUser = new Usuario();
                // usando usuario valido que exista el id
                try{
                    $oUser->getByIdFree($id_usuario);
                }catch (Exception $e){
                    throw new Exception(" El Id $id_usuario del cliente no está libre o no existe  ");
                }*/
                $insertFields .= ",id_usuario";
                $insertValues .= ",$id_usuario";                
            }
            $insertFields .= ")";
            $insertValues .= ")"; 
            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
        }else{
            throw new Exception(" El nombre y apellido son obligatorios para crear un cliente : ".$e->getMessage());  
        }
    }


public function update( $id_empleado=0, $nombre, $apellido, $email="", $calle="", $numero_calle, $localidad="",  $cod_provincia = null, $id_usuario=null){ 
     

        if(!empty($id_empleado)){
            $registrocliente = $this->getByid($id_empleado);
            
            $updateStat = " update cliente set ";
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
                if($registrocliente[0]["id_usuario"]!=$id_usuario){
                    // le está cambiando el usuario al cliente                    

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
            throw new Exception(" El id_empleado es obligatorio para modificar un cliente : ".$e->getMessage());  
        }
    }

    public function delete($id_empleado){       
        
        try{       
            $this->getByid($id_empleado);// valida que exista                                  
            $this->NoResultQuery("DELETE FROM cliente WHERE id_empleado = $id_empleado ");              
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando cliente : ".$e->getMessage());         
        }
    }

    // empiezo las funciones para activar y desactivar

    public function activar($id_cliente){
        $this->updateEstado($id_cliente,1);
    }

    public function desActivar($id_cliente){
        $this->updateEstado($id_cliente,0);
    }

    private function updateEstado($id_cliente,$estado){
        try{
            $registroCliente = $this->getById($id_cliente);                      
            $updStat = "update cliente c set c.activo=$estado where c.id_empleado = $id_cliente";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" Error Dando de baja al Cliente: ".$e->getMessage());         
        }
    }


}
?>