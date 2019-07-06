<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/facturar/Facturar.php';
$facturar = new Facturar; 
$db = new dbConn();

?>

<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { ?>

<div class="row">
<div class="col-md-6 btn-outline-info z-depth-2" id="origen">
AGREGAR FACTURA

<form class="text-center border border-light p-3" id="form-factura" name="form-factura"> 
    <div class="form-row mb-4">
        <div class="col">
            <input type="text" id="nombre" name="nombre" autocomplete="off" class="form-control mb-2" placeholder="Nombre"> 
        </div>
        <div class="col">
            <input type="text" id="imagen" name="imagen" autocomplete="off" class="form-control mb-2" placeholder="Imagen">
        </div>    
  </div>
          <select class="browser-default custom-select mb-3" id="tipo" name="tipo">
            <option value="1" selected>Ticket</option>
            <option value="2">Factura</option>
          </select> 
TEXTOS
    <div class="form-row mb-4">
        <div class="col">
            <input type="text" id="txt1" name="txt1" autocomplete="off" class="form-control mb-2" placeholder="TXT1"> 
        </div>
        <div class="col">
            <input type="text" id="txt2" name="txt2" autocomplete="off" class="form-control mb-2" placeholder="TXT2">
        </div>
        <div class="col">
            <input type="text" id="txt3" name="txt3" autocomplete="off" class="form-control mb-2" placeholder="TXT3">
        </div>
        <div class="col">
            <input type="text" id="txt4" name="txt4" autocomplete="off" class="form-control mb-2" placeholder="TXT4">
        </div>       
    </div>

ENTRELINEADO
    <div class="form-row mb-4">
        <div class="col">
            <input type="text" id="n1" name="n1" autocomplete="off" class="form-control mb-2" placeholder="N1"> 
        </div>
        <div class="col">
            <input type="text" id="n2" name="n2" autocomplete="off" class="form-control mb-2" placeholder="N2">
        </div>
        <div class="col">
            <input type="text" id="n3" name="n3" autocomplete="off" class="form-control mb-2" placeholder="N3">
        </div> 
        <div class="col">
            <input type="text" id="n4" name="n4" autocomplete="off" class="form-control mb-2" placeholder="N4">
        </div>        
    </div>


<button class="btn btn-info btn-block my-4" type="submit" id="btn-factura" name="btn-factura">Agregar FACTURA</button>
</form>



</div>

<div class="col-md-6 z-depth-2" id="destino">
FACTURAS
<div id="facturas">
<?php Facturar::VerTickets(); ?>
</div>

</div> 
</div>   <!-- row -->

<br> <hr>

<div class="row">
<div class="col-md-6 btn-outline-info z-depth-2" id="origen">
AGREGAR IMPRESOR


<form class="text-center border border-light p-3" id="form-impresora" name="form-impresora"> 
    <div class="form-row mb-4">
        <div class="col">
            <input type="text" id="impresora" name="impresora" autocomplete="off" class="form-control mb-2" placeholder="Impresora"> 
        </div>
        <div class="col">
            <input type="text" id="comentarios" name="comentarios" autocomplete="off" class="form-control mb-2" placeholder="Comentarios">
        </div>
    </div>
<button class="btn btn-info btn-block my-4" type="submit" id="btn-impresora" name="btn-impresora">Agregar impresora</button>
</form>

</div>



<div class="col-md-6 z-depth-2" id="destino">

IMPRESORAS
<div id="impresoras">
  <?php Facturar::VerImpresoras(); ?>
</div>

</div> 
</div>   <!-- row -->

<hr> <br>

<?php } ?>


<div class="row">
<div class="col-md-6 btn-outline-info z-depth-2" id="origen">
AGREGAR USUARIOS


<form class="text-center border border-light p-3" id="form-usuarios" name="form-usuarios"> 

<select class="browser-default custom-select mb-3" id="tipo" name="tipo">
  <option value="1" selected>Ticket</option>
  <option value="2">Factura</option>
</select> 

<select class="browser-default custom-select mb-3" id="ticket" name="ticket">

  <?php 
    $a = $db->query("SELECT * FROM facturar_ticket WHERE td = ".$_SESSION["td"]."");
    foreach ($a as $b) {

        echo '<option value="'.$b["id"].'">'.$b["nombre"].'</option>';

    }$a->close();
   ?>
</select>

<select class="browser-default custom-select mb-3" id="impresora" name="impresora">
  <?php 
    $a = $db->query("SELECT * FROM facturar_impresora WHERE td = ".$_SESSION["td"]."");
    foreach ($a as $b) {

        echo '<option value="'.$b["id"].'">'.$b["impresora"].'</option>';

    }$a->close();
   ?>
</select> 

<input type="text" id="clase" name="clase" autocomplete="off" class="form-control mb-2" placeholder="Clase">

<button class="btn btn-info btn-block my-4" type="submit" id="btn-usuarios" name="btn-usuarios">Agregar Usuario</button>
</form>

</div>



<div class="col-md-6 z-depth-2" id="destino">
USUARIOS
<div id="usuarios">
  <?php Facturar::VerUsuarios(); ?>
</div>

</div> 
</div>   <!-- row -->
