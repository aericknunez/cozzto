<?php 
class Opciones{

	public function __construct() { 
 	} 



 	public function AddCredito($factura){
 		$db = new dbConn();

 			$datos = array();
		    $datos["hash_cliente"] = $_SESSION["cliente_c"];
		    $datos["nombre"] = $_SESSION["cliente_credito"];
		    $datos["factura"] = $factura;
		    $datos["orden"] = $_SESSION["orden"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["edo"] = 1;
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("creditos", $datos); 

			if(isset($_SESSION["cliente_c"])) unset($_SESSION["cliente_c"]);
			if(isset($_SESSION["cliente_credito"])) unset($_SESSION["cliente_credito"]);
 	}












} // termina clase