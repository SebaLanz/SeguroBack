<?php
require_once ("baseBiz.class.php");

class Geodata extends BaseBiz{   

    public function getAllprovincia(){
        try{
            $resultado = $this->ResultQuery("select * from provincia");
            return $resultado;
        }catch (Exception $e){
            throw new Exception("::Error obteniendo provincias :: ".$e->getMessage());         
        }
    }

    //obtengo si es automovil, moto, camion, etc
    public function getAllTipo(){
        try{
            $resultado = $this->ResultQuery("select * from tipo_automovil");
            return $resultado;
        }catch (Exception $e){
            throw new Exception("::Error obteniendo tipo_automovil :: ".$e->getMessage());         
        }
    }

     //obtengo las marcas de los automoviles
     public function getAllMarcas(){
        try{
            $resultado = $this->ResultQuery("select * from marca");
            return $resultado;
        }catch (Exception $e){
            throw new Exception("::Error obteniendo Marcas de automoviles :: ".$e->getMessage());         
        }
    }

      //obtengo las marcas de los automoviles
      public function getAllByMarca($marca){
        try{
            $resultado = $this->ResultQuery("select marca from marca where marca = '$marca'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception("::Error obteniendo Marcas de automoviles :: ".$e->getMessage());         
        }
    }

    


}
?>