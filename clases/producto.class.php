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
public function save($id_producto = 0, $producto, $detalle ){       

        if(empty($producto)) {
             throw new Exception("::Error, debe indicar al menos  el nombre del producto para esta operación ");
        }
        try{
            if($id_producto != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM producto WHERE id_producto = $id_producto ";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla
                    $updateStat = "update producto set ";
                    $updateStat .= "producto ='$producto',";
                    $updateStat .= "detalle = $detalle',";
                    
                    $this->NoResultQuery($updateStat);
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El producto con id $id_producto no existe ");
                } 
            }else{
                // hago el insert
                $insertStat = "INSERT INTO producto (producto,detalle,codigo_producto) VALUES(";
                $insertStat .= "'$producto','$detalle',";
                $insertStat .= " $codigo_producto)";
                $this->NoResultQuery($insertStat);
            }
        }catch (Exception $e){
            throw new Exception("::Error obteniendo producto  ".$e->getMessage());         
        }
    }
   public function delete($id_producto){          
        try{            

            $recproducto =  $this->getByid($id_producto);

            $selectStat = "select id_producto from producto where id_producto = $id_producto";
            $resultado = $this->ResultQuery($selectStat);
            if(count( $resultado)==0){

                $this->iniciarTransaccion();
                
                $this->NoResultQuery("DELETE FROM producto WHERE id_producto = $id_producto ");
                   
            }else{
                throw new Exception(" No puede eliminarse el producto");
            }
        }   
            
    }
   
}
?>