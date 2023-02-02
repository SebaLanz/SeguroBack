<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("geodata.class.php");


class Plan extends BaseBiz
{
    //OBTENGO TODOS LOS DATOS tipo_plan
    public function getAll(){
        try{
            $sqlStat = "SELECT * FROM tipo_plan";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo PLan : ".$e->getMessage());         
        }
    }

    //BUSCO POR ID DE LA TABLA tipo_plan
    public function getById($id_tipo_plan){
        try{
            $selectStat = "select * from tipo_plan where id_tipo_plan = $id_tipo_plan";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El Plan con el ID: $id_tipo_plan no existe ");
            } 
        }catch (Exception $e){
            throw new Exception(" obteniendo Plan : ".$e->getMessage());         
        }
    }

    //BUSCO POR EL CAMPO 'TIPO_PLAN' DE LA TABLA tipo_plan (F-B-G ETC)
    public function getByTipoPlan($tipo_plan){
        try{
            $selectStat = "SELECT *
                           FROM tipo_plan ta
                           WHERE ta.tipo_plan = '$tipo_plan'";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El Plan con el nombre: $tipo_plan no existe ");
            } 
        }catch (Exception $e){
            throw new Exception(" obteniendo Plan : ".$e->getMessage());         
        }
    }

    public function crear($tipo_plan,$descripcion){ 

        // $marcas =  $oMarca->getAllByMarca();
         if(!empty($tipo_plan)) {
             
             $insertStat = "  INSERT INTO `seguro`.`tipo_plan` (`tipo_plan`, descripcion) 
                              VALUES                           ('$tipo_plan','$descripcion')";   
        
             $this->noResultQuery($insertStat); 
         }else{
             throw new Exception(" El campo 'Tipo de Plan' es obligatorio ".$e->getMessage());  
         }
     }

    

    public function activar($id_tipo_plan){
        $this->updateEstado($id_tipo_plan,1);
    }

    public function desActivar($id_tipo_plan){
        $this->updateEstado($id_tipo_plan,0);
    }

    //falta 
    private function updateEstado($id_tipo_plan,$estado){
        try{
            $registroAutomovil = $this->getById($id_tipo_plan);                      
            $updStat = "update tipo_plan set activo=$estado where id_tipo_plan = $id_tipo_plan";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" Error Dando de baja la Patente: ".$e->getMessage());         
        }
    }


    public function update($id_tipo_plan=0,$tipo_plan,$descripcion){ 


        if(!empty($tipo_plan)){
            $registroPlan = $this->getById($id_tipo_plan);

            $updateStat = " update tipo_plan set ";
            $updateFields = "";
            $updateFilter = " where id_tipo_plan = $id_tipo_plan";

            $updateFields .= " tipo_plan ='$tipo_plan'";

            $updateFields .= ", descripcion ='$descripcion'";


        $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
        throw new Exception(" Es obligatorio el tipo de plan: ".$e->getMessage());  
        }
        }

}

?>