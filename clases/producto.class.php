<?php
require_once ("baseBiz.class.php");

class Producto extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("select * from producto");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el producto : ".$e->getMessage());         
        }
    }

    public function getById($id_producto){
        try{
            $selectStat = "select * from producto where id_producto = $id_producto";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El producto con id $id_producto no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo producto : ".$e->getMessage());         
        }
    }

   
   
}
?>