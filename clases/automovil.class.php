<?php
require_once ("baseBiz.class.php");
require_once ("cripto.class.php");
require_once ("geodata.class.php");


class Automovil extends BaseBiz
{

    /*a = automovil
      c = cliente
      a2 = automovil
      tp = tipo de pago
      a3 = automovil
      mdp = metodos de pago*/
      //getAll simple
      //me traigo todos los vehículos dados de alta por el usuario logeado
    public function getAll($id_usuario){
        try{
            $sqlStat = "SELECT au.id_automovil,au.patente, m.marca, au.modelo, ta.tipo, au.activo
            FROM usuario u
            INNER JOIN cliente cli ON u.id_usuario = cli.id_usuario
            INNER JOIN automovil au ON cli.id_empleado = au.id_cliente
            INNER JOIN marca m ON au.id_marca = m.id_marca
            INNER JOIN tipo_automovil ta ON au.id_tipo_automovil = ta.id_tipo_automovil
            WHERE cli.id_usuario = $id_usuario 
            GROUP BY au.id_automovil";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo automoviles : ".$e->getMessage());         
        }
    }

    //me trae los automoviles dados de alta por el usuario logeado
    public function getByIdSimple($id_automovil){
        try{
            $sqlStat = "SELECT *
            FROM automovil au
            WHERE au.id_automovil = $id_automovil";
            $resultado = $this->resultQuery($sqlStat);
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuarios : ".$e->getMessage());         
        }
    }
    // GetById me trae todos los usuarios y los datos de los clientes asociados a la cuenta logeada 
    /*au.id_automovil, cli.nombre as 'nombre', cli.apellido, cli.email, cli.telefono,
                                    au.patente, au.modelo,
                                    m.marca,
                                    ta.tipo,
                                    pp.`abonó`, pp.fecha,
                                    t.tipo_plan,
                                    mdp.medio_pago*/
    public function getById($id_usuario){
        try{
            $selectStat = "SELECT   u.usuario,
                                    cli.nombre, cli.apellido, cli.email, cli.telefono,
                                    au.patente, au.modelo,
                                    m.marca,
                                    ta.tipo,
                                    pg.`abonó`, pg.fecha,
                                    tp.tipo_plan,
                                    mdp.medio_pago

                            FROM medios_de_pago mdp
                            INNER JOIN plan_pago pg ON mdp.id_medios_pago = pg.id_medios_pago
                            INNER JOIN tipo_plan tp ON pg.id_tipo_plan = tp.id_tipo_plan
                            INNER JOIN automovil au ON pg.id_automovil = au.id_automovil
                            INNER JOIN marca m ON au.id_marca = m.id_marca
                            INNER JOIN tipo_automovil ta ON au.id_tipo_automovil = ta.id_tipo_automovil
                            INNER JOIN cliente cli ON au.id_cliente = cli.id_empleado
                            INNER JOIN usuario u ON cli.id_usuario = u.id_usuario
                            WHERE u.id_usuario = $id_usuario";

                $resultado = $this->resultQuery($selectStat);                          
                return  $resultado;          
        }catch (Exception $e){
            throw new Exception(" Error obteniendo datos | automovil.class.php | getbyID : ".$e->getMessage());         
        }
    }

    public function getByPatente($patente){
        try{            
            $selectStatement = "SELECT * FROM automovil a WHERE a.Patente = '$patente'";

            $resultado = $this->resultQuery($selectStatement);            
            if(count($resultado) > 0){                
                return  $resultado;
            }else{
                throw new Exception(" No hay vehículos relacionados con la Patente $patente ");
            } 
        }catch (Exception $e){
            throw new Exception(" Error obteniendo usuario : ".$e->getMessage());         
        }
    }

    public function activar($patente){
        $this->updateEstado($patente,1);
    }

    public function desActivar($patente){
        $this->updateEstado($patente,0);
    }

    private function updateEstado($patente,$estado){
        try{
            $registroAutomovil = $this->getByPatente($patente);                      
            $updStat = "update automovil set activo=$estado where patente = '$patente'";
            $this->noResultQuery($updStat);            
        }catch (Exception $e){
            throw new Exception(" Error Dando de baja la Patente: ".$e->getMessage());         
        }
    }

    public function crear($id_cliente,$patente, $modelo,$id_marca,$id_tipo_automovil){ 

       // $marcas =  $oMarca->getAllByMarca();
        if(!empty($patente) && !empty($id_cliente) ) {
            
            $insertStat = "  INSERT INTO automovil    (`id_cliente`, `patente`, `modelo`, `id_marca`, `id_tipo_automovil`)
                                             VALUES   ($id_cliente, '$patente', $modelo, $id_marca, $id_tipo_automovil)";   
 
            
            $this->noResultQuery($insertStat); 
        }else{
            throw new Exception(" Complete todos los campos para el alta del automovil: ".$e->getMessage());  
        }
    }


    public function update($id_automovil=0,$id_cliente,$patente,$modelo,$marca,$id_tipo_automovil){ 


        if(!empty($id_automovil)){
            $registroAutomovil = $this->getByIdSimple($id_automovil);

            $updateStat = " update automovil set ";
            $updateFields = "";
            $updateFilter = " where id_automovil = $id_automovil";

        // campos no obligatorios
        if(!empty($id_cliente)){
            if(!empty($updateFields)){
                $updateFields .= ",";   
            }
            $updateFields .= " id_cliente ='$id_cliente'";             
        }
        if(!empty($patente)){
         if(!empty($updateFields)){
                $updateFields .= ",";   
            }
            $updateFields .= " patente ='$patente'";             
        }

            $updateFields .= ", modelo ='$modelo'";

            $updateFields .= ", id_marca ='$marca'";

            $updateFields .= ", id_tipo_automovil ='$id_tipo_automovil'";


        $this->noResultQuery($updateStat.$updateFields.$updateFilter); 
        }else{
        throw new Exception(" Todos los datos son obligatorios para actualizar al automovil : ".$e->getMessage());  
        }
        }

}

?>