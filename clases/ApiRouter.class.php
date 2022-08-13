<?php
class ApiRouter {

    public function __construct($aplicacion) {  
       //$this->app = $aplicacion;
       $this->createRoutes($aplicacion);
    }

   public function createRoutes($aplicacion) {
        // Cada clase que herede de esta implementa el método para crear sus rutas
   }
}
?>