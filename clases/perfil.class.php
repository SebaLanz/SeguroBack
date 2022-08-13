<?php
require_once ("baseBiz.class.php");
require_once ("ruta.class.php");

class perfil extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("select * from perfil");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo perfil : ".$e->getMessage());         
        }
    }

    public function getById($id_perfil){
        try{
            $selectStat = "select * from perfil where id_perfil = $id_perfil";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El perfil con id $id_perfil no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo perfil : ".$e->getMessage());         
        }
    }

    public function getDefault(){
        try{
            $selectStat = "select * from perfil where esdefault = 1";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" Falta definir un perfil por defecto para usuarios ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo perfil : ".$e->getMessage());         
        }
    }


    // devuelve los accesos a rutas de un perfil dado
    public function getAccesosById($id_perfil){
        try{       
            //eturn $id_perfil;     
            $resultado = $this->getById($id_perfil); 
            $selectStat = " SELECT pf.id_perfil, pf.id_ruta,r.ruta,r.regular_exp,r.descripcion
                            FROM perfil_acceso pf
                            INNER JOIN ruta r ON pf.id_ruta = r.id_ruta
                            WHERE id_perfil = $id_perfil";
            $resultado = $this->ResultQuery($selectStat);
            $oRuta = new Ruta();
            $rutasForAll =  $oRuta->getRutasForAll();
            for ($i=0; $i < count($rutasForAll) ; $i++) { 
                 $rutasForAll[$i]["id_perfil"] = $id_perfil;
                 $resultado[]=$rutasForAll[$i];
            }
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo perfil : ".$e->getMessage());         
        }
    }

   
 
    public function crear( $perfil ){ 

        if(!empty($perfil)) {
            
            $insertStat = " INSERT INTO perfil( perfil) VALUES ('$perfil')";            
            
            $this->noResultQuery( $insertStat); 
        }else{
            throw new Exception(" El nombre del perfil es obligatorio para crear un perfil : ".$e->getMessage());  
        }
    }


    public function update( $id_perfil=0, $perfil){      

        if(!empty($id_perfil)){
            $registroperfil = $this->getByid($id_perfil);
            
            $updateStat = " update perfil set perfil='$perfil'";
            
            // campos no obligatorios
            if(!empty($perfil)){
                      
            }else{
                throw new Exception(" El nombre del perfil es obligatorio para actualizar un perfil : ".$e->getMessage());  
            }
            
            $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
            throw new Exception(" El id_perfil es obligatorio para modificar un perfil : ".$e->getMessage());  
        }
    }

    public function delete($id_perfil){          
        try{            
            $oUsuario = new Usuario();
            // valido si el perfil ya lo usa algún usuario
            $recUsuario = $oUsuario->getByIdPerfil($id_perfil);  
            if(count($recUsuario) == 0){
                $this->iniciarTransaccion();
                $this->getByid($id_perfil);// valida que exista
                try{
                    // elimino los accesos del perfil
                    $this->deleteAccesosByIdPerfil($id_perfil);
                    // elimino el perfil
                    $this->NoResultQuery("DELETE FROM perfil WHERE id_perfil = $id_perfil ");
                    $this->commitTransaccion();
                }catch (Exception $e){
                    $this->rollBackTransaccion();
                    throw new Exception($e->getMessage());         
                }
            }else{
                 throw new Exception(" No puede eliminarse el perfil porque está siendo utilizado ");
            }
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando perfil : ".$e->getMessage());         
        }
    }


    public function deleteAccesosByIdPerfil($id_perfil){          
        try{    
            // elimino los accesos del perfil
            $this->NoResultQuery("DELETE FROM perfil_acceso WHERE id_perfil = $id_perfil ");            
        }catch (Exception $e){
            throw new Exception(" Error eliminando perfil : ".$e->getMessage());         
        }
    }

    public function updateAccesosByIdPerfil($id_perfil, $accesos){          
        try{            
      
                $this->iniciarTransaccion();
                $this->getByid($id_perfil);// valida que exista
                try{
                    // elimino los accesos del perfil
                    $this->deleteAccesosByIdPerfil($id_perfil);
                    // creo los nuevos accesos
                    for ($i=0; $i < count($acceso) ; $i++) { 
                        $this->crearAcceso($id_perfil,$acceso[$i]["id_ruta"]);
                    }
                    $this->commitTransaccion();
                }catch (Exception $e){
                    $this->rollBackTransaccion();
                    throw new Exception($e->getMessage());         
                }
            
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando perfil : ".$e->getMessage());         
        }
    }
    
    public function crearAcceso( $id_perfil, $id_ruta ){ 

        if(!empty($perfil)) {
            
            $insertStat = " INSERT INTO perfil_acceso(id_perfil,id_ruta) VALUES ('$id_perfil, $id_ruta)";            
            
            $this->noResultQuery( $insertStat); 
        }else{
            throw new Exception(" Error creando el acceso al perfil : ".$e->getMessage());  
        }
    }

}
?>