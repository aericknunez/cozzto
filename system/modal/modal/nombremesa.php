<?php 
include_once 'application/common/Mysqli.php';
$db = new dbConn();

if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$_GET["mesa"]." and tx = ".$_SESSION["tx"]." and td =".$_SESSION["td"]."")) { 
            $nmesa = $r["nombre"];
        } unset($r);


if($_POST){

    if($_POST["nombre"] != NULL){

        if($nmesa == NULL){ // insertamos
                   $datos = array();
                    $datos["mesa"] = $_GET["mesa"];
                    $datos["tx"] = $_SESSION["tx"];
                    $datos["nombre"] = $_POST["nombre"];
                    $datos["fecha"] = date("d-m-Y");
                    $datos["hora"] = date("H:i:s");
                    $datos["td"] = $_SESSION["td"];
                    $db->insert("mesa_nombre", $datos); 

        } else { // actualizamos

              $cambio = array();
              $cambio["nombre"] =$_POST["nombre"];
              $db->update("mesa_nombre", $cambio, "WHERE mesa = ".$_GET["mesa"]." and tx = ".$_SESSION["tx"]." and td =".$_SESSION["td"]."");

        }
        echo '<script>
          window.location.href="?view&mesa='.$_GET["mesa"].'"
        </script>';
        exit();
    }
}

 ?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
         NOMBRE DE LA MESA</h5>
      </div>
      <div class="modal-body">
<!-- ./  content -->

<form id="form1" name="form1" method="post" action="" >

     <input type="text" name="nombre" id="nombre"  class="form-control mb-4"  placeholder="Nombre" autofocus <?php if($nmesa != NULL) echo 'value = "'.$nmesa.'"' ?> />
    
    <input type="submit" name="Enviar" id="Enviar"  class="btn btn-info btn-block my-4" value="Enviar" /> 

</form>

<!-- ./  content -->
      </div>
      <div class="modal-footer">

          <a href="?view&mesa=<?php echo $_GET["mesa"] ?>" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->