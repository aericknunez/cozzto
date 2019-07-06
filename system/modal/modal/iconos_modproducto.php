<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Modificar Iconos</h5>
      </div>
      <div class="modal-body">


<form id="form1" name="form1"  enctype="multipart/form-data" method="post" 
action="?modal=selectimg" >
<input type="hidden" name="op" id="op" value="6" />

<input type="text" name="nombre" id="nombre" class="form-control mb-4" placeholder="Nombre" value="<? echo $_REQUEST['name']; ?>" />

<input type="text" name="codigo" id="codigo" class="form-control mb-4" placeholder="Codigo" value="<? echo $_REQUEST['cod']; ?>" readonly > 

<select name="popup" id="popup" class="form-control mb-4 browser-default" placeholder="PopUp" >
<option value="0">Ninguno</option>
<?php
include_once 'application/common/Mysqli.php';
$db = new dbConn();

$d = $db->selectGroup("cod, categoria", "categorias", "WHERE td = ".$_SESSION["td"]." order by categoria");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) {
            echo "<option value='";
    echo $r["cod"];
    echo "'";
    if ($_REQUEST['pop'] == $r["cod"]) echo "selected='selected' ";
    echo ">"; 
    echo $r["categoria"];
    echo "</option>";
        }
    }   
    $d->close();

 ?>

</select>

<input name="Enviar" type="submit" id="Enviar" value="Modificar" class="btn btn-primary btn-rounded"  onclick="return confirmar('Esta seguro que desea modificar el icono?')" ></li>
</form>

<? 
if($_REQUEST['cod'] != "1111" and $_REQUEST['cod'] != "2222") {
?>
<hr>
<p>Eliminar este Icono, Los cambios no se podran deshacer y los productos agrupados en el pasaran a la pantalla principal</p>
<div class="row text-center portfolio"> 
   <ul class="gallery">
<?

echo '<li><a id="deleteicon" op="8" cod="'.$_REQUEST['cod'] .'"><em>Eliminar</em><img src="'. $_REQUEST["img"].'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
?>  
</ul>
</div>
<? } 
else
{
echo "<br><hr>
<p>Este icono no se puede eliminar por que son de uso exclusivo del sistema</p>";
} 
?>

      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->