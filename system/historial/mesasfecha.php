<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/mesashoy/Mesas.php';
?>


  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-fechas" method="post" id="form-fechas">
    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
    <label for="fecha">Fecha a buscar</label>
	<input name="btn-fechas" type="submit" id="btn-fechas" value="Mostrar datos" class="btn btn-outline-info btn-rounded btn-sm btn-block waves-effect">
      </form> 
    </div>
  </div>

<div class="row justify-content-md-center" id="loaderx">
	<img src="assets/img/loading.gif" alt=""></div>

<div id="contenido">
</div>
