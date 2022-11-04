<?php
require_once ("baseBiz.class.php");

class Producto extends BaseBiz{   

    public function getProductosAll(){
        try{

            $resultado = $this->ResultQuery("SELECT * FROM producto WHERE activo=true");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el producto : ".$e->getMessage());         
        }
    }
    
    public function getById($id_producto){
        try{
            $selectStat = "SELECT * FROM producto WHERE id_producto = $id_producto";
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


    public function crear($id_producto=0,$codigo_producto, $producto, $detalle, $id_rubro){       
        //no debe recibir id producto 
        //debe recibir código de producto, producto, detalle, y id_rubro
        // valida que el código de producto no exista (si exite error ya existe)
        // valida que exista el id_rubro (si no existe error el id rubro no existe)
        if(empty($producto)) {
             throw new Exception("::Error, debe indicar al menos  el nombre del producto para esta operación ");
        }
        try{

            if($id_producto != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM producto WHERE id_producto = $id_producto";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla
                    $updateStat = "UPDATE producto SET ";
                    $updateStat .= "producto ='$producto',";
                    $updateStat .= "detalle ='$detalle',";
                    $updateStat .= "id_rubro ='$id_rubro'";

                    $updateStat .= " WHERE id_producto = $id_producto ";
                    
                    $this->NoResultQuery($updateStat);
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El producto con id " + $id_producto + "no existe ");
                } 
            }else{
                // hago el insert
                $insertStat = "INSERT INTO producto (codigo_producto,producto,detalle,id_rubro) VALUES(";
                $insertStat .= "'$codigo_producto',";
                $insertStat .= "'$producto','$detalle',";
                $insertStat .= "'$id_rubro')";
                $this->NoResultQuery($insertStat);
            }
        }catch (Exception $e){
            throw new Exception("::Error obteniendo producto  ".$e->getMessage());         
        }
    }

    public function desactivar($id_producto){
        $this->updateEstado($id_producto,0);
    }

    private function updateEstado($id_producto,$estado){
        try{
            $registroProducto = $this->getById($id_producto);                      
            $updStat = "UPDATE producto SET activo=$estado WHERE id_producto='$id_producto'";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" No se pudo dar de baja el producto. : ".$e->getMessage());         
        }
    }
   
}


?>