<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'system/index/Inicio.php';
include_once 'system/corte/Corte.php';
$cut = new Corte();
// echo Helpers::HashId();
	
//echo "Plataforma Root: " .  $_SESSION["root_plataforma"];

// echo Helpers::TimeId();

//Helpers::DeleteId("producto_ingresado", "producto='2' and td = ".$_SESSION["td"]."");


// $dato = array();
// $dato["cant"] = "15";
// Helpers::UpdateId("producto_ingresado", $dato, "producto='1' and td = ".$_SESSION["td"]."");

echo '<div id="ventana"></div>';



if($cut->UltimaFecha() != date("d-m-Y")){ // comprobacion de corte
	if($_SESSION["tipo_inicio"] == 2){ 	include_once 'system/ventas/venta_lenta.php'; } 
	else { include_once 'system/ventas/venta_rapida.php'; }

} else { /// termina comprobacion de corte
	Alerts::CorteEcho("ventas");
}

?>