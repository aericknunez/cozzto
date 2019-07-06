<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/gastos/Gasto.php';
include_once 'system/corte/Corte.php';
$db = new dbConn();

if(Corte::UltimaFecha() == date("d-m-Y")){
Alerts::CorteEcho("gastos");
	} else {

?>


<div class="row d-flex justify-content-center">
  <div class="col-sm-6">
<h3>Gasto y Compras</h3>

<form class="text-center border border-light p-3" id="form-gastos" name="form-gastos">
    
<input type="text"  id="gasto" name="gasto" class="form-control mb-3" placeholder="Gasto">
<select class="browser-default custom-select mb-3" id="tipo" name="tipo">
  <option value="1" selected>GASTOS NO FACTURADOS</option>
  <option value="2">COMPRAS CON FACTURAS</option>
  <option value="3">REMESAS</option>
  <option value="4">ADELANTO A PERSONAL</option>
  <option value="5">CHEQUES</option>
</select>
Descripci&oacuten
<textarea type="text" id="descripcion" name="descripcion" class="form-control mb-3"></textarea>

<input type="text" id="cantidad" name="cantidad" class="form-control mb-3" placeholder="Cantidad">
<button class="btn btn-info btn-block my-4" type="submit" id="btn-gastos" name="btn-gastos">Agregar Gasto</button>
 </form>

  </div>


</div>

<hr>
<div  class="col-sm-12" id="gastos">
 <?php 
  Gasto::VerGastos();
   ?>
</div> 

<?php 
}
 ?>