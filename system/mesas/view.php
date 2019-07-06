<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Mysqli.php';
include_once 'system/mesas/Mesa.php';
$mesas = new Mesa;
$db = new dbConn();

unset($_SESSION['client-asign']);
$_SESSION["mesa"] = $_REQUEST["mesa"];
$_SESSION["view"] = "1"; // esta hace que la mesa este activada para saber que biene de view

 ?>

 <div id="clientes">
<?php
$mesas->VerClientes($_REQUEST["mesa"]);
 ?>  
 </div>
   <?php 
// para agregarle el numbre de la mesa a la ventana
    if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ". $_REQUEST["mesa"]. " and tx = ". $_SESSION["tx"]." and td = ". $_SESSION["td"]."")) { 
        $mesa_nombre = $r["nombre"];
    } unset($r);  echo "<div align='center'>" . $mesa_nombre . "</div>";

 ?> 
 <hr>
<div id="iconos" align="center">
<img src="assets/img/loading.gif">
</div>
<div id="ventana"></div>
  <div class="modal fade top" id="NuevoCliente" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
      data-backdrop="false">
      <div class="modal-dialog modal-frame modal-bottom modal-notify modal-info" role="document">
          <div class="modal-content">
              <div class="modal-body">
                  <div class="row d-flex justify-content-center align-items-center">

                      <p class="pt-3 pr-2">En verdad desea agregar un nuevo cliente a esta mesa?</p>

                      <a id="nuevo-cliente" op="44" clientes="<?php echo $clientes + 1; ?>" mesa="<?php echo $_SESSION["mesa"]; ?>" class="btn btn-info">Agregar
                          <i class="fa fa-diamond ml-1"></i>
                      </a>
                      <a type="button" class="btn btn-outline-info waves-effect" data-dismiss="modal">Cerrar</a>
                  </div>
              </div>
          </div>
      </div>
  </div>