<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/historial/Historial.php';
$db = new dbConn();
?>

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-cortes" method="post" id="form-cortes">
    <input placeholder="Seleccione una fecha" type="text" id="fecha1" name="fecha1" class="form-control datepicker my-2">
    <input placeholder="Seleccione una fecha" type="text" id="fecha2" name="fecha2" class="form-control datepicker my-2">

	<input name="btn-cortes" type="submit" id="btn-cortes" value="Mostrar datos" class="btn btn-outline-info btn-rounded btn-sm btn-block waves-effect">
      </form> 
    </div>
  </div>

<div id="contenido">

<div class="row justify-content-md-center"><img src="assets/img/loading.gif" alt=""></div>

</div>