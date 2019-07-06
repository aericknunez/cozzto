<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 
$db = new dbConn();

?>

<div class="text-center p-4">
  <h3>ELIMINAR FACTURAS</h3>
      <div id="resultado">
      <?php 
      if($_SESSION["tx"] == 1){
      $facturar->EliminarFacturas();
      } else {
        echo '<h3 class="border border-light">Debe estar en la opcion facturando para usar esta funcion</h3>';
      } 
       ?>
      </div>


</div>