<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/productos/Producto.php';
include_once 'application/common/Encrypt.php';
$db = new dbConn();
?>

<nav class="navbar navbar-expand-lg navbar-dark primary-color">
    <a class="navbar-brand">Opciones de productos</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false"
        aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item <?php if($_REQUEST["x"] == "1") echo "active"; ?>">
                <a class="nav-link" href="index.php?producto&x=1">Materia Prima <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item <?php if($_REQUEST["x"] == "2") echo "active"; ?>">
                <a class="nav-link" href="index.php?producto&x=2">Porciones</a>
            </li>
            <li class="nav-item <?php if($_REQUEST["x"] == "3") echo "active"; ?>">
                <a class="nav-link" href="index.php?producto&x=3">Productos</a>
            </li>
            <li class="nav-item <?php if($_REQUEST["x"] == "4") echo "active"; ?>">
                <a class="nav-link" href="index.php?producto&x=4">Unidades de Medida </a>
            </li>
        </ul>
    </div>
</nav>

<!-- Tab panels -->
   <?php if($_REQUEST["x"] == "1"){ 
    ?>
<div class="row">
  <div class="col-sm-6">

 <h2>Nueva Materia Prima</h2>
Esta secci&oacuten es solamente para agregar el producto por primera vez
<form name="form-materia" method="post" id="form-materia" class="text-center border border-light p-2">
    
    <input type="text" id="nombre" name="nombre" class="form-control mb-2" placeholder="Nombre" required="yes">

   <select id="unidad" name="unidad" class="browser-default form-control mb-2" required="yes">
    <option disabled selected>Unidades de Media</option>
    <?php 
    $a = $db->query("SELECT * FROM pro_unidades_medida WHERE td = ". $_SESSION["td"] ." ORDER BY iden");
    foreach ($a as $b) {
        echo '<option value='. $b["iden"] .'>'. $b["unidad"] .'</option>';
    }
    $a->close();
     ?>
  </select>

    <input type="number" id="cantidad" name="cantidad" step="any" class="form-control mb-2" placeholder="Cantidad" required="yes">
    <button class="btn btn-info my-4" name="btn-materia" id="btn-materia" type="submit">Agregar Producto</button>

</form>

  </div>


<div  class="col-sm-6">
 <h3>Detalle</h3>

 <?php
  echo '<div id="productos">'; 
    Producto::VerMateria($_REQUEST["page"]);
  echo '</div>';
?>
</div> 


</div>

<? } ?> 
    <!--/.Panel 1-->

    <!--Panel 2-->



  <?php if($_REQUEST["x"] == "2"){ 
    ?>
<div class="row">
  <div class="col-sm-6">

        <h2>Nuevas Porciones</h2>
        <form name="form-porciones" id="form-porciones" class="text-center border border-light p-2">
    
    <input type="text" id="nombre" name="nombre" class="form-control mb-2" placeholder="Nombre" required="yes">

   <select id="producto" name="producto" class="browser-default form-control mb-2" required="yes">
    <option disabled selected>Seleccione Materia Prima</option>
    <?php 
    $a = $db->query("SELECT * FROM pro_bruto WHERE td = ". $_SESSION["td"] ." ORDER BY id");
    foreach ($a as $b) {
        echo '<option value='. $b["iden"] .'>'. $b["nombre"] .'</option>';
    }
    $a->close();
     ?>
  </select>

    <input type="number" id="cantidad" name="cantidad" step="any" class="form-control mb-2" placeholder="Cantidad" required="yes">
    <button class="btn btn-info my-4" id="btn-porciones" name="btn-porciones" type="submit">Agregar Porci&oacuten</button>

</form>

  </div>


<div  class="col-sm-6">
 <h3>Detalle</h3>

 <?php
  echo '<div id="productos">'; 
    Producto::VerPorciones($_REQUEST["page"]);
  echo '</div>';
?>
</div> 


</div>

<? } ?>  
    <!--/.Panel 2-->

    <!--Panel 3-->
<?php if($_REQUEST["x"] == "3"){
 ?>
 <h2>Productos</h2>

<?php 
echo '<div id="productos">';
Producto::VerPlatillos($_REQUEST["page"]);
echo '</div>';
}
?>

    <!--/.Panel 3-->

    <!--Panel 4-->
<?php if($_REQUEST["x"] == "4"){ 
    ?>
<div class="row">
  <div class="col-sm-6">
     <h2>Nueva Unidad de medida</h2>
     <form name="form-unidades" id="form-unidades" class="text-center border border-light p-2">
     <input type="text" id="nombre" name="nombre" class="form-control mb-2" placeholder="Nombre de la Unidad" required="yes">
     <input type="text" id="abreviacion" name="abreviacion" class="form-control mb-2" placeholder="Abreviacion" required="yes">
    <button class="btn btn-info my-4" id="btn-unidades" name="btn-unidades" type="submit">Agregar Unidad</button>
</form>
  </div>


<div  class="col-sm-6">
 <h3>Detalle</h3>

 <?php
  echo '<div id="productos">'; 
    Producto::VerUnidad($_REQUEST["page"]);
  echo '</div>';
?>
</div> 


</div>

<? } ?>