<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/historial/Historial.php';
$db = new dbConn();
?>

  <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
        <form name="form-gdiario" method="post" id="form-gdiario">
    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
    <label for="fecha">Fecha a buscar</label>
	<input name="btn-gdiario" type="submit" id="btn-gdiario" value="Mostrar datos" class="btn btn-outline-info btn-rounded btn-sm btn-block waves-effect">
      </form> 
    </div>
  </div>

<div class="row justify-content-md-center" id="loaderx">
	<img src="assets/img/loading.gif" alt=""></div>

<div id="contenido">
<?php 
	$historial = new Historial;
	$historial->HistorialGDiario(date("d-m-Y"));

 ?>
</div>