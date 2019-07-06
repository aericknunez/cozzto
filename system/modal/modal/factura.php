<?php
include_once 'application/common/Mysqli.php';
$db = new dbConn();

// obtengo el numero de la factura
     $a = $db->query("SELECT num_fac FROM ticket WHERE num_fac != 0 and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." order by id desc limit 1");
    foreach ($a as $b) {
        $factura = $b["num_fac"];
    } $a->close();
//
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Factura No. <?php echo $factura ?></h5>
      </div>
      <a href="?">
      <div class="modal-body">
<!-- ./  content -->
<?php 
if($_REQUEST["cancela"] != NULL){ 
 $a = $db->query("SELECT sum(stotal) FROM ticket WHERE num_fac = '$factura' and cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
 } else { 
 $a = $db->query("SELECT sum(stotal) FROM ticket WHERE num_fac = '$factura' and mesa = ".$_REQUEST["mesa"]."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
}
    foreach ($a as $b) {
        $stotal=$b["sum(stotal)"];
    } $a->close();
//////////////////
if($_REQUEST["cancela"] != NULL){ 
$a = $db->query("SELECT sum(imp) FROM ticket WHERE num_fac = '$factura' and cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
 } else { 
$a = $db->query("SELECT sum(imp) FROM ticket WHERE num_fac = '$factura' and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
}
foreach ($a as $b) {
        $imp=$b["sum(imp)"];
    } $a->close();


//////////////////
if($_REQUEST["cancela"] != NULL){ 
$a = $db->query("SELECT sum(total) FROM ticket WHERE num_fac = '$factura' and cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
 } else { 
$a = $db->query("SELECT sum(total) FROM ticket WHERE num_fac = '$factura' and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
}
    foreach ($a as $b) {
        $total=$b["sum(total)"];
    } $a->close();

/// define las variables finales

if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina
 $prop = ' | Propina '.$_SESSION['config_propina'].'% : '. Helpers::Dinero(Helpers::Propina($total));
 $total = Helpers::PropinaTotal($total);
}
if($_REQUEST["efectivo"]==NULL){ $efectivo = $total; } else { $efectivo = $_REQUEST["efectivo"];}

$cambio = $efectivo - $total;

echo '<p class="text-center">Sub Total: '. Helpers::Dinero($stotal) .' ||  Impuestos: '. Helpers::Dinero($imp) . $prop .'</p>';

echo '<p class="text-center font-weight-bold">TOTAL:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">EFECTIVO:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($efectivo) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">CAMBIO:</p>'; 
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($cambio) . '</div>'; 


if($_SESSION["noimprimir"] == NULL){
//////////////// para facturar //////////////
///
$user = $_SESSION["user"];
    $a = $db->query("SELECT * FROM facturar_users WHERE user = '$user' and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {

    $clase = $b["clase"];
    
    if($b["tipo"] == 1){ // para ticket
    include_once 'system/facturar/Ticket.php';
    $imprimir = new Ticket; 
        $imprimir->$clase(2,$factura,$_REQUEST["efectivo"],$b["impresora"],$_REQUEST["mesa"],$b["ticket"]);
    
    } //(tipo,numero,cambio,impresor,mesa,factura_o_tiket)
    // el tipo es 1 =  mesa, 2 = factura, 3 = cancela un cliente
    if($b["tipo"] == 2 and $_SESSION["tx"] == 1){ // para factura
    include_once 'system/facturar/Factura.php';
    $imprimir = new Factura;  // la mesa aqui es solo si es op 3 en el 1er para
        $imprimir->$clase(2,$factura,$_REQUEST["efectivo"],$b["impresora"],$_REQUEST["mesa"],$b["ticket"]);
    //(tipo,numero,cambio,imp,mesa,factura_o_tiket)
    }

    } $a->close();


}

    if($_SESSION["noimprimir"] == 1){ unset($_SESSION["noimprimir"]); } /// elimino la opcion de no imprimir
    // elimino los rtn
    if($_SESSION["rtn"] != NULL and $_SESSION["cliente"] != NULL){
        unset($_SESSION["cliente"]);
        unset($_SESSION["rtn"]); }

 ?> 


      </div></a>
      <div class="modal-footer">

          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->