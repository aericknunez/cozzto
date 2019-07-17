<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/proveedor/Proveedor.php';
$proveedor = new Proveedores(); 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los proveedores</h2>


<div id="destinoproveedor">
   <?php $proveedor->VerTodosProveedores(); ?>
</div>


