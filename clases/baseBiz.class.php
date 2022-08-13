<?php
require_once 'dao.class.php'; // me garantizo acceso a las funciones de base de datos

class baseBiz{
    // Propiedad donde se guarda el objeto de acceso a datos
    private $dao;    
    
    // constructor, inicia el objeto, conecta a la base de datos 
    // le asigno default a los parámetros para cuando no me los pasen
    public function __construct($paramDBhost="",$paramDBuser="",$paramDBpass="",$paramDBbase="",$paramDBpuerto=0) {                                
        try {   
           
            if(empty($paramDBhost)){
                // si no recibo la data de conexión uso las constantes de config                
                $paramDBhost = DBhost;
                $paramDBuser = DBuser;
                $paramDBpass = DBpass;
                $paramDBbase = DBbase;
                $paramDBpuerto = DBpuerto;
                if(!isset($GLOBALS["GL_DAO"])){
                    $GLOBALS["GL_DAO"] = new Dao($paramDBhost, $paramDBuser, $paramDBpass, $paramDBbase, $paramDBpuerto); 
                }
                $this->dao = $GLOBALS["GL_DAO"];
            }else{ 
                $this->dao = new Dao($paramDBhost, $paramDBuser, $paramDBpass, $paramDBbase, $paramDBpuerto);                                 
            }
                
        } catch (Exception $e) {
            throw new Exception(" ERROR iniciando objeto Base : ".$e->getMessage());
        }
    }
    
    
    // query sin resultados, recibe el texto de
    // la instrucción sql a ejecutar (insert-update-delete)
    public function NoResultQuery($tcQuery){
        // pasa manos con el dao
        return $this->dao->NoResultQuery($tcQuery);
    }
    
    // Qquery con resultados, recibe el texto de
    // la instrucción sql a ejecutar (select)
    public function ResultQuery($tcQuery){
        // pasa manos con el dao
        return $this->dao->ResultQuery($tcQuery);
    }

    // inicia una transacción
    function iniciarTransaccion(){   
        // pasa manos con el dao
        return $this->dao->NoResultQuery("STRAT TRANSACTION");        
    }

    // finaliza la transacción
    function commitTransaccion(){   
        // pasa manos con el dao
        return $this->dao->NoResultQuery("COMMIT");        
    }

    // vuelve atrás una transacción
    function rollBackTransaccion(){   
         // pasa manos con el dao
        return $this->dao->NoResultQuery("ROLLBACK");        
    }
   

}
?>