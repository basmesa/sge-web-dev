<?php
include("../cnx/swgc-mysql.php");


date_default_timezone_set('America/America/Mexico_City');


	function calcularInventario($eCodInventario)
	{
		$ePiezas = 0;
		
		$select = "SELECT ePiezas FROM CatInventario WHERE eCodInventario = $eCodInventario";
		$rsInventario = mysql_query($select);
		$rInventario = mysql_fetch_array($rsInventario);
		
		$ePiezas = $rInventario{'ePiezas'};
		
		return $ePiezas;
	}
    
//floor(number) returns the nearest DOWN of a number

	function  calcularPaquete($eCodServicio)
	{
		$eCantidad = 0;
		
		$eCantidades = array();
        
		$select = 	" SELECT  ".
					" 	rsi.ePiezas ePiezasPaquete,  ".
					" 	ci.ePiezas ePiezasInventario  ".
					" FROM  ".
					" 	RelServiciosInventario rsi  ".
					" INNER JOIN CatInventario ci ON ci.eCodInventario=rsi.eCodInventario  ".
					" WHERE rsi.eCodServicio = $eCodServicio";
		
		$rsProductos = mysql_query($select);
		while($rProducto = mysql_fetch_array($rsProductos))
		{
           
            $eTotal = (int)$rProducto{'ePiezasInventario'} / (int)$rProducto{'ePiezasPaquete'};
            $eTotal = floor($eTotal);
			$eCantidades[] = $eTotal;
		}
        
		return min($eCantidades);
	}
?>