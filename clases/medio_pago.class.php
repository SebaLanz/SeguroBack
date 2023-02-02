<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("geodata.class.php");


class Medio_de_pago extends BaseBiz
{
    //OBTENGO TODOS LOS DATOS tipo_plan
    public function getAll(){
        try{
            $sqlStat = "SELECT * FROM medios_de_pago mdp where mdp.estado = 1";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo medios_de_pago : ".$e->getMessage());         
        }
    }

    //BUSCO POR ID DE LA TABLA tipo_plan
    public function getById($id_medios_pago){
        try{
            $selectStat = "select * from medios_de_pago where id_medios_pago = $id_medios_pago";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El Medio de pago con el ID: $id_medios_pago no existe");
            } 
        }catch (Exception $e){
            throw new Exception(" obteniendo Plan : ".$e->getMessage());         
        }
    }



    public function crear($medio_pago){ 

        if(!empty($medio_pago   )) {
            
            $insertStat = "  INSERT INTO `seguro`.`medios_de_pago` (`medio_pago`) 
                            VALUES                           ('$medio_pago')";   
        
            $this->noResultQuery($insertStat); 
        }else{
            throw new Exception(" Complete los campos, son obligatorios ".$e->getMessage());  
        }
    }


        public function update($id_medios_pago=0,$medio_pago){ 

            if(!empty($medio_pago)){
                
                    $registroPlan = $this->getById($id_medios_pago);

                    $updateStat = " update medios_de_pago set ";
                    $updateFields = "";
                    $updateFilter = " where id_medios_pago = $id_medios_pago";

                    $updateFields .= " medio_pago ='$medio_pago'";



                $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
            
                }else{
                throw new Exception(" Es obligatorio el método de pago: ".$e->getMessage());  
                }
        }
            
    
        public function activar($id_medios_pago){
        $this->updateEstado($id_medios_pago,1);
        }

        public function desActivar($id_medios_pago){
            $this->updateEstado($id_medios_pago,0);
            }

        private function updateEstado($id_medios_pago,$estado){
            try{
                $registroAutomovil = $this->getById($id_medios_pago);                      
                $updStat = "update medios_de_pago set estado=$estado where id_medios_pago = '$id_medios_pago'";
                $this->noResultQuery($updStat);            
            }catch (Exception $e){
                throw new Exception(" Error modificando el estado del ID: $id_medios_pago: ".$e->getMessage());         
            }
        }
            
}
?>