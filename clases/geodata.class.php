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

    


}
?>