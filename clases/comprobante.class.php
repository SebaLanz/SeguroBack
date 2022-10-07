<?php
require_once ("baseBiz.class.php");
require_once ("proveedor.class.php");
require_once ("comprobantetipo.class.php");

class Comprobante extends BaseBiz{   

    public function getAll(){
        try{
            $sqlStat = "SELECT c.id_comprobante,c.id_comprobante_tipo,
                        c.fecha,c.fecha_ingreso,c.nro_comprobante,
                        ifnull(c.id_proveedor,0) as id_proveedor
                        from comprobante c
                        left JOIN comprobante_tipo ct ON c.id_comprobante_tipo = ct.id_comprobante_tipo
                        left JOIN proveedor pr ON c.id_proveedor = pr.id_proveedor";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo comprobantes : ".$e->getMessage());         
        }
    }

    public function getById($id_comprobante){
        try{
            $selectStat = "select * from comprobante where id_comprobante = $id_comprobante";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El comprobante con id $id_comprobante no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo comprobante : ".$e->getMessage());         
        }
    }

 
    public function crear( $id_comprobante_tipo, $fecha, $fecha_ingreso, $nro_comprobante,
                           $id_proveedor=0){ 
        
        try{
            if(empty($id_comprobante_tipo) || empty($nro_comprobante)){
                throw new Exception("Faltan datos necesarios para crear un comprobante "); 
            }  
    
            $resultado = $this->ResultQuery("select * from comprobante where nro_comprobante = '$nro_comprobante'");
            if(count($resultado) == 0){  
                $insertFields = " INSERT INTO comprobante(id_comprobante_tipo,fecha,fecha_ingreso,nro_comprobante";

                if($id_comprobante_tipo==0 || $id_comprobante_tipo=="" || $id_comprobante_tipo==null){

                }else{
                    $oComprobante = new ComprobanteTipo();
                    try{
                        $oComprobante->getById($id_comprobante_tipo);
                        $insertValues = " VALUES ('$id_comprobante_tipo','$fecha','$fecha_ingreso','$nro_comprobante'";
                    }catch (Exception $e){
                        throw new Exception(" El Id del tipo de comprobante no existe");
                    }
                }
                 // campos no obligatorios
                if($id_proveedor==0 || $id_proveedor=="" || $id_proveedor==null){
                                        
                }else{
                    $oProveedor = new Proveedor();
                    try{
                        $oProveedor->getById($id_proveedor);
                        $insertFields .= ",id_proveedor";
                        $insertValues .= ",'$id_proveedor'";
                    }catch (Exception $e){
                        throw new Exception(" El Id de proveedor no existe");
                    }
                }
                $insertFields .= ")";
                $insertValues .= ")";                 
                $this->noResultQuery($insertFields.$insertValues);                    
                         
            }else{
                throw new Exception(" El nro de comprobante ". $nro_comprobante ." ya existe");
            }                  
        }catch (Exception $e){
            throw new Exception(" Error creando comprobante :".$e->getMessage());         
        }

    }


    public function update( $id_comprobante=0, $id_comprobante_tipo=0, $fecha, $fecha_ingreso, $nro_comprobante, $id_proveedor=0){ 
        try{
            if(!empty($id_comprobante)){
                $registroComprobante = $this->getByid($id_comprobante);
                
                $updateStat = " update comprobante set ";
                $updateFields = "";
                $updateFilter = " where id_comprobante = $id_comprobante";

                if(!empty($id_comprobante_tipo) || $id_comprobante_tipo==0 || $id_comprobante_tipo=="" || $id_comprobante_tipo==null){
                    $oComprobante = new ComprobanteTipo();
                    $oComprobante->getById($id_comprobante_tipo);

                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " id_comprobante_tipo ='$id_comprobante_tipo'";             
                }
                if(!empty($fecha)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " fecha ='$fecha'";             
                }
                if(!empty($fecha_ingreso)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " fecha_ingreso ='$fecha_ingreso'";             
                }
                if(!empty($nro_comprobante)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " nro_comprobante ='$nro_comprobante'";             
                }
                if(!empty($id_proveedor) || $id_proveedor==0 || $id_proveedor=="" || $id_proveedor==null){
                    try{
                        $oProveedor = new Proveedor();
                        $oProveedor->getById($id_proveedor);
                    }catch(Exception){
                        throw new Exception(" El id ". $id_proveedor ." de proveedor no existe");
                    }

                    if(!empty($updateFields) || $id_proveedor==0 || $id_proveedor=="" || $id_proveedor==null){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " id_proveedor ='$id_proveedor'";             
                }
                $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
            }else{
                if($id_comprobante=="" || $id_comprobante==null){
                    $id_comprobante=0;
                }
                $registroComprobante = $this->getByid($id_comprobante);
            }
        }catch(Exception $e){
            throw new Exception(" Error actualizando comprobante : ".$e->getMessage());
        }
    }

    public function updateInterno( $id_comprobante=0, $id_comprobante_tipo=0, $fecha, $fecha_ingreso, $nro_comprobante, $id_proveedor=0){ 
        try{
            if(!empty($id_comprobante)){
                $registroComprobante = $this->getByid($id_comprobante);
                
                $updateStat = " update comprobante set ";
                $updateFields = "";
                $updateFilter = " where id_comprobante = $id_comprobante";

                if(!empty($id_comprobante_tipo) || $id_comprobante_tipo==0 || $id_comprobante_tipo=="" || $id_comprobante_tipo==null){
                    $oComprobante = new ComprobanteTipo();
                    $oComprobante->getById($id_comprobante_tipo);

                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }
                    $updateFields .= " id_comprobante_tipo ='$id_comprobante_tipo'";             
                }
                if(!empty($fecha)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }else{
                        throw new Exception(" La fecha es obligatoria para modificar un comprobante: ".$e->getMessage());
                    }
                    $updateFields .= " fecha ='$fecha'";             
                }
                if(!empty($fecha_ingreso)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }else{
                        throw new Exception(" La fecha de ingreso es obligatoria para modificar un comprobante : ".$e->getMessage());
                    }
                    $updateFields .= " fecha_ingreso ='$fecha_ingreso'";             
                }
                if(!empty($nro_comprobante)){
                    if(!empty($updateFields)){
                       $updateFields .= ",";   
                    }else{
                        throw new Exception(" El nro de comprobante es obligatorio para modificar un comprobante : ".$e->getMessage());
                    }
                    $updateFields .= " nro_comprobante ='$nro_comprobante'";             
                }
                if(!empty($id_proveedor) || $id_proveedor==0 || $id_proveedor=="" || $id_proveedor==null){

                    $oProveedor = new Proveedor();
                    $oProveedor->getById($id_proveedor);

                    if(!empty($updateFields) || $id_proveedor==0 || $id_proveedor=="" || $id_proveedor==null){
                       $updateFields .= ",";   
                    }else{
                        throw new Exception(" La fecha de ingreso es obligatoria para modificar un comprobante : ".$e->getMessage());
                    }
                    $updateFields .= " id_proveedor ='$id_proveedor'";             
                }
                $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
            }else{
                throw new Exception(" El id_comprobante es obligatorio para modificar un comprobante : ".$e->getMessage());  
            }
        }catch(Exception $e){
            throw new Exception(" Error actualizando comprobante : ".$e->getMessage());
        }
    }

    public function delete($id_comprobante){       
        
        try{       
            $this->getByid($id_comprobante);// valida que exista                                  
            $this->NoResultQuery("DELETE FROM comprobante WHERE id_comprobante = $id_comprobante ");              
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando comprobante : ".$e->getMessage());         
        }
    }


}
?>