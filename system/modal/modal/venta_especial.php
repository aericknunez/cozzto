<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
include_once 'system/ventas/Especial.php';
$especiales = new Especial;

?> 
 <div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          VENTA ESPECIAL</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<div class="row">
    <div class="col-md-6 btn-outline-info z-depth-2" id="origen">
        <?php
        $especiales->ProductoEspecial(); 
         ?>
    </div>
    <div class="col-md-6 btn-outline-danger z-depth-2" id="destino">
      <?php
        $especiales->VerProductos($_SESSION["mesa"],$url); 
         ?>
    </div> 
</div>   <!-- row -->
<!-- ./  content -->
      </div>
      <div class="modal-footer">
        <?php 
        if($_REQUEST["view"]==1){
            $url="?view&mesa=".$_REQUEST["mesa"]."&select=".$_REQUEST["cliente"];
          } else {
            $url="?";
          }
          $url=urlencode($url);
          ?>
        <a href="application/src/routes.php?op=20v&url=<?php echo $url ?>" class="btn red btn-rounded">Cancelar todo</a>  
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->