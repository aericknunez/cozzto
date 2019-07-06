<script type="text/JavaScript" src="assets/login/sha512.js"></script> 
<script type="text/JavaScript" src="assets/login/forms.js"></script> 
     <!-- Modal para modificar la orden -->
<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
          Registrar nuevo Usuario</h5>
      </div>
      <div class="modal-body">

        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>

        <form method="post" name="registration_form" action="">
            <input type='text' name='username' id='username' class="my-1 form-control" placeholder="Usuario" />
            <input type="text" name="email" id="email" class="my-2 form-control" placeholder="email"/>
            <input type="password" name="password" id="password" class="my-1 form-control" placeholder="Password"/>
            <input type="password" name="confirmpwd" id="confirmpwd" class="my-1 form-control" placeholder="Confirmar Password"/>
            <input type="button" value="Registrar" class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-4 waves-effect" onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
      </div>
      <div class="modal-footer">

          <a href="?user" class="btn btn-primary btn-rounded">Regresar</a>
    
      </div>
    </div>
  </div>
</div>
<!-- ./  Modal -->