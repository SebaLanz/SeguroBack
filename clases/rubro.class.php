<?php
require_once ("baseBiz.class.php");

//NO BORRAR
class Rubro extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("SELECT * FROM rubro");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo rubro : ".$e->getMessage());         
        }
    }

    public function getById($id_rubro){
        try{
            $selectStat = "SELECT * FROM rubro WHERE id_rubro = $id_rubro";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El rubro no existe ");
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
                  $updateStat = " UPDATE rubro SET rubro='$rubro' WHERE id_rubro=$id_rubro";
                  $this->noResultQuery($updateStat.$updateFields.$updateFilter);      
            }else{
                throw new Exception(" El nombre del rubro es obligatorio para actualizar un rubro : ".$e->getMessage());  
            }
            
           
        }else{
             throw new Exception(" El id de rubro no existe : ");  
        }
    }

    
    public function activar($id_rubro){
            $this->updateEstado($id_rubro,1);
        }

    public function desactivar($id_rubro){
        $this->updateEstado($id_rubro,0);
    }

    private function updateEstado($id_rubro,$estado){
        try{
            $registroRubro = $this->getById($id_rubro);                      
            $updStat = "UPDATE rubro SET activo=$estado WHERE id_rubro='$id_rubro'";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" No se pudo modificar el estado del rubro. : ".$e->getMessage());         
        }
    }


    
    
    
   
}
?>