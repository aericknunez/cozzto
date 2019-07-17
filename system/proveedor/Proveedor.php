<?php 
class Proveedores{

		public function __construct() { 
     	} 



  public function AddProveedor($datos){
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

                $datos["td"] = $_SESSION["td"];
                if ($db->insert("proveedores", $datos)) {

                    $i = $db->insert_id();
                   if(Helpers::UpdateIden("proveedores", $i)){
                    Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");
                  }  
                }

        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerProveedores();
  }


  public function CompruebaForm($datos){
        if($datos["nombre"] == NULL or
          $datos["documento"] == NULL or
          $datos["direccion"] == NULL or
          $datos["telefono"] == NULL){
          return FALSE;
        } else {
         return TRUE;
        }
  }

  public function UpProveedor($datos){ // lo que viede del formulario principal
    $db = new dbConn();
      if($this->CompruebaForm($datos) == TRUE){ // comprueba si todos los datos requeridos estan llenos

              if ($db->update("proveedores", $datos, "WHERE iden = ".$datos["iden"]." and td = ".$_SESSION["td"]."")) {
                  Alerts::Alerta("success","Realizado!","Cambio realizado exitsamente!");
                  echo '<script>
                        window.location.href="?proveedorver"
                      </script>';
              }           

      } else {
        Alerts::Alerta("error","Error!","Faltan Datos!");
      }
  }



  public function VerProveedores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM proveedores WHERE td = ".$_SESSION["td"]." order by id desc limit 10");
          if($a->num_rows > 0){
        echo '<table class="table table-sm table-hover">
          <thead>
            <tr>
              <th scope="col">#</th>
              <th scope="col">Nombre</th>
              <th scope="col">Documento</th>
              <th scope="col">Direccion</th>
              <th scope="col">Telefono</th>
              <th scope="col">Contacto</th>
              <th scope="col">Eliminar</th>
            </tr>
          </thead>
          <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <th scope="row">'. $n ++ .'</th>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["direccion"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.$b["contacto"].'</td>
                      <td><a id="delproveedor" iden="'.$b["iden"].'" op="61" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
        </table>';

          } $a->close();  
      echo '<div class="text-center"><a href="?proveedorver" class="btn btn-outline-info btn-rounded waves-effect btn-sm">Ver Todos</a></div>';
  }


  public function DelProveedor($iden){ // elimina precio
    $db = new dbConn();
        if ( $db->delete("proveedores", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Proveedor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerProveedores();
  }

  public function DelProveedorx($iden){ // elimina precio
    $db = new dbConn();
        if ( $db->delete("proveedores", "WHERE iden=" . $iden)) {
           Alerts::Alerta("success","Eliminado!","Proveedor eliminado correctamente!");
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerTodosProveedores();
  }


  public function VerTodosProveedores(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM proveedores WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Documento</th>
                    <th class="th-sm">Direccion</th>
                    <th class="th-sm">Telefono</th>
                    <th class="th-sm">Contacto</th>
                    <th class="th-sm">Editar</th>
                    <th class="th-sm">Eliminar</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["documento"].'</td>
                      <td>'.$b["direccion"].'</td>
                      <td>'.$b["telefono"].'</td>
                      <td>'.$b["contacto"].'</td>
                      <td><a href="?modal=editproveedor&key='.$b["iden"].'" class="btn-floating btn-sm btn-green"><i class="fas fa-edit"></i></a></td>
                      <td><a id="delproveedor" iden="'.$b["iden"].'" op="62" class="btn-floating btn-sm btn-red"><i class="fa fa-trash"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Documento</th>
                    <th>Direccion</th>
                    <th>Telefono</th>
                    <th>Contacto</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }





} // Termina la lcase