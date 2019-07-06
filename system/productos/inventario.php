<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Mysqli.php';
$db = new dbConn();
?>

<div class="row d-flex justify-content-center">
  <div class="col-sm-8">

 <?php
    $a = $db->query("SELECT * FROM pro_bruto WHERE td = ". $_SESSION['td'] ."");
            if($a->num_rows > 0){
            echo '<table class="table table-sm table-striped">
              <thead>
                <tr>
                  <th scope="col">Nombre</th>
                  <th scope="col">Medida</th>
                  <th scope="col">Cantidad</th>
                  
                </tr>
              </thead>
              <tbody>';
        foreach ($a as $b) {

            if ($r = $db->select("abreviacion", "pro_unidades_medida", "WHERE id = ".$b["um"]." and td = ".$_SESSION["td"]."")) { 
                $uni = $r["abreviacion"];
            } unset($r);

                echo '<tr>
                  <th scope="row">'. $b["nombre"] .'</th>
                  <td>'. $uni .'</td>
                  <td>'. $b["cantidad"] .'</td>
                                    
                </tr>';
            unset($uni);
            } echo '</tbody>
                     </table>';
        }
        $a->close();
?>
  </div> 
</div> 