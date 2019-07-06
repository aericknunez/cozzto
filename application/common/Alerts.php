<?php 
class Alerts{

      public function __construct(){
        
      }


       public function Alerta($tipo,$encabezado,$texto){ 
       //tipo = warning , success , error , info , danger
        echo '<script>
        toastr.'.$tipo.'("'.$texto.'", "'.$encabezado.'", {
              "closeButton": true,
              "debug": false,
              "newestOnTop": true,
              "progressBar": false,
              "positionClass": "toast-top-center",
              "preventDuplicates": true,
              "onclick": null,
              "showDuration": 100,
              "hideDuration": 100,
              "timeOut": 2000,
              "extendedTimeOut": 1000,
              "showEasing": "swing",
              "hideEasing": "linear",
              "showMethod": "fadeIn",
              "hideMethod": "fadeOut"
            }) 
        </script>';
        }

        public function Cambios($return){
        echo '<div class="alert alert-info alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            
         Se han realizado los cambios exitosamente. 
        <br>
        <a href="index.php?'.$return.'" class="btn btn-danger waves-effect waves-light">Aceptar</a>
        </div>';
    }


    public function Eliminado(){
        echo '<div class="alert alert-danger ">
        <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
        Se ha eliminado el registro correctamente... 

        </div>';
    }



    public function Eliminar($id,$op,$iden,$return){
        echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
    Esta seguro que desea eliminar este resgistro? Es posible que se pierda informaci&oacuten relacionada a este. 
    <br>
    
    <a id="'.$id.'" op="'.$op.'" iden="'.$iden.'" class="btn btn-default waves-effect waves-light" >Eliminar</a>
    
    <a href="index.php?'.$return.'" class="btn btn-danger waves-effect waves-light">Cancelar</a>

  </div>';
    }




    public function EliminarUsuario($iden, $user){
        echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
    Esta seguro que desea eliminar este usuario? Es posible que se pierda informaci&oacuten relacionada a este. 
    <br>
    
    <a id="deluser" op="3" iden="'.$iden.'" username="'.$user.'" class="btn btn-default waves-effect waves-light" >Eliminar</a>
    
    <a href="?user" class="btn btn-danger waves-effect waves-light">Cancelar</a>

  </div>';
    }

    public function UsuarioEliminado(){
        echo '<div class="alert alert-danger ">
    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
    Usuario Eliminado Correctamente 
    <br>
    
    <a href="?user" class="btn btn-default waves-effect waves-light" >Continuar...</a>
    
  </div>';
    }



    public function RealizarCorte($id,$op,$efectivo){
    echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
    Esta seguro que <strong>'. $efectivo .'</strong> es la cantidad correcta?
    <br>
    
    <a id="'.$id.'" op="'.$op.'" efectivo="'.$efectivo.'" class="btn btn-default waves-effect waves-light" >Aceptar</a>
    
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="alert" aria-hidden="true">Cancelar</button>

  </div>';
    }



    public function AlertaCambios($id,$op,$iden,$mensaje){
    echo '<div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="icon fa fa-ban"></i> Alerta!</h4>
    '. $mensaje .'
    <br>
    
    <a id="'.$id.'" op="'.$op.'" iden="'.$iden.'" class="btn btn-default waves-effect waves-light" >Aceptar</a>
    
    <button type="button" class="btn btn-danger waves-effect waves-light" data-dismiss="alert" aria-hidden="true">Cancelar</button>

  </div>';
    }


    public function CorteEcho($tipo){
      $num = rand(1,4);
      echo '<div class="alert alert-danger alert-dismissible">
<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
Existe un corte realizado este dia, ya no se puede seguir agregando '.$tipo.' a menos que elimine el corte realizado
<br>
<a href="?corte" class="btn btn-danger waves-effect waves-light">Eliminar Corte</a>
</div><div align="center"><img src="assets/img/imagenes/error'.$num.'.png" class="img-fluid" alt="Responsive image"></div>';
    }



    public function RealizarRespaldo($texto){
      echo '<div class="alert alert-danger alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      '.$texto.'
      <br>
      </div>';
    }

    public function RealizadoRespaldo($texto){
      echo '<div class="alert alert-success alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      '.$texto.'
      <br>
      </div>';
    }


    public function Mensaje($texto,$style,$boton,$boton2){
      echo '<div class="border border-light alert alert-'.$style.' alert-dismissible">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
      '.$texto.'
      <br>
      '.$boton.'  '.$boton2.'
      </div>';
    }



}
 ?>