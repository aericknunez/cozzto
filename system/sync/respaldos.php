<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'application/common/Mysqli.php';
$db = new dbConn();
include_once 'system/corte/Corte.php';
include_once 'system/sync/Sync.php';
$sync = new Sync();
?>
<h1>RESPALDOS PENDIENTES <?php 

echo '<a href="?modal=respaldar&type=2" class="btn-floating btn-sm red"><i class="fa fa-download"></i></a> Configuraciones';
 ?></h1>

<?php if(isset($_REQUEST["msj"])){
    echo '<div class="alert alert-danger">
 Se ha detectado que en los &uacuteltimos dias hubo actividad en el sistema pero por alg&uacutena raz&oacuten no se hubo registro de cortes o respaldos. <br>
 Puede hacer los cortes y respaldos uno a uno en esta secci&oacuten 
</div> ';
} ?>


<div class="row">
    <div class="col-md-6 btn-outline-info z-depth-2" id="origen">
    <h4>Estado de corte de los ultimos 7 dias</h4>
    <?php 
    $sync->ListaCortes();
     ?>
    </div>
    
    <div class="col-md-6 btn-outline-danger z-depth-2" id="destino">
	<h4>Estado de respaldos de los ultimos 7 dias</h4>
    <?php 
    $sync->ListaRespaldos();
     ?>
    </div>
   
</div>
