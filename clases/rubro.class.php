<?php
require_once ("baseBiz.class.php");

class Rubro extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("select * from rubro");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo rubro : ".$e->getMessage());         
        }
    }

    public function getById($id_rubro){
        try{
            $selectStat = "select * from rubro where id_rubro = $id_rubro";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El rubro con id $id_rubro no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo rubro : ".$e->getMessage());         
        }
    }

    


   
 
    public function crear( $rubro, $sigla_rubro){ 

        if(!empty($rubro) && !empty($sigla_rubro) ) {
            
            $insertStat = " INSERT INTO rubro( rubro, sigla_rubro) VALUES ('$rubro', '$sigla_rubro')";            
            
            $this->noResultQuery( $insertStat); 
        }else{
            throw new Exception(" El nombre del rubro y la sigla son obligatorias para crear un rubro : ".$e->getMessage());  
        }
    }


    public function update( $id_rubro=0, $rubro){      

        if(!empty($id_rubro)){
            $registrorubro = $this->getByid($id_rubro);
            
            
            
            // campos no obligatorios
            if(!empty($rubro)){
                  $updateStat = " update rubro set rubro='$rubro' where id_rubro=$id_rubro";
                  $this->noResultQuery($updateStat.$updateFields.$updateFilter);      
            }else{
                throw new Exception(" El nombre del rubro es obligatorio para actualizar un rubro : ".$e->getMessage());  
            }
            
           
        }else{
             throw new Exception(" El id de rubro no existe : ");  
        }
    }

    public function delete($id_rubro){          
        try{            
            // valido que exista el id rubro

            $recrubro =  $this->getByid($id_rubro);
        
            // valido si el rubro ya lo usa algún producto
            $selectStat = "select id_producto from producto where id_rubro = $id_rubro limit 1";
            $resultado = $this->ResultQuery($selectStat);
            if(count( $resultado)==0){

                $this->iniciarTransaccion();
                // elimino el rubro
                $this->NoResultQuery("DELETE FROM rubro WHERE id_rubro = $id_rubro ");
                   
            }else{
                throw new Exception(" No puede eliminarse el rubro porque está siendo utilizado ");
            }


            
        }catch (Exception $e){
            throw new Exception(" Error eliminando rubro : ".$e->getMessage());         
        }
    }


    
    
    
   
}
?>