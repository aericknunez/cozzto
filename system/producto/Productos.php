<?php 
class Productos{

		public function __construct() { 
     	} 


	public function AddProducto($datos){ // lo que viede del formulario principal
		$db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos
                if($datos["gravado"] == NULL) $datos["gravado"] = 0;
                if($datos["receta"] == NULL) $datos["receta"] = 0;
                if($datos["servicio"] == NULL) $datos["servicio"] = 0;
                if($datos["compuesto"] == NULL) $datos["compuesto"] = 0;
                if($datos["caduca"] == NULL) $datos["caduca"] = 0;
                if($datos["dependiente"] == NULL) $datos["dependiente"] = 0;
                $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
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

            // debo actualizar el total (cantidad) de producto
                    if ($r = $db->select("cantidad", "producto", "WHERE cod = ".$datox["producto"]." and td = ".$_SESSION["td"]."")) { 
                        $canti = $r["cantidad"];
                    } unset($r); 
                                          
              $datos = array();
              $datos["producto"] = $datox["producto"];
              $datos["cant"] = $canti;
              $datos["precio_costo"] = $datox["precio_costo"];
              $datos["caduca"] = $datox["caduca_submit"];
              $datos["caducaF"] = Fechas::Format($datox["caduca_submit"]);
              $datos["comentarios"] = $datox["comentarios"];
              $datos["fecha"] = date("d-m-Y");
              $datos["hora"] = date("H:i:s");
              $datos["td"] = $_SESSION["td"];
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
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
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_precio", $datos)) {

                 Alerts::Alerta("success","Realizado!","Precio agregado correctamente!");
                
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
                      <td><a id="delprecio" hash="'.$b["hash"].'" op="31" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelPrecios($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_precio", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
               $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_compuestos", $datos)) {

                 Alerts::Alerta("success","Realizado!","Compuesto agregado correctamente!");
                
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
                      <td><a id="delcompuesto" hash="'.$b["hash"].'" op="34" producto="'.$producto.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }

  public function DelCompuesto($hash, $producto){ // elimina precio
    $db = new dbConn();
        if (Helpers::DeleteId("producto_compuestos", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_dependiente", $datos)) {

                  Alerts::Alerta("success","Realizado!","Dependiente agregado correctamente!");
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
                      <td><a id="deldependiente" hash="'.$b["hash"].'" op="36" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
  }


  public function DelDependiente($hash, $producto){ // elimina dependiente
    $db = new dbConn();
        if (Helpers::DeleteId("producto_dependiente", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              if ($db->insert("producto_tags", $datos)) {

                  $this->VerTag($datox["producto"]);
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
                       <a id="deltag" hash="'.$b["hash"].'" op="39" producto="'.$producto.'"> 
                       <i class="close fa fa-times"></i>
                       </a>
                     </div>';
      
              }
          } $a->close();  
  }



  public function DelTag($hash, $producto){ // elimina dependiente
    $db = new dbConn();
        if (Helpers::DeleteId("producto_tags", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
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
                $ubica = $b["ubicacion"];
                if ($r = $db->select("ubicacion", "ubicacion", "WHERE hash = '$ubica' and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["ubicacion"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delubicacionasig" hash="'.$b["hash"].'" op="41" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelUbicacionAsig($hash, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if (Helpers::DeleteId("ubicacion_asig", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Ubicacion eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUbicacionAsig($producto);
  }


  public function SelectUbicacion(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, ubicacion FROM ubicacion WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="ubicacion" name="ubicacion">
                  <option selected disabled>Ubicaci&oacuten</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["ubicacion"] .'</option>'; 
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
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
                if ($r = $db->select("caracteristica", "caracteristicas", "WHERE hash = '".$b["caracteristica"]."' and td = ".$_SESSION["td"]."")) { 
                        $nombre = $r["caracteristica"];
                      }  unset($r); 
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["cant"].'</td>
                      <td>'.$nombre.'</td>
                      <td><a id="delcaracteristicaasig" hash="'.$b["caracteristica"].'" op="44" producto="'.$producto.'" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                    </tr>';
                    $canta =  $canta + $b["cant"];          
              }
        echo '</tbody>
        </table>

        Total Asignado: ' . $canta;

          } $a->close();  
  }



  public function DelCaracteristicaAsig($hash, $producto){ // elimina ubicacion asig
    $db = new dbConn();
        if (Helpers::DeleteId("caracteristicas_asig", "caracteristica='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Caracteristica eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerCaracteristicaAsig($producto);
  }

  public function SelectCaracteristica(){ // Es el Select de la Ubicacion Para poder Recargarlo
    $db = new dbConn();
    $a = $db->query("SELECT hash, caracteristica FROM caracteristicas WHERE td = ".$_SESSION["td"].""); 
           echo '<select class="browser-default custom-select" id="caracteristica" name="caracteristica">
                  <option selected disabled>Caracteristica</option>';

             foreach ($a as $b) {
              echo '<option value="'. $b["hash"] .'">'. $b["caracteristica"] .'</option>'; 
                } $a->close();
          echo '</select>';          

  }




// /////////////////  categorias








  public function AddCategoria($datos){ // agrega una categoria para ponersela al producto
    $db = new dbConn();

      if($datos["categoria"] != NULL){
              $datos["hash"] = Helpers::HashId();
              $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_categoria", $datos)) {
                   Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
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
                  <td><a id="delcategoria" hash="'.$b["hash"].'" op="23" ><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelCategoria($hash){ // elimina categoria
    $db = new dbConn();
        if (Helpers::DeleteId("producto_categoria", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("producto_unidades", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
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
                  <td><a id="delunidad" hash="'.$b["hash"].'" op="25"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelUnidad($hash){ // elimina Unidad
    $db = new dbConn();
        if (Helpers::DeleteId("producto_unidades", "hash='$hash'")) {
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("caracteristicas", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
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
                  <td><a id="delcaracteristica" hash="'.$b["hash"].'" op="27"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelCaracteristica($hash){ // elimina caracteristica
    $db = new dbConn();
        if (Helpers::DeleteId("caracteristicas", "hash='$hash'")) {
            Helpers::DeleteId("caracteristicas_asig", "caracteristica='$hash' and td = " . $_SESSION["td"]);
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
              $datos["hash"] = Helpers::HashId();
                $datos["time"] = Helpers::TimeId();
              $datos["td"] = $_SESSION["td"];
              if ($db->insert("ubicacion", $datos)) {
                  
                  Alerts::Alerta("success","Agregado!","Agregado Correctamente!");
                  
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
                  <td><a id="delubicacion" hash="'.$b["hash"].'" op="29"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>
                </tr>';          
          }
    echo '</tbody>
    </table>';

      } $a->close();
  }



  public function DelUbicacion($hash){ // elimina categoria
    $db = new dbConn();
        if (Helpers::DeleteId("ubicacion", "hash='$hash'")) {
          Helpers::DeleteId("ubicacion_asig", "ubicacion='$hash' and td = " . $_SESSION["td"] );  
           Alerts::Alerta("success","Eliminado!","Ubicacion eliminada correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerUbicacion();
  }











  public function VerTodosProductos(){ 
    $db = new dbConn();

    $a = $db->query("SELECT producto.cod, producto.descripcion, producto.cantidad, producto.existencia_minima, producto_categoria.categoria FROM producto INNER JOIN producto_categoria ON producto.categoria = producto_categoria.hash and producto.td = ".$_SESSION["td"]." order by producto.id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">Cod</th>
                    <th class="th-sm">Producto</th>
                    <th class="th-sm">Cantidad</th>
                    <th class="th-sm">Categoria</th>
                    <th class="th-sm">Minimo</th>
                    <th class="th-sm">Editar</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'.$b["cod"].'</td>
                      <td>'.$b["descripcion"].'</td>
                      <td>'.$b["cantidad"].'</td>
                      <td>'.$b["categoria"].'</td>
                      <td>'.$b["existencia_minima"].'</td>
                      <td><a href="?proup&key='.$b["cod"].'"><i class="fas fa-edit fa-lg green-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>Cod</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Categoria</th>
                    <th>Minimo</th>
                    <th>Editar</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }








} // Termina la lcase