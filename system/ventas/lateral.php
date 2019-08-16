<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($_GET["modal"])){
	if($venta == TRUE){
		include_once 'application/common/Mysqli.php';
		$db = new dbConn();
		include_once 'system/ventas/Laterales.php';
		$lateral = new Laterales(); 

		$lateral->VerLateral($_SESSION["orden"]);
	} else {
		echo '<img src="assets/img/logo/default.png" alt="">';
	}
} 
?>