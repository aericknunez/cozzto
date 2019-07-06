<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/mesashoy/Mesas.php';
$db = new dbConn();

if($_SESSION["mesa"] != NULL){ // para eliminar la masa que viene de index
 include_once 'system/ventas/Venta.php'; 
    if(Venta::VerProductosMesa($_SESSION["mesa"]) == NULL){
      $db->delete("mesa", "WHERE estado = 1 and mesa = ". $_SESSION["mesa"] ." and tx = ". $_SESSION["tx"] ." and td = " . $_SESSION["td"]);
      unset ($_SESSION["mesa"]);
    }
}

?>
<div id="contenido">
<?php 
$mesas = new Mesas;
$mesas->VerMesas(date("d-m-Y"),1);

 ?>
</div>