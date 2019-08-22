<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/credito/Creditos.php';
$credito = new Creditos(); 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>

<div id="msj"></div>
<h2 class="h2-responsive">CREDITOS ACTIVOS	1</h2>


<div id="destinoproveedor">
   <?php $credito->VerCreditos(); ?>
</div>
