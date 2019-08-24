<?php 
class Creditos{

		public function __construct() { 
     	} 



  public function VerCreditos(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM creditos WHERE td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Factura</th>
                    <th class="th-sm">Fecha</th>
                    <th class="th-sm">Estado</th>
                    <th class="th-sm">Ver</th>
                    <th class="th-sm">Abonos</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["factura"].'</td>
                      <td>'.$b["fecha"] . ' | ' . $b["hora"] . '</td>
                      <td>'.Helpers::EstadoCredito($b["edo"]) . '</td>
                      <td><a href="?modal=cre_prodcuto&cre='. $b["hash"] .'&factura='. $b["factura"] .'&tx='. $b["tx"] .'"><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a href="?modal=abonos&cre='. $b["hash"] .'&factura='. $b["factura"] .'&tx='. $b["tx"] .'"><i class="fas fa-money-bill-alt fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Factura</th>
                    <th>Fecha</th>
                    <th>Ver</th>
                    <th>Abonos</th>
                  </tr>
                </tfoot>
              </table>';

          } else{
          Alerts::Mensajex("<h3>No se encontraron creditos activos en este momento</h3>","info",$boton,$boton2);
        }
        $a->close();  

  }


  public function ObtenerTotal($factura, $tx){ // total del credito
    $db = new dbConn();

        if ($r = $db->select("sum(total)", "ticket", "WHERE num_fac = '$factura' and tx = '$tx' and td = ".$_SESSION["td"]."")) { 
            return $r["sum(total)"];
        }  unset($r);  
    
  }


  public function TotalAbono($credito){ // total abonos
    $db = new dbConn();

    if ($r = $db->select("sum(abono)", "creditos_abonos", "WHERE credito = '$credito' and td = ".$_SESSION["td"]."")) { 
            return $r["sum(abono)"];
        }  unset($r);  
    
  }




  public function VerProducto($factura, $tx) { //leva el control del autoincremento de los clientes
    $db = new dbConn();
        
        $a = $db->query("SELECT * FROM ticket WHERE num_fac = '$factura' and tx = '$tx' and td = ".$_SESSION["td"]."");

        if($a->num_rows > 0){
            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Cant</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Subtotal</th>
                <th scope="col">Impuesto</th>
                <th scope="col">Total</th>
              </tr>
            </thead>
            <tbody>';
            $pv = 0; $stotal = 0; $imp = 0; $tot = 0;
            foreach ($a as $b) {
              $pv = $pv + $b["pv"]; $stotal = $stotal + $b["stotal"]; $imp = $imp + $b["imp"]; $tot = $tot + $b["total"];
            echo '<tr>
                  <th scope="row">'.$b["cant"].'</th>
                  <td>'.$b["producto"].'</td>
                  <td>'.$b["pv"].'</td>
                  <td>'.$b["stotal"].'</td>
                  <td>'.$b["imp"].'</td>
                  <td>'.$b["total"].'</td>
                </tr>';
            }
              echo '<tr>
                  <th></th>
                  <td></td>
                  <th>'.Helpers::Dinero($pv).'</th>
                  <th>'.Helpers::Dinero($stotal).'</th>
                  <th>'.Helpers::Dinero($imp).'</th>
                  <th>'.Helpers::Dinero($tot).'</th>
                </tr>
                </tbody>
              </table>';
        } $a->close();

   
  }









public function VerAbonos($credito) { //leva el control del autoincremento de los clientes
    $db = new dbConn();
        
        $a = $db->query("SELECT * FROM creditos_abonos WHERE credito = '$credito' and td = ".$_SESSION["td"]." order by id desc");

        if($a->num_rows > 0){

    if ($r = $db->select("factura, tx", "creditos", "WHERE hash = '$credito' and td = ".$_SESSION["td"]."")) { 
        $factura = $r["factura"]; $tx = $r["tx"];
    }  unset($r); 

            echo '<table class="table table-striped table-sm">
            <thead>
              <tr>
                <th scope="col">Nombre</th>
                <th scope="col">Abono</th>
                <th scope="col">Fecha</th>
                <th scope="col">Hora</th>
                <th scope="col">Eliminar</th>
              </tr>
            </thead>
            <tbody>';
            $n = 1;
            foreach ($a as $b) {
            echo '<tr>
                  <th scope="row">'.$b["nombre"].'</th>
                  <td>'.Helpers::Dinero($b["abono"]).'</td>
                  <td>'.$b["fecha"].'</td>
                  <td>'.$b["hora"].'</td>';

                      if($n == 1 and $b["fecha"] == date("d-m-Y")){
                      echo '<td><a id="delabono" hash="'.$b["hash"].'" op="108" credito="'.$b["credito"].'" factura="'.$factura.'" tx="'.$tx.'"><i class="fa fa-minus-circle fa-lg red-text"></i></a></td>';
                    } else {
                      echo '<td><i class="fa fa-ban fa-lg green-text"></i></td>';
                    }
              echo '</tr>';
            $n ++;
            }
              echo '</tbody>
              </table>';
        } else{
          Alerts::Mensajex("A&uacuten no se ha realizado ningun abono","danger",$boton,$boton2);
        } $a->close();

   
  }



  public function AddAbono($datos){
    $db = new dbConn();
      if($datos["credito"] != NULL and $datos["abono"] != NULL){ // comprueba dtos
        
        $tot = $this->ObtenerTotal($datos["factura"], $datos["tx"]);
        $abo = $this->TotalAbono($datos["credito"]);
        $resultado = Helpers::Format($tot - $abo);
        $abono = Helpers::Format($datos["abono"]);

          if($abono <= $resultado){
                $data["credito"] = $datos["credito"];
                $data["nombre"] = strtoupper($datos["nombre"]);
                $data["abono"] = $datos["abono"];

                $data["fecha"] = date("d-m-Y");
                $data["hora"] = date("H:i:s");
                $data["hash"] = Helpers::HashId();
                $data["time"] = Helpers::TimeId();
                $data["td"] = $_SESSION["td"];
                if ($db->insert("creditos_abonos", $data)) {

                       Alerts::Alerta("success","Realizado!","Registro realizado correctamente!");  
                        $abo2 = $this->TotalAbono($datos["credito"]);
                        $resultado2 = $tot - $abo2;
                       if($resultado2 == 0){
                            $cambio = array();
                            $cambio["edo"] = 2;
                            Helpers::UpdateId("creditos", $cambio, "hash='".$datos["credito"]."' and td = ".$_SESSION["td"].""); 
                       }

                }
          } else {
            Alerts::Alerta("error","Error!","La cantidad ingresada es mayor al credito!");
          }
        } else {
          Alerts::Alerta("error","Error!","Faltan Datos!");
        }
      $this->VerAbonos($datos["credito"]);
  }



  public function DelAbono($hash, $credito){ // elimina abono
    $db = new dbConn();
        if (Helpers::DeleteId("creditos_abonos", "hash='$hash'")) {
           Alerts::Alerta("success","Eliminado!","Abono Eliminado correctamente!");
                    $cambio = array();
                    $cambio["edo"] = 1;
                    Helpers::UpdateId("creditos", $cambio, "hash='$credito' and td = ".$_SESSION["td"].""); 
        } else {
            Alerts::Alerta("error","Error!","Algo Ocurrio!");
        } 
      $this->VerAbonos($credito);
  }











} // Termina la lcase