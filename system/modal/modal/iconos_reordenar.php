<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Reordenar Iconos</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<a href="javascript:void(0);" class="btn blue-gradient reorder_link" id="save_reorder">REORDENAR</a>

<div class="row text-center portfolio"> 
<ul class="gallery reorder_ul reorder-photos-list"> 

<?php 
include_once 'system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->GetReordenar($_REQUEST["popup"]);
 ?>

 </ul> 
 </div> 
 <!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->