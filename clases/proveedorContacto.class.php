<?php
require_once ("baseBiz.class.php");

class ProveedorContactoContacto extends BaseBiz{   

    public function getAll($id_proveedor){
        try{
            $resultado = $this->ResultQuery("select * from proveedor_contacto where id_proveedor = $id_proveedor");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo proveedor contactoes : ".$e->getMessage());         
        }
    }

    public function getById($id_proveedor_contacto){
        try{
            $selectStat = "select * from proveedor_contacto where id_proveedor_contacto = $id_proveedor_contacto";
            $resultado = $this->ResultQuery($selectStat); 
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" El proveedor_contacto con id $id_proveedor_contacto no existe ");
            }                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception(" Error obteniendo proveedor contacto : ".$e->getMessage());         
        }
    }

 
    public function crear( $id_proveedor, $nombre, $apellido, $telefono="", $celular="", $email=""){ 

        if(!empty($id_proveedor) && !empty($nombre) && !empty($apellido)){
            
            $insertFields = " INSERT INTO proveedor_contacto( id_proveedor, nombre, apellido";
            $insertValues = " VALUES (id_proveedor, 'nombre', 'apellido'";
            
            // campos no obligatorios
            if(!empty($telefono)){
                $insertFields .= ",telefono";
                $insertValues .= ",'$telefono'";                
            }
            if(!empty($celular)){
                $insertFields .= ",celular";
                $insertValues .= ",'$celular'";                
            }
            if(!empty($email)){
                $insertFields .= ",email";
                $insertValues .= ",'$email'";                
            }                        
            $insertFields .= ")";
            $insertValues .= ")"; 
            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
        }else{
            throw new Exception(" El id de proveedor nombre y apellido son obligatorios para crear un proveedor contacto : ".$e->getMessage());  
        }
    }


public function update( $id_proveedor_contacto=0, $razon_soc, $cuit, $calle="", $numero_calle="",
                           $localidad="", $cod_provincia = null, $email="", $telefono=""){ 
     

        if(!empty($id_proveedor_contacto)){
            $registroproveedor_contacto = $this->getByid($id_proveedor_contacto);
            
            $updateStat = " update proveedor_contacto set ";
            $updateFields = "";
            $updateFilter = " where id_proveedor_contacto = $id_proveedor_contacto";

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

            $updateFields .= " email ='$email'";
           
            $updateFields .= ", calle ='$calle'";
            
            $updateFields .= " telefono ='$telefono'";

            $updateFields .= ", numero_calle ='$numero_calle'";
            
            if($cod_provincia!=null){
                $updateFields .= ", cod_provincia ='$cod_provincia'";
            }else{
                $updateFields .= ", cod_provincia = NULL ";
            }
           
            $updateFields .= ", localidad ='$localidad'";
            
            $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
            throw new Exception(" El id_proveedor_contacto es obligatorio para modificar un proveedor_contacto : ".$e->getMessage());  
        }
    }

    public function delete($id_proveedor_contacto){       
        
        try{       
            $this->getByid($id_proveedor_contacto);// valida que exista                                  
            $this->NoResultQuery("DELETE FROM proveedor_contacto WHERE id_proveedor_contacto = $id_proveedor_contacto ");              
            
        }catch (Exception $e){
            throw new Exception(" Error eliminando proveedor_contacto : ".$e->getMessage());         
        }
    }


}
?>