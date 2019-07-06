<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Mysqli.php';
$db = new dbConn();
include_once 'system/search/Busqueda.php';


$a = $db->query("SELECT * FROM ticket WHERE num_fac='".$_POST["search"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
$registros = $a->num_rows;
$a->close();

if($registros != 0){
?>


<div class="row">
 <div class="col-sm-6">
  <h3>Opciones</h3>
  <div id="ventana"></div>
<hr>
<?php if($_SESSION["tx"]==1){
echo '<a id="imprimir-factura" op="86" tipo="2" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fa fa-print"></i></a>';

    if ($r = $db->select("edo", "ticket", "WHERE num_fac='".$_POST["search"]."' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        if($r["edo"] == 1){
        	echo '<a id="mensaje-borrar" op="82" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-danger" title="Elimiar Factura"><i class="fa fa-trash"></i></a>';

        }
    } unset($r); 

} else {
echo '<a id="imprimir-factura" op="86" tipo="1" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-mdb-color" data-toggle="tooltip" title="Imprimir Factura"><i class="fa fa-print"></i></a>

<a id="mensaje-borrar" op="80" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-danger" title="Elimiar Factura"><i class="fa fa-trash"></i></a>

<a id="mensaje-pasar" op="84" iden="'.$_POST["search"].'" class="btn-floating btn-lg btn-warning" title="Cambiar Orden"><i class="fa fa-refresh"></i></a>'; 
}


?>


</div>


<div  class="col-sm-6" id="unidades">
 <h3>Detalles de la factura # <?php echo $_POST["search"] ?></h3>
<hr>
<?php 
Busqueda::VerProductosFactura($_POST["search"]);
?>
<!-- <a href="" class="btn btn-danger">Cancelar</a> -->


</div> 


</div>
<?php 
} else {
	echo '<div align="center"><h2>No se ha encontrado ningun registro con este numero de factura</h2></div>';
}


 ?>