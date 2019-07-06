<?php
include_once 'system/mesashoy/Mesas.php';
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          DETALLES MESA SELECCIONADA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 
$a = $db->query("SELECT * FROM ticket WHERE edo != 1 and mesa = ".$_REQUEST["m"]." and tx = ".$_REQUEST["t"]." and td = ".$_SESSION["td"]."");
if($a->num_rows > 0) echo '<p class="text-danger">Esta mesa contiene facturas eliminadas!</p>';
$a->close();



$mesas = new Mesas;
$mesas->VerProductoMesas($_REQUEST["m"],$_REQUEST["t"]);

 ?>

<!-- ./  content -->
      </div>
      <div class="modal-footer">
          
          <?php if($_REQUEST["dir"] == 1){
            echo '<a href="?mesashoy" class="btn btn-primary btn-rounded">Regresar</a>';
          } else {
            echo '<a href="?mesasfecha" class="btn btn-primary btn-rounded">Regresar</a>';
          } ?>
          
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->