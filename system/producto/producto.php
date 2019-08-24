<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/producto/Productos.php';
$producto = new Productos(); 
?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los Productos</h2>


<div id="contenido">
   <?php $producto->VerTodosProductos(1, "producto.id", "asc"); ?>
</div>


