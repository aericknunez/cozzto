<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Agregar Producto</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->
<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
 ?>  
<form id="form1" name="form1"  enctype="multipart/form-data" method="post" action="?modal=selectimg" >
 <input type="hidden" name="op" id="op" value="5" />
<input type="text" name="nombre" id="nombre" class="form-control mb-4" placeholder="Nombre" autofocus />

 Categoria:   
    <select name="popup" id="popup" class="form-control mb-4 browser-default" placeholder="PopUp" >

<option value="0" selected="selected">Ninguno</option>
<?php 

$d = $db->selectGroup("cod, categoria", "categorias", "WHERE td = ".$_SESSION["td"]." order by categoria");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {
            echo "<option value='".$r["cod"]."'>" .$r["categoria"]. "</option>";
        }
    }   
    $d->close();

 ?>
</select>


 Opciones:   
    <select name="opcion" id="opcion" class="form-control mb-4 browser-default" placeholder="opcion" >

<option value="0" selected="selected">Ninguno</option>
<?php 
$d = $db->selectGroup("cod, nombre", "opciones", "WHERE td = ".$_SESSION["td"]."");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {
            echo "<option value='".$r["cod"]."'>" .$r["nombre"]. "</option>";
        }
    }   
    $d->close();

 ?>
</select>

  <input type="number" name="precio" id="precio"  step="any" class="form-control mb-4" placeholder="Precio" > 
<input name="Enviar" type="submit" id="Enviar" value="Agregar" class="btn btn-info btn-block my-4"  onclick="return confirmar('Esta seguro que los datos ingresados son correctos?')" >
</form>


<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->