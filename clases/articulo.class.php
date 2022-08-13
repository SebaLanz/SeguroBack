<?php
require_once ("baseBiz.class.php");

class Articulo extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("select * from articulo");
            return $resultado;
        }catch (Exception $e){
            throw new Exception("::Error obteniendo artículos :: ".$e->getMessage());         
        }
    }

    public function getById($id_articulo){
        try{
            $selectStat = "select * from articulo where id_articulo = $id_articulo";
            $resultado = $this->ResultQuery($selectStat);                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception("::Error obteniendo artículo  ".$e->getMessage());         
        }
    }

 
    public function save($id_articulo = 0, $nombre, $precio_venta = 0  , $precio_compra = 0, $cantidad_stock=0){       

        if(empty($nombre)) {
             throw new Exception("::Error, debe indicar al menos nombre de artículo para esta operación ");
        }
        try{
            if($id_articulo != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM articulo WHERE id_articulo = $id_articulo ";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla
                    $updateStat = "update articulo set ";
                    $updateStat .= "nombre ='$nombre',";
                    $updateStat .= "precio_venta = $precio_venta,";
                    $updateStat .= "precio_compra = $precio_compra,";
                    $updateStat .= "cantidad_stock = $cantidad_stock ";
                    $updateStat .= " where id_articulo = $id_articulo ";
                    $this->NoResultQuery($updateStat);
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El artículo con id $id_articulo no existe ");
                } 
            }else{
                // hago el insert
                $insertStat = "INSERT INTO articulo (nombre,precio_venta,precio_compra,cantidad_stock) VALUES(";
                $insertStat .= "'$nombre',$precio_venta,";
                $insertStat .= " $precio_compra,$cantidad_stock)";
                $this->NoResultQuery($insertStat);
            }
        }catch (Exception $e){
            throw new Exception("::Error obteniendo artículo  ".$e->getMessage());         
        }
    }

    public function delete($id_articulo = 0){       
        
        try{
            if($id_articulo != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM articulo WHERE id_articulo = $id_articulo ";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla                   
                    $this->NoResultQuery("DELETE FROM articulo WHERE id_articulo = $id_articulo ");
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El artículo con id $id_articulo no existe ");
                } 
            }else{
                throw new Exception("::Error, debe indicar el id de artículo para esta operación ");
            }
        }catch (Exception $e){
            throw new Exception("::Error obteniendo artículo  ".$e->getMessage());         
        }
    }


}
?>