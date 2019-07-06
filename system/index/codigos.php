<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
$db = new dbConn();

include_once 'application/common/Fechas.php';
include_once 'application/common/Encrypt.php';
include_once 'system/index/Inicio.php';


echo '<div id="formulario">'; 
Inicio::FormularioCodigos();
?>
</div> 
<div id="clave"></div>