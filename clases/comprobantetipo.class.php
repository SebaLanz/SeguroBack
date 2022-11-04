<?php
require_once ("baseBiz.class.php");

class ComprobanteTipo extends BaseBiz{   

    public function getAll(){
        try{
            $sqlStat = "SELECT * FROM comprobante_tipo";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo comprobantes : ".$e->getMessage());         
        }
    }

    public function getById($id_comprobante_tipo){
        try{
            $selectStat = "select * from comprobante_tipo where id_comprobante_tipo = $id_comprobante_tipo";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El tipo de comprobante con id $id_comprobante_tipo no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo tipo de comprobante : ".$e->getMessage());         
        }
    }


}
?>