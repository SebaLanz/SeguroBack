<?php
require_once ("baseBiz.class.php");
require_once ("proveedorContacto.class.php");

class Proveedor extends BaseBiz{   

    public function getAll(){
        try{
            $sqlStat = "SELECT * FROM proveedor";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo estado : ".$e->getMessage());         
        }
    }

    public function getById($id_proveedor){
        try{
            $selectStat = "select * from proveedor where id_proveedor = $id_proveedor";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El proveedor con id $id_proveedor no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo proveedor : ".$e->getMessage());         
        }
    }

 
    public function crear( $razon_soc, $cuit, $calle="", $numero_calle="",
                           $localidad="", $cod_provincia = null, $email="", $telefono=""){ 
                   
        if(!empty($razon_soc) && !empty($cuit)){
            
            $insertFields = " INSERT INTO proveedor( razon_soc, cuit ";
            $insertValues = " VALUES ('$razon_soc', '$cuit'";
            
            // campos no obligatorios
            if(!empty($email)){
                $insertFields .= ",email";
                $insertValues .= ",'$email'";                
            }
            if(!empty($calle)){
                $insertFields .= ",calle";
                $insertValues .= ",'$calle'";                
            }
            if(!empty($numero_calle)){
                $insertFields .= ",numero_calle";
                $insertValues .= ",'$numero_calle'";                
            }
            if(!empty($localidad)){
                $insertFields .= ",localidad";
                $insertValues .= ",'$localidad'";                
            }
            if(!empty($telefono)){
                $insertFields .= ",telefono";
                $insertValues .= ",'$telefono'";                
            }
            if($cod_provincia!=null){
                $insertFields .= ",cod_provincia";
                $insertValues .= ",'$cod_provincia'";                
            }
            
            $insertFields .= ")";
            $insertValues .= ")"; 
            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
           
        }else{
           
            throw new Exception(" La razón social y el cuit son obligatorios para crear un proveedor : ".$e->getMessage());  
        }
    }


    public function update( $id_proveedor=0, $razon_soc, $cuit, $calle="", $numero_calle="",
                            $localidad="", $cod_provincia = null, $telefono="", $email=""){ 


    if(!empty($id_proveedor)){
        $registroproveedor = $this->getByid($id_proveedor);

        $updateStat = " update proveedor set ";
        $updateFields = "";
        $updateFilter = " where id_proveedor = $id_proveedor";

        // campos no obligatorios
        if(!empty($razon_soc)){
        if(!empty($updateFields)){
        $updateFields .= ",";   
        }
        $updateFields .= " razon_soc ='$razon_soc'";             
        }
        if(!empty($cuit)){
        if(!empty($updateFields)){
        $updateFields .= ",";   
        }
        $updateFields .= " cuit ='$cuit'";             
        }

        if(!empty($updateFields)){
        $updateFields .= ",";   
        }

        $updateFields .= " telefono ='$telefono'";

        $updateFields .= ", calle ='$calle'";

        $updateFields .= ", email ='$email'";

        $updateFields .= ", numero_calle ='$numero_calle'";

        if($cod_provincia!=null){
        $updateFields .= ", cod_provincia ='$cod_provincia'";
        }else{
        $updateFields .= ", cod_provincia = NULL ";
        }

        $updateFields .= ", localidad ='$localidad'";


        $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
        throw new Exception(" El id_proveedor es obligatorio para modificar un proveedor : ".$e->getMessage());  
        }
    }

    public function delete($id_proveedor){       
        
        try{       
            $this->getByid($id_proveedor);// valida que exista                                  
            $this->NoResultQuery("DELETE FROM proveedor WHERE id_proveedor = $id_proveedor ");              
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando proveedor : ".$e->getMessage());         
        }
    }


    public function crearContacto($id_proveedor, $nombre, $apellido, $telefono="", $celular="", $email=""){       
        
        try{  
            $this->iniciarTransaccion();     
            $this->getByid($id_proveedor);// valida que exista                                  
            $oContactos = new ProveedorContactoContacto();              
            $oContactos->crear($id_proveedor, $nombre, $apellido, $telefono, $celular, $email);
            $this->commitTransaccion();
        }catch (Exception $e){
            $this->rollBackTransaccion();
            throw new Exception(" Error creando contacto de Proveedor : ".$e->getMessage());         
        }
    }

    public function getAllContacto($id_proveedor){      
        
        try{       

            $this->getByid($id_proveedor);// valida que exista                                  
            $oContactos = new ProveedorContactoContacto();              
            $oContactos->getAll($id_proveedor);
        }catch (Exception $e){
            throw new Exception(" Error obteniendo contactos del proveedor : ".$e->getMessage());         
        }
    }


    public function deleteContacto($id_proveedor, $id_proveedor_contacto){       
        
        try{       
            $this->getByid($id_proveedor);// valida que exista                                  
            $oContactos = new ProveedorContactoContacto();
            $oContactos->delete($id_proveedor_contacto);           
        }catch (Exception $e){
            throw new Exception(" Error eliminando proveedor : ".$e->getMessage());         
        }
    }

}
?>