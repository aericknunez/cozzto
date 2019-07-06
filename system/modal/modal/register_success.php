<div class="modal" id="<? echo $_GET["modal"]; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"  data-backdrop="false">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">
           <? echo $_REQUEST["user"]; ?> Ya casi terminamos...</h5>
      </div>
      <div class="modal-body">

<?php 
if($_REQUEST["op"] == "actualizar"){
include_once 'application/common/Mysqli.php';
$db = new dbConn();
$usuario = sha1($_REQUEST["user"]);
    if ($r = $db->select("nombre, tipo", "login_userdata", "WHERE user = '$usuario'")) { 
        $name = $r["nombre"]; $type = $r["tipo"];
    } else {
        echo "- No Record Found!<br />";
    }
    unset($r); 
  
  $opciones = 'id="form-actualizar" name="form-actualizar"';
$boton='<button class="btn btn-outline-warning" type="submit" id="btn-actualizar" name="btn-actualizar">Actualizar<i class="fa fa-paper-plane-o ml-2"></i></button>';
} 
else{
 $opciones = 'id="form-user" name="form-user"';
$boton='<button class="btn btn-outline-warning" type="submit" id="btn-user" name="btn-user">Terminar<i class="fa fa-paper-plane-o ml-2"></i></button>'; 
} 
 ?>

<?php 
if($_SESSION['tipo_cuenta'] == 1 or $_SESSION['tipo_cuenta'] == 2 or $_SESSION["user"]==$usuario){
  ?>
<!-- Default form contact -->
<form name="form1" method="post" <?php echo $opciones; ?>>
    <label for="nombre" class="grey-text">Nombre</label>
    <input type="text" id="nombre" name="nombre" class="form-control" placeholder="Nombre" 
    <?php 
        if(isset($_REQUEST["op"])){ echo 'value="'.$name.'"'; } 
     ?> required="yes" >
 
    <input type="hidden" id="user" name="user" value="<? echo $_REQUEST["user"]; ?>">

<!-- solo para usuarios root o admin -->
<?php 
if($_SESSION['tipo_cuenta'] != 4){
 ?>

<label>Tipo de Cuenta</label>
<select id="tipo" name="tipo" class="browser-default form-control" required="yes">
    <?php 
        if(!isset($_REQUEST["op"])){ echo '<option value="" disabled selected>Elija una Opcion</option>'; } 
     ?>
    <option <? 
    if(isset($_REQUEST["op"]) && $type == 2) echo "selected"; 
    if($_SESSION['tipo_cuenta'] == 3 or $_SESSION['tipo_cuenta'] == 4 or $_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="2">Administrador</option>
    <option <? 
    if(isset($_REQUEST["op"]) && $type == 3) echo "selected";
    if($_SESSION['tipo_cuenta'] == 3 or $_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="3">Usuario</option>
    <option <? 
    if(isset($_REQUEST["op"]) && $type == 4) echo "selected";
    if($_SESSION['tipo_cuenta'] == 4 or $_SESSION['tipo_cuenta'] == 5) echo "disabled"; ?> value="4">Pantalla</option>
    <option <? 
    if(isset($_REQUEST["op"]) && $type == 5) echo "selected";
    if($_SESSION['tipo_cuenta'] == 5 or $_SESSION['tipo_cuenta'] != 1) echo "disabled"; ?> value="5">Invitado</option>
</select>
<?php 
}
?>

    <div class="text-center mt-2">
        <?php echo $boton; ?>
    </div>
</form>

<?php 
} // del formulario

if($_SESSION["user"]==$usuario){

echo ' <div class="row justify-content-md-center">
    <div class="col-12 col-md-auto">
      
      Cambiar Password
      
      <form name="form-pass-usuarios" method="post" id="form-pass-usuarios">
      <input type="password" class="my-1 form-control" id="pass1" name="pass1" placeholder="Nuevo Password" required autocomplete="off">
      <input type="password" class="my-1 form-control" id="pass2" name="pass2" placeholder="Repetir Password" required autocomplete="off">
      <input name="form-pass-usuarios" type="submit" id="btn-pass-usuarios" value="Cambiar" class="btn btn-outline-info btn-rounded btn-block z-depth-0 my-1 waves-effect">
      </form> 

    </div>
  </div>'; 
}



 ?>
 

<div id="caja_user"></div>
<!-- Default form contact -->

      </div>
      
      <div class="modal-footer">
        <?php 
        if($_REQUEST["op"] == "actualizar"){
        echo '<a href="?user" class="btn btn-primary btn-rounded">Regresar</a>';
        } ?>
      </div>

    </div>
  </div>
</div>