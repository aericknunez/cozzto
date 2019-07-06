<?php  

class Reporte{

	public function __construct(){
		
	}


	public function Contenido($fecha){ // para sacar el resumen del dia

		$this->Corte($fecha);
		$this->CalculaMateriaPrima($fecha);
		$this->ProductosEspeciales($fecha);
		Historial::HistorialGDiario($fecha);
		$this->VentaEspecial($fecha);
		$this->OtrasVentas($fecha);

	}


	public function Corte($fecha){
			$db = new dbConn();

				$pro=0;
				//busqueda de usuarios
				$a = $db->query("select * from corte_diario where fecha = '$fecha' and td = ".$_SESSION['td']."");

				if($a->num_rows > 0){  
					echo '<h2>Corte Diario</h2>
				    <table class="table table-striped table-sm">

						<thead>
					     <tr>
					       <th>Fecha</th>';
					if($_SESSION["td"] != 3){
					echo '<th>Mesas</th>
					       <th>Clientes</th>';
					   }
					echo '<th>Efectivo</th>
					        <th>Total</th>
					        <th>Gastos</th>
					        <th>Diferencia</th>
					     </tr>
					   </thead>

					   <tbody>';

			    foreach ($a as $b) {
				
				if($b["edo"] == 1){
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				} 
				  echo '<tr '.$colores.'>
				       <th scope="row">'. $b["fecha"] . '</th>';
				if($_SESSION["td"] != 3){
				echo '<td>'. $b["mesas"] . '</td>
				       <td>'. $b["clientes"] . '</td>';
				   }
				echo '<td>'. Helpers::Dinero($b["efectivo"]) . '</td>
				       <td>'. Helpers::Dinero($b["total"]) . '</td>
				       <td>'. Helpers::Dinero($b["gastos"]) . '</td>
				       <td>'. Helpers::Dinero($b["diferencia"]) . '</td>
				     </tr>';
					unset($colores);
				    }
				   $a->close();

			echo '</tbody>
				</table>';
			} // num rows
	}





	public function VentaEspecial($fecha){
			$db = new dbConn();

				$a = $db->query("select * from ticket where fecha = '$fecha' and cod = 8889 and edo = 1 and td = ".$_SESSION['td']."");

				if($a->num_rows > 0){  
					echo '<h2>Venta Especial</h2>
				    <table class="table table-striped table-sm">
						<thead>
					     <tr>
					       <th>Producto</th>
					       <th>Sub Total</th>
					       <th>Imp</th>
					       <th>Total</th>
					        <th>Factura</th>
					        <th>Hora</th>
					        <th>Cajero</th>
					     </tr>
					   </thead>

					   <tbody>';

			    foreach ($a as $b) {
				  echo '<tr class="text-black">
				       <th scope="row">'. $b["producto"] . '</th>
				       <td>'. $b["stotal"] . '</td>
				       <td>'. $b["imp"] . '</td>
				       <td>'. $b["total"] . '</td>
				       <td>'. $b["num_fac"] . '</td>
				       <td>'. $b["hora"] . '</td>
				       <td>'. $b["cajero"] . '</td>
				     </tr>';

// aqui busco los productos que lleva ese bolado
				$ax = $db->query("select * from ticket where fecha = '$fecha' and cod != 8889 and num_fac = ".$b["num_fac"]." and edo = 1 and tx = ".$b["tx"]." and td = ".$_SESSION['td']."");
				 foreach ($ax as $bx) {
				 	    
				 	    if ($r = $db->select("nombre", "producto", "WHERE cod = ".$bx["cod"]." and td = ".$_SESSION['td']."")) { 
					        $nombre = $r["nombre"];
					    } unset($r);  

				 	echo '<tr class="text-danger">
				       <th scope="row">'. $nombre . '</th>
				       <td>'. $bx["stotal"] . '</td>
				       <td>'. $bx["imp"] . '</td>
				       <td>'. $bx["total"] . '</td>
				       <td>'. $bx["num_fac"] . '</td>
				       <td>'. $bx["hora"] . '</td>
				       <td>'. $bx["cajero"] . '</td>
				     </tr>';

				 }

				} $a->close();

					    $a = $db->query("SELECT sum(stotal), sum(imp), sum(total) FROM ticket where fecha = '$fecha' and cod = 8889 and edo = 1 and td = ".$_SESSION['td']."");
					    foreach ($a as $b) {
					        $stotal=$b["sum(stotal)"];
					        $imp=$b["sum(imp)"];
					        $total=$b["sum(total)"];
					    } $a->close();

					echo '<tr class="text-black">
				       <th scope="row">TOTALES</th>
				       <td>'. $stotal . '</td>
				       <td>'. $imp . '</td>
				       <td>'. $total . '</td>
				       <td></td>
				       <td></td>
				       <td></td>
				     </tr>';

			echo '</tbody>
				</table>';
			} // num rows
	}







	public function OtrasVentas($fecha){
			$db = new dbConn();

				$a = $db->query("select * from ticket where fecha = '$fecha' and cod = 8888 and edo = 1 and td = ".$_SESSION['td']."");

				if($a->num_rows > 0){  
					echo '<h2>Otras Ventas</h2>
				    <table class="table table-striped table-sm">
						<thead>
					     <tr>
					       <th>Producto</th>
					       <th>Sub Total</th>
					       <th>Imp</th>
					       <th>Total</th>
					        <th>Factura</th>
					        <th>Hora</th>
					        <th>Cajero</th>
					     </tr>
					   </thead>

					   <tbody>';

			    foreach ($a as $b) {
				  echo '<tr class="text-black">
				       <th scope="row">'. $b["producto"] . '</th>
				       <td>'. $b["stotal"] . '</td>
				       <td>'. $b["imp"] . '</td>
				       <td>'. $b["total"] . '</td>
				       <td>'. $b["num_fac"] . '</td>
				       <td>'. $b["hora"] . '</td>
				       <td>'. $b["cajero"] . '</td>
				     </tr>';

					} $a->close();

					    $a = $db->query("SELECT sum(stotal), sum(imp), sum(total) FROM ticket where fecha = '$fecha' and cod = 8888 and edo = 1 and td = ".$_SESSION['td']."");
					    foreach ($a as $b) {
					        $stotal=$b["sum(stotal)"];
					        $imp=$b["sum(imp)"];
					        $total=$b["sum(total)"];
					    } $a->close();

					echo '<tr class="text-black">
				       <th scope="row">TOTALES</th>
				       <td>'. $stotal . '</td>
				       <td>'. $imp . '</td>
				       <td>'. $total . '</td>
				       <td></td>
				       <td></td>
				       <td></td>
				     </tr>';

			echo '</tbody>
				</table>';
			} // num rows
	}







	public function ProductosEspeciales($fecha){
			$db = new dbConn();

				$a = $db->query("select * from alter_producto_reporte where td = ".$_SESSION['td']."");

				if($a->num_rows > 0){  
					echo '<h2>Productos Especiales</h2>
				    <table class="table table-striped table-sm">
						<thead>
					     <tr>
					       <th>No</th>
					       <th>Producto</th>
					       <th>Cantidad</th>					       
					       <th>Precio</th>
					       <th>Total</th>
					     </tr>
					   </thead>

					   <tbody>';
					   $n = 0;
			    foreach ($a as $b) {
			    		$n = $n + 1;

			    		$cod = $b["producto"];
			    		 $ax = $db->query("SELECT sum(cant), sum(total) FROM ticket where fecha = '$fecha' and cod = '$cod' and edo = 1 and td = ".$_SESSION['td']."");
					    
					    foreach ($ax as $bx) {
					    	$cant=$bx["sum(cant)"];
					        $total=$bx["sum(total)"];
					    } $ax->close();

					    if ($r = $db->select("nombre, precio", "precios", "WHERE cod = '$cod' and td = ".$_SESSION['td']."")) { 
					        $nombre = $r["nombre"]; $precio = $r["precio"];
					    } unset($r);

				  echo '<tr class="text-black">
				       <th scope="row">'. $n . '</th>
				       <th>'. $nombre . '</th>
				       <th>'. Helpers::Entero($cant) . '</th>				  
				       <td>'. $precio . '</td>
				       <th>'. Helpers::Dinero($total) . '</th>
				     </tr>';

					} $a->close();

				echo '</tbody>
				</table>';
			} // num rows
	}




	public function Contadora($mes, $ano){
			$db = new dbConn();
			$fechax = "-". $mes .  "-". $ano;

  		$a = $db->query("select * from corte_diario where fecha like '%$fechax' and td = ".$_SESSION['td']." and edo = 1 order by fecha_format asc");

				if($a->num_rows > 0){  
					echo '<div id="areaImprimir">
					<div align="center">
					<h3>' . $_SESSION["config_cliente"] . '</h3>
					<p>' . $_SESSION["config_propietario"] . ', ' . $_SESSION["config_giro"] . ' <br> 
					Dirección: ' . $_SESSION["config_direccion"] . ' <br>
					Teléfono: ' . $_SESSION["config_telefono"] . ' <br>
					RTN: ' . $_SESSION["config_nit"] . ' <br>
					' . Helpers::Pais($_SESSION["config_pais"]) . '
					</p> </div>
					<br><hr>
					<table class="table table-striped table-sm">

						<thead>
					     <tr>
					       <th>Fecha</th>
					       <th>Facturas</th>
					       <th>Fact Inicial - Fact Final</th>
					       <th>Exento</th>
					        <th>Gravado</th>
					        <th>Sub Total</th>
					        <th>ISV 15 %</th>
					        <th>ISV 18 %</th>
					        <th>Total</th>
					     </tr>
					   </thead>

					   <tbody>';

			    foreach ($a as $b) {
			    	$fecha = $b["fecha"];
			    // inicial y final
			        $ax = $db->query("SELECT max(num_fac), min(num_fac), count(num_fac)  FROM ticket_num WHERE fecha = '$fecha' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
				    foreach ($ax as $bx) {
				        $max=$bx["max(num_fac)"]; $min=$bx["min(num_fac)"]; $count=$bx["count(num_fac)"];
				    } $ax->close();
			    // total
			    $ay = $db->query("SELECT sum(total) FROM ticket WHERE fecha = '$fecha' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
				    foreach ($ay as $by) {
				        $total=$by["sum(total)"];
				    } $ay->close();
				
				// si hay facturas muestro
				if($count > 0){
			  echo '<tr>
				       <th scope="row"><a id="imprimir-reporte" op="89" iden="'. $fecha . '">'. $fecha . '</a></th>
				       <td>'. $count . '</td>
				       <td>'. Helpers::NFactura($min) . ' <br> '. Helpers::NFactura($max) .'</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::Impuesto(Helpers::STotal($total, $_SESSION['config_imp']), $_SESSION['config_imp'])) .'</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero($total) . '</td>
				     </tr>';
					} /// del count
				    } // del foreach
				   $a->close();

			echo '</tbody>
				</table>';

				$fechas = "-" . $mes . "-" .$ano;
			    // inicial y final
			        $ax = $db->query("SELECT max(num_fac), min(num_fac), count(num_fac)  FROM ticket_num WHERE fecha like '%$fechas' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
				    foreach ($ax as $bx) {
				        $max=$bx["max(num_fac)"]; $min=$bx["min(num_fac)"]; $count=$bx["count(num_fac)"];
				    } $ax->close();
			    // total
			    $ay = $db->query("SELECT sum(total) FROM ticket WHERE fecha like '%$fechas' and tx = 1 and edo = 1 and td = ".$_SESSION["td"]."");
				    foreach ($ay as $by) {
				        $total=$by["sum(total)"];
				    } $ay->close();

			// aqui hacemos la tabla para los totales
			echo '<hr>
					<table class="table table-striped table-sm">

						<thead>
					     <tr>
					       <th>Facturas</th>
					       <th>Fact Inicial - Fact Final</th>
					       <th>Exento</th>
					        <th>Gravado</th>
					        <th>Sub Total</th>
					        <th>ISV 15 %</th>
					        <th>ISV 18 %</th>
					        <th>Total</th>
					     </tr>
					   </thead>

					   <tbody>';

				echo '<tr>
				       <td>'. $count . '</td>
				       <td>'. Helpers::NFactura($min) . ' <br> '. Helpers::NFactura($max) .'</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($total, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::Impuesto(Helpers::STotal($total, $_SESSION['config_imp']), $_SESSION['config_imp'])) .'</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero($total) . '</td>
				     </tr>';

				
				echo '</tbody>
				</table>';     
				// 
				




				/* aqui ira la parte de las facturas eliminadas*/

				$ar = $db->query("select * from ticket_num where fecha like '%$fechax' and td = ".$_SESSION['td']." and edo = 2 and tx = 1 order by id asc");
			if($ar->num_rows > 0){ 

					echo "<h2>Facturas Eliminadas</h2>";

				echo '<hr>
					<table class="table table-striped table-sm">

						<thead>
					     <tr>
					       <th>Fecha</th>
					       <th>Factura</th>
					       <th>Exento</th>
					        <th>Gravado</th>
					        <th>Sub Total</th>
					        <th>ISV 15 %</th>
					        <th>ISV 18 %</th>
					        <th>Total</th>
					     </tr>
					   </thead>

					   <tbody>';

				foreach ($ar as $br) {
					$fechar = $br["fecha"];
					$num_fact = $br["num_fac"];

				$aq = $db->query("SELECT sum(total) FROM ticket WHERE num_fac = '$num_fact' and tx = 1 and edo = 2 and td = ".$_SESSION["td"]."");
				    foreach ($aq as $bq) {
				        $tol = $bq["sum(total)"];
				    } $aq->close();

			  	echo '<tr>
				       <th scope="row">'. $fechar . '</th>
				       <td>'. Helpers::NFactura($num_fact) . '</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($tol, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::STotal($tol, $_SESSION['config_imp'])) . '</td>
				       <td>'. Helpers::Dinero(Helpers::Impuesto(Helpers::STotal($tol, $_SESSION['config_imp']), $_SESSION['config_imp'])) .'</td>
				       <td>'. Helpers::Dinero(0) . '</td>
				       <td>'. Helpers::Dinero($tol) . '</td>
				     </tr>';				

				} // del foreach
				echo '</tbody>
				</table>';
				echo "Total de facturas eliminadas " . $ar->num_rows ;
				$ar->close();

				} // num rows de las facturas eliminadas
				
				// vinvulo para imprimir
		echo '</div>'; // div de imprimir
		echo '<script>
              function printDiv(nombreDiv) {
                   var contenido= document.getElementById(nombreDiv).innerHTML;
                   var contenidoOriginal= document.body.innerHTML;

                   document.body.innerHTML = contenido;

                   window.print();

                   document.body.innerHTML = contenidoOriginal;
              } 
              </script>';

        echo '<div align="center"><a onclick="printDiv(\'areaImprimir\')" class="btn-floating btn-sm blue-gradient"><i class="fa fa-print" id="basic"></i></a><a href="?contadora" class="btn-floating btn-sm red"><i class="fa fa-ban"></i></a></div>';


		} // num rows
			//else { echo "No hay datos que mostrar"; }
	
				
	}



	public function CalculaMateriaPrima($fecha){
		$db = new dbConn();
		    $a = $db->query("SELECT * FROM alter_materiaprima_reporte WHERE td = ". $_SESSION["td"]. " order by id desc");
		    if($a->num_rows > 0){
		    	echo "<h2>Productos especiales vendidos</h2>";
		    	 echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Producto</th>
			      <th scope="col">Cantidad</th>
			    </tr>
			  </thead>
			  <tbody>';
			    foreach ($a as $b) {
			    	// obtengo el nombre del producto
			    	    if ($r = $db->select("nombre", "pro_bruto", "WHERE iden = ". $b["producto"] ." and td = ". $_SESSION["td"]. "")) { $nombre = $r["nombre"]; } unset($r); 
			    	// calculo cuanto producto se vendio
			    	    	$cantidadx = 0;
			    	   // * cuales son los dependientes y cuanto ocupan del materia prima
			    	        $adep = $db->query("SELECT * FROM pro_dependiente WHERE producto = ". $b["producto"] ." and td = ". $_SESSION["td"]. "");
							    foreach ($adep as $bdep) {
							        $idend = $bdep["iden"]; $cantd = $bdep["cantidad"];
					    // * busco los productos que tienen asignado esa dependiente y multiplico cantidad por productos
							           $ar = $db->query("SELECT * FROM pro_asignado WHERE dependiente = '$idend' and td = ". $_SESSION["td"]. "");
									    foreach ($ar as $br) {
									        $productox = $br["cod"];
									        // busco cuantos productos se vendieron
									            if ($prod = $db->select("sum(cant)", "ticket", "WHERE fecha = '$fecha' and cod = '$productox' and edo = 1 and td = ". $_SESSION["td"]. "")) { 
											        $cantidad = $prod["sum(cant)"];
											        $cantidades = $cantd * $cantidad;
											        $cantidadx = $cantidadx + $cantidades;
											        unset($cantidades);
											    }  unset($prod);  
									    } $ar->close();



							} $adep->close();

			        $producto = $b["producto"];
		
			        echo '<tr>
			      <th scope="row">'. $nombre .'</th>
			      <td>'. $cantidadx .'</td>
			    </tr>';
			    
			    } 
			    echo '</tbody>
		    	</table>';
			} $a->close();

	}








// termina la clase
 }


?>