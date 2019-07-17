<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'application/common/Mysqli.php';
include_once 'system/index/Inicio.php';
$db = new dbConn();

// echo Helpers::HashId();
	
//echo "Plataforma Root: " .  $_SESSION["root_plataforma"];

// echo Helpers::TimeId();

//Helpers::DeleteId("producto_ingresado", "producto='2' and td = ".$_SESSION["td"]."");


// $dato = array();
// $dato["cant"] = "15";
// Helpers::UdatadeId("producto_ingresado", $dato, "producto='1' and td = ".$_SESSION["td"]."");

echo '<div id="ventana"></div>';
?>