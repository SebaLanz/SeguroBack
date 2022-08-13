<?php
require_once ("baseBiz.class.php");

class Ruta extends BaseBiz{   

    public function getAll(){
        try{
            $resultado = $this->ResultQuery("select * from ruta");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo rutas : ".$e->getMessage());         
        }
    }

    public function getById($id_ruta){
        try{
            $selectStat = "select * from ruta where id_ruta = $id_ruta";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El ruta con id $id_ruta no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo ruta : ".$e->getMessage());         
        }
    }

     // devuelve las rutas de acceso habilitadas para todos los usuarios
    public function getRutasForAll(){
        try{       
            //eturn $id_perfil;                 
            $selectStat = " SELECT r.id_ruta, r.ruta,r.regular_exp,r.descripcion
                            FROM ruta r                            
                            WHERE forall = 1 ";
            $resultado = $this->ResultQuery($selectStat);                   
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo rutas  habilitadas para todos los usuarios : ".$e->getMessage());         
        }
    }
}
?>