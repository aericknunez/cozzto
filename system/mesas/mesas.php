<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Mysqli.php';

$db = new dbConn();

unset($_SESSION["mesa"]);

    $a = $db->query("SELECT * FROM mesa WHERE estado = 1 and tx = ".$_SESSION["tx"]." and td =".$_SESSION["td"]."");
    echo '<div class="d-flex justify-content-center">';
    
    foreach ($a as $b) {
    		// obtengo el nombre de la mesa
    	    if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$b["mesa"]." and tx = ".$_SESSION["tx"]." and td =".$_SESSION["td"]."")) { 
        		$nmesa = $r["nombre"];
    		} unset($r);  
   	// 
   	if($nmesa == NULL) $mesan = "Mesa ".$b["mesa"];
   	else  $mesan = $nmesa;
	echo '<a href="?view&mesa='.$b["mesa"].'">
	<figure class="figure">
	    <img src="assets/img/imagenes/'.Helpers::Mesa($b["clientes"]).'" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
	    <figcaption class="figure-caption text-center">'.$mesan.'</figcaption>
	</figure>
	</a>  &nbsp &nbsp &nbsp';
	unset($nmesa);
    } 
echo '</div>';
    $a->close();
?>

<hr>
<!-- aqui comienza para agregar mesa -->
<div class="d-flex justify-content-center">
<a href="?modal=addmesa">
<i class="fa fa-plus fa-5x" aria-hidden="true"></i><br>
Agregar
</a>
</div>  