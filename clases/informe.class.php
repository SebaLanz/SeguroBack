<?php
require_once ("baseBiz.class.php");

class Informe extends BaseBiz{   


    public function getAll(){
        try{

            $resultado = $this->ResultQuery("SELECT * FROM stock");

            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el producto : ".$e->getMessage());         
        }
    }
    
    

    public function getMe(){
        try{

            $resultado = $this->ResultQuery("SELECT s.id_stock,p.producto,s.codigo_producto,s.nro_lote,s.vencimiento,s.bultos,s.nro_stock,s.iso_origen,s.presentacion
                                            FROM stock s
                                            INNER JOIN producto p ON s.codigo_producto = p.codigo_producto
                                            WHERE s.nro_stock LIKE 'me%'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el Material de Empaque : ".$e->getMessage());         
        }
    }

    public function getPe(){
        try{

            $resultado = $this->ResultQuery("SELECT s.id_stock,p.producto AS nombre_pe,s.codigo_producto,s.nro_lote,s.vencimiento,s.bultos,s.nro_stock,s.iso_origen,s.presentacion
                                            FROM stock s
                                            INNER JOIN producto p ON s.codigo_producto = p.codigo_producto
                                            WHERE s.nro_stock LIKE 'pe%'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el Producto Elaborado : ".$e->getMessage());         
        }
    }



public function getNombrePE($nStock){
        try{

            $resultado = $this->ResultQuery("SELECT p.producto AS nombre_pe
											FROM stock s
											INNER JOIN producto p ON s.codigo_producto = p.codigo_producto
											WHERE s.nro_stock LIKE 'pe%' AND s.nro_stock = '$nStock'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo el Producto Elaborado : ".$e->getMessage());         
        }
    }
   

    public function getMp(){
        try{

            $resultado = $this->ResultQuery("SELECT s.id_stock,p.producto,s.codigo_producto,s.nro_lote,s.vencimiento,s.bultos,s.nro_stock,s.iso_origen,s.presentacion
                                            FROM stock s
                                            INNER JOIN producto p ON s.codigo_producto = p.codigo_producto
                                            WHERE s.nro_stock LIKE 'mp%'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo la materia Prima : ".$e->getMessage());         
        }
    }

     //-- dado un producto elavorado listo todos los MP/ME que usé para hacerlo, EJ. PE1 UTILIZÓ MP1,MP2,ME1,ME2.
     public function getMateriaDePE($nStock){
        try{

            $resultado = $this->ResultQuery("SELECT c.nro_comprobante AS orden_prod, c.fecha AS fecha_orden_prod, smp.codigo_producto, p.producto,	sm.cantidad *-1 AS cantidad ,	um.detalle,	smp.nro_stock,	smp.nro_lote,	smp.vencimiento
											FROM stock s
											INNER JOIN comprobante c ON c.id_comprobante_tipo = 2 AND s.nro_orden_prod = c.nro_comprobante 
											INNER JOIN stock_movimiento sm ON c.id_comprobante = sm.id_comprobante
											INNER JOIN stock smp ON sm.nro_stock = smp.nro_stock
											INNER JOIN producto p ON smp.codigo_producto = p.codigo_producto
											LEFT JOIN unidad_medida um ON sm.id_unidad_medida = um.id_unidad_medida
											WHERE s.nro_stock ='$nStock'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo la materia Prima utilizada en un producto : ".$e->getMessage());         
        }
    }

     //-- En la materia "x" en que PRODUCTO ELAVORADO SE UTILIZÓ. EJ MP4 SE UTILIZÓ EN PE1, PE2, PE3, PE4.
     public function getMateriaUtilizadaEnPe($nStock){
        try{

            $resultado = $this->ResultQuery("SELECT mp.nro_stock AS MpUtilizada,c.nro_comprobante,c.fecha,spe.nro_stock,p.codigo_producto,p.producto,spe.nro_lote,spe.vencimiento  
                                            FROM 
                                            stock_movimiento mp
                                            INNER JOIN comprobante c ON c.id_comprobante_tipo = 2 AND mp.id_comprobante = c.id_comprobante
                                            INNER JOIN stock spe ON c.nro_comprobante = spe.nro_orden_prod
                                            INNER JOIN producto p ON spe.codigo_producto = p.codigo_producto
                                            WHERE mp.nro_stock = '$nStock'");
            return $resultado;
        }catch (Exception $e){
            throw new Exception(" Error obteniendo la materia Prima utilizada en un producto : ".$e->getMessage());         
        }
    }
}
?>