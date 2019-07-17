<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'application/common/Mysqli.php';
include_once 'system/index/Inicio.php';
$db = new dbConn();

echo Helpers::HashId();
	
echo "<br>";

echo Helpers::TimeId();


echo '<div id="ventana"></div>';
?>