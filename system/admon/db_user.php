<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Mysqli.php';
$db = new dbConn();

include_once 'system/admon/Admin.php';
$admon = new Admin;

?>
<h1>Sync de base de datos</h1>

<?php   
echo '<div id="contenido">';
$admon->VerHashes();
echo '</div>';
 ?>

 <div class="row d-flex justify-content-center text-center">
	  <div class="col-sm-6">

<?php  if($_SESSION["tipo_cuenta"] == 1){ ?>
	 <pre>Agregar nuevo registro</pre>	

	<form class="text-center border border-light p-2" method="post" id="form-new-hash" name="form-new-hash">
	
 	<input type="text"  id="hash" name="hash" class="form-control mb-3" placeholder="hash">
	<button class="btn btn-success" type="submit" id="btn-new-hash" name="btn-new-hash">AGREGAR</button>
	</form>

<?php } ?>
	  </div>
	</div>