<?php  

class Mesas{

	public function __construct(){

	}

	public function VerMesas($fecha,$dir) {
		$db = new dbConn();
		$a = $db->query("select * from mesa where fecha = '$fecha' and td = ".$_SESSION['td']." order by id desc");
		    
		echo ' <h1>Mesas registradas '.$fecha.'</h1>
		    <table class="table table-striped table-responsive-sm table-sm">

		   <thead>
		     <tr>
		       <th>Mesa</th>';

		if($_SESSION["tipo_cuenta"] == 1){
		 echo '<th>Nombre</th>'; } 
		 echo '<th>Clientes</th>
		       <th>Mesero</th>
		       <th>Hora</th>
		       <th>S Total</th>
		       <th>Propina</th>
		       <th>Total</th>
		       <th>Ver</th>
		     </tr>
		   </thead>

		   <tbody>';
		    foreach ($a as $b) {
		    
		    if($_SESSION["tipo_cuenta"] == 1){
		       	if ($r = $db->select("nombre", "mesa_nombre", "WHERE mesa = ".$b["mesa"]." and tx = ".$_SESSION['tx']." and td = ".$_SESSION['td']."")) { 
		        $nombre = $r["nombre"];
		    	} unset($r); 
		    }
		     
		   
		    
		   $ax = $db->query("SELECT cod, sum(total) FROM ticket WHERE edo = 1 and fecha = '$fecha' and mesa = ".$b["mesa"]." and td = ".$_SESSION['td']."");
		    foreach ($ax as $bx) {
		      $total=$bx["sum(total)"];
		      $totalz = Helpers::Dinero($total);

		      if($bx["cod"] == "989898"){
		        $prop = 0;
		      } else{
		      $prop=$_SESSION["config_propina"]/100;
			   $prop=$total*$prop;
			   $propz = Helpers::Dinero($prop);
		      }
			    
		    } $ax->close();


		    $ar = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ar as $br) {

		      $totalr = $br["sum(total)"];
		    } $ar->close();



		    $az = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and cod != '989898' and fecha = '$fecha' and td = ".$_SESSION['td']."");
		    foreach ($az as $bz) {
		      $xtotal=$bz["sum(total)"];

		      $xprop=$_SESSION["config_propina"]/100;
		      $xprop=$xtotal*$xprop;
		      
		      $totales=$total+$prop;
		      $totalesz = Helpers::Dinero($totales);
		    } $az->close();

		   
		    // si no esta cobrada
		   if($b["estado"] == 1) { 
		   	//$totalz='<span class="badge badge-danger">Pendiente</span>';
		   	$propz='<span class="badge badge-danger">Pendiente</span>';
		    $totalesz='<span class="badge badge-danger">Pendiente</span>';
		   } ///////
		   	
		  echo '<tr>
		       <th scope="row">'. $b["mesa"] . '</th>';

		  if($_SESSION["tipo_cuenta"] == 1){     
		  echo '<td>'. $nombre . '</td>'; unset($nombre); }
		  echo '<td>'. $b["clientes"] . '</td>
		       <td>'. $b["empleado"] . '</td>
		       <td>'. $b["hora"] . '</td>
		       <td>'.$totalz.'</td>
		       <td>'.$propz.'</td>
		       <td>'.$totalesz.'</td>
		       <td><a href="?modal=ver_mesa&m='. $b["mesa"] . '&t='. $b["tx"] . '&dir='. $dir . '" class="btn-floating btn-sm"><i class="fa fa-cutlery red-text"></i></a></td>
		     </tr>';
		    }
		   $a->close();

		  if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
		  echo '<tr class="light-blue lighten-4">
		       <th scope="row">Totales</th>
		       <td></td>
		       <td></td>
		       <td></td>
		       <td></td>
		       <td><strong>'.Helpers::Dinero($totalr).'</strong></td>
		       <td><strong>'.Helpers::Dinero($xprop).'</strong></td>
		       <td><strong>'.Helpers::Dinero($xtotal=$totalr+$xprop).'</strong></td>
		     </tr>';
		 	}
		 
		  echo '</tbody>

		</table>';
		  
	}



	public function VerProductoMesas($mesa,$tx) {
		$db = new dbConn();

		   $a = $db->query("SELECT * FROM ticket WHERE mesa = '$mesa' and tx = '$tx' and td = ".$_SESSION["td"]."");
		    if($a->num_rows > 0){
		    
		      	echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cantidad</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					      <th scope="col">Cliente</th>
					      <th scope="col">No</th>
					      <th scope="col">Estado</th>
					      </tr>
					  </thead>
					  <tbody>';

		    	 foreach ($a as $b) {
		    	 	if($b["num_fac"] == 0) $edo="Pendiente"; else $edo="Cancelado";
		    	     
		    	     
				     if($b["edo"] != 1){
				     	echo '<tr class="text-danger">';
				     } else {
				     	echo '<tr>';
				     }
				     echo '<th scope="row">'. $b["cant"] .'</th>
				      <td>'. $b["producto"] .'</td>
				      <td>'. $b["pv"] .'</td>
				      <td>'. $b["total"] .'</td>
				      <td>'. $b["cliente"] .'</td>
				      <td>'. $b["num_fac"] .'</td>
				      <td>'. $edo .'</td>
				      </tr>';
		    	}
		    	echo '</tbody>
					</table>';

				    $s = $db->query("SELECT sum(total) FROM ticket WHERE mesa = '$mesa' and edo = 1 and tx = '$tx' and td = ".$_SESSION["td"]."");
				    foreach ($s as $t) {
				        $max=$t["sum(total)"];
				    } $s->close();
				    echo "<h1>Total: ". Helpers::Dinero($max) ."</h1>";

		    } $a->close();
		   

	}





// termina la clase
 }


?>