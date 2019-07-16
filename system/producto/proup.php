<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Mysqli.php';
$db = new dbConn();

?>


<div align="center">
  <div class="col-md-6 z-depth-2 justify-content-center">
      <div class="md-form mt-0">
        <input class="form-control" type="text" placeholder="Buscar" aria-label="Search" id="producto-busqueda" name="producto-busqueda" autofocus>
      </div>
  </div>
  <div class="col-md-6 z-depth-2 justify-content-center" id="muestra-busqueda"></div>
</div>



<div id="contenido">
<?php if($_REQUEST["key"] != NULL){ ?>
  <form id="form-proadd">
  
  <div class="form-row">
    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Codigo Producto</label>
      <input type="number" class="form-control" id="cod" name="cod" required>
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Descripci&oacuten</label>
      <input type="text" class="form-control" id="descripcion" name="descripcion" required>
    </div>

  </div>


  <div class="form-row">


    <div class="col-md-4 mb-1 md-form">
      <?php $a = $db->query("SELECT iden, nombre FROM proveedores WHERE td = ".$_SESSION["td"].""); ?>
      <select class="browser-default custom-select" id="proveedor" name="proveedor">
        <option selected disabled>Proveedor</option>
        <?php foreach ($a as $b) {
        echo '<option value="'. $b["iden"] .'">'. $b["nombre"] .'</option>'; 
        } $a->close(); ?>
      </select>
    </div>


    <div class="col-md-4 mb-1 md-form">
      <?php $c = $db->query("SELECT iden, categoria FROM producto_categoria WHERE td = ".$_SESSION["td"].""); ?>
      <select class="browser-default custom-select" id="categoria" name="categoria">
        <option selected disabled>* Categorias</option>
        <?php foreach ($c as $d) {
        echo '<option value="'. $d["iden"] .'">'. $d["categoria"] .'</option>'; 
        } $c->close(); ?>
      </select>
    </div>

    <div class="col-md-4 mb-1 md-form">
      <?php  $e = $db->query("SELECT iden, nombre FROM producto_unidades WHERE td = ".$_SESSION["td"].""); ?>
        <select class="browser-default custom-select" id="medida" name="medida">
        <option selected disabled>* Unidad de Medida</option>
        <?php foreach ($e as $f) {
        echo '<option value="'. $f["iden"] .'">'. $f["nombre"] .'</option>'; 
        } $e->close();
         ?>
      </select>
    </div>

  </div>

  <div class="form-row">
    
    <div class="col-md-4 mb-1 md-form">
      <label for="cantidad">* Cantidad</label>
      <input type="number" step="any" class="form-control" id="cantidad" name="cantidad" required>
    </div>

    <div class="col-md-4 mb-1 md-form">
      <label for="existencia_minima">* Existencia Minima</label>
      <input type="number" class="form-control" id="existencia_minima" name="existencia_minima" required>
    </div>
  
  <div class="col-md-4 mb-1 md-form">
        <div class="switch">
            <label>
            * Gravado ||  Off
              <input type="checkbox" id="gravado" name="gravado">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>

  <div class="form-row">
    
    <div class="col-md-12 mb-1 md-form">
      <textarea id="informacion" name="informacion" class="md-textarea form-control" rows="3"></textarea>
      <label for="informacion">Informaci&oacuten adicional</label>
    </div>

  </div>


  <div class="form-row">
  
  <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Servicio ||  Off
              <input type="checkbox" id="servicio" name="servicio">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Compuesto ||  Off
              <input type="checkbox" id="compuesto" name="compuesto">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

   <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Caduca ||  Off
              <input type="checkbox" id="caduca" name="caduca">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

    <div class="col-md-3 mb-1 md-form">
        <div class="switch">
            <label>
             Dependiente ||  Off
              <input type="checkbox" id="dependiente" name="dependiente">
              <span class="lever"></span> On 
            </label>
          </div>
    </div>

  </div>






  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-proadd"><i class="fa fa-floppy-o mr-1"></i> Guardar y continuar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->
<? } ?>
</div> <!-- TERMINA CONTENIDO -->