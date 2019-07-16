<?php 
class Productos{

		public function __construct() { 
     	} 


	public function AddProducto($datos){ // lo que viede del formulario principal
		$db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto", $datos)) {
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
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=1&cad=0&com=0&dep=0";
        </script>';
      } else {
        echo '<script>
        window.location.href="?modal=proadd&key='. $datos["cod"] .'&step=1&cad='. $datos["caduca"] .'&com='. $datos["compuesto"] .'&dep='. $datos["dependiente"] .'";
        </script>';
      }
  }

  public function IngresarProducto($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
          if($datox["precio_costo"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["precio_costo"] = $datox["precio_costo"];
              $datos["caduca"] = $datox["caduca_submit"];
              $datos["caducaF"] = Fechas::Format($datox["caduca_submit"]);
              $datos["comentarios"] = $datox["comentarios"];
              $datos["fecha"] = date("d-m-Y");
              $datos["hora"] = date("H:i:s");
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_ingresado", $datos)) {
                 echo '<script>
                  window.location.href="?modal=proadd&key='. $datox["producto"] .'&step=2&com='. $datox["com"] .'&dep='. $datox["dep"] .'";
                  </script>'; 
                }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }

  }



  public function AddPrecios($datox){ // ingresa un nuevo lote de productos
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["precio"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["precio"] = $datox["precio"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_precio", $datos)) {

                 $i = $db->insert_id();
                 if(Helpers::UpdateIden("producto_precio", $i)){
                   Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
                }
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
          $this->VerPrecios($datox["producto"]);
  }

  public function VerPrecios($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_precio WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Precio</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$b["precio"].'</td>
                      <td><a id="delprecio" iden="'.$b["iden"].'" op="31" producto="'.$producto.'" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelPrecios($iden, $producto){ // elimina precio
    $db = new dbConn();
        if ( $db->delete("producto_precio", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Precio eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerPrecios($producto);
  }



  public function CompuestoBusqueda($dato){ // Busqueda para compuestos
    $db = new dbConn();
// echo '<ul id="producto-list">
// <a href="index.php?key="><li onClick="selectProducto(\'descripcion\');">Descripcion</li></a>
// </ul>';

          $a = $db->query("SELECT * FROM producto WHERE cod like '%".$dato["keyword"]."%' or descripcion like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-p" cod="'. $b["cod"] .'" descripcion="'. $b["descripcion"] .'">
                      '. $b["cod"] .'  || '. $b["descripcion"] .'</a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un producto";
          }
  }


    public function AddCompuesto($datox){
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["producto-codigo"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["agregado"] = $datox["producto-codigo"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_compuestos", $datos)) {

                 $i = $db->insert_id();
                 if(Helpers::UpdateIden("producto_compuestos", $i)){
                    Alerts::Alerta("success","Realizado!","Compuesto agregado correctamente!");
                }
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
           $this->VerCompuesto($datox["producto"]);
    }


  public function VerCompuesto($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_compuestos WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'PRODUCTOS QUE LO COMPONE
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Producto Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                    if ($r = $db->select("descripcion", "producto", "WHERE cod = ".$b["agregado"]." and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["descripcion"];
                      }  unset($r);  
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delcompuesto" iden="'.$b["iden"].'" op="34" producto="'.$producto.'" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }

  public function DelCompuesto($iden, $producto){ // elimina precio
    $db = new dbConn();
        if ( $db->delete("producto_compuestos", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Compuesto eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCompuesto($producto);
  }



    public function AddDependiente($datox){
      $db = new dbConn();
          if($datox["cantidad"] != NULL or $datox["producto-codigo"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];              
              $datos["dependiente"] = $datox["producto-codigo"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_dependiente", $datos)) {

                 $i = $db->insert_id();
                 if(Helpers::UpdateIden("producto_dependiente", $i)){
                  Alerts::Alerta("success","Realizado!","Dependiente agregado correctamente!");
                }
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
        $this->VerDependiente($datox["producto"]);
    }


  public function VerDependiente($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_dependiente WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'PRODUCTO QUE LO COMPONE
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Producto Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { 
                    if ($r = $db->select("descripcion", "producto", "WHERE cod = ".$b["dependiente"]." and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["descripcion"];
                      }  unset($r);  
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="deldependiente" iden="'.$b["iden"].'" op="36" producto="'.$producto.'" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelDependiente($iden, $producto){ // elimina dependiente
    $db = new dbConn();
        if ( $db->delete("producto_dependiente", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Dependiente eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerDependiente($producto);
  }




//////////tags

  public function TagsBusqueda($keyword){ // Busquedade tags agragados
    $db = new dbConn();
      $a = $db->query("SELECT * FROM producto_tags WHERE tag like '%".$keyword."%' and td = ".$_SESSION["td"]." limit 3");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
                 foreach ($a as $b) {
                 echo '<tr>
                        <td scope="row"><a id="select-tag" tag="'. $b["tag"] .'">'. $b["tag"] .'</a></td>
                      </tr>'; 
             }  $a->close();

        echo '
        </table>';
          } 
  }



    public function AddTag($datox){
      $db = new dbConn();
          if($datox["etiquetas"] != NULL){
              $datos = array();
              $datos["producto"] = $datox["producto"];              
              $datos["tag"] = $datox["etiquetas"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_tags", $datos)) {

                 $i = $db->insert_id();
                 if(Helpers::UpdateIden("producto_tags", $i)){
                  $this->VerTag($datox["producto"]);
                }
                
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
    }


  public function VerTag($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM producto_tags WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

              foreach ($a as $b) {  
                echo '<div class="chip cyan lighten-4">
                        '.$b["tag"].'
                       <a id="deltag" iden="'.$b["iden"].'" op="39" producto="'.$producto.'"> 
                       <i class="close fa fa-times"></i>
                       </a>
                     </div>';
      
              }
          } $a->close();  
  }



  public function DelTag($iden, $producto){ // elimina dependiente
    $db = new dbConn();
        if ( $db->delete("producto_tags", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Etiqueta eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTag($producto);
  }

/////// asignar ubicacion

    public function AddUbicacionAsig($datox){
      $db = new dbConn(); 
      // aqui comruebo si se le puede agregar
        if ($r = $db->select("sum(cant)", "ubicacion_asig", "WHERE producto = ".$datox["producto"]." and td = ".$_SESSION["td"]."")) { $suma = $r["sum(cant)"]; } unset($r);
              $prototal = $this->CuentaProductosU($datox["producto"]);

              $disponible = $prototal - $suma;
        if($disponible >= $datox["cantidad"]){       
          if($datox["cantidad"] != NULL or $datox["ubicacion"] != NULL){
              $datos = array();
              $datos["ubicacion"] = $datox["ubicacion"];              
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("ubicacion_asig", $datos)) {
                  Alerts::Alerta("success","Agregado!","Agregado correctamente!");
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
      } else {
        Alerts::Alerta("error","Error!","La cantidad disponible es menor a la que desea asignar!");
      }
      $this->VerUbicacionAsig($datox["producto"]);
    }



  public function VerUbicacionAsig($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM ubicacion_asig WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'DONDE SE ENCUETRA UBICADO EL PRODUCTO
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Ubicacion Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
          $canta = 0;
              foreach ($a as $b) { 
                if ($r = $db->select("ubicacion", "ubicacion", "WHERE iden = ".$b["ubicacion"]." and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["ubicacion"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delubicacionasig" iden="'.$b["id"].'" op="41" producto="'.$producto.'" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelUbicacionAsig($iden, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if ( $db->delete("ubicacion_asig", "WHERE id=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Etiqueta eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUbicacionAsig($producto);
  }


  public function SelectUbicacion(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT iden, ubicacion FROM ubicacion WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="ubicacion" name="ubicacion">
                  <option selected disabled>Ubicaci&oacuten</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["iden"] .'">'. $b["ubicacion"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }

  public function CuentaProductosU($cod){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
        if ($r = $db->select("cantidad", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
        $total = $r["cantidad"];
    } unset($r);  
    return $total; 

  }

///////////////// caracteristicas asign

    public function AddCaracteristicaAsig($datox){
      $db = new dbConn(); 
      // aqui comruebo si se le puede agregar
        if ($r = $db->select("sum(cant)", "caracteristicas_asig", "WHERE caracteristica = ".$datox["caracteristica"]." and producto = ".$datox["producto"]." and td = ".$_SESSION["td"]."")) { $suma = $r["sum(cant)"]; } unset($r);
              $prototal = $this->CuentaProductosU($datox["producto"]);

              $disponible = $prototal - $suma;
        if($disponible >= $datox["cantidad"]){       
          if($datox["cantidad"] != NULL or $datox["caracteristica"] != NULL){
              $datos = array();
              $datos["caracteristica"] = $datox["caracteristica"];              
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $datox["cantidad"];
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("caracteristicas_asig", $datos)) {
                  Alerts::Alerta("success","Agregado!","Agregado correctamente!");
              }
          } else {
              Alerts::Alerta("error","Error!","Faltan Datos!");
          }
      } else {
        Alerts::Alerta("error","Error!","La cantidad disponible es menor a la que desea asignar!");
      }
      $this->VerCaracteristicaAsig($datox["producto"]);
    }



  public function VerCaracteristicaAsig($producto){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM caracteristicas_asig WHERE producto = '$producto' and td = ".$_SESSION["td"]."");
          if($a->num_rows > 0){

        echo 'CARACTERISTICAS ASIGNADAS
        <table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Cantidad</th>
              <th scope="col">Caracteristica Agregado</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
          $canta = 0;
              foreach ($a as $b) { 
                if ($r = $db->select("caracteristica", "caracteristicas", "WHERE iden = ".$b["caracteristica"]." and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["caracteristica"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delcaracteristicaasig" iden="'.$b["id"].'" op="44" producto="'.$producto.'" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelCaracteristicaAsig($iden, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if ( $db->delete("caracteristicas_asig", "WHERE id=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Caracteristica eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCaracteristicaAsig($producto);
  }

  public function SelectCaracteristica(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT iden, caracteristica FROM caracteristicas WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="caracteristica" name="caracteristica">
                  <option selected disabled>Caracteristica</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["iden"] .'">'. $b["caracteristica"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }




// categorias

  public function AddCategoria($datos){ // agrega una categoria para ponersela al producto
    $db = new dbConn();

      if($datos["categoria"] != NULL){

              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_categoria", $datos)) {
                  $i = $db->insert_id();
                     if(Helpers::UpdateIden("producto_categoria", $i)){
                       Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                    }
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerCategoria();
  }




  public function VerCategoria(){ // listado de categorias
    $db = new dbConn();

      $a = $db->query("SELECT * FROM producto_categoria WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Categoria</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["categoria"].'</td>
                  <td><a id="delcategoria" iden="'.$b["id"].'" op="23" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelCategoria($iden){ // elimina categoria
    $db = new dbConn();
        if ( $db->delete("producto_categoria", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCategoria();
  }








// Unidades de medida

  public function AddUnidad($datos){ // agrega una unidad de medida para ponersela al producto
    $db = new dbConn();

      if($datos["nombre"] != NULL and $datos["abreviacion"] != NULL){

              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_unidades", $datos)) {
                  $i = $db->insert_id();
                     if(Helpers::UpdateIden("producto_unidades", $i)){
                       Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                    }
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerUnidad();
  }




  public function VerUnidad(){ // listado de Unidad
    $db = new dbConn();

      $a = $db->query("SELECT * FROM producto_unidades WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Unidad de medida</th>
          <th scope="col">Abreviaci&oacuten</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["nombre"].'</td>
                  <td>'.$b["abreviacion"].'</td>
                  <td><a id="delunidad" iden="'.$b["id"].'" op="25" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelUnidad($iden){ // elimina Unidad
    $db = new dbConn();
        if ( $db->delete("producto_unidades", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Categoria eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUnidad();
  }





// caracteristicas

  public function AddCaracteristica($datos){ // agrega una caracteritica para ponersela al producto
    $db = new dbConn();

      if($datos["caracteristica"] != NULL){

              $datos["td"] = $_SESSION["td"];
              if ($db->insert("caracteristicas", $datos)) {
                  $i = $db->insert_id();
                     if(Helpers::UpdateIden("caracteristicas", $i)){
                       Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                    }
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerCaracteristica();
  }




  public function VerCaracteristica(){ // listado de caracteristicas
    $db = new dbConn();

      $a = $db->query("SELECT * FROM caracteristicas WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Caracteristica</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["caracteristica"].'</td>
                  <td><a id="delcaracteristica" iden="'.$b["id"].'" op="27" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelCaracteristica($iden){ // elimina caracteristica
    $db = new dbConn();
        if ( $db->delete("caracteristicas", "WHERE iden=" . $iden)) {
          $db->delete("caracteristicas_asig", "WHERE caracteristica=" . $iden . " and td = " . $_SESSION["td"] );
           Alerts::Alerta("success","Eliminado!","Caracteristica eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCaracteristica();
  }








// categorias

  public function AddUbicacion($datos){ // agrega una categoria para ponersela al producto
    $db = new dbConn();

      if($datos["ubicacion"] != NULL){

              $datos["td"] = $_SESSION["td"];
              if ($db->insert("ubicacion", $datos)) {
                  $i = $db->insert_id();
                     if(Helpers::UpdateIden("ubicacion", $i)){
                       Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                    }
                  
              }else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
          }
      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
      $this->VerUbicacion();
  }




  public function VerUbicacion(){ // listado de categorias
    $db = new dbConn();

      $a = $db->query("SELECT * FROM ubicacion WHERE td = ".$_SESSION["td"]."");
      if($a->num_rows > 0){
    echo '<table class="table table-sm table-hover">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Ubicaci&oacuten</th>
          <th scope="col">Eliminar</th>
        </tr>
      </thead>
      <tbody>';
      $n = 1;
          foreach ($a as $b) { ;
            echo '<tr>
                  <th scope="row">'. $n ++ .'</th>
                  <td>'.$b["ubicacion"].'</td>
                  <td><a id="delubicacion" iden="'.$b["id"].'" op="29" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelUbicacion($iden){ // elimina categoria
    $db = new dbConn();
        if ( $db->delete("ubicacion", "WHERE iden=" . $iden)) {
            $db->delete("ubicacion_asig", "WHERE ubicacion=" . $iden . " and td = " . $_SESSION["td"] );  
           Alerts::Alerta("success","Eliminado!","Ubicacion eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUbicacion();
  }















} // Termina la lcase