<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();

$a = $db->query("SELECT * FROM gastos_images WHERE gasto = ".$_REQUEST["gasto"]."");
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Imagenes</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<div align="center">
<?php 
    foreach ($a as $b) {
      echo '<a id="mostrarimagen" op="121" iden="'.$b["id"].'"><img src="assets/img/facturas/'.$b["imagen"].'" alt="thumbnail" class="img-thumbnail z-depth-3"
  style="width: 100px; height: 75px"></a>';

    }

    echo "<br><br>El numero de registros es: ". $a->num_rows;
    
    $a->close();

 ?>
</div>

<div id="mostrar" align="center"><img src="assets/img/logo/<?php echo $_SESSION['config_imagen'] ?>" class="img-fluid" alt="Responsive image"></div>
<!-- ./  content -->
      </div>
      <div class="modal-footer">
          <a href="?modal=imageup&gasto=2" class="btn green btn-rounded">Agregar Imagenes</a>

          <a href="?gastos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->