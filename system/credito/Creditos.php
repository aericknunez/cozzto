<?php 
class Creditos{

		public function __construct() { 
     	} 



  public function VerCreditos(){
      $db = new dbConn();
          $a = $db->query("SELECT * FROM creditos WHERE edo = 1 and td = ".$_SESSION["td"]." order by id desc");
          if($a->num_rows > 0){
        echo '<table id="dtMaterialDesignExample" class="table table-striped" table-sm cellspacing="0" width="100%">
                <thead>
                  <tr>
                    <th class="th-sm">#</th>
                    <th class="th-sm">Nombre</th>
                    <th class="th-sm">Factura</th>
                    <th class="th-sm">Orden</th>
                    <th class="th-sm">Fecha</th>
                    <th class="th-sm">Ver</th>
                    <th class="th-sm">Mod</th>
                  </tr>
                </thead>
                <tbody>';
          $n = 1;
              foreach ($a as $b) { ;
                echo '<tr>
                      <td>'. $n ++ .'</td>
                      <td>'.$b["nombre"].'</td>
                      <td>'.$b["factura"].'</td>
                      <td>'.$b["orden"].'</td>
                      <td>'.$b["fecha"] . ' | ' .  $b["hora"] . '</td>
                      <td><a><i class="fas fa-search fa-lg green-text"></i></a></td>
                      <td><a ><i class="fas fa-money-bill-alt fa-lg red-text"></i></a></td>
                    </tr>';          
              }
        echo '</tbody>
                <tfoot>
                  <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Factura</th>
                    <th>Orden</th>
                    <th>Fecha</th>
                    <th>Editar</th>
                    <th>Mod</th>
                  </tr>
                </tfoot>
              </table>';

          } $a->close();  

  }





} // Termina la lcase