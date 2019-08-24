<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/cliente/Cliente.php';
$cliente = new Clientes(); 

?>

<div id="msj"></div>
<h2 class="h2-responsive">Todos los Clientes</h2>


<div id="destinocliente">
   <?php $cliente->VerTodosClientes(); ?>
</div>


