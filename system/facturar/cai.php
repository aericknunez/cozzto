<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 
$db = new dbConn();

?>


<div class="row d-flex justify-content-center">
  <div class="col-sm-6">

<h3>AGREGAR NUEVO CAI</h3>

<form class="text-center border border-light p-3" id="form-cai" name="form-cai"> 
    <div class="form-row mb-4">
        <div class="col">
            <input type="text" id="inicial" name="inicial" autocomplete="off" class="form-control mb-2" placeholder="Inicial"> 
        </div>
        <div class="col">
            <input type="text" id="final" name="final" autocomplete="off" class="form-control mb-2" placeholder="Final">
        </div>
    </div>
<input placeholder="Seleccione una fecha" type="text" id="fechalimite" name="fechalimite" class="form-control datepicker my-2">
    <label for="fecha">Fecha Limite</label>
<input type="text" id="cai" name="cai" autocomplete="off" class="form-control mb-2" placeholder="CAI">
<button class="btn btn-info btn-block my-4" type="submit" id="btn-cai" name="btn-cai">Agregar RTN</button>
</form>

  </div>
</div>

<div id="resultado" class="my-4 text-center">
 <?php 
     $facturar->ListarCai();            
  ?> 
</div>