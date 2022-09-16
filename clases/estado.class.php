<?php
require_once ("baseBiz.class.php");

/*al instanciar la clase BaseBiz puedo utilizar los métodos/constructores.
La clase baseBiz instancia la clase Dao(conexiónBDD), entonces nos podemos 
conectar a la Base de datos*/
class estado extends BaseBiz{   

    //funciona
    public function getAll(){
        try{
            $sqlStat = "SELECT id_estado,descripcion
                        FROM estado";
            $resultado = $this->ResultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo estado : ".$e->getMessage());         
        }
    }
    //funciona
    public function getById($id_estado){
        try{
            $selectStat = "select * from estado where id_estado = $id_estado";
            $resultado = $this->ResultQuery($selectStat);                        
            return  $resultado;           
        }catch (Exception $e){
            throw new Exception("::Error obteniendo estado  ".$e->getMessage());         
        }
    }
   
        //funciona
    public function delete($id_estado = 0){       
        
        try{
            if($id_estado != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM estado WHERE id_estado = $id_estado ";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla                   
                    $this->NoResultQuery("DELETE FROM estado WHERE id_estado = $id_estado ");
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El estado con id $id_estado no existe ");
                } 
            }else{
                throw new Exception("::Error, debe indicar el id de estado para esta operación ");
            }
        }catch (Exception $e){
            throw new Exception("::Error obteniendo estado  ".$e->getMessage());         
        }
    }

    //funciona
    public function crear( $Descripcion){ 

        if(!empty($Descripcion)){
            
            $insertFields = " INSERT INTO estado(descripcion)";
            $insertValues = " VALUES ('$Descripcion')";

            //return $insertFields.$insertValues;
            $this->noResultQuery($insertFields.$insertValues); 
        }else{
            throw new Exception(" La descripción es obligatoria : ".$e->getMessage());  
        }
    }



    //Falta probar- --- --
    public function save($id_estado = 0, $Descripcion, $id_stock = 0){       

        try{
            if($id_estado != 0){
                // llegó id valido que exista para hacer update
                $selectStat = "SELECT * FROM estado WHERE id_estado = $id_estado ";
                $resultado = $this->ResultQuery($selectStat);
                if(count($resultado) > 0){                
                    // existe el id en la tabla
                    $updateStat = "update estado set ";
                    $updateStat .= "descripcion ='$Descripcion',";
                    $this->NoResultQuery($updateStat);
                }else{
                    // no existe el id en la tabla
                    throw new Exception("::El estado con id $id_estado no existe ");
                } 
            }else{
                // hago el insert
                $insertFields = " INSERT INTO estado(descripcion)";
                $insertValues = " VALUES ('$Descripcion')";
                $this->noResultQuery($insertFields.$insertValues); 
            }
        }catch(Exception $e){
            throw new Exception("::Error obteniendo estado  ".$e->getMessage());         
        }
    }

}
    ?>