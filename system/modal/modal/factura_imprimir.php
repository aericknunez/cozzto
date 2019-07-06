<?php
include_once 'application/common/Mysqli.php';
$db = new dbConn();
//////////////// este archivo nad mas sirve para imprimir el ticket o factura antes de ser cobrado.
?>
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Imprimir</h5>
      </div>
      <a href="?">
      <div class="modal-body">
<!-- ./  content -->
<?php 
if($_REQUEST["cancela"] != NULL){ 
 $a = $db->query("SELECT sum(stotal) FROM ticket_temp WHERE cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
 } else { 
 $a = $db->query("SELECT sum(stotal) FROM ticket_temp WHERE mesa = ".$_REQUEST["mesa"]."  and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
}
    foreach ($a as $b) {
        $stotal=$b["sum(stotal)"];
    } $a->close();
//////////////////
if($_REQUEST["cancela"] != NULL){ 
$a = $db->query("SELECT sum(imp) FROM ticket_temp WHERE cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
 } else { 
$a = $db->query("SELECT sum(imp) FROM ticket_temp WHERE mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"].""); 
}
foreach ($a as $b) {
        $imp=$b["sum(imp)"];
    } $a->close();


//////////////////
if($_REQUEST["cancela"] != NULL){ 
$a = $db->query("SELECT sum(total) FROM ticket_temp WHERE cancela = ".$_REQUEST["cancela"]." and mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
 } else { 
$a = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa = ".$_REQUEST["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
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
 ?> 


      </div></a>
      <div class="modal-footer">

          <a href="?" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->