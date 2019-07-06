<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Agregar Opciones</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();

if ($r = $db->select("nombre", "opciones", "WHERE cod = ".$_REQUEST["cod"]." and td = ".$_SESSION["td"]."")) { 
        echo "<h2>".$r["nombre"]. "</h2>";
    } unset($r); 
 ?>  
<form name="form-addopciones" id="form-addopciones" enctype="multipart/form-data" method="post" action="?modal=selectimg" >
<input type="hidden" name="op" id="op" value="11" />
<input type="hidden" name="codigo" id="codigo" value="<? echo $_REQUEST["cod"]; ?>" />
<input type="text" name="nombre" id="nombre" class="form-control mb-4" placeholder="Nombre" autofocus />

<input name="btn-addopciones" type="submit" id="btn-addopciones" value="Agregar" class="btn btn-info btn-block my-4">
</form>

<div id="veropcion">
<?php  
include_once 'system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->VerOpcionesName($_REQUEST["cod"]);
?>  
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