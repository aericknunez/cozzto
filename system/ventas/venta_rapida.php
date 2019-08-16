<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
$venta = TRUE;
$tventa = 1;

include_once 'system/ventas/VentasR.php';
$ventas = new Ventas(); 
include_once 'application/common/Mysqli.php';
$db = new dbConn();

?>
<div align="center">
  <div class="col-md-6 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
      	<form id="form-busquedaR">
        <input class="form-control" type="text" placeholder="Codigo del Producto" aria-label="Search" id="cod" name="cod" autofocus>
         <button class="btn aqua-gradient btn-rounded btn-sm" type="submit" id="btn-busquedaR" name="btn-busquedaR">Buscar</button>
        </form>
      </div>
  </div>
</div>
<!-- hasta aqui llega la busqueda -->



<div id="ver">
<?php 
$ventas->VerProducto();	
 ?>
</div>  <!--  Aqui ira el resultado de lo precesado -->
