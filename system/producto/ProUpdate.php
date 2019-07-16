<?php 
class ProUpdate{

		public function __construct() { 
     	} 


  public function UpProducto($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              if ($db->update("producto", $datos, "WHERE cod = ".$datos["cod"]." and td = ".$_SESSION["td"]."")) {
                  $this->Redirect($datos);
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  
  }


  public function CompruebaForm($datos){
        if($datos["cod"] == NULL or
          $datos["descripcion"] == NULL or
          $datos["cantidad"] == NULL or
          $datos["existencia_minima"] == NULL or
          $datos["categoria"] == NULL or
          $datos["medida"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function Redirect($datos){
      if($datos["servicio"] == "on"){
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=2&cad=0&com=0&dep=0";
        </script>';
      } else {
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=2&cad='. $datos["caduca"] .'&com='. $datos["compuesto"] .'&dep='. $datos["dependiente"] .'";
        </script>';
      }
  }



  public function UrlNext($cod, $step,$cad,$com,$dep){
    if($step == "1"){
      header("location: ../../?modal=proadd&key=$cod&step=2&cad=$cad&com=$com&dep=$dep");
    }
      if($step == "2"){
        if($com == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=3&cad=$cad&com=$com&dep=$dep");
        } 
        elseif($dep == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=4&cad=$cad&com=$com&dep=$dep");
        } else {
          header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep");
        }  
      }
      if($step == "3"){
        if($dep == "on"){
           header("location: ../../?modal=proadd&key=$cod&step=4&cad=$cad&com=$com&dep=$dep");
        } else {
          header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep");
       }  
      }
     if($step == "4"){
        header("location: ../../?modal=proadd&key=$cod&step=5&cad=$cad&com=$com&dep=$dep"); 
      }

  }









} // Termina la lcase