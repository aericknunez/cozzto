<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/gastos/Gasto.php';
$gasto = new Gastos();

include_once 'system/corte/Corte.php';
$cut = new Corte();
if($cut->UltimaFecha() != date("d-m-Y")){ // comprobacion de corte
?>

<div class="row d-flex justify-content-center">
  <div class="col-md-6">
<h3>ENTRADAS DE EFECTIVO</h3>

<form class="text-center border border-light p-3" id="form-entradas" name="form-entradas">

Descripci&oacuten
<textarea type="text" id="descripcion" name="descripcion" class="form-control mb-3"></textarea>

<input type="number" step="any" id="cantidad" name="cantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-info my-4" type="submit" id="btn-entradas" name="btn-entradas">Agregar Efectivo</button>
 </form>

  </div>


</div>

<hr>
<div  class="col-sm-12" id="contenido">
 <?php 
  $gasto->VerEntradas();
   ?>
</div> 



<?php 
} else { /// termina comprobacion de corte
	Alerts::CorteEcho("Ingresos de efectivo");
}
 ?>