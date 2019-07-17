<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'system/proveedor/Proveedor.php';
$proveedor = new Proveedores(); 
include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>

<div id="msj"></div>
<h2 class="h2-responsive">Nuevo Proveedor</h2>
<div class="row">
    <div class="col-md-6 btn-outline-black z-depth-2">
            

  <form id="form-addproveedor">
  
  <div class="form-row">

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Nombre</label>
      <input type="text" class="form-control" id="nombre" name="nombre">
    </div>

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Documento</label>
      <input type="text" class="form-control" id="documento" name="documento">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">Registro</label>
      <input type="text" class="form-control" id="registro" name="registro">
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Direcci&oacuten</label>
      <input type="text" class="form-control" id="direccion" name="direccion">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Departamento</label>
      <input type="text" class="form-control" id="departamento" name="departamento">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Municipio</label>
      <input type="text" class="form-control" id="municipio" name="municipio">
    </div>

  </div>


  <div class="form-row">

    <div class="col-md-4 mb-2 md-form">
      <label for="cod">* Giro</label>
      <input type="text" class="form-control" id="giro" name="giro">
    </div>

  <div class="col-md-8 mb-2 md-form">
      <label for="descripcion">* Tel&eacutefono</label>
      <input type="text" class="form-control" id="telefono" name="telefono">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-6 mb-2 md-form">
      <label for="cod">Email</label>
      <input type="text" class="form-control" id="email" name="email">
    </div>

  <div class="col-md-6 mb-2 md-form">
      <label for="descripcion">Nombre Contacto</label>
      <input type="text" class="form-control" id="contacto" name="contacto">
    </div>

  </div>



  <div class="form-row">

    <div class="col-md-12 mb-1 md-form">
      <textarea id="comentarios" name="comentarios" class="md-textarea form-control" rows="3"></textarea>
      <label for="comentarios">Comentarios..</label>
    </div>

  </div>



  <div class="form-row">
    <div class="col-md-12 my-6 md-form text-center">
     <button class="btn btn-info my-4" type="submit" id="btn-addproveedor"><i class="fa fa-floppy-o mr-1"></i> Guardar</button>

    </div>
  </div>

</form>

<!-- TERMINA FORMULARIO PRINCIPAL -->

    </div>
    
    <div class="col-md-6 btn-outline-black z-depth-2" id="destinoproveedor">
          <?php $proveedor->VerProveedores(); ?>
    </div>
   
</div>  <!-- row -->
