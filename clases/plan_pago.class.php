<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("geodata.class.php");


class Plan_pago extends BaseBiz
{
    //OBTENGO TODOS LOS DATOS tipo_plan
    public function getAll(){
        try{
            $sqlStat = "SELECT * FROM plan_pago";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo plan_pago : ".$e->getMessage());         
        }
    }

    //BUSCO POR ID DE LA TABLA tipo_plan
    public function getById($id_plan_pago){
        try{
            $selectStat = "select * from plan_pago where id_plan_pago = $id_plan_pago";
            $resultado = $this->resultQuery($selectStat);
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El Plan-pago con el ID: $id_plan_pago no existe ");
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

    public function crear($id_automovil,$id_tipo_plan,$id_medios_pago,$abonó,$fecha){ 

        // $marcas =  $oMarca->getAllByMarca();
         if(!empty($id_automovil) || !empty($id_tipo_plan) || !empty($id_medios_pago) || !empty($abonó)) {
             
             $insertStat = "  INSERT INTO `seguro`.`plan_pago` (`id_automovil`, id_tipo_plan, id_medios_pago,abonó, fecha) 
                              VALUES                           ('$id_automovil','$id_tipo_plan','$id_medios_pago','$abonó','$fecha')";   
        
             $this->noResultQuery($insertStat); 
         }else{
             throw new Exception(" Complete los campos, son obligatorios ".$e->getMessage());  
         }
     }


    public function update($id_plan_pago=0,$id_automovil,$id_tipo_plan,$id_medios_pago,$abonó,$fecha){ 


        if(!empty($id_automovil)||!empty($id_tipo_plan)||!empty($id_medios_pago)||!empty($abonó)||!empty($fecha)){
            $registroPlan = $this->getById($id_plan_pago);

            $updateStat = " update plan_pago set ";
            $updateFields = "";
            $updateFilter = " where id_plan_pago = $id_plan_pago";

            $updateFields .= " id_automovil ='$id_automovil'";

            $updateFields .= ", id_tipo_plan ='$id_tipo_plan'";

            $updateFields .= ", id_medios_pago ='$id_medios_pago'";

            $updateFields .= ", abonó ='$abonó'";

            $updateFields .= ", fecha ='$fecha'";


        $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
            throw new Exception(" Todos los campos son obligatorios: ".$e->getMessage());  
        }
    }
     
        public function delete($id_plan_pago){  
            try{
                $this->getByid($id_plan_pago);// valida que exista                                  
                $this->NoResultQuery("DELETE FROM `seguro`.`plan_pago` WHERE  `id_plan_pago`=$id_plan_pago;");
            }catch (Exception $e){
                throw new Exception(" obteniendo Plan : ".$e->getMessage());         
            }     
    
        }
        
    }
?>