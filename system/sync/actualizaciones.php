<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

?>
<h1>ACTUALIZACIONES</h1>


<div class="row justify-content-md-center" id="loaderx">
    <img src="assets/img/loading.gif" alt=""></div>

<div id="mostrar"></div>

<?php if(Helpers::ServerDomain() == FALSE and $_SESSION["tipo_cuenta"] == 1){ ?>
<a id="actualizar" op="166" class="btn btn-success">Actualizar Archivo de Control</a>
<?php } ?>