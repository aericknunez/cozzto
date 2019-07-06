<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Modificar Iconos</h5>
      </div>
      <div class="modal-body">
<!-- contenido -->
<div class="row text-center portfolio"> 
   <ul class="gallery">

<?php 
$a = $db->query("Select * from images where popup=".$_REQUEST["cod"]." and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($a as $b) {
    $img=$b['img_name'];
    $cod=$b["cod"];
    $pop=$b["popup"];

  if ($r = $db->select("nombre,cat", "precios", "where cod='$cod' td = ".$_SESSION["td"]."")) { 
    $nombres=$r["nombre"]; $cat=$r["cat"];
    }

    if ($r = $db->select("categoria", "categorias", "where cod='$cod' td = ".$_SESSION["td"]."")) { 
        $nombres=$r["categoria"]; 
        }

    echo "<li><a href='?modal=modproducto&cod=$cod&name=$nombres&img=$img&cat=$cat&pop=".$_REQUEST["cod"]."'><em>$nombres</em><img src='$img' alt='image' class='img-fluid img-responsive wow fadeIn' /></a></li>";
    
    }
    $a->close();

 ?>

  <br>
   </ul> 

</div>


<!-- contenido -->
      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->