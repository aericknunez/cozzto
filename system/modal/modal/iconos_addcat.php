     <!-- Modal para modificar la orden -->
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Registrar nueva categoria</h5>
      </div>
      <div class="modal-body">


<form id="form1" name="form1"  enctype="multipart/form-data" method="post" action="?modal=selectimg" >

     <input type="text" name="nombre" id="nombre"  class="form-control mb-4"  placeholder="Nombre" autofocus /> 
      <input type="hidden" name="op" id="op" value="4" />

    
    <input type="submit" name="Enviar" id="Enviar"  class="btn btn-info btn-block my-4" value="Enviar" /> 

</form>

      </div>
      <div class="modal-footer">

          <a href="?iconos" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->