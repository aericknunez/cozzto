<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

if(!isset($_GET["modal"])){
	if($venta == TRUE){
		include_once 'system/ventas/Laterales.php';
		$lateral = new Laterales(); 

		$lateral->VerLateral($_SESSION["orden"]);
	} else {
		echo '<div class="text-center"><img src="assets/img/logo/'.$_SESSION['config_imagen'].'" class="img-fluid responsive" alt="Responsive image"></div>';
	}
} 
?>

